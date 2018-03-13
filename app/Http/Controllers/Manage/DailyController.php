<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DailyController extends Controller
{

    public function main(){
        return view('manage.daily.main');
    }

}
