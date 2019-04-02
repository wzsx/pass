<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Model\UserModel;

class UsersController extends Controller
{

    public function end(Request $request){
        //print_r($_POST);
        //     $user_id=$request->input('uid');
        //    // print_r($user_id);
        //     $end_where=[
        //       'uid'=>$user_id,
        //     ];
//         $friend_id=UserFriendModel::where($end_where)->pluck('friend_id')->toArray();
//     //  print_r($end_data);
// //        foreach ($end_data as $k=>$v) {
// //            $friend[] = $v['friend_id'];
// //        }
// //        print_r($friend);

//         $data=FriendModel::whereIn('friend_id',$friend_id)->get();
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