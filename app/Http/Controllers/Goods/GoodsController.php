<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Model\GoodsModel;
use App\Model\UserModel;
class GoodsController extends Controller
{
    //
    public function goods()
    {
        $data = GoodsModel::get();
        $arr = [
            'data' => $data
        ];
        return json_decode($data, true);
    }
}