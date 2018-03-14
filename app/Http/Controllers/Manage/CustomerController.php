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
        return view('manage.calendar.main');
    }

    public function khdetails(){
        return view('manage.calendar.main');
    }

}
