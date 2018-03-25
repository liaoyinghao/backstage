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

    public function mainlist(){
        return view('manage.notice.mainlist');
    }

    public function addnotice(){
    	//如果是查看，就赋$store值
    	$data['store'] = '';
        return view('manage.notice.addnotice',$data);
    }

}
