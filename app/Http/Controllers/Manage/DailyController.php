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
        if($user){
            if($user['position'] == '总经理'){
                $data['lists'] = Daily::get();
            }else{
                $data['lists'] = Daily::where('nid',$user['id'])->get();

            }
        }
        return view('manage.daily.main',$data);
    }

    public function adddaily(){
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
