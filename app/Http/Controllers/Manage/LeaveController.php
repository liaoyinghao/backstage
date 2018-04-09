<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Leave;

class LeaveController extends Controller
{

    public function main(){
    	$data['info'] = Accountnum::userinfo($GLOBALS['m']['user']);
    	$data['list'] = Leave::dailylist($data['info']);
        foreach ($data['list'] as $key => $value) {
            if(!empty($value)){
                $data['list'][$key]['kstime'] = str_replace("T",' ',$value['kstime']);
                $data['list'][$key]['jstime'] = str_replace("T",' ',$value['jstime']);
            }
        }
        // dd($data['list']);
        return view('manage.leave.main',$data);
    }

    public function dailylist(Request $request){
        if($request['kstime'] && $request['jstime']){
            $data['kstime'] = $request['kstime'];
            $data['jstime'] = $request['jstime'];
          }
        $data['info'] = Accountnum::userinfo($GLOBALS['m']['user']);
        $data['list'] = Leave::dailylistst($data['info'],$request);
        foreach ($data['list'] as $key => $value) {
            if(!empty($value)){
                $data['list'][$key]['kstime'] = str_replace("T",' ',$value['kstime']);
                $data['list'][$key]['jstime'] = str_replace("T",' ',$value['jstime']);
            }
        }
        return view('manage.leave.mainlist',$data);
    }

    public function ldetails(){
        $id = request()->input("id");
        if(!empty($id)){
            $data['stoer'] = Leave::dailyinfo($id);
        }
    	$data['info'] = Accountnum::where('username',$GLOBALS['m']['user'])->select('nickname')->first();
        return view('manage.leave.ldetails',$data);
    }

    public function addldetails(){
    	$info = Accountnum::where('username',$GLOBALS['m']['user'])->select('id')->first();
    	$start = $username=request()->input('start');
    	$start['qid'] = $info['id'];
    	$start['addtime'] = time();
    	$m = Leave::insert($start);
    	if($m){
    		return redirect()->route('manage_leave_main');
    	}else{
    		return view('manage.common.error',['msg'=>'申请请假添加失败！']);
    	}
    }

    public function leavestatus(){
        $id = request()->input("id");
        $status = request()->input("status");
        if(!empty($id) || !empty($status)){
            Leave::where("id",$id)->update(['status'=>$status]);
            return 1;
        }else{
            return 0;
        }
    }

}
