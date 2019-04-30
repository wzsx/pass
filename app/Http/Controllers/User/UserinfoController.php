<?php
namespace App\Http\Controllers\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Model\UserModel;
class UserinfoController extends Controller{
    public function login(){
        $user_account=$_POST['user_name'];
        $user_pwd=$_POST['user_pwd'];
        if(empty($user_account)){
            $res_data=[
                'errcode'=>'5010',
                'msg'=>'账号不能为空'
            ];
            return $res_data;
        }
        if(empty($user_pwd)){
            $res_data=[
                'errcode'=>'5010',
                'msg'=>'密码不能为空'
            ];
            return $res_data;
        }
        if(is_numeric($user_account) || strlen($user_account)==11){
            $user_where=[
                'user_tel'=>$user_account,
                'user_pwd'=>$user_pwd
            ];
        }elseif(substr_count($user_account,'@')!=0){
            $user_where=[
                'user_email'=>$user_account,
                'user_pwd'=>$user_pwd
            ];
        }else{
            $user_where=[
                'user_name'=>$user_account,
                'user_pwd'=>$user_pwd
            ];
        }

        $user_data=UserModel::where($user_where)->first();
        $ktoken='token:u:'.$user_data['user_id'];
        $token=$token=str_random(32);
        Redis::hSet($ktoken,'app:token',$token);
        Redis::expire($ktoken,60*24*3);
        if($user_data){
            $res_data=[
                'code'=>0,
                'msg'=>'登陆成功',
                'token'=>$token,
                'user_id'=>$user_data['user_id'],
                'user_name'=>$user_data['user_name'],
            ];
        }else{
            $res_data=[
                'code'=>'1',
                'msg'=>'账号或者密码错误'
            ];
        }
        return $res_data;
    }
    public function register(){
        $uname=trim($_POST['uname']);
        if(empty($uname)){
            $data=[
                'code'=>1,
                'msg'=>'用户名不能为空'
            ];
            return $data;
        }elseif (strlen($uname)>10){
            $data=[
                'code'=>1,
                'msg'=>'用户名最多10位'
            ];
            return $data;
        }
        $res_info=UserModel::where(['user_name'=>$uname])->first();
        if($res_info){
            $data=[
                'code'=>1,
                'msg'=>'客观，您输入的账号已被注册！换一个呗。'
            ];
            return $data;
        }
        $upwd=$_POST['upwd'];
        if(empty($upwd)){
            $data=[
                'code'=>1,
                'msg'=>'密码不能为空'
            ];
            return $data;
        }
        $upwd2=$_POST['upwd2'];
        if($upwd2!=$upwd){
            $data=[
                'code'=>1,
                'msg'=>'密码和确认密码不一致'
            ];
            return $data;
        }
        $uemail=trim($_POST['uemail']);
        if(empty($uemail)){
            $data=[
                'code'=>1,
                'msg'=>'邮箱不能为空'
            ];
            return $data;
        }elseif(substr_count($uemail,'@')==0){
            $data=[
                'code'=>2,
                'msg'=>'邮箱格式不符合'
            ];
            return $data;
        }
        $utel=trim($_POST['utel']);
        if(empty($utel)){
            $data=[
                'code'=>1,
                'msg'=>'手机号不能为空'
            ];
            return $data;
        }elseif(!is_numeric($utel) || strlen($utel)!=11){
            $data=[
                'code'=>1,
                'msg'=>'手机号格式不符合'
            ];
            return $data;
        }
        $info=[
            'user_name'=>$uname,
            'user_pwd'=>$upwd,
            'user_tel'=>$utel,
            'user_email'=>$uemail,
        ];
        $res=UserModel::insert($info);
        if($res){
            $data=[
                'code'=>0,
                'msg'=>'注册成功'
            ];
        }else{
            $data=[
                'code'=>1,
                'msg'=>'注册失败'
            ];
        }
        return $data;
    }
    public function center(){
        $user_id=$_POST['user_id'];
        $token=$_POST['token'];
        $ktoken='token:u:'.$user_id;
        $redis_token=Redis::hget($ktoken,'app:token');
        if($token==$redis_token){
            $user_info=UserModel::where(['user_id'=>$user_id])->first();
            $data=[
                'code'=>0,
                'msg'=>'ok',
                'user_name'=>$user_info['user_name'],
            ];
        }else{
            $data=[
                'code'=>1,
                'msg'=>'no'
            ];
        }
        return $data;
    }

    //修改密码
    public  function updatePwd()
    {
        $user_id = $_POST['user_id'];
        if (!empty($user_id)) {
            $userinfo = UserModel::where(['user_id' => $user_id])->first();
            $uname = $userinfo['user_account'];
            $data = [
                'code' => 0,
                'uname' => $uname
            ];
            return $data;
        }
    }
    public function pwd1(){
        $pwd=$_POST['upwd'];
        $pwd1=$_POST['upwd1'];
        $pwd2=$_POST['upwd2'];
        $user_id=$_POST['user_id'];
        $userinfo=UserModel::where(['user_id'=>$user_id])->first();
        $upwd=$userinfo['user_pwd'];
        if($pwd!=$upwd){
            $data=[
                'code' => 1,
                'msg'     => '原密码错误'
            ];
        }else{
            if($pwd1!=$pwd2){
                $data=[
                    'code' => 1,
                    'msg'     => '确认密码需和密码一致'
                ];
            }else{
                UserModel::where(['user_id'=>$user_id])->update(['user_pwd'=>$pwd1]);
                $data=[
                    'code'=>0,
                    'msg'=>'ok'
                ];
            }
        }
        return $data;
    }
}