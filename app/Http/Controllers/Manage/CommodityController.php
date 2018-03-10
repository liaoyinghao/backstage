<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsOrder;
use App\Models\Shop;
use App\Models\MemberKol;
use App\Models\MemberCard;


class CommodityController extends Controller
{

    public function commodity(){
        $data['list'] = GoodsOrder::select("id","unionid","out_trade_no","addtime","total","status")->where('status',1)->get();
        if($data['list']){
            foreach ($data['list'] as $k => $v) {
                $shop = Shop::select("id","name")->where('unionid',$v['unionid'])->first();
                $data['list'][$k]['name'] = $shop['name'];
            }
        }
        return view('manage.commodity.main',$data);
    }

    public function Cdetails(){
        $id = request()->input('id');
        if(empty($id)){
            return redirect()->route('manage_recharge_commodity');
        }
        $data['basic'] = GoodsOrder::where('id',$id)->where('status',1)->first();
        if(!$data['basic']){
            return redirect()->route('manage_recharge_commodity');
        }
        
        $shop = Shop::select("id","name")->where('unionid',$data['basic']['unionid'])->first();
        $data['basic']['name'] = $shop['name'];
        
        //反序列化得到商品详情
        $data['shopmain'] = unserialize($data['basic']['shopmain']);
        $shopm = [];
        $shopmoney = 0;
        foreach ($data['shopmain'] as $key => $val) {
            $arr = explode(',',$val);
            $shopm[$key] = $arr;
            $money = $arr[1] * $arr[2];
            $shopmoney += $money;
        }
        $data['shopm'] = $shopm;
        $data['shopmoney'] = $shopmoney;//这一次购买的总价

        

        //得到会员卡的信息,如果没有得到就是，没有使用会员卡
        if(!empty($data['basic']['member_card'])){
        $memberKol = MemberKol::where('member_card',$data['basic']['member_card'])->first();
        if($memberKol){
            //得到这比订单所增加的积分和佣金
            // $balance = 0;
            // $balances = 0;
            $membercard = MemberCard::where('member_id',$memberKol['member_id'])->first();
            // if($membercard){
            //     //如果有积分设置
            //     if($membercard['supply_bonus'] == 1){
            //         $membercards = unserialize($membercard['balance_corr']);
            //         if($membercards['balance_corr_money'] < $shopmoney){
            //             //这一次购买获得的积分
            //             $balance = round($shopmoney * $membercards['balance_corr_integral']);
            //         }
            //     }
            //     //如果有佣金设置
            //     if($membercard['brokerage'] == 1){
            //         $brokerage = unserialize($membercard['balance_corr']);
            //         if($brokerage['balance_corr_money'] < $shopmoney){
            //             //这一次购买获得的佣金
            //             $balances = round($shopmoney * $brokerage['balance_corr_integral'],2);
            //         }
            //     }
            // }
            $data['membercard'] = $membercard;
        }


        // $data['balance'] = $balance;
        // $data['balances'] = $balances;
        
        $data['memberkol'] = $memberKol;
        }
        
        return view('manage.commodity.details',$data);
    }



}
