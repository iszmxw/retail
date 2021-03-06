<?php

/**
 * 店铺 模块，包括：
 *   店铺信息
 */

namespace App\Http\Controllers\Fansmanage;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountInfo;
use App\Models\AccountNode;
use App\Models\Module;
use App\Models\OperationLog;
use App\Models\Organization;
use App\Models\OrganizationAssets;
use App\Models\OrganizationFansmanageinfo;
use App\Models\OrganizationRetailinfo;
use App\Models\OrganizationSimpleinfo;
use App\Models\Package;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class StoreController extends Controller
{
    /**
     * 创建店铺页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store_create(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 中间件产生的菜单数据参数
        $menu_data = $request->get('menu_data');
        // 中间件产生的子菜单数据参数
        $son_menu_data = $request->get('son_menu_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 需要渲染模式里面的数据
        $res = Organization::getProgramAsset(["organization_id" => $admin_data["organization_id"]]);
        $program_id = OrganizationAssets::getPluck(["organization_id" => $admin_data["organization_id"]],'program_id')->first();
        $program = Program::getOne(['id'=>$program_id]);//获取当前粉丝管理系统能使用的资产程序
        // 渲染页面
        return view('Fansmanage/Store/store_create', ["program_info" => $program, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
    }


    /**
     * 创建店铺功能提交
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store_create_check(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 获取当前的页面路由
        $route_name = $request->path();

        // 组织id
        $organization_id = $admin_data['organization_id'];
        // 获取父级组织id信息
        $oneOrganization = Organization::getOneStore([['id', $organization_id]]);

        // 组织上级id
        $organization_parent_id = $organization_id;
        // 树型关系
        $parent_tree = $oneOrganization['parent_tree'] . $organization_id . ',';

        // 选择资产程序id
        $program_id = $request->get('program_id');
        // 程序剩余数量
        $organization_assets = OrganizationAssets::getOne([['organization_id', $organization_id], ['program_id', $program_id]]);

        // 查看是否有创建资产程序的资格
        if (!empty($organization_assets)) {
            $organization_assets->toArray();
        } else {
            return response()->json(['data' => '创建店铺失败，没有创建该资产程序的权利！', 'status' => '0']);
        }

        // 创建后减少程序剩余数量
        $num = $organization_assets['program_balance'] - 1;
        $used_num = $organization_assets['program_used_num'] + 1;
        // 判断其分配的资产程序数量
        if ($num < 0) {
            return response()->json(['data' => '创建店铺失败，您暂无剩余的资产程序了！', 'status' => '0']);
        }

        // 获取组织名
        $organization_name = $request->organization_name;
        // 判断该组织名称是否存在
        $re = Organization::checkRowExists([['organization_name', $organization_name]]);
        if ($re) {
            return response()->json(['data' => '平台已存在该名称', 'status' => '0']);
        }

        // 店铺组织为4
        $type = '4';
        // 负责人姓名
        $realname = $request->realname;
        // 负责人电话
        $mobile = $request->mobile;

        // 获取账号数值，自增1
        $user = Account::max('account');
        // 用户账号
        $account = $user + 1;
        $password = $request->password;

        // 零售店铺加密方法（retail）
        // 获取加密盐
        if ($program_id == 10) {
            $key = config("app.retail_encrypt_key");
        } elseif ($program_id == 12) {
            $key = config("app.simple_encrypt_key");
        }
        // 密码加密
        $encrypted = md5($password);//加密密码第一重
        $encryptPwd = md5("lingyikeji" . $encrypted . $key);//加密密码第二重

        // 生成uuid 的值
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-';
        $uuid .= substr($chars, 8, 4) . '-';
        $uuid .= substr($chars, 12, 4) . '-';
        $uuid .= substr($chars, 16, 4) . '-';
        $uuid .= substr($chars, 20, 12);
        // 检测该值是否存在
        if (Account::checkRowExists([['uuid', $uuid]])) {
            return response()->json(['data' => 'uuid重复，请重新操作！', 'status' => '0']);
        }
        // 事务处理
        DB::beginTransaction();
        try {
            $organization = [
                'organization_name' => $organization_name,
                'parent_id' => $organization_parent_id,
                'parent_tree' => $parent_tree,
                'program_id' => $oneOrganization["program_id"],
                'asset_id' => $program_id,
                'type' => $type,
                'status' => '1',
            ];
            // 在组织表创建保存店铺信息
            $id = Organization::addOrganization($organization);


            // 在分店织信息表创建店铺组织信息
            if ($program_id == 10) {
                $storeinfo = [
                    'organization_id' => $id,
                    'retail_owner' => $realname,
                    'retail_owner_idcard' => '',
                    'retail_owner_mobile' => $mobile,
                ];
                OrganizationRetailinfo::addOrganizationRetailinfo($storeinfo);
            } elseif ($program_id == 12) {
                $storeinfo = [
                    'organization_id' => $id,
                    'simple_owner' => $realname,
                    'simple_owner_idcard' => '',
                    'simple_owner_mobile' => $mobile,
                ];
                OrganizationSimpleinfo::addOrganizationSimpleinfo($storeinfo);
            }


            $accdata = [
                'organization_id' => $id,
                'parent_id' => '0',
                'parent_tree' => '0' . ',',
                'deepth' => '1',
                'account' => $account,
                'password' => $encryptPwd,
                'mobile' => $mobile,
                'uuid' => $uuid
            ];
            // 在管理员表添加信息
            $account_id = Account::addAccount($accdata);

            $accdatainfo = [
                'account_id' => $account_id,
                'realname' => $realname,
                'idcard' => '',
            ];
            // 在管理员表添加信息
            AccountInfo::addAccountInfo($accdatainfo);
            // 修改资产的数量
            OrganizationAssets::editAssets([['id', $organization_assets['id']]], ['program_balance' => $num, 'program_used_num' => $used_num]);
            // 获取当前系统的所有节点
            $module_node_list = Module::getListProgram($program_id, [], 0, 'id');
            // 添加账号节点
            foreach ($module_node_list as $key => $val) {
                foreach ($val->program_nodes as $k => $v) {
                    AccountNode::addAccountNode(['account_id' => $account_id, 'node_id' => $v['id']]);
                }
            }
            //添加操作日志
            if ($admin_data['is_super'] == 1) {
                //超级管理员操作商户的记录
                OperationLog::addOperationLog('1', '1', '1', $route_name, '在粉丝管理系统创建了店铺：' . $organization_name);    //保存操作记录
            } else {
                //商户本人操作记录
                OperationLog::addOperationLog('3', $admin_data['organization_id'], $admin_data['id'], $route_name, '创建了店铺：' . $organization_name);//保存操作记录
            }
            // 提交事务
            DB::commit();
        } catch (\Exception $e) {
            // 事件回滚
            DB::rollBack();
            return response()->json(['data' => '创建店铺失败，请稍后再试！', 'status' => '0']);
        }
        return response()->json(['data' => '创建店铺成功,请前往店铺管理平台进行管理！', 'status' => '1']);
    }

    /**
     * 分店店管理列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store_list(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 中间件产生的菜单数据参数
        $menu_data = $request->get('menu_data');
        // 中间件产生的子菜单数据参数
        $son_menu_data = $request->get('son_menu_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 获取组织id
        $organization_id = $admin_data['organization_id'];
        // 获取分店信息
        $list = Organization::getstore([['parent_id', $organization_id], ['type', 4]], '10', 'id');
        // 渲染页面
        return view('Fansmanage/Store/store_list', ['list' => $list, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
    }


    public function fansmanage_edit_check(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 获取组织id
        $organization_id = $request->input('organization_id');
        // 店铺名称
        $organization_name = $request->input('organization_name');
        // 负责人
        $simple_owner = $request->input('simple_owner');
        // 手机号码
        $mobile = $request->input('mobile');
        // 获取上传上来的图片信息
        $file = $request->file('simple_logo');

        if (!empty($file)) {
            // 判断图片的格式
            if (!in_array(strtolower($file->getClientOriginalExtension()), ['jpeg', 'jpg', 'gif', 'gpeg', 'png'])) {
                // 不对就进行数据的返回
                return response()->json(['status' => '0', 'data' => '错误的图片格式']);
            }
            // 检测图片是否有效
            if ($file->isValid()) {
                // 重命名
                $new_name = date('Ymdhis') . mt_rand(100, 999) . '.' . $file->getClientOriginalExtension();
                // 文件路径
                $path = '/uploads/simple_logo/' . $admin_data['organization_id'] . '/';
                $base_path = base_path() . $path;
                // 将图片进行保存
                $file->move($base_path, $new_name);

                // 文件名称
                $file_path = $path . $new_name;
                $param_organization_fansmanage_info["logo"] = $file_path;
            }
        }

        DB::beginTransaction();
        try {
            // 商户信息
            $param_organization["organization_name"] = $organization_name;
            Organization::insertData($param_organization, "update_create", ["id" => $organization_id]);
            // 商户负责人信息
            $param_organization_fansmanage_info["fansmanage_owner"] = $simple_owner;
            $param_organization_fansmanage_info["fansmanage_owner_mobile"] = $mobile;

            // 保存商户信息
            OrganizationFansmanageinfo::insertData($param_organization_fansmanage_info, "update_create", ["fansmanage_id" => $organization_id]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => '修改失败，请检查', 'status' => '0']);
        }
        return response()->json(['data' => '修改成功', 'status' => '1']);
    }
}

