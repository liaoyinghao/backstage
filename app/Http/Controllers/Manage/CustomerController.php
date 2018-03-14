<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CustomerController extends Controller
{
    public function main(){
        return view('manage.customer.main');
    }

    public function khadd(){
        return view('manage.customer.khadd');
    }

    public function khaddpost(){
    	$start=request()->input('start');
    	//fromuser谁的客户 = 添加的人
    	//进度默认为空，进度时间默认为当前时间和addtime一样
        dd($start);
    }

    public function khdetails(){
    	$id=request()->input('id');

    	$data['start']=1;

        return view('manage.customer.khadd',$data);
    }

}
