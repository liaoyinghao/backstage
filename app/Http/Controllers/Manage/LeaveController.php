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

        if($data['info']['position'] == '销售主管' || $data['info']['position'] == '客服主管'){
            //如果是主管
            $userid = Accountnum::where("fromuser",$data['info']['id'])->get();
            $nameid = [];
            foreach ($userid as $k => $v) {
                if(!empty($v)){
                    $nameid[$k] = $v['id'];
                }
            }
            // $time = time() - 86400*3;
            // $data['stoer'] = Leave::where("status",'1')->where("addtime",'>',$time)->whereIn("qid",$nameid)->count();

            $stoer = Leave::where("status",'1')->whereIn("qid",$nameid)->get();
            $kong=[];
            foreach ($stoer as $key => $value) {
              $starttime = explode('T',$value['kstime']);
              $endtime = explode('T',$value['jstime']);
              if(strtotime($endtime[0]) - strtotime($starttime[0]) < 86400*3){
                array_push($kong,$value);
              }
            }
            $data['stoer'] = count($kong);
        }
        // dd($data);
        return view('manage.leave.main',$data);
    }

    public function dailylist(Request $request){
        if($request['kstime'] && $request['jstime']){
            $data['kstime'] = $request['kstime'];
            $data['jstime'] = $request['jstime'];
          }

        $data['info'] = Accountnum::userinfo($GLOBALS['m']['user']);

        if($data['info']['position'] == '销售主管' || $data['info']['position'] == '客服主管'){
          // dd(1);
          $data['flag'] = 2;
          // dd($data['flag']);
        }
        $data['list'] = Leave::dailylistst($data['info'],$request);
        foreach ($data['list'] as $key => $value) {
            if(!empty($value)){
                $data['list'][$key]['kstime'] = str_replace("T",' ',$value['kstime']);
                $data['list'][$key]['jstime'] = str_replace("T",' ',$value['jstime']);
            }
        }
        return view('manage.leave.mainlist',$data);
    }

    public function zuleave(){
          $user = Accountnum::userinfo($GLOBALS['m']['user']);
          if($user['position'] == '销售主管'){
              $data['zuyuan'] = Accountnum::userfromleave($user['id']);
              return view('manage.leave.zuleave',$data);
          }
          if($user['position'] == '客服主管'){
              $data['zuyuan'] = Accountnum::userfromleave($user['id']);
              return view('manage.leave.zuleave',$data);
          }
    }

    public function zuyuanqj(){
        $id=request()->input('id');
        $lists = Leave::where('qid',$id)->where('status','!=',0)->get();


        $userList = [];
        $i = 0;
        foreach ($lists as $key => $val) {
          if(!empty($val)){
            $userList[$i] = $val;
            $str = Accountnum::userid($val['qid']);
            $userList[$i]['nickname'] = $str['nickname'];
            $userList[$i]['position'] = $str['position'];
            $i++;
          }
        }
        $data['list'] = $userList;
        foreach ($data['list'] as $key => $value) {
            if(!empty($value)){
                $data['list'][$key]['kstime'] = str_replace("T",' ',$value['kstime']);
                $data['list'][$key]['jstime'] = str_replace("T",' ',$value['jstime']);
            }
        }
        return view('manage.leave.zuyuanqj',$data);
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


    public function sqlist(){
        $data['info'] = Accountnum::userinfo($GLOBALS['m']['user']);

        //显示自己的状态为1未读和0拒绝的的申请列表
        $userid = Accountnum::where("fromuser",$data['info']['id'])->get();
        $nameid = [];
        foreach ($userid as $k => $v) {
            if(!empty($v)){
                $nameid[$k] = $v['id'];
            }
        }
        $stoer = Leave::where("status",'1')->whereIn("qid",$nameid)->get();
        $kong=[];
        foreach ($stoer as $key => $value) {
          $starttime = explode('T',$value['kstime']);
          $endtime = explode('T',$value['jstime']);
          if(strtotime($endtime[0]) - strtotime($starttime[0]) < 86400*3){
            array_push($kong,$value);
          }
        }
        foreach ($kong as $key => $val) {
            if(!empty($val)){
                $str = Accountnum::userid($val['qid']);
                $stoer[$key]['nickname'] = $str['nickname'];
                $stoer[$key]['position'] = $str['position'];
                $stoer[$key]['kstime'] = str_replace("T",' ',$val['kstime']);
                $stoer[$key]['jstime'] = str_replace("T",' ',$val['jstime']);
            }
        }
        $data['list'] = $kong;

        return view('manage.leave.sqlist',$data);
    }

}
