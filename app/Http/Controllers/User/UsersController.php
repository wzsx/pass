<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Model\UserModel;

class UsersController extends Controller
{

    public function end(Request $request){
        $user_id=$_POST['uid'];
        $user_data=UserModel::where(['uid'=>$user_id])->first();
        // print_r($data);
        return $user_data;
    }
    public function cartShow(){
        $uid=$_POST['uid'];
        $user_where=[
            'uid'=>$uid,
        ];
        $user_data=UserModel::where(['uid'=>$uid])->first();
        return $user_data;
    }
}