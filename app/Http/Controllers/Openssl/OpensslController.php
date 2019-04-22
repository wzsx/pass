<?php
namespace App\Http\Controllers\Openssl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OpensslModel;
//use App\Model\UserModel;
class OpensslController extends Controller{

    public function openssl(){
        //加密
        $str='this is a 加密文件';
        $info=OpensslModel::first();
        $priv=$info->private;
        $pub=$info->public;
        $encryptData="";
        echo $encryptData;echo "<br>";
        openssl_private_encrypt($str,$encryptData,$priv);
        $destr = base64_encode($encryptData);
        echo $encryptData;echo "<br>";
        echo $destr;echo '<br>';
        $this->index($destr,$pub);


    }
    public function index($destr,$pub){
        //解密
        $str=base64_decode($destr);
        $decrypData="";
        openssl_public_decrypt($str,$decrypData,$pub);
        echo $decrypData;
    }
}