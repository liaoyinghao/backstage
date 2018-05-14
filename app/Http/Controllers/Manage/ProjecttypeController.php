<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Projecttype;
use App\Models\Customer;
use App\Models\Accountnum;

class ProjecttypeController extends Controller
{

    public function main(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['list'] = Projecttype::exproList();

        if($data['user']['position'] == '总经理' or $data['user']['position'] == '客服主管'){
            $data['flag'] = 1;
        }else{
            $data['flag'] = 2;
        }
        return view('manage.projecttype.main',$data);
    }

    //从客户变成项目
    public function addprojecttype(){
        return view('manage.projecttype.addprojecttype');
    }

    //从客户变成项目
    public function updata(){
    	$id = request()->input('id');
      $detail = Exproject::detail($id);
      $data['detail'] = $detail;
      return view('manage.exproject.updata',$data);
    }

    //项目增加和修改
    public function addprojecttypepost(){
    	$id = request()->input('id');
      $start = request()->input('start');
      $start['status'] = 1;
  		Projecttype::insert($start);
    	return redirect()->route('manage_projecttype_main');
    }

    public function updataprojectpost(){
    	$id = request()->input('id');
      $start = request()->input('start');
      Exproject::where("exproject_id",$id)->update($start);
    	return redirect()->route('manage_projecttype_main');
    }

    //项目改变状态
    public function detail(){
    	$id = request()->input('id');
      $detail = Exproject::detail($id);
      $data['detail'] = $detail;
      return view('manage.exproject.detail',$data);
    }

}
