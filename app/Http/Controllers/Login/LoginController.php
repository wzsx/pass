<?php

namespace  App\Http\Controllers\Login;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
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
        $pass =$request->input('u_pass');
        $root=$request->input('u_email');
        $r=$request->input('redirect')?? env('SHOP_URL');
        //var_dump($r);die;
        $id2 = UserModel::where(['u_email'=>$root])->first();
        //var_dump($id2);
        if($id2){
            if(password_verify($pass,$id2->pwd)){
                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('token',$token,time()+86400,'/','cms.com',false,true);
                setcookie('u_email',$id2->u_email,time()+86400,'/','cms.com',false,true);
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
    public function slogin(){

    }

}
