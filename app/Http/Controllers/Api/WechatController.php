<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WechatOpenSetting;

class WechatController extends Controller{
    public function response($appid,Request $request){
        dump($appid);
        //\Wechat::getVerify_Ticket();
        WechatOpenSetting::editComponentVerifyTicket(123,time());
        echo "这里是消息与事件接收URL";
    }

    public function open(Request $request){
        $timeStamp    =$_GET['timestamp'];
        $nonce        =$_GET['nonce'];
        $encrypt_type =$_GET['encrypt_type'];
        $msg_sign     =$_GET['msg_signature'];
        $encryptMsg   =file_get_contents('php://input');
        //file_put_contents('testopen.txt',$timeStamp.'|'.$nonce.'|'.$encrypt_type.'|'.$msg_sign.'|'.$encryptMsg);
        $result = \Wechat::getVerify_Ticket($timeStamp,$nonce,$encrypt_type,$msg_sign,$encryptMsg);
        if($result){
            ob_clean();
            echo "success";
        }
    }

    public function auth(){
       // header('location: http://www.baidu.com');
        echo 123;
    }
}
?>