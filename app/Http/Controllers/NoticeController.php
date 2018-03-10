<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Wechat;


class NoticeController extends Controller
{

    public function index(){
        return 'O2OPark';
    }

    public function modelMsg(){
        $input=request()->all();
        $wechat= new Wechat;
        $wechat->notice();


    }



}
