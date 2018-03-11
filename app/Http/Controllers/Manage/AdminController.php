<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Verifications;
use App\Models\Admin;

class AdminController extends Controller
{

    public function login(){
        $data['time']=time();
        $data['code']=str_random(8);
        return view('manage.index.login' , $data);
    }


    public function loginPost(){
        $username=request()->input('username');
        $password=request()->input('password');
        if(!empty($username) && !empty($password)){
            return 1;
        }
        


        // cookie()->queue('manage_uid',$admin->id,86400*30);
        // cookie()->queue('manage_name',$admin->name,86400*30);
        // cookie()->queue('manage_avatar',$admin->avatar,86400*30);
                
        $flag=request()->input('flag');
        if($flag=='logout'){
            cookie()->queue('manage_uid',null,-1);
            cookie()->queue('manage_name',null,-1);
            cookie()->queue('manage_avatar',null,-1);
            return redirect()->route('manage_login');
        }


    }
}
