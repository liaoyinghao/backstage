<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function main(){
      $topuser=$GLOBALS['m']['user'];
      $type= request()->input('type');
      $shai= request()->input('shaixuan');
      $user=Accountnum::where('username',$topuser)->first();
      //总经理
      if($user['position'] == '总经理'){

          $data['flag']=1;
          $data['user']=Accountnum::pluck('nickname','id')->toArray();
          if($type == 'shaixuan'){
            $data['lists']=Customer::where('fromuser',$user['id'])->where('grade',$shai)->where('status',1)->get();
            $lists=Customer::where('status',0)->where('grade',$shai)->get();
          }else{
            $data['lists']=Customer::where('fromuser',$user['id'])->where('status',1)->get();
            $lists=Customer::where('status',0)->get();
          }
          $kong=[];
          foreach ($data['lists'] as $key => $value) {
            array_push($kong,$value);
          }
          foreach ($lists as $key => $value) {
            array_push($kong,$value);
          }
          $data['lists'] = $kong;

      }

      //销售主管
      if($user['position'] == '销售主管'){
          $data['flag']=2;
          $data['user']=Accountnum::pluck('nickname','id')->toArray();
          if($type == 'shaixuan'){
            $data['lists']=Customer::where('fromuser',$user['id'])->where('grade',$shai)->where('status',1)->get();//放弃
            $lists=Customer::where('status',0)->where('grade',$shai)->get();
          }else{
            $data['lists']=Customer::where('fromuser',$user['id'])->where('status',1)->get();//放弃
            $lists=Customer::where('status',0)->get();
          }
          $kong=[];
          foreach ($data['lists'] as $key => $value) {
            array_push($kong,$value);
          }
          foreach ($lists as $key => $value) {
            array_push($kong,$value);
          }
          $data['lists'] = $kong;


      }

      //销售
      if($user['position'] == '销售'){

          $data['flag']=3;
          $data['user']=Accountnum::pluck('nickname','id')->toArray();
          if($type == 'shaixuan'){
            $data['lists']=Customer::where('fromuser',$user['id'])->where('grade',$shai)->where('status',1)->get();//放弃
            $lists=Customer::where('status',0)->where('grade',$shai)->get();
          }else{
            $data['lists']=Customer::where('fromuser',$user['id'])->where('status',1)->get();//放弃
            $lists=Customer::where('status',0)->get();
          }
          $kong=[];
          foreach ($data['lists'] as $key => $value) {
            array_push($kong,$value);
          }
          foreach ($lists as $key => $value) {
            array_push($kong,$value);
          }
          $data['lists'] = $kong;

      }

      //总经理查全部
      if($type == 'quan'){
        $data['flag']=1;
        $data['user']=Accountnum::pluck('nickname','id')->toArray();
        $data['lists']=Customer::get();
      }

      //销售主管加队员
      if($type == 'zu'){
        $data['flag']=2;
        $data['user']=Accountnum::pluck('nickname','id')->toArray();
        $fromuser=Accountnum::where('fromuser',$user['id'])->pluck('id')->toArray();//找到队员
        $data['lists']=Customer::whereIn('fromuser',$fromuser)->where('status',1)->get();//队员客户
        $lists=Customer::where('fromuser',$user['id'])->where('status',1)->get();//自己客户
        // dd($user,$fromuser,$data['lists']);
        $kong=[];
        foreach ($data['lists'] as $key => $value) {
          array_push($kong,$value);
        }
        foreach ($lists as $key => $value) {
          array_push($kong,$value);
        }
        $data['lists'] = $kong;//自己+队员
      }

      //7天跟进
      if($type == 'qi'){
        $data['user']=Accountnum::pluck('nickname','id')->toArray();
        $data['lists']=Customer::get();
        $kong=[];
        foreach ($data['lists'] as $key => $value) {
          $time= time();
          if($time - $value['progresstime'] > 604800){
            array_push($kong,$value);
          }
        }
        $data['lists'] = $kong;
      }

      return view('manage.customer.main',$data);
    }

    //添加用户
    public function khadd(){
        return view('manage.customer.khadd');
    }

    //添加用户post
    public function khaddpost(){
    	$start=request()->input('start');
    	$form_type=request()->input('form_type');

    	$user = Accountnum::userinfo($GLOBALS['m']['user']);

    	if(!empty($form_type)){	//修改信息
    		$start['fromuser'] = $user['id'];
    		$m = Customer::where("id",$start['id'])->update($start);
    		if($m){
    			return redirect()->route('manage_customer_main');
    		}else{
    			dd('修改失败');
    		}
    	}

    	if(empty($start) || empty($start['name'])){
    		return redirect()->route('manage_customer_khaddpost');
    	}

    	$user = Accountnum::userinfo($GLOBALS['m']['user']);
    	$start['addtime'] = time();
    	$start['progresstime'] = time();
    	$start['fromuser'] = $user['id'];
    	$m = Customer::insert($start);
    	if($m){
    		return redirect()->route('manage_customer_main');
    	}else{
    		dd('添加失败');
    	}
    }

    //修改客户资料
    public function khdetails(){
    	$id=request()->input('id');
    	$data['start']=Customer::customerinfo($id);
    	if(!$data['start']){
    		dd('客户不存在！');
    	}
        return view('manage.customer.khadd',$data);
    }

    //修改客户等级
    public function khgrades(){
      $id=request()->input('id');
      $grades=request()->input('grades');
      $sta = Customer::where('id',$id)->select("grade")->first();
      if($sta['grade'] == $grades){
        return 1;
      }
      $start=Customer::where('id',$id)->update(['grade'=>$grades]);
      if($start){
        return 1;
      }else{
        return 0;
      }
    }

    //修改跟进信息
    public function followup(){
      $id=request()->input('id');
      $data['info'] = Customer::where('id',$id)->first();
      if(!empty($data['info']['progress'])){
          $tprogresst = @unserialize($data['info']['progress']);
          $count = count($tprogresst);
          if($count > 1){
              $data['count'] = $count / 2;
              $data['progress'] = [];
              $key = [];
              $val = [];
              $i = 1;
              $j = 1;
              $h = 1;
              $t = 1;
              foreach ($tprogresst as $k => $v) {
                if ($i%2==0){
                    $val[$h] = $v;
                    $h++;
                }else{
                    $key[$j] = $v;
                    $j++;
                }
                $i++;
              }

              foreach ($key as $v1 => $v2) {
                 $data['progress'][$v1]['time'] = $v2;
                 $data['progress'][$v1]['main'] = $val[$v1];
                 $data['progress'][$v1]['timename'] = 'time'.$t;
                 $data['progress'][$v1]['mainname'] = 'main'.$t;
                 $t++;
              }

              // dd($data['progress']);
          }
      }
      // dd($data);
      return view('manage.customer.followup',$data);
    }

    //修改跟进信息post
    public function followuppost(){
      $id=request()->input('id');
      $stoer = request()->input('stoer');
      foreach ($stoer as $key => $value) {
        if(empty($value)){
            $stoer[$key] = 0;
        }
      }
      $progress = serialize($stoer);
      $isok = Customer::where("id",$id)->update(["progress"=>$progress]);
      if($isok){
          $time = time();
          $isok = Customer::where("id",$id)->update(["progresstime"=>$time]);
          return redirect()->route('manage_customer_main');
      }else{
         dd('修改失败');
      }
    }


}
