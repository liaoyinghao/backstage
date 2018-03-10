<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemberWx;
use App\Models\Shop;
use App\Models\ShopEmployee;
use App\Models\Kol;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;


class UserController extends Controller
{
    public function index(){
        return redirect()->route('manage_user_wechat');
    }


    public function wechat(){
        $data['lists'] = MemberWx::orderBy('id','desc')->paginate(15);
        $data['shops']=Shop::pluck('name','unionid')->toArray();
        $data['emps']=ShopEmployee::where('status',1)->pluck('realname','unionid')->toArray();
        $data['kols']=Kol::pluck('realname','unionid')->toArray();
        return view('manage.user.wechat' , $data);
    }


    public function wechatPost(){
        
        $pagination['lists']=MemberWx::orderBy('id','desc')->paginate(15);
        $pagination['shops']=Shop::pluck('name','unionid')->toArray();
        $pagination['emps']=ShopEmployee::where('status',1)->pluck('realname','unionid')->toArray();
        $pagination['kols']=Kol::pluck('realname','unionid')->toArray();
        return $pagination;

    }

    public function wechatPosts(){
        $pp=MemberWx::orderBy('id','desc')->paginate(15)->links();
        return $pp;
    }

    public function search(){
        $name = request()->input('name');
        $sorting = request()->input('sorting');
        if($sorting == 1){
           $data['lists'] = MemberWx::where('nickname', 'like', "%$name%")->paginate(15);
        }elseif($sorting == 1.5){
           $data['lists'] = MemberWx::orderBy('id','desc')->where('nickname', 'like', "%$name%")->paginate(15); 
        }elseif($sorting == 2){
           $data['lists'] = MemberWx::orderBy('subscribe_time','desc')->where('nickname', 'like', "%$name%")->paginate(15); 
        }elseif($sorting == 2.5){
           $data['lists'] = MemberWx::orderBy('subscribe_time','asc')->where('nickname', 'like', "%$name%")->paginate(15); 
        }elseif($sorting == 3){
           $data['lists'] = MemberWx::orderBy('addtime','desc')->where('nickname', 'like', "%$name%")->paginate(15); 
        }elseif($sorting == 3.5){
           $data['lists'] = MemberWx::orderBy('addtime','asc')->where('nickname', 'like', "%$name%")->paginate(15); 
        }else{
            $data['lists'] = MemberWx::orderBy('id','desc')->where('nickname', 'like', "%$name%")->paginate(15);
        }
        
        $data['shops']=Shop::pluck('name','unionid')->toArray();
        $data['emps']=ShopEmployee::where('status',1)->pluck('realname','unionid')->toArray();
        $data['kols']=Kol::pluck('realname','unionid')->toArray();
        return $data;
    }

    public function searchPagination(){
        $name = request()->input('name');
        $sorting = request()->input('sorting');
        if($sorting == 1){
            $pp=MemberWx::where('nickname', 'like', "%$name%")->paginate(15)->links();
        }else{
           $pp=MemberWx::orderBy('id','desc')->where('nickname', 'like', "%$name%")->paginate(15)->links(); 
        }
        $pp=MemberWx::orderBy('id','desc')->where('nickname', 'like', "%$name%")->paginate(15)->links();
        return $pp;
    }

    public function sortingData(){
        $id = request()->input('id');
        $subscribe_time = request()->input('subscribe_time');
        $addtime = request()->input('addtime');
        if($id){
            if($id=='1'){
                $pagination['lists']=MemberWx::paginate(15);
            }else{
                $pagination['lists']=MemberWx::orderBy('id','desc')->paginate(15);
            }
        }elseif ($subscribe_time) {
            if($subscribe_time=='1'){
                $pagination['lists']=MemberWx::orderBy('subscribe_time','asc')->paginate(15);
            }else{
                $pagination['lists']=MemberWx::orderBy('subscribe_time','desc')->paginate(15);
            }
        }

        $pagination['shops']=Shop::pluck('name','unionid')->toArray();
        $pagination['emps']=ShopEmployee::where('status',1)->pluck('realname','unionid')->toArray();
        $pagination['kols']=Kol::pluck('realname','unionid')->toArray();
        return $pagination;
    }
    public function sortingPagination(){
        $id = request()->input('id');
        $subscribe_time = request()->input('subscribe_time');
        $addtime = request()->input('addtime');
        $name = request()->input('name');
        if($id){
            if($id == 'zero'){
                $pp=MemberWx::orderBy('id','desc')->paginate(15)->links();
            }else{
                if($name){
                    $pp=MemberWx::where('nickname', 'like', "%$name%")->paginate(15)->links();
                }else{
                    $pp=MemberWx::paginate(15)->links();
                }
            }  
        }elseif ($subscribe_time) {
            if($subscribe_time=='1'){
                $pagination['lists']=MemberWx::orderBy('subscribe_time','asc')->paginate(15)->links();
            }else{
                if($name){
                    $pagination['lists']=MemberWx::where('nickname', 'like', "%$name%")->orderBy('subscribe_time','desc')->paginate(15)->links();
                }else{
                        $pp=MemberWx::orderBy('subscribe_time','desc')->paginate(15)->links();
                }
            }
        }
        
        
        return $pp;
    }

}
