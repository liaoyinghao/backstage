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
        $type = request()->input('type');
        if(!empty($type)){
    	   $data['type'] = $type;
        }
        $data['list'] = Accountnum::whereRaw("status = ? and (position = ? or position = ?)",['1','客服主管','客服'])->get();
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
        $paiddepositcount = 0;
        if(!empty($data['start']['paiddeposit'])){
            $data['start']['paiddeposit'] = unserialize($data['start']['paiddeposit']);
            $paiddepositcount= count($data['start']['paiddeposit']);
        }
            $data['start']['paiddepositcount'] = $paiddepositcount;
        return view('manage.project.addproject',$data);
    }

    //项目增加和修改
    public function addprojectpost(){
    	$id = request()->input('id');
    	$aid = request()->input('aid');
        $start = request()->input('start');

    	$type = request()->input('type');//这是销售添加的已付定金
        if(!empty($type)){
            $paiddeposit = serialize($start['paiddeposit']);
            $projects = Project::where("id",$id)->first();
            if($start['paiddeposit'] != $projects['paiddeposit']){
                Project::where("id",$id)->update(['paiddeposit'=>$paiddeposit,'status'=>1]);
            }
            return redirect()->route('manage_project_main');
        }

        $dijia = request()->input('dijia');//这是客服修改底价
        if(!empty($dijia)){
            Project::where("id",$id)->update(['floorprice'=>$start['floorprice']]);
            return redirect()->route('manage_project_main');
        }

        if(!empty($aid)){
            //增加
            $paiddeposit[0] = $start['paiddeposit'];
            $start['paiddeposit'] = serialize($paiddeposit);
            $start['addtime'] = time();
    		$start['kid'] = $aid;
    		Project::insert($start);
    		Customer::where("id",$aid)->update(['status'=>2]);
    	}else{
    		//修改
            $start['paiddeposit'] = serialize($start['paiddeposit']);  
            $projects = Project::where("id",$id)->first();
            if($start['paiddeposit'] != $projects['paiddeposit']){
                $start['status'] = 1;
            }
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
    	$cwid = request()->input('cwid');
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
            if(empty($cwid)){
                $isok = Project::where("id",$id)->update(['status'=>$status]);
            }else{
    		   $isok = Project::where("id",$id)->update(['status'=>$status,'cwid'=>$cwid]);
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

    //添加定金
    public function addprojectst(){
        $id = request()->input('id');
        $data['start'] = Project::projectinfo($id);
        $paiddepositcount = 0;
        if(!empty($data['start']['paiddeposit'])){
            $data['start']['paiddeposit'] = unserialize($data['start']['paiddeposit']);
            $paiddepositcount= count($data['start']['paiddeposit']);
        }
        $data['start']['paiddepositcount'] = $paiddepositcount;
        return view('manage.project.addprojectst',$data);
    }

    //更改底价
    public function gaidijia(){
        $id = request()->input('id');
        $data['start'] = Project::projectinfo($id);
        return view('manage.project.gaidijia',$data);
    }

}
