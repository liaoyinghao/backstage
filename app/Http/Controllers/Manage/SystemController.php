<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemText;
use App\Models\ShopWxpic;
use App\Models\Shop;
use App\Models\Logs;

class SystemController extends Controller
{
    public function index(){
        return redirect()->route('manage_system_text');
    }


    public function text(){
        $data['lists']=SystemText::aRead();
        return view('manage.system.text' , $data);
    }

    public function textPost(){
        return SystemText::aUpdate( request()->input('text') );
    }

    public function textadd(){
        return view('manage.system.textadd' );
    }


    public function textaddPost(){
        SystemText::aSave( request()->input('text') );
        return redirect()->route('manage_system_text');
    }


    //图片
    public function pic(){
        $data['lists']=ShopWxpic::aRead() ;
        $data['shops']=Shop::shopNameByid();
        return view('manage.system.pic' , $data);
    }

    public function logs(){
      $id=request()->input('id');
      if($id){
        $info=Logs::where('id',$id)->first();
        echo @unserialize($info->note);
        exit;
      }
      $lists=Logs::where('type',13)->orderBy('id','desc')->get();

      return view('manage.system.logs' , ['lists'=>$lists]);
    }

}
