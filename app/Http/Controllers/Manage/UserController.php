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
      $data['info'] = $user;
      if($user['position'] == '总经理'){
        $data['lists']=Accountnum::get();
      }else{
        $data['lists']=Accountnum::where('username',$topuser)->get();
        $data['ltype'] = 1;
      }
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
        return view('manage.common.error',['msg'=>'用户名已经存在！']);
      }else{
        $topuser=$GLOBALS['m']['user'];
        $t['username'] =$user;
        $t['password'] =$pas;
        $t['addtime'] =time();
        $t['position']=$job;
        $t['fromuser'] = '';
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
      $ltype=request()->input('ltype');
      if(!empty($ltype)){
          $data['ltype'] = $ltype;
      }
      $data['user'] = Accountnum::where('id',$data['id'])->first();
      return view('manage.user.xiugai',$data);
    }

    //确认修改
    public function userxiugai(Request $request)
    {
      $id=$request['id'];
      $cz_id=$request['cz_id'];
      if(!empty($cz_id)){
          $passwd = md5('123456');
          Accountnum::where('id',$cz_id)->update(['password'=>$passwd]);
          return redirect()->route('manage_user_main');
      }
      $user=$request['name'];
      if(!empty($user)){
        $m['username'] = $user;
      }
        $pas=$request['password'];
      if(!empty($pas)){
        $pas=md5($pas);
        $m['password'] = $pas;
      }
      $job=$request['job'];
      if(!empty($job)){
        $m['position'] = $job;
      }
      $nickname=$request['nickanme'];
      if(!empty($nickname)){
        $m['nickname'] = $nickname;
      }
      
      Accountnum::where('id',$id)->update($m);

      return redirect()->route('manage_user_main');
    }

    //分配组员
    public function distribution(){
        $id=request()->input('id');
        $type=request()->input('type');
        $data['user']=Accountnum::where('id',$id)->first();

          if($data['user']['position'] == '销售主管'){
              $data['xsinfo'] = Accountnum::where("status",1)->where("position",'销售')->where('fromuser','')->get();
          }
          if($data['user']['position'] == '销售'){
              $data['xsstore'] = Accountnum::where("status",1)->where("position",'销售主管')->get();
          }
          if($data['user']['position'] == '客服主管'){
              $data['xsinfo'] = Accountnum::where("status",1)->where("position",'客服')->where('fromuser','')->get();
          }
          if($data['user']['position'] == '客服'){
              $data['xsstore'] = Accountnum::where("status",1)->where("position",'客服主管')->get();
          }


        return view('manage.user.distribution',$data);
    }

        //分配组员
    public function distributionpost(){
        $zhuguan=request()->input('zhuguan');
        $xiaoshou=request()->input('xiaoshou');
        $zhiwei=request()->input('zhiwei');
        if($zhiwei=='销售'){
            Accountnum::where("id",$xiaoshou)->update(['fromuser'=>$zhuguan]);
        }else{
            $arr = explode(',',$xiaoshou);
            if(count($arr) == 1){
                Accountnum::where("id",$arr[0])->update(['fromuser'=>$zhuguan]);
            }else{
              foreach ($arr as $key => $val) {
                  Accountnum::where("id",$val)->update(['fromuser'=>$zhuguan]);
              }
            }
        }

        return 1;
    }
}
