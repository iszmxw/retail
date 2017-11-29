<?php
/**
 *新版本登陆界面
 *
 **/
namespace App\Http\Controllers\Program;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Models\ProgramAdmin;
use App\Models\ProgramErrorLog;
use App\Models\ProgramLoginLog;
use App\Libraries\IP2Attr\IP;
use Session;

class LoginController extends Controller{
    /*
     * 登陆页面
     */
    public function display()
    {
        $data['random']=time();//生成调用验证码的随机数
        return view('Program/Login/display',$data);
    }
    /*
     * 生成验证码
     */
    public function captcha()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 150, $height = 35, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        Session::flash('program_system_captcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    //检测登录
    public function checkLogin(){
        $ip = Request::getClientIp();//获取访问者IP
        $addr_arr = IP::find($ip);//获取访问者地址
        $addr = $addr_arr[0].$addr_arr[1].$addr_arr[2].$addr_arr[3];//获取访问者地址
        $ip = ip2long($ip);//IP查询完地址后转化为整型。便于存储和查询

        $allowed_error_times = config("app.allowed_error_times");//允许登录错误次数
       ;
        $username = Request::input('username');//接收用户名
        $password = Request::input('password');//接收用户密码
        $key = config("app.program_encrypt_key");//获取加密盐
        $encrypted = md5($password);//加密密码第一重
        $encryptPwd = md5("lingyikeji".$encrypted.$key);//加密密码第二重

        //实例化错误记录表模型
        $error = new ProgramErrorLog();
        $error_log = $error->where('ip',$ip)->first();//获取该IP的错误记录

        //如果没有错误记录 或 错误次数小于允许错误的最大次数 或 错误次数超出 但时间已经过了10分钟
        if(empty($error_log) || $error_log['error_time'] <  $allowed_error_times || (strtotime($error_log['error_time']) >= $allowed_error_times && time()-strtotime($error_log['updated_at']) >= 600)) {
            $admininfo = ProgramAdmin::where('account', $username)->first()->toArray();//根据账户查询用户信息
            if (!empty($admininfo)) {//如果查询不到，则提示账号或密码错误
                if ($encryptPwd != $admininfo['password']) {//查询密码是否对的上
                    $this->setErrorLog($ip);//记录错误次数
                    return response()->json(['data' => '登录账号或密码错误', 'status' => '0']);
                } elseif($admininfo['status']=='0'){//查询账号状态
                    $this->setErrorLog($ip);//记录错误次数
                    return response()->json(['data' => '您的账号已被冻结', 'status' => '0']);
                }else{
                    $this->clearErrorLog($ip);//清除掉错误记录
                    //插入登录记录
                    $loginlog = new ProgramLoginLog();
                    $loginlog->account_id = $admininfo['id'];
                    $loginlog->ip = $ip;
                    $loginlog->ip_position = $addr;
                    $loginlog->save();
                    $id = $loginlog->id;
                    if(!empty($id)) {
                        session('zerone_program_account_id',$admininfo['id']);//存储登录session_id为当前用户ID
                        //构造用户缓存数据
                        $admin_data = ['admin_id'=>$admininfo['id'],'admin_account'=>$admininfo['account'],'admin_is_super'=>$admininfo['is_super'],'admin_login_ip'=>$ip,'admin_login_position'=>$addr,'admin_login_time'=>time()];
                        $admin_data = serialize($admin_data);
                        Redis::connection('zeo');//连接到我的redis服务器
                        $data_key = 'program_system_admin_data_'.$admininfo['id'];
                        Redis::set($data_key,$admin_data);
                        return response()->json(['data' => '登录成功', 'status' => '1']);
                    }else{
                        return response()->json(['data' => '登录失败', 'status' => '0']);
                    }
                }
            } else {
                $this->setErrorLog($ip);//记录错误次数
                return response()->json(['data' => '登录账号或密码错误', 'status' => '0']);
            }
        }else{
            return response()->json(['data' => '您短时间内错误的次数超过'.$allowed_error_times.'次，请稍候再尝试登陆 ','status' => '0']);
        }
    }

    //错误次数记录
    private function setErrorLog($ip){
        $error = new ProgramErrorLog();
        $error_log = $error->where('ip',$ip)->first();//获取该IP的错误记录

        if(empty($error_log)){//没有错误记录，插入错误记录，有错误记录，更新错误记录
            $error->ip = $ip;
            $error->error_time = 1;
            $error->save();
        }else{
            $error->where('ip',$ip)->increment('error_time');
        }
    }
    //清除错误记录
    private function clearErrorLog($ip){
        $error = new ProgramErrorLog();
        $error->where('ip',$ip)->update(['error_time'=>0]);
    }

}
?>