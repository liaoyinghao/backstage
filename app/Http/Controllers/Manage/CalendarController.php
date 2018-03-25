<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Accountnum;

class CalendarController extends Controller
{

    public function main(){
        $info = Accountnum::userinfo($GLOBALS['m']['user']);
        $data['info'] = Calendar::datalistwz($info['id']);
        return view('manage.calendar.main',$data);
    }

    //添加修改事件
    public function eventdetails(){
        $data = [];
        $data['upid'] = request()->input('upid');
        if(!empty($data['upid'])){
            $info = Calendar::Memoranduminfo($data['upid']);
            if($info){
                $data['start'] = $info;
            }
        }
        return view('manage.calendar.eventdetails',$data);
    }

    //查看全部事件
    public function eventlist(){
        $info = Accountnum::userinfo($GLOBALS['m']['user']);
        $data['info'] = Calendar::datalist($info['id']);
        return view('manage.calendar.eventlist',$data);
    }

    //添加修改事件
    public function addcalendar(){
        $upid = request()->input('upid');
        $start = request()->input('start');
        if(empty($upid)){
            $info = Accountnum::userinfo($GLOBALS['m']['user']);
            $start['uid'] = $info['id'];
            $start['status'] = 1;
            $start['addtime'] = time();
            $m = Calendar::insert($start);
            if($m){
                return redirect()->route('manage_calendar_main');
            }else{
                return view('manage.common.error',['msg'=>'备忘录添加失败！']);
            }
        }else{
            Calendar::where("id",$upid)->update($start);
            return redirect()->route('manage_calendar_main');
        }
    }

    //添加修改事件
    public function updatestatus(){
        $id = request()->input('id');
        $status = request()->input('status');
        $m = Calendar::where('id',$id)->update(["status"=>$status]);
        if($m){
            return 1;
        }else{
            return 0;
        }
    }

}
