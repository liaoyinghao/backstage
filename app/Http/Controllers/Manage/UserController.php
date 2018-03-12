<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;

class UserController extends Controller
{

    public function main(){
        return view('manage.user.main');
    }

    public function userdetailed(){
        return view('manage.user.userdetailed');
    }


    //职位添加
    public function userzhuce(Request $request)
    {

      $user=$request['name'];
      $pas=md5($request['password']);
      $job=$request['job'];
      $nickname=$request['nickanme'];
      $account=Accountnum::where('username',$user)->first();
      if($account){
        return view('h5.common.error',['msg'=>'用户名已经存在！']);
      }else{
        $topuser=$GLOBALS['m']['user'];
        $fromuser=Accountnum::where('username',$topuser)->first();
        $t['username'] =$user;
        $t['password'] =$pas;
        $t['addtime'] =time();
        $t['position']=$job;
        $t['fromuser'] = $fromuser['id'];
        $t['nickname'] =$nickname;
        Accountnum::insert($t);
      }
      return redirect()->route('manage_user_main');
    }


}
