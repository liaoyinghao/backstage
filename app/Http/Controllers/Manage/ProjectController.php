<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Customer;

class ProjectController extends Controller
{

    public function main(){
        $data['lists'] =Project::get();
        return view('manage.project.main',$data);
    }

    public function addproject(){
    	$aid = request()->input('aid');
    	$id = request()->input('id');
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

}
