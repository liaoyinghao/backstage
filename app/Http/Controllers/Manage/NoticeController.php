<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;

class NoticeController extends Controller
{

    public function main(){
        return view('manage.notice.main');
    }

    public function addnotice(){
    	// $info = Accountnum::userinfo($GLOBALS['m']['user']);
    	$data['user'] = Accountnum::where('username','!=',$GLOBALS['m']['user'])->where("status",1)->select("id","nickname")->get();
        return view('manage.notice.addnotice',$data);
    }

}
