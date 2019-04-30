<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Routing\Router;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
class UssController extends Controller{
    public function demo(){

        return view('user.logins');
    }
    public function demo2(Request $request)

    {


        $name = $request->input('name');
        $password = $request->input('pwd');

        //echo $password;

        $uid = $name;

        $key = 'token:' . $uid;

        $token = Redis::get($key);

        if(!empty($token)){
            $token = substr(md5(time() + $uid + rand(1000,9999)),10,20);
            Redis::del($key);
            Redis::set($key,$token);

        }
        header("refresh:0;/demo3?token=$token");
    }
    public function demo3(Request $request){
        $token=$request->input('token');
        $key = 'token:' . 123;

        $tokens = Redis::get($key);
        if($token!=$tokens){
            echo 'NO';
        }else{
            echo "OK";
        }
    }
}
?>