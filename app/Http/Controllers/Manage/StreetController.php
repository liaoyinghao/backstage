<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StreetController extends Controller
{
    public function index(){
        return redirect()->route('manage_street_main');
    }


    public function main(){
        return view('manage.street.main');
    }

}
