<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{

    public function main(){
        return view('manage.user.main');
    }

    public function userdetailed(){
        return view('manage.user.userdetailed');
    }

}
