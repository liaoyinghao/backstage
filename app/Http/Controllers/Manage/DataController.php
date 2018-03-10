<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ViewPage;
use App\Models\Member;
use App\Models\Shop;

class DataController extends Controller
{
    public function index(){
        return redirect()->route('manage_data_pv');
    }


    public function pv(){
        $data['lists']=ViewPage::orderBy('id','desc')
        ->where('ling','=',null)
        ->where('he','=',null)
        ->where('member','=',null)
        ->where('share','=',null)
        ->where('yiye','=',null)
        ->where('kap','=',null)
        ->where('kaqview','=',null)
        ->where('external','=',null)
        ->where('shopid', '!=',0)
        ->paginate(25);
        $data['members']=Member::pluck('nickname','unionid')->toArray();
        $data['shops']=Shop::pluck('name','id')->toArray();
        return view('manage.data.pv' , $data);
    }
}
