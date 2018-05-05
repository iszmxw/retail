<?php
/**
 * 粉丝管理系统
 * 支付设置
 **/

namespace App\Http\Controllers\Fansmanage;

use App\Http\Controllers\Controller;
use App\Models\OperationLog;
use App\Models\WechatAuthorization;
use App\Models\WechatPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaysettingController extends Controller
{

    /**
     * 微信支付设置
     */
    public function wechat_setting(Request $request)
    {
        // 中间件产生的管理员数据参数
        $admin_data = $request->get('admin_data');
        // 中间件产生的菜单数据参数
        $menu_data = $request->get('menu_data');
        // 中间件产生的子菜单数据参数
        $son_menu_data = $request->get('son_menu_data');
        // 获取当前的页面路由
        $route_name = $request->path();
        // 店铺id
        $fansmanage_id = $admin_data['organization_id'];
        // 支付信息
        $pay_info = [];
        // 获取公众号的信息
        $authorize_info = WechatAuthorization::getAuthInfo(["organization_id" => $fansmanage_id], ["authorizer_appid"]);
        // 判断是否已经进行第三方授权
        if (!empty($res)) {
            // 获取支付参数
            $pay_info = WechatPay::getInfo(["organization_id" => $fansmanage_id], ["appid", "appsecret", "mchid", "api_key", "apiclient_cert_pem", "apiclient_key_pem", "status"]);
        }
        // 渲染页面
        return view('Fansmanage/Paysetting/wechat_setting', ["authorize_info" => $authorize_info, "pay_info" => $pay_info, 'admin_data' => $admin_data, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data, 'route_name' => $route_name]);
    }


    /**
     * 编辑微信支付参数检测
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function editPayInfo()
    { // 中间件产生的管理员数据参数
        $admin_data = request()->get('admin_data');
        // 获取当前的页面路由
        $route_name = request()->path();


//        // 检验参数是否存在
//        $error_info = $this->validate(request(), [
//            'appid' => 'required',
//            'appsecret' => 'required',
//            'mchid' => 'required',
//            'api_key' => 'required',
//            'apiclient_cert_pem' => 'required',
//            'apiclient_key_pem' => 'required',
//        ]);

        $rule = [
            'appid' => 'required',
            'appsecret' => 'required',
            'mchid' => 'required',
            'api_key' => 'required',
            'apiclient_cert_pem' => 'required',
            'apiclient_key_pem' => 'required',
        ];


        // 获取appid
        $data["appid"] = request()->input('appid');
        // 获取appsecret
        $data["appsecret"] = request()->input('appsecret');
        // 获取商户号
        $data["mchid"] = request()->input('mchid');
        // 获取api 密钥
        $data["api_key"] = request()->input('api_key');
        // 获取商户支付证书
        $data["apiclient_cert_pem"] = request()->input('apiclient_cert_pem');
        // 获取支付证书私钥
        $data["apiclient_key_pem"] = request()->input('apiclient_key_pem');
        // 获取组织id
        $data["organization_id"] = $organization_id = request()->get('organization_id');





        $validate = \Validator::make($data, $rule);

        dd($validate);




        // 事务处理
        DB::beginTransaction();
        try {

            WechatPay::insertData($data, ["organization_id" => $organization_id]);

            // 添加操作日志
            if ($admin_data['is_super'] == 1) {
                // 超级管理员操作商户的记录
                OperationLog::addOperationLog('1', $organization_id, '1', $route_name, '编辑微信支付信息成功');
            } else {
                OperationLog::addOperationLog('4', $organization_id, $admin_data['id'], $route_name, '编辑微信支付信息成功');
            }

            DB::commit();
        } catch (\Exception $e) {
            // 事件回滚
            DB::rollBack();
            return response()->json(['data' => '编辑微信支付信息失败，请检查', 'status' => '0']);
        }
        // 返回提示
        return response()->json(['data' => '编辑微信支付信息成功', 'status' => '1']);
    }

}

