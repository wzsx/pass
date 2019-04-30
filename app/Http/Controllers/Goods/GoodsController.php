<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Model\GoodsModel;
use App\Model\UserModel;
use App\Model\OpensslModel;
class GoodsController extends Controller
{
    //
    public function goods()
    {
        $data = GoodsModel::get();
        $arr = [
            'data' => $data
        ];
        //return $arr;
        return json_decode($data, true);
    }

    public function openssl()
    {
        //加密
        $str = 'this is a 加密文件';
        $info = OpensslModel::first();
        $priv = $info->private;
        $pub = $info->public;
        $encryptData = "";
        echo $encryptData;
        echo "<br>";
        openssl_private_encrypt($str, $encryptData, $priv);
        $destr = base64_encode($encryptData);
        echo $encryptData;
        echo "<br>";
        echo $destr;
        echo '<br>';
        $this->index($destr, $pub);
    }
    public function index($destr, $pub)
    {
        //解密
        $str = base64_decode($destr);
        $decrypData = "";
        openssl_public_decrypt($str, $decrypData, $pub);
        echo $decrypData;
    }

    public function details(Request $request){
        $goods_id=$request->input('goods_id');
        $salekey='sale:value:goods:'.$goods_id;
        $salenum=Redis::zscore($salekey,$goods_id);
        if(empty($goods_id || $goods_id<=0)){
            $response=[
                'error'=>4001,
                'msg'=>'请选择商品'
            ];
        }else{
            $where=[
                'goods_id'=>$goods_id
            ];
            $res=GoodsModel::where($where)->first();
            if(!$res){
                $response=[
                    'error'=>4001,
                    'msg'=>'商品不存在'
                ];
            }else{
                $response=[
                    'error'=>0,
                    'msg'=>$res,
                    'salenum'=>$salenum,
                ];
            }
        }
        return $response;
    }
}