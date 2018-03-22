<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LeaveController extends Controller
{

    public function main(){
        return view('manage.leave.main');
    }

    public function ldetails(){
        return view('manage.leave.ldetails');
    }

}
