<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Userlist;

class AdminController extends Controller
{

    public function login(){
        return view('manage.index.login');
    }


    public function loginPost(){
        $username=request()->input('username');
        $password=request()->input('password');
        if(!empty($username) && !empty($password)){
            $data = Accountnum::useris($username,$password);
            if($data){
                cookie()->queue('backstage_user',$data->username,86400*30);
                cookie()->queue('backstage_user_nickname',$data->nickname,86400*30);
                cookie()->queue('backstage_user_quanxian',$data->is_account,86400*30);
                return 1;
            }else{
                return 2;
            }
        }
        

                
        $flag=request()->input('flag');
        if($flag=='logout'){
            cookie()->queue('backstage_user',null,-1);
            cookie()->queue('backstage_user_quanxian',null,-1);
            cookie()->queue('backstage_user_nickname',null,-1);
            return redirect()->route('manage_login');
        }

        return 0;
    }
}
