<?php
namespace App\Http\Controllers\Catering;
use App\Http\Controllers\Controller;
use App\Models\MemberLabel;
use App\Models\OperationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class UserController extends Controller{
    //粉丝标签管理
    public function user_tag(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        $organization_id = $admin_data['organization_id'];//组织id

        $list = MemberLabel::getPaginage([['organization_id',$organization_id]],'10','id');
        return view('Catering/User/user_tag',['list'=>$list,'admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }
    //添加会员标签ajax显示页面
    public function member_label_add(Request $request){

        return view('Catering/User/member_label_add');
    }
    //添加会员标签功能提交
    public function member_label_add_check(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        $member_name = $request->member_name; //会员标签名称
        $organization_id = $admin_data['organization_id'];//组织id

        $re = MemberLabel::checkRowExists([['organization_id',$organization_id],['member_name',$member_name]]);
        if($re == 'true'){
            return response()->json(['data' => '会员标签名称已存在！', 'status' => '0']);
        }
        
        DB::beginTransaction();
        try {
            $data = [
                'member_name'=>$member_name,
                'organization_id'=>$organization_id,
                'parent_id'=>0,
                'member_number'=>0,
            ];
            MemberLabel::addMemberLabel($data);
            if($admin_data['is_super'] != 2){
                OperationLog::addOperationLog('4',$admin_data['organization_id'],$admin_data['id'],$route_name,'创建会员标签成功：'.$member_name);//保存操作记录
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();//事件回滚
            return response()->json(['data' => '创建会员标签失败！', 'status' => '0']);
        }
        return response()->json(['data' => '创建会员标签成功！', 'status' => '1']);



    }
    //编辑会员标签ajax显示页面
    public function member_label_edit(Request $request){
        $id = $request->id; //会员标签id
        $oneMemb = MemberLabel::getOneMemberLabel([['id',$id]]);
        return view('Catering/User/member_label_edit',['oneMemb'=>$oneMemb]);
    }
    //编辑会员标签功能提交
    public function member_label_edit_check(Request $request){

        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        $organization_id = $admin_data['organization_id'];//组织id

        $id = $request->id; //会员标签id
        $member_name = $request->member_name; //会员标签名称
        $re = MemberLabel::checkRowExists([['organization_id',$organization_id],['member_name',$member_name]]);
        if($re == 'true'){
            return response()->json(['data' => '会员标签名称已存在！', 'status' => '0']);
        }
        DB::beginTransaction();
        try {
            MemberLabel::editMemberLabel(['id'=>$id],['member_name'=>$member_name]);
            if($admin_data['is_super'] != 2){
                OperationLog::addOperationLog('4',$admin_data['organization_id'],$admin_data['id'],$route_name,'修改会员标签成功：'.$member_name);//保存操作记录
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();//事件回滚
            return response()->json(['data' => '修改会员标签失败！', 'status' => '0']);
        }
        return response()->json(['data' => '修改会员标签成功！', 'status' => '1']);


    }
    //删除会员标签ajax显示页面
    public function member_label_delete(Request $request){

        return view('Catering/User/member_label_delete');
    }
    //粉丝用户管理
    public function user_list(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        return view('Catering/User/user_list',['admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }
    //粉丝用户足迹
    public function user_timeline(Request $request){
        $admin_data = $request->get('admin_data');//中间件产生的管理员数据参数
        $menu_data = $request->get('menu_data');//中间件产生的管理员数据参数
        $son_menu_data = $request->get('son_menu_data');//中间件产生的管理员数据参数
        $route_name = $request->path();//获取当前的页面路由

        return view('Catering/User/user_timeline',['admin_data'=>$admin_data,'route_name'=>$route_name,'menu_data'=>$menu_data,'son_menu_data'=>$son_menu_data]);
    }
}
?>