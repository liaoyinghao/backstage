<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Userlist;

class UserController extends Controller
{

    public function main(){
      $topuser=$GLOBALS['m']['user'];
      $user=Accountnum::where('username',$topuser)->first();
      $job=Userlist::where('jobtitle',$user['position'])->first();
      if($job){
        if($job['is_account'] ==1 ){
          $data['flag'] = 1;
        }
      }
      $data['lists']=Accountnum::get();
      $data['user']=Accountnum::pluck('nickname','id')->toArray();
      return view('manage.user.main',$data);
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


    //删除
    public function del()
    {
      $id=request()->input('id');
      Accountnum::where('id',$id)->update(['status'=>0]);
      return 1;
    }
    //恢复
    public function hui()
    {
      $id=request()->input('id');
      Accountnum::where('id',$id)->update(['status'=>1]);
      return 1;
    }

    //修改
    public function xiugai()
    {
      $data['id']=request()->input('id');
      $data['user'] = Accountnum::where('id',$data['id'])->first();
      return view('manage.user.xiugai',$data);
    }

    //确认修改
    public function userxiugai(Request $request)
    {
      $id=$request['id'];
      $user=$request['name'];
      $pas=md5($request['password']);
      $job=$request['job'];
      $nickname=$request['nickanme'];
      $account=Accountnum::where('username',$user)->first();
      if($account){
        return view('h5.common.error',['msg'=>'用户名已经存在！']);
      }else{
        Accountnum::where('id',$id)->update([
          'username'=>$user,
          'password'=>$pas,
          'position'=>$job,
          'nickname'=>$nickname,
        ]);
      }
      return redirect()->route('manage_user_main');
    }


}
