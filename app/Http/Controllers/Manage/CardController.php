<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponCode;
use App\Models\Member;
use App\Models\Shop;
use App\Models\ShopEmployee;
use App\Models\Kol;
use App\Models\Advert;
use App\Models\Common;
use App\Models\Executive;

class CardController extends Controller
{
    public function index(){
        return redirect()->route('manage_card_main');
    }


    public function main(){

        $data['lists']=Coupon::manageLists();
        $data['veris']=CouponCode::verificationCode();
        return view('manage.card.main' , $data);
    }

    public function details(Request $request){
      $id = $request['id'];
      if($id){
        $data['lists']=Coupon::where("id",$id)->first();
        $shopname = Shop::where('id',$data['lists']['shopid'])->first();
        $data['veris']=CouponCode::verificationCode();
        $data['name']=$shopname['name'];
      }else{
        return "对不起，参数不正确";
      }
      // dd($data);
      return view('manage.card.details' , $data);
    }


    public function code(){
        $card_id=request()->input('card_id');
        if($card_id){
            $data['lists']=CouponCode::where('card_id',$card_id)->orderBy('id','desc')->get();
        }else{
            $data['lists']=CouponCode::orderBy('id','desc')->where('verycode','!=','' )->paginate(50);
        }
        //循环修改卡券领取渠道
        foreach ($data['lists'] as $key => $value) {
          $verycode = $value->verycode;
          $employee=$value->unionid;
          $member =$value->openid;
          $sn=$value->punionid;
          $shopid=$value->shopid;
          $cardid=$value->card_id;
          $s=explode('|' , $verycode);
          if(!isset($s[2])){
              $s[2]=$s[1];
              $s[1]=$s[0];
          }
          if($s[0] == 'm' || $s[0] == '911'){
              $name=Shop::where('id',$shopid)->first();
              if(isset($name)){
                   $data['lists'][$key]['nickname']=$name->name;
              }
          }else{
              $p=Coupon::where('card_id',$cardid)->where('power_type',0)->first();
              if($p){
              $t=Executive::where('id',$p->shopid)->first();
              if($t){
                  $data['lists'][$key]['nickname']=$t->nickname;
              }
              }
          }


          //修改领取渠道等
          if($s[0] == 'k'){
            $s[0] ='达人';
          }elseif($s[0] == 'p'){
            $s[0] ='店员';
          }elseif($s[0] == 'fz') {
            $s[0] ='福州';
          }else{
            $name=Shop::where('id',$shopid)->first();
            if(isset($name)){
                $s[0]=$name->name;

            }else {
                $s[0] ='店铺不存在';
            }

          }
          if($s[0] == '店铺不存在'){
              //修改sn领取渠道
              if($s[0] !='达人' && $s[0] !='店员'){
                  if(empty($name=Shop::where('sn',$sn)->first())){
                      $s[1] ='';
                  }else{
                      $s[1] = $name->name;
                  }
              }

            //达人领取渠道
              if($s[0] == '达人'){
              if(empty($name=Kol::where('sn',$sn)->first())){
                  $s[1] ='';
              }else{
                $s[1] = $name->realname;
              }
            }

            //店员领取渠道
            if($s[0] == '店员'){
              if(empty($name=ShopEmployee::where('sn',$sn)->first())){
                  $s[1] ='';
              }else{
                  $s[1] = $name->realname;
              }
            }
          }


        //判断领取渠道是否为空
        if(empty($s[1])){
        $data['lists'][$key]['verycode']=$s[0];
        }else{
        $data['lists'][$key]['verycode']=$s[0].'|'.$s[1];
        }
      }
        $data['coupons']=Coupon::pluck('title','card_id')->toArray();
        $data['members']=Member::pluck('nickname','unionid')->toArray();
        $data['members_openid']=Member::pluck('nickname','openid')->toArray();
        $data['shops']=Shop::pluck('name','id')->toArray();
        return view('manage.card.code' , $data);
  }

    public function advert(){
      $data['list'] = Advert::Get();
      return view('manage.card.advert' , $data);
    }

    //删除
    public function advertdel(){
        $id = request()->input('id');
        if(empty($id)){
          return 2;
        }

        $is = Advert::where("id",$id)->update(['status'=>'0']);
        if($is){return 1;}else{return 0;}
    }

    //恢复
    public function advertadd(){
        $id = request()->input('id');
          if(empty($id)){
            return 2;
          }
        $is = Advert::where("id",$id)->update(['status'=>'1']);
        if($is){return 1;}else{return 0;}
    }

    public function advertst(){
      return view('manage.card.advertst');
    }

    //外部券ajax提交
    public function cardAddPost(){

        $advert['title'] = request()->input('title');
        $advert['des'] = request()->input('des');
        $advert['url'] = request()->input('url');
        $advert['logo'] = request()->input('logo');
        $advert['status'] = 1;
        $advert['addtime'] = time();
        $advert['exec_id'] = 0;
        $is_advert = Advert::insert($advert);

        if($is_advert){
          if($advert['logo'] != "/img/hdj.png"){
              $imimg = public_path().$advert['logo'];
              Common::compressed_image($imimg,$imimg);//压缩图片
          }
            return 1;
        }else{
            return 0;
        }

    }

}
