<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Daily;

class DailyController extends Controller
{

    public function main(){
        $topuser=$GLOBALS['m']['user'];
        $user=Accountnum::where('username',$topuser)->first();
        $data['user']=Accountnum::pluck('nickname','id')->toArray();
        $uid = request()->input('uid');
        if(!empty($uid)){
            $data['lists'] = Daily::where('nid',$uid)->get();
            $listsuser = Accountnum::where('id',$uid)->first();
            $data['listsuser'] = $listsuser['nickname'];
            return view('manage.daily.main',$data);
        }
        if($user){
            if($user['position'] == '总经理'){
                $data['lists'] = Accountnum::where('status','1')->get();
                foreach ($data['lists'] as $key => $value) {
                    if(!empty($value)){
                        $data['lists'][$key]['count'] = daily::where("nid",$value['id'])->count();
                    }
                }
                return view('manage.daily.mains',$data);
            }else{
                $data['lists'] = Daily::where('nid',$user['id'])->get();
                return view('manage.daily.main',$data);
            }
        }
        return view('manage.daily.main',$data);
    }

    public function adddaily(){
        $id = request()->input('id');
        if(!empty($id)){
            $data['store'] = Daily::dailyinfo($id);
        }
        $topuser=$GLOBALS['m']['user'];
        $data['id']=Accountnum::where('username',$topuser)->first();
        return view('manage.daily.adddaily',$data);
    }

    public function rb(Request $request)
    {
        $m['nid']=$request['id'];
        $m['title']=$request['title'];
        $m['progress']=$request['progress'];
        $m['addtime']=time();
        Daily::insert($m);

        return redirect()->route('manage_daily_main');
    }

}
