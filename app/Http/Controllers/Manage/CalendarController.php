<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CalendarController extends Controller
{

    public function main(){
        return view('manage.calendar.main');
    }

    //添加修改事件
    public function eventdetails(){
        return view('manage.calendar.eventdetails');
    }

    //查看全部事件
    public function eventlist(){
        return view('manage.calendar.eventlist');
    }


}
