<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Verifications;
use App\Models\Admin;

class AdminController extends Controller
{

    public function index(){
        $data['lists']=[];
        return view('manage.index.index' , $data);
    }

    public function login(){
        $data['time']=time();
        $data['code']=str_random(8);
        return view('manage.index.login' , $data);
    }


    public function loginPost(){
        $time=request()->input('time');
        $code=request()->input('code');
        $flag=request()->input('flag');
        if($flag=='enter'){
            $info=Verifications::where('code',$code)->where('addtime',$time)->where('status',2)->first();
            if(!$info)
            return 0;

            $admin=Admin::where('unionid' , $info->unionid)->first();
            if($info && $admin){
                cookie()->queue('manage_uid',$admin->id,86400*30);
                cookie()->queue('manage_name',$admin->name,86400*30);
                cookie()->queue('manage_avatar',$admin->avatar,86400*30);
                return 1;
            }else{
                return 0;
            }
        }

        if($flag=='logout'){
            cookie()->queue('manage_uid',null,-1);
            cookie()->queue('manage_name',null,-1);
            cookie()->queue('manage_avatar',null,-1);
            return redirect()->route('manage_login');
        }


    }
}
