<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Accountnum;

class ProjectController extends Controller
{

    public function main(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['lists'] =Project::projectlistgr($data['user']);
        return view('manage.project.main',$data);
    }

    //从客户变成项目
    public function addproject(){
    	$aid = request()->input('aid');
    	$id = request()->input('id');
        $data['list'] = Accountnum::where("status",1)->where("position",'财务')->get();
        if(!empty($aid)){
    		$start = Customer::customerinfo($aid);
    		if($start){
    			$time = date("Y-m-d",time());
    			$data['start']['id'] = $start['id'];
    			$data['start']['customername'] = $start['name'];
    			$data['start']['contact'] = $start['info'];
    			$data['start']['contractamount'] = $start['offer'];
    			$data['start']['remarks'] = $start['remarks'];
    			$data['start']['status'] = 1;
    			$data['start']['signingtime'] = $time;
    			$data['start']['timepayment'] = $time;
    			$data['aid'] = $aid;
    			return view('manage.project.addproject',$data);
    		}
    	}

    	$data['start'] = Project::projectinfo($id);
        return view('manage.project.addproject',$data);
    }

    //项目增加和修改
    public function addprojectpost(){
    	$id = request()->input('id');
    	$aid = request()->input('aid');
    	$start = request()->input('start');
    	if(!empty($aid)){
    		//增加
    		$start['addtime'] = time();
    		$start['kid'] = $aid;
    		Project::insert($start);
    		Customer::where("id",$aid)->update(['status'=>2]);
    	}else{
    		//修改
    		Project::where("id",$id)->update($start);
    	}
    	return redirect()->route('manage_project_main');
    }

    //项目改变状态
    public function updatastatus(){
    	$id = request()->input('id');
    	$type = request()->input('type');//1.丢弃，2找回，3选择其他状态
        $status = request()->input('status');
    	$kfid = request()->input('kfid');
    	if($type == 1){
    		$isok = Project::where("id",$id)->update(['status'=>0]);
    		if($isok){
    			return 1;
    		}else{
    			return 0;
    		}
    	}
    	if($type == 2){
    		$isok = Project::where("id",$id)->update(['status'=>1]);
    		if($isok){
    			return 1;
    		}else{
    			return 0;
    		}
    	}
    	if($type == 3){
            if(empty($status)){ return redirect()->route('manage_project_main'); }
            if(empty($kfid)){
                $isok = Project::where("id",$id)->update(['status'=>$status]);
            }else{
    		   $isok = Project::where("id",$id)->update(['status'=>$status,'kfid'=>$kfid]);
            }
    		return redirect()->route('manage_project_main');
    	}
    }

    //全部项目
    public function list(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['lists'] =Project::projectlist($data['user']);
        return view('manage.project.list',$data);
    }

}
