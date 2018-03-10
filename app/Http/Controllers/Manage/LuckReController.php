<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Luck;
use App\Models\Shop;
use App\Models\Member;
use App\Library\Wechat;


class LuckReController extends Controller
{
    public function index(){
        $data['lists']=Luck::manageLists();
        $data['shops']=Shop::shopNameByid();
        $data['members']=Member::memberNames();
        $data['level']=Luck::level();
        $data['status']=Luck::status();
        return view('manage.luck.takenlists' , $data);
    }



    public function show($id){
        $wechat= new Wechat;
        $data['info']=$wechat->searchLuck($id);
        // dd($data);

    }

}
