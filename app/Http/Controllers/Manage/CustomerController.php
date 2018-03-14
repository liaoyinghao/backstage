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
      $user=Accountnum::where('username',$topuser)->first();
      //总经理
      if($user['position'] == '总经理'){
        $data['flag']=1;
        $data['user']=Accountnum::pluck('nickname','id')->toArray();
        $data['lists']=Customer::where('fromuser',$user['id'])->get();
      }

      //销售主管
      if($user['position'] == '销售主管'){
        $data['flag']=2;
        $data['user']=Accountnum::pluck('nickname','id')->toArray();
        $data['lists']=Customer::where('fromuser',$user['id'])->get();
        $lists=Customer::where('status',2)->get();
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
        $data['lists']=Customer::where('fromuser',$user['id'])->get();
        $lists=Customer::where('status',2)->get();
        $kong=[];
        foreach ($data['lists'] as $key => $value) {
          array_push($kong,$value);
        }
        foreach ($lists as $key => $value) {
          array_push($kong,$value);
        }
        $data['lists'] = $kong;
      }
      return view('manage.customer.main',$data);
    }

    public function khadd(){
        return view('manage.customer.khadd');
    }

    public function khaddpost(){
    	$start=request()->input('start');
    	//fromuser谁的客户 = 添加的人
    	//进度默认为空，进度时间默认为当前时间和addtime一样
        dd($start);
    }

    public function khdetails(){
    	$id=request()->input('id');

    	$data['start']=1;

        return view('manage.customer.khadd',$data);
    }

}
