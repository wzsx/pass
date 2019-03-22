<?php

namespace  App\Http\Controllers\Pass;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Router;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class PassController extends Controller
{
    public function userl(){
        $redirect=$_GET['redirect'] ?? env('SHOP_URL');
        $data=[
            'redirect'=>$redirect
        ];
        return view('pass.login',$data);
    }
    public function login(Request $request){
        //echo '<pre>';print_r($_POST);echo '</pre>';
        // echo __METHOD__;
        // echo '<pre>';print_r($_POST);echo '</pre>';
        $pass =$request->input('pass');
        $root=$request->input('email');
        $r=$request->input('redirect')?? env('SHOP_URL');
        //var_dump($r);die;
        $id2 = UserModel::where(['email'=>$root])->first();
        //var_dump($id2);
        if($id2){
            if(password_verify($pass,$id2->pass)){
                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('token',$token,time()+86400,'/','cms.com',false,true);
                setcookie('email',$id2->email,time()+86400,'/','cms.com',false,true);
                setcookie('uid',$id2->uid,time()+86400,'/','cms.com',false,true);
                $redis_key_web='str:u:web:'.$id2->uid;
                Redis::set($redis_key_web,$token);
                Redis::expire($redis_key_web,86400);
                // echo $redis_key_web;die;
                header("Refresh:3;$r");
                echo '登录成功';
            } else {
                die('密码或用户名错误');

            }
        }else{
            die('用户不存在');
        }

    }
public function aaa(){
        echo 1;
}
    public function pss(){
        $pass=$_POST['pass'];
        $email=$_POST['email'];
        $id = UserModel::where(['email'=>$email])->first();
        if(password_verify($pass,$id->pass)){
            $token = substr(md5(time().mt_rand(1,99999)),10,10);
            setcookie('token',$token,time()+86400,'/','xiuge.52self.cn',false,true);
            setcookie('uid',$id->uid,time()+86400,'/','xiuge.52self.cn',false,true);
            $redis_key_web='str:u:pass:'.$id->uid;
            Redis::set($redis_key_web,$token);
            Redis::expire($redis_key_web,86400);
            $response=[
                'errno'=>0,
                'msg'=>'登录成功'
            ];
        } else {
            $response=[
                'errno'=>5001,
                'msg'=>'用户密码不正确'
            ];

        }
        return $response;
    }

}
