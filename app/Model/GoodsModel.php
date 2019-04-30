<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    public $table='api_goods';    //表名
    public $timestamps = false;  //开启自动写入时间
    //public $updated_at=false;   //关闭自动修改时间
    public $primaryKey = 'goods_id'; //数据库主键
    //展示价格以元为单位
    public function getPriceAttribute($price){
        return $price/100;
    }
    //写入导数据库时价格以分为单位写入
    public function setPriceAttribute($price){
        $this->attributes['goods_price']=$price*100;
    }
}
