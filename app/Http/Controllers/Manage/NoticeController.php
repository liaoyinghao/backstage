<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Notice;
class NoticeController extends Controller
{

    public function main(){
        $topuser=$GLOBALS['m']['user'];
        $user=Accountnum::where('username',$topuser)->first();
        $data['user']=Accountnum::where('position','总经理')->pluck('nickname','id')->toArray();
        if($user['position'] == '总经理'){
            $data['flag'] = 1;
        }
        $time=date('Y-m-d',time());
        $data['lists'] =Notice::where('kstime','<',$time)->where('jstime','>=',$time)->get();
        return view('manage.notice.main',$data);
    }

    public function mainlist(){
        $data['time']=date('Y-m-d',time());
        $data['lists'] =Notice::get();
        $data['user']=Accountnum::where('position','总经理')->pluck('nickname','id')->toArray();
        return view('manage.notice.mainlist',$data);
    }

    public function addnotice(){
    	//如果是查看，就赋$store值
    	$data['flag'] = request()->input('flag');
        $data['kid'] = request()->input('kid');
        $topuser=$GLOBALS['m']['user'];
        $user=Accountnum::where('username',$topuser)->first();
        if($user['position'] == '总经理'){
            $data['id'] =$user['id'];
        }
        if($data['kid']){
            $data['lists'] =Notice::where('id',$data['kid'])->first();
        }
        return view('manage.notice.addnotice',$data);
    }

    public function tz(Request $request)
    {
        $m['fsid'] = $request['id'];
        $m['title'] = $request['title'];
        $m['progress'] = $request['progress'];
        $m['addtime'] = time();
        $m['kstime'] = $request['kstime'];
        $m['jstime'] = $request['jstime'];
        Notice::insert($m);
        return redirect()->route('manage_notice_main');
    }

}
