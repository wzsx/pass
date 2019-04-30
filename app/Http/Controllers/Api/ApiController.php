<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
class ApiController extends Controller{
    public function mds(){

        $url ="http://lara.com/password?t=".time();
        $str="hello";
        $key='pass';
        $time=time();
        $api='AES-128-CBC';
        $argc=OPENSSL_RAW_DATA;
        $salt='sssss';
        $iv=substr(md5($time.$salt),5,16);
        $json=json_encode($str);
        $enc_str=openssl_encrypt($json,$api,$key,$argc,$iv);
        $post_data=base64_encode($enc_str);
        //计算签名
        $key_res =openssl_pkey_get_private(file_get_contents("./rsa_private_key.pem"));
        openssl_sign($post_data,$signature,$key_res,OPENSSL_ALGO_SHA256);
        //释放资源
        openssl_free_key($key_res);
        $sign = base64_encode($signature);
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['data'=>$post_data,'sign'=>$sign]);
        //执行命令
        $data = curl_exec($curl);
        print_r($data);die;
        $response=json_encode($data,true);
        $iv2=substr(md5($response['t'].$salt),5,16);
        $dec_data=openssl_decrypt(base64_decode($response['data']),$api,$key,OPENSSL_RAW_DATA,$iv2);
        var_dump($dec_data);
    }

}