<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Luck;
use App\Models\Shop;
use App\Models\Member;
use App\Library\Wechat;
use App\Models\OrderAd;
use App\Models\Coupon;
use App\Models\KolHistory;
use App\Models\Kol;
use App\Models\ShopHistories;
use App\Models\Merchant;
use App\Models\Purchase;
use App\Models\Paypos;

class PromotionFeeController extends Controller
{
    public function index(){
        $data['lists']=OrderAd::orderBy('id','desc')->get();
        $data['shops']=Shop::pluck('name','id')->toArray();
        $data['coupons']=Coupon::pluck('title','card_id')->toArray();
        $data['status']= array('0' =>'未支付', '1' =>'已支付','2' =>'已结束');
        return view('manage.promotionfee.promotionfee' , $data);
    }

    public function details(){
        $id=request()->input('id');
        $data['lists']=KolHistory::where('sn',$id)->get();
        $data['order']=OrderAd::where('out_trade_no',$id)->first();
        $data['list']=ShopHistories::where('sn',$id)->get();
        foreach ($data['list'] as $key => $value) {
            if($value->shopid == $data['order']->shopid){
                unset($data['list'][$key]);
            }
        }
        $data['pricetype']=array('0' =>'未设置','1'=>'领取推广','2'=>'核销推广');
        $data['coupons']=Coupon::pluck('title','card_id')->toArray();
        $data['kol']=Kol::pluck('nickname','unionid')->toArray();
        $data['shop']=Shop::pluck('name','unionid')->toArray();
        return view('manage.promotionfee.details',$data );
    }

    public function detailed(){
        $id=request()->input('id');
        $data['lists']=OrderAd::where('id',$id)->first();
        $data['shops']=Shop::pluck('name','id')->toArray();
        $data['coupons']=Coupon::pluck('title','card_id')->toArray();
        $data['status']= array('0' =>'未支付', '1' =>'已支付','2' =>'已结束');
        $data['pay']= array( '1' =>'余额','2' =>'pos','3'=>'微信');
        $data['pricetype']=array('0' =>'未设置','1'=>'领取推广','2'=>'核销推广');
        return view('manage.promotionfee.detailed' , $data);
    }

    public function merchant()
    {
        $data['lists']=Merchant::get();
        $data['shops']=Shop::shopNameByid();
        $data['members']=Member::memberNames();
        $data['level']=Luck::level();
        $data['status']=Luck::status();
        return view('manage.merchant.merchantlists' , $data);
    }

    public function purchase()
    {
        $data['lists']=Purchase::get();
        $data['shops']=Shop::shopNameByid();
        $data['status']=array('0' =>'未购买','1' =>'已购买' );
        return view('manage.purchase.purchase' , $data);
    }

    public function paypos()
    {
        $data['lists']=Paypos::get();
        $data['shops']=Shop::shopNameByid();
        $data['status']=array('0' =>'未购买','1' =>'已购买' );
        return view('manage.purchase.paypos' , $data);
    }

    public function payposDetails(){
        $out_trade_no = request()->input('out_trade_no');
        $data['info'] = Paypos::where('out_trade_no',$out_trade_no)->first();
        $data['shop'] = Shop::where('id',$data['info']['shopid'])->first();
        return view('manage.promotionfee.payposdetails',$data);
    }

    public function payposModify(){
        $delivery = request()->input('delivery');
        $ordernumber = request()->input('ordernumber');
        $out_trade_no = request()->input('out_trade_no');
        $paypos = Paypos::where('out_trade_no',$out_trade_no)->first();
        if($paypos['delivery'] == $delivery && $paypos['ordernumber'] == $ordernumber){
            return 2;
        }
        $data = Paypos::where('out_trade_no',$out_trade_no)->update(['delivery'=>$delivery,'ordernumber'=>$ordernumber]);
        if($data){
            return 1;
        }else{
            return 0;
        }
        
    }

}
