<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Exproject;
use App\Models\Customer;
use App\Models\Accountnum;

class ExprojectController extends Controller
{

    public function main(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['list'] = Exproject::exproList($user);

        if($data['user']['position'] == '总经理' or $data['user']['position'] == '客服主管'){
            $data['flag'] = 1;
        }else{
            $data['flag'] = 2;
        }
        return view('manage.exproject.main',$data);
    }

    //从客户变成项目
    public function addproject(){
        return view('manage.exproject.addproject');
    }

    //从客户变成项目
    public function updata(){
    	$id = request()->input('id');
      $detail = Exproject::detail($id);
      $data['detail'] = $detail;
      return view('manage.exproject.updata',$data);
    }

    //项目增加和修改
    public function addprojectpost(){
    	$id = request()->input('id');
      $start = request()->input('start');
      $start['status'] = 1;
  		Exproject::insert($start);
    	return redirect()->route('manage_exproject_main');
    }

    public function updataprojectpost(){
    	$id = request()->input('id');
      $start = request()->input('start');
      Exproject::where("exproject_id",$id)->update($start);
    	return redirect()->route('manage_exproject_main');
    }

    //项目改变状态
    public function detail(){
    	$id = request()->input('id');
      $detail = Exproject::detail($id);
      $data['detail'] = $detail;
      return view('manage.exproject.detail',$data);
    }

}
