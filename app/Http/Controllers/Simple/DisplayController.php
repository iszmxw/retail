<?php
/**
 * 简版店铺管理系统
 * 首页
 **/

namespace App\Http\Controllers\Simple;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\FansmanageUser;
use App\Models\LoginLog;
use App\Models\OperationLog;
use App\Models\Organization;
use App\Models\OrganizationSimpleinfo;
use App\Models\Program;
use App\Models\SimpleGoods;
use App\Models\SimpleOrder;
use App\Services\ZeroneRedis\ZeroneRedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class DisplayController extends Controller
{
    //首页
    public function display(Request $request)
    {
        $admin_data = $request->get('admin_data');          //中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');            //中间件产生的菜单数据参数
        $son_menu_data = $request->get('son_menu_data');    //中间件产生的子菜单数据参数
        $route_name = $request->path();                         //获取当前的页面路由
        //只查询自己相关的数据
        $where = [
            ['account_id', $admin_data['id']],
            ['program_id', '12'], //查询program_id(12)简版店铺管理系统
            ['organization_id', $admin_data['organization_id']]
        ];
        $login_log_list = LoginLog::getList($where, 10, 'created_at', 'DESC');
        $operation_log_list = OperationLog::getList($where, 10, 'created_at', 'DESC');//操作记录
        if ($admin_data['is_super'] == 1 && $admin_data['organization_id'] == 0) { //如果是超级管理员并且组织ID等于零则进入选择组织页面
            return redirect('simple/simple_list');
        }
        if (empty($admin_data['safe_password'])) {//先设置安全密码
            return redirect('simple/account/password');
        } else {
            $organization = Organization::getOne([['id', $admin_data['organization_id']]]);
            $program = Program::getOne([['id', $organization->program_id]]);
            $organization->program_name = $program;
            $fans = FansmanageUser::getCount(['fansmanage_id' => $admin_data['organization_id']]);//查询当前店铺粉丝数量
            $order = SimpleOrder::getList(['simple_id' => $admin_data['organization_id'], 'status' => '1'], '0', 'id', 'DESC');
            $order_spot = SimpleOrder::getList(['simple_id' => $admin_data['organization_id']], '0', 'id', 'DESC')->count();
            $goods = SimpleGoods::getList(['simple_id' => $admin_data['organization_id']], '0', 'id', 'DESC')->count();
            $operating_receipt = 0.00;//营业收入
            foreach ($order as $key => $val) {
                $operating_receipt += $val->order_price;
            }
            //简单数据统计
            $statistics = ['fans' => $fans, 'operating_receipt' => $operating_receipt, 'goods' => $goods, 'order_spot' => $order_spot];
            return view('Simple/Display/display', ['organization' => $organization, 'statistics' => $statistics, 'login_log_list' => $login_log_list, 'operation_log_list' => $operation_log_list, 'admin_data' => $admin_data, 'route_name' => $route_name, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data]);
        }
    }

    //简版店铺列表（超级管理员使用）
    public function simple_list(Request $request)
    {
        $admin_data = $request->get('admin_data');                      //中间件产生的管理员数据参数
        if ($admin_data['id'] != 1 && $admin_data['organization_id'] != 0) {  //如果是超级管理员并且已经切换身份成功则跳转
            return redirect('simple');
        }
        $organization_name = $request->organization_name;
        $where = [['asset_id', '12'], ['type', '4']];                        //（资产程序ID）asset=12为简版管理系统，type=4为店铺类型的组织
        $organization = Organization::getOrganizationAndAccount($organization_name, $where, 20, 'id', 'ASC'); //所有简版版本店铺
        foreach ($organization as $key => $val) {
            $catering = Organization::getOneStore(['id' => $val->parent_id]);
            $val->cateringname = $catering->organization_name;
        }
        return view('Simple/Account/simple_list', ['organization' => $organization, 'organization_name' => $organization_name]);
    }

    //选择店铺
    public function simple_select(Request $request)
    {
        $admin_data = $request->get('admin_data');          //中间件产生的管理员数据参数
        $account_id = $request->account_id;                     //获取当前店铺的管理员id
        //如果是超级管理员且商户组织ID有值并且当前管理员的组织ID为空
        if ($admin_data['is_super'] == '1' && $admin_data['organization_id'] == 0) {
            $this->superadmin_login($account_id);      //超级管理员选择身份登录
            return response()->json(['data' => '成功选择店铺，即将前往该店铺！', 'status' => '1']);
        } else {
            return response()->json(['data' => '操作失败，请稍后再试！', 'status' => '1']);
        }
    }

    //超级管理员退出当前店铺（切换店铺）

    public function superadmin_login($account_id)
    {
        $account_info = Account::getOneAccount([['id', $account_id]]);//根据账号查询
        //Admin登录商户平台要生成的信息
        //重新生成缓存的登录信息
        $admin_data = [
            'id' => $account_info->id,                            //用户ID
            'organization_id' => $account_info->organization_id,  //组织ID
            'parent_id' => $account_info->parent_id,              //上级ID
            'parent_tree' => $account_info->parent_tree,          //上级树
            'deepth' => $account_info->deepth,                    //账号在组织中的深度
            'account' => $account_info->account,                  //用户账号
            'password' => $account_info->password,                //用户密码
            'safe_password' => $account_info->safe_password,      //安全密码
            'is_super' => 1,                                      //这里设置成1超级管理员，便于切换各个商户组织
            'status' => $account_info->status,                    //用户状态
            'mobile' => $account_info->mobile,                    //绑定手机号
        ];
        Session::put('simple_account_id', encrypt(1));         //存储登录session_id为当前用户ID
        //构造用户缓存数据
        if (!empty($account_info->account_info->realname)) {
            $admin_data['realname'] = $account_info->account_info->realname;
        } else {
            $admin_data['realname'] = '未设置';
        }
        if (!empty($account_info->account_roles) && $account_info->account_roles->count() != 0) {
            foreach ($account_info->account_roles as $key => $val) {
                $account_info->role = $val;
            }
            $admin_data['role_name'] = $account_info->role->role_name;
        } else {
            $admin_data['role_name'] = '角色未设置';
        }
        ZeroneRedis::create_simple_account_cache(1, $admin_data);   //生成账号数据的Redis缓存
        ZeroneRedis::create_simple_menu_cache(1);                       //生成对应账号的简版店铺系统菜单
    }

    //超级管理员以分店平台普通管理员登录处理

    public function simple_switch(Request $request)
    {
        $admin_data = $request->get('admin_data');                //中间件产生的管理员数据参数
        $admin_data['organization_id'] = 0;
        ZeroneRedis::create_simple_account_cache(1, $admin_data);//清空所选组织
        return redirect('simple');
    }

    //店铺信息编辑检测
    public function store_edit_check(Request $request)
    {
        $admin_data = $request->get('admin_data');                      //中间件产生的管理员数据参数
        $route_name = $request->path();                                     //获取当前的页面路由
        $organization_id = $request->get('organization_id');            //获取姓名
        $organization_name = $request->get('organization_name');        //获取组织ID
        $simple_owner = $request->get('simple_owner');                  //获取负责人姓名
        $simple_owner_mobile = $request->get('mobile');                 //获取负责人手机号码
        $simple_address = $request->get('simple_address');              //获取店铺地址
        $file = $request->file('simple_logo');                          //获取店铺logo
        $lng = $request->lng;    //lon 百度经度
        $lat = $request->lat;    //lat 百度纬度
        $bd_gcj = $this->bd09togcj02($lng, $lat);
        $file_path = '';       //初始化文件路径为空
        $simple_info = [];      //初始化店铺信息
        if ($request->hasFile('simple_logo')) {                          //检测是否有文件上传，有就处理文件
            if ($file->isValid()) {
                //检验文件是否有效
                $entension = $file->getClientOriginalExtension();                          //获取上传文件后缀名
                $new_name = date('Ymdhis') . mt_rand(100, 999) . '.' . $entension;  //重命名
                $file->move(base_path() . '/uploads/simple/', $new_name);          //上传文件操作
                $file_path = 'uploads/simple/' . $new_name;
                //要存储的数据
                $simple_info = [
                    'organization_id' => $organization_id,
                    'simple_logo' => $file_path,
                    'simple_owner' => $simple_owner,
                    'simple_owner_mobile' => $simple_owner_mobile,
                    'simple_address' => $simple_address,
                    'lng' => $bd_gcj['0'],
                    'lat' => $bd_gcj['1'],
                ];
            }
        } else {
            //要存储的数据
            $simple_info = [
                'organization_id' => $organization_id,
                'simple_owner' => $simple_owner,
                'simple_owner_mobile' => $simple_owner_mobile,
                'simple_address' => $simple_address,
                'lng' => $bd_gcj['0'],
                'lat' => $bd_gcj['1'],
            ];
        }
        DB::beginTransaction();
        try {
            Organization::editOrganization([['id', $organization_id]], ['organization_name' => $organization_name]);
            if(OrganizationSimpleinfo::checkRowExists([['organization_id', $organization_id]])){
                OrganizationSimpleinfo::editOrganizationSimpleinfo([['organization_id', $organization_id]], $simple_info);
            }else{
                OrganizationSimpleinfo::addOrganizationSimpleinfo($simple_info);
            }
            //添加操作日志
            if ($admin_data['is_super'] == 1) {//超级管理员修改店铺信息的记录
                OperationLog::addOperationLog('1', '1', '1', $route_name, '在上简版店铺管理系统修改了店铺信息！');//保存操作记录
            } else {//店铺本人操作记录
                OperationLog::addOperationLog('12', $admin_data['organization_id'], $admin_data['id'], $route_name, '修改了店铺信息！');//保存操作记录
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();//事件回滚
            return response()->json(['data' => '修改店铺信息失败，请检查', 'status' => '0']);
        }
        return response()->json(['data' => '修改店铺信息成功', 'file_path' => $file_path, 'status' => '1']);
    }

    /**
    　　* 百度坐标系 (BD-09) 与 火星坐标系 (GCJ-02)的转换
    　　* 即 百度 转 谷歌、高德
    　　* @param bd_lon
    　　* @param bd_lat
    　　* @returns
    　　*/
    public function bd09togcj02 ($bd_lon, $bd_lat) {
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $bd_lon - 0.0065;
        $y = $bd_lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $gg_lng = $z * cos($theta);
        $gg_lat = $z * sin($theta);
        return array($gg_lng, $gg_lat);
    }

}


?>