<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Street;
use App\Models\Executive;
use App\Models\Shop;
use App\Models\Shake;
use App\Models\Kol;
use App\Models\ShakeToPage;

class StreetController extends Controller
{
    public function index(){
        return redirect()->route('manage_street_main');
    }


    public function main(){
//        $data['lists']=Street::mList();
//        $data['mname']=Executive::mName();
//        $data['count']=Shop::mCount();
//        $data['nums']=Shake::streetShakeNum();
//        $data['types']=Street::streetType();
//        $data['kols']=Kol::streetNum();
        $data['a'] = 1;
        return view('manage.street.main' , $data);
    }


//    public function add(){
//        $data=[];
//        $data['types']=Street::streetType();
//        return view('manage.street.form' , $data);
//    }
//
//
//    public function addPost(){
//        $street=request()->input('street');
//        Street::aSave($street);
//        return redirect()->route('manage_street_main');
//    }
//
//
//    public function edit(){
//        $streetid=request()->input('streetid');
//        $data['edits']=Street::manageInfo($streetid);
//        $data['types']=Street::streetType();
//        return view('manage.street.form' , $data);
//    }
//
//
//    public function editPost(){
//        $street=request()->input('street');
//        Street::where('id',$street['id'])->update($street);
//        return redirect()->route('manage_street_main');
//    }
//
//    public function bindShake(){
//        $streetid=request()->input('streetid');
//        $data['street']=Street::manageInfo($streetid);
//        $data['lists']=Shake::mLists();
//        $data['nums']=ShakeToPage::shakeNum(1);
//        return view('manage.street.bindshake' , $data);
//    }
//
//    public function bindShakePost(){
//        $streetid=request()->input('streetid');
//        $shakeid=request()->input('shakeid');
//        if($shakeid)
//            Shake::streetBind($streetid,$shakeid);
//
//        return 1;
//    }




}
