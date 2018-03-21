<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FinanceController extends Controller
{

    public function main(){
        return view('manage.finance.main');
    }

    public function fdetails(){
        return view('manage.finance.fdetails');
    }

}
