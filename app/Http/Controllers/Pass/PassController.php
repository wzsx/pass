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
                setcookie('token',$token,time()+86400,'/','52xiuge.com',false,true);
                setcookie('email',$id2->email,time()+86400,'/','52xiuge.com',false,true);
                setcookie('uid',$id2->uid,time()+86400,'/','52xiuge.com',false,true);
//                $redis_key_web='str:u:web:'.$id2->uid;
//                Redis::set($redis_key_web,$token);
//                Redis::expire($redis_key_web,86400);
                // echo $redis_key_web;die;
                $redis_key_web_token='str:u:token:'.$id2->uid;
            Redis::del($redis_key_web_token);
            Redis::hSet($redis_key_web_token,'web',$token);
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
    public function reg(){
        // echo __METHOD__;
        $email = $_POST['email'];

        $w = UserModel::where(['email'=>$email])->first();
        if($w){
            die("用户名已存在");

        }
        $pass=$_POST['pass'];
        $pass2=$_POST['pass2'];
        if($pass !==$pass2){
            die( '密码必须保持一致');
        };
        $nick_name=$_POST['nick_name'];
        $age=$_POST['age'];
        $pass = password_hash($pass,PASSWORD_BCRYPT);
        // echo '<pre>';print_r($_POST);echo '</pre>';
        $data=[
            'nick_name' => $nick_name,
            'email' =>$email,
            'pass'=>$pass,
            'age'=>$age,
            'reg_time' =>time()
        ];
        $id=UserModel::insertGetId($data);
        var_dump($id);
        if($id){
            setcookie('email',$email,time()+86400,'/','xiuge.52self.cn',false,true);

            setcookie('uid',$id,time()+86400,'/','xiuge.52self.cn',false,true);
            // header("Refresh:3;url=/center");
            $response=[
                'errno'=>0,
                'msg'=>'注册成功'
            ];
        }else{
            $response=[
                'erron'=>5001,
                'msg'=>'注册失败'
            ];
        }
        return $response;
        // header("Refresh:3;url=");
    }


    public function pss(){
        $pass=$_POST['pass'];
        $email=$_POST['email'];
        $id = UserModel::where(['email'=>$email])->first();
        if(password_verify($pass,$id->pass)){
            $token = substr(md5(time().mt_rand(1,99999)),10,10);
            setcookie('token',$token,time()+86400,'/','xiuge.52self.cn',false,true);
            setcookie('uid',$id->uid,time()+86400,'/','xiuge.52self.cn',false,true);
//            $redis_key_web='str:u:pass:'.$id->uid;
//            Redis::set($redis_key_web,$token);
//            Redis::expire($redis_key_web,86400);

            $redis_key_web_token='str:u:token:'.$id->uid;
            Redis::del($redis_key_web_token);
            Redis::hSet($redis_key_web_token,'app',$token);
            $response=[
                'errno'=>0,
                'msg'=>'登录成功',
                'token'=>$token,
                'id'=>$id->uid,

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
