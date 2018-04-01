<?php
/**
 * Android接口
 */
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Organization;
use App\Models\RetailCategory;
use App\Models\RetailGoods;
use App\Models\RetailGoodsThumb;
use App\Models\RetailOrder;
use App\Models\RetailOrderGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class AndroidApiController extends Controller{
    /**
     * 登入检测
     */
    public function login(Request $request){
        $account = $request->account;//登入账号
        $password = $request->password;//登入密码
        $data = Account::where([['account',$account]])->orWhere([['mobile',$account]])->first();//根据账号进行查询
        if(empty($data)){
            return response()->json(['msg' => '用户不存在', 'status' => '0','data'=>'']);
        }
        $key = config("app.retail_encrypt_key");//获取加密盐
        $encrypted = md5($password);//加密密码第一重
        $encryptPwd = md5("lingyikeji".$encrypted.$key);//加密密码第二重
        if($encryptPwd != $data['password']){
            return response()->json(['msg' => '密码不正确', 'status' => '0']);
        }
        $data = ['status' => '1', 'msg' => '登陆成功', 'data' => ['account_id' => $data['id'], 'account' => $data['account'], 'organization_id' => $data['organization_id'], 'uuid' => $data['uuid']]];
        return response()->json($data);
    }

    /**
     * 商品分类接口
     */
    public function goodscategory(Request $request){
        $organization_id = $request->organization_id;//店铺id
        $categorylist = RetailCategory::getList([['fansmanage_id',$organization_id]],'0','displayorder','asc',['id','name','displayorder']);
        $data = ['status' => '1', 'msg' => '获取分类成功', 'data' => ['categorylist' => $categorylist]];
        return response()->json($data);
    }

    /**
     * 商品列表接口
     */
    public function goodslist(Request $request){
        $organization_id = $request->organization_id;//店铺id
        $keyword = $request->keyword;//关键字
        $scan_code = $request->scan_code;//条码
        $where = [['fansmanage_id',$organization_id]];
        if($keyword){
            $where =[['keywords','LIKE','%'.$keyword.'%']];
        }
        if($scan_code){
            $where =[['barcode',$scan_code]];
        }
        $goodslist = RetailGoods::getList($where,'0','displayorder','asc',['id','name','category_id','details','price','stock']);
        foreach($goodslist as $key=>$value){
            $goodslist[$key]['category_name']=RetailCategory::getPluck([['id',$value['category_id']]],'name')->first();
            $goodslist[$key]['thumb']=RetailGoodsThumb::where([['goods_id',$value['id']]])->select('thumb')->get();
        }
        $data = ['status' => '1', 'msg' => '获取分类成功', 'data' => ['goodslist' => $goodslist]];
        return response()->json($data);
    }

    /**
     * 商品列表接口
     */
    public function order_check(Request $request){
        $organization_id = $request->organization_id;//店铺id
        $user_id = $request->user_id;//用户id 散客为0
        if(!$user_id){
            $user_id = 0;
        }
        $account_id = $request->account_id;//操作员id
        $remarks = $request->remarks;//备注
        $order_type = $request->order_type;//订单类型
        if(!$order_type){
            $order_type =1;
        }
        $goodsdata = json_decode($request->goodsdata,TRUE);//商品数组
        $order_price = 0;
        foreach($goodsdata as $key=>$value){
            foreach($value as $k=>$v){
                $order_price += $v['price'];
            }
        }
        $fansmanage_id = Organization::getPluck([['id',$organization_id]],'parent_id')->first();
        $num = RetailOrder::where([['fansmanage_id',$organization_id],['ordersn','LIKE','%'.date("Ymd",time()).'%']])->count();//查询订单今天的数量
        if(!$num){
            $num = 1;
        }
        $sort = 100000 + $num;
        $ordersn ='LS'.date("Ymd",time()).'_'.$organization_id.'_'.$sort;
        $orderData = [
            'ordersn' => $ordersn,
            'order_price' => $order_price,
            'remarks' => $remarks,
            'order_type' => $order_type,
            'fansmanage_id' => $fansmanage_id,
            'retail_id' => $organization_id,
            'user_id' => $user_id,
            'operator_id' => $account_id,
            'status' => '0',
        ];
        DB::beginTransaction();
        try{
            $order_id = RetailOrder::addRetailOrder($orderData);
            foreach($goodsdata as $key=>$value){
                foreach($value as $k=>$v){
                    $onedata = RetailGoods::getOne([['id',$v['id']]]);
                    print_r($onedata);exit;
                    $data = [
                        'order_id'=>$order_id,
                        'goods_id'=>$v['id'],
                        'title'=>$v['name'],
                        'thumb'=>$v['thumb'],
                        'details'=>$v['details'],
                        'total'=>$v['total'],
                        'price'=>$v['price'],
                    ];
                    RetailOrderGoods::addOrderGoods($data);
                }

            }

            DB::commit();//提交事务
        }catch (\Exception $e) {
            dd($e);
            DB::rollBack();//事件回滚
            return response()->json(['msg' => '提交订单失败', 'status' => '0', 'data' => '']);
        }
        return response()->json(['status' => '1', 'msg' => '提交订单成功', 'data' => ['order_id' => $order_id]]);
    }

//account_id=76&organization_id=5&timestamp=1522485361983&token=e71eaa006f6854ca6c86380a7e94e853&goodsdata={"data":[{"id":1,"total":"1","thumb":"jhsdfdsjkfdsjkfjskdjfkdsjfksdjfk","name":"\u9178\u83dc\u8089\u4e1d\u9762","category_id":1,"details":"\u91cd\u5e86\u5c0f\u9762\u91cd\u5e86\u5c0f\u9762\u91cd\u5e86\u5c0f\u9762\u91cd\u5e86\u5c0f\u9762\u91cd\u5e86\u5c0f\u9762\u91cd\u5e86\u5c0f\u9762","price":"10.00","stock":1001,"category_name":"\u9762\u6761"},{"id":2,"total":"1","thumb":"jhsdfdsjkfdsjkfjskdjfkdsjfksdjfk","name":"\u8304\u5b50\u8c46\u89d2","category_id":8,"details":"\u8304\u5b50\u8c46\u89d2\u8304\u5b50\u8c46\u89d2\u8304\u5b50\u8c46\u89d2\u8304\u5b50\u8c46\u89d2\u8304\u5b50\u8c46\u89d2\u8304\u5b50\u8c46\u89d2","price":"12.00","stock":1001,"category_name":"\u76d6\u6d47\u996d"}]}

}
?>