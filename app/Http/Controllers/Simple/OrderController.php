<?php
/**
 *简版店铺管理系统
 **/

namespace App\Http\Controllers\Simple;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\SimpleGoods;
use App\Models\SimpleOrder;
use App\Models\OperationLog;
use App\Models\SimpleStock;
use App\Models\SimpleStockLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //订单管理-现场订单
    public function order_spot(Request $request)
    {
        $admin_data = $request->get('admin_data');          //中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');            //中间件产生的菜单数据参数
        $son_menu_data = $request->get('son_menu_data');    //中间件产生的子菜单数据参数
        $route_name = $request->path();                         //获取当前的页面路由

        $account = $request->get('account');                //接收搜索账号
        $operator_id = Account::getPluck([['account', $account]], 'id');//操作员账号ID

        $ordersn = $request->get('ordersn');                //接收订单编号
        $paytype = $request->get('paytype');                //接收支付方式
        $status = $request->get('status');                  //接收订单状态
        $search_data = ['operator_id' => $operator_id, 'account' => $account, 'ordersn' => $ordersn, 'paytype' => $paytype, 'status' => $status]; //搜索数据
        $where[] = ['simple_id', $admin_data['organization_id']];
        //按订单编号搜索
        if (!empty($ordersn) && $ordersn != null) {
            $where[] = ['ordersn', $ordersn];
        }
        //按用户账号搜索
        if (!empty($operator_id) || !empty($account) && $operator_id == null) {
            $where[] = ['operator_id', $operator_id];
        }
        //按照支付方式搜索
        if (!empty($paytype) && $paytype != '请选择' || $paytype == '0') {
            $where[] = ['paytype', $paytype];
        }
        //按照订单状态搜索
        if (!empty($status) && $status != '请选择' || $status == '0') {
            $where[] = ['status', $status];
        }
        $list = SimpleOrder::getPaginage($where, 10, 'created_at', 'DESC');
        foreach ($list as $key => $val) {
            $user = User::getOneUser([['id', $val->user_id]]);
            $val->user = $user;
        }
        return view('Simple/Order/order_spot', ['list' => $list, 'search_data' => $search_data, 'admin_data' => $admin_data, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data, 'route_name' => $route_name]);
    }

    //订单管理-现场订单详情
    public function order_spot_detail(Request $request)
    {
        $admin_data = $request->get('admin_data');          //中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');            //中间件产生的菜单数据参数
        $son_menu_data = $request->get('son_menu_data');    //中间件产生的子菜单数据参数
        $route_name = $request->path();                         //获取当前的页面路由
        $id = $request->get('id');                          //获取订单id
        $order = SimpleOrder::getOne([['id', $id]]);             //查询订单信息
        $user = User::getOneUser([['id', $order->user_id]]);
        $order->user = $user;
        $order_price = 0.00;    //设置订单的初始总价
        foreach ($order->SimpleOrderGoods as $key => $val) {
            $price = $val->total * $val->price;
            $order_price += $price;        //计算订单总价
        }
        return view('Simple/Order/order_spot_detail', ['order_price' => $order_price, 'order' => $order, 'admin_data' => $admin_data, 'menu_data' => $menu_data, 'son_menu_data' => $son_menu_data, 'route_name' => $route_name]);
    }


    //修改订单状态确认密码弹窗
    public function order_status(Request $request)
    {
        $order_id = $request->get('order_id');          //订单ID
        $status = $request->get('status');              //订单状态
        return view('Simple/Order/order_status', ['order_id' => $order_id, 'status' => $status]);
    }

    //修改订单状态以及支付方式确认密码弹窗
    public function order_status_paytype(Request $request)
    {
        $order_id = $request->get('order_id');          //订单ID
        $status = $request->get('status');              //订单状态
        return view('Simple/Order/order_status_paytype', ['order_id' => $order_id, 'status' => $status]);
    }

    //修改订单状态确认操作
    public function order_status_check(Request $request)
    {
        $admin_data = $request->get('admin_data');      //中间件产生的管理员数据参数
        $route_name = $request->path();                     //获取当前的页面路由
        $order_id = $request->get('order_id');          //订单ID
        $status = $request->get('status');              //订单状态
        $order = SimpleOrder::getOne(['id' => $order_id]);    //获取订单信息
        DB::beginTransaction();
        try {
            if ($order['stock_status'] != '1') {//说明下单减库存，此时库存已经减去，需要还原
                $this->return_stock($order, '7');
            }
            SimpleOrder::editSimpleOrder(['id' => $order_id], ['status' => $status]);
            //添加操作日志
            if ($admin_data['is_super'] == 1) {//超级管理员操作简版店铺订单状态的记录
                OperationLog::addOperationLog('1', '1', '1', $route_name, '在简版店铺管理系统修改了订单状态！');//保存操作记录
            } else {//简版店铺本人操作记录
                OperationLog::addOperationLog('12', $admin_data['organization_id'], $admin_data['id'], $route_name, '修改了订单状态！');//保存操作记录
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();//事件回滚
            return response()->json(['data' => '修改订单状态失败，请检查', 'status' => '0']);
        }
        return response()->json(['data' => '修改订单状态成功！', 'status' => '1']);
    }

    public function order_status_paytype_check(Request $request)
    {
        $admin_data = $request->get('admin_data');      //中间件产生的管理员数据参数
        $route_name = $request->path();                     //获取当前的页面路由
        $order_id = $request->get('order_id');          //订单ID
        $status = $request->get('status');              //订单状态
        $paytype = $request->get('paytype');            //订单付款方式
        $order = SimpleOrder::getOne(['id' => $order_id]);    //获取订单信息
        if ($paytype == '请选择') {
            return response()->json(['data' => '请选择付款方式！', 'status' => '0']);
        }

        DB::beginTransaction();
        try {

            if ($status == '1' && $order->status == '0') {//手动确认付款    1、判断是否付款减库存
                if ($order['stock_status'] == '1') {//说明付款减库存
                    $this->return_stock($order, '6');
                    SimpleOrder::editSimpleOrder(['id' => $order_id], ['stock_status' => '-1']);
                }
            }
            SimpleOrder::editSimpleOrder(['id' => $order_id], ['status' => $status, 'paytype' => $paytype]);
            //添加操作日志
            if ($admin_data['is_super'] == 1) {//超级管理员操作简版店铺订单状态的记录
                OperationLog::addOperationLog('1', '1', '1', $route_name, '在简版店铺管理系统修改了订单状态！');//保存操作记录
            } else {//简版店铺本人操作记录
                OperationLog::addOperationLog('12', $admin_data['organization_id'], $admin_data['id'], $route_name, '修改了订单状态！');//保存操作记录
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();//事件回滚
            return response()->json(['data' => '修改订单状态失败，请检查', 'status' => '0']);
        }
        return response()->json(['data' => '修改订单状态成功！', 'status' => '1']);
    }

    //修改订单状态以及确认付款方式确认操作

    public static function return_stock($order, $type)
    {
        foreach ($order->SimpleOrderGoods as $key => $val) {
            $old_stock = SimpleGoods::getPluck(['id' => $val->goods_id], 'stock'); //查询原来商品的库存
            if ($type == '6') {//销售出库
                $new_stock = $old_stock - $val->total;         //确认付款后处理的新库存
            } elseif ($type == '7') {//销退入库
                $new_stock = $old_stock + $val->total;         //退货后处理的新库存
            }
            //1、更新商品信息中的库存
            SimpleGoods::editSimpleGoods(['id' => $val->goods_id], ['stock' => $new_stock]);
            //2、更新库存表的库存
            SimpleStock::editStock(['goods_id' => $val->goods_id], ['stock' => $new_stock]);
            $stock_data = [
                'fansmanage_id' => $order->fansmanage_id,
                'simple_id' => $order->simple_id,
                'goods_id' => $val->goods_id,
                'amount' => $val->total,
                'ordersn' => $order->ordersn,
                'operator_id' => $order->operator_id,
                'remark' => $order->remarks,
                'type' => $type,  //销售出库、销退入库
                'status' => '1',
            ];
            SimpleStockLog::addStockLog($stock_data);
        }
    }


}

?>