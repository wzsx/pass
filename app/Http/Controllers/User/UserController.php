<?php
namespace App\Http\Controllers\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Model\UserModel;
class UserController extends Controller
{
    public function userl()
    {
        $redirect = $_GET['redirect'] ?? env('SHOP_URL');
        $data = [
            'redirect' => $redirect
        ];
        return view('user.login', $data);
    }

    public function loginweb(Request $request){
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
    public function login()
    {
        $user_account = $_POST['nick_name'];
        $user_pwd = $_POST['pass'];
        if (empty($user_account)) {
            $res_data = [
                'errcode' => '5010',
                'msg' => '账号不能为空'
            ];
            return $res_data;
        }
        if (empty($user_pwd)) {
            $res_data = [
                'errcode' => '5010',
                'msg' => '密码不能为空'
            ];
            return $res_data;
        }
        if (is_numeric($user_account) || strlen($user_account) == 11) {
            $user_where = [
                'user_tel' => $user_account,
                'pass' => $user_pwd
            ];
        } elseif (substr_count($user_account, '@') != 0) {
            $user_where = [
                'email' => $user_account,
                'pass' => $user_pwd
            ];
        } else {
            $user_where = [
                'nick_name' => $user_account,
                'pass' => $user_pwd
            ];
        }

        $user_data = UserModel::where($user_where)->first();
        $ktoken = 'token:u:' . $user_data['uid'];
        $token = $token = str_random(32);
        Redis::hSet($ktoken, 'app:token', $token);
        Redis::expire($ktoken, 60 * 2 );
        if ($user_data) {
            $res_data = [
                'errcode' => 0,
                'msg' => '登陆成功',
                'token' => $token,
                'uid' => $user_data['uid'],
                'nick_name' => $user_data['nick_name'],
            ];
        } else {
            $res_data = [
                'errcode' => '5011',
                'msg' => '账号或者密码错误'
            ];
        }
        return $res_data;
    }
}