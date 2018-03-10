<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemberCard;
use App\Models\Coupon;
use App\Models\Executive;
use \App\Library\Tools;
use App\Library\Wechat;

class MemberController extends Controller
{

    public function main(){

        $data['list'] = MemberCard::Get();

        foreach ($data['list'] as $k => $v) {
            $exec = Executive::select('nickname')->where('id',$v['exec_id'])->pluck('nickname');
            if(empty($exec[0])){
            $data['list'][$k]['nickname'] = "无";
            }else{
            $data['list'][$k]['nickname'] = $exec[0];
            }
        }
        return view('manage.membershipcard.main',$data);
    }

    public function modify(Request $request){
        $id = $request['id'];
        $data['modify'] = MemberCard::where("id",$id)->first();
        $exec_id = $data['modify']['exec_id'];
        if(!empty($exec_id)){
            $exec = Executive::select('nickname')->where('id',$exec_id)->pluck('nickname');
            $data['modify']['nickname'] = $exec[0];
        }


        if(!empty($data['modify']['balance_corr'])){
            $data['modify']['balance_corr'] = unserialize($data['modify']['balance_corr']);
        }

        if(!empty($data['modify']['brokerage_corr'])){
            $data['modify']['brokerage_corr'] = unserialize($data['modify']['brokerage_corr']);
        }

        if(!empty($data['modify']['f_brokerage'])){
            $data['modify']['f_brokerage'] = unserialize($data['modify']['f_brokerage']);
        }

        if(!empty($data['modify']['f_balance'])){
            $data['modify']['f_balance'] = unserialize($data['modify']['f_balance']);
        }


        // if(!empty($data['modify']['f_balance'])){
        //     $data['modify']['f_balance'] = unserialize($data['modify']['f_balance']);
        // }
        // if(!empty($data['modify']['f_brokerage'])){
        //     $data['modify']['f_brokerage'] = unserialize($data['modify']['f_brokerage']);
        // }
        if(!empty($data['modify']['condition'])){
            $data['modify']['condition'] = unserialize($data['modify']['condition']);
        }


        $data['exec'] = Executive::Get();

        $data['color'] = Coupon::cardcolor();
        $data['cards'] = MemberCard::where('id','!=',$id)->get();
        return view('manage.membershipcard.modify',$data);
    }

    public function modifyPost(){
            $member_id = request()->input('member_id');
            $members = request()->input('members');
            $integral = request()->input('integral');
            $members['f_balance'] = serialize($integral);
            $b_num = $members['f_broke_bonus'];
            if($b_num ==1){
                $f_brokerage=[
                    "zuidi"=>$members['zuidi'],
                    "type"=>1,  //使用第一种给上级佣金结算方式
                    "f_brokerage1"=>$members['f_brokerage1'],
                    "f_brokerage2"=>$members['f_brokerage2'],
                ];
            }else{
                $f_brokerage=[
                    "zuidi"=>$members['zuidi'],
                    "type"=>2,  //使用第二种给上级佣金结算方式
                    "f_brokerage"=>$members['f_brokerage']
                ];
            }
            
            $balance_corr=[
                "balance_corr_money"=>$members['balance_corr_money'],
                "balance_corr_integral"=>$members['balance_corr_integral'],
            ];
            $brokerage_corr=[
                "brokerage_corr_money"=>$members['brokerage_corr_money'],
                "brokerage_corr_integral"=>$members['brokerage_corr_integral'],
            ];
            $condition=[
                "condition1"=>$members['condition1'],
                "condition2"=>$members['condition2']
            ];

            
            $members['balance_corr'] = serialize($balance_corr);
            $members['brokerage_corr'] = serialize($brokerage_corr);
            $members['f_brokerage'] = serialize($f_brokerage);
            $members['condition'] = serialize($condition);


            unset(
                $members['balance_corr_money'],
                $members['balance_corr_integral'],
                $members['brokerage_corr_money'],
                $members['brokerage_corr_integral'],
                $members['f_brokerage1'],
                $members['f_brokerage2'],
                $members['zuidi'],
                $members['f_brokerage_rule'],
                $members['f_brokerage_corr_money'],
                $members['f_brokerage_corr_integral'],
                $members['f_brokerage_init'],
                $members['condition1'],
                $members['condition2']
                );



            if(empty($member_id)){
                $pattern = '1 2 3 4 5 6 7 8 9 0 a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L O M N O P Q R S T U V W X Y Z';
                $patter = explode(' ',$pattern);
                $key = 8;
                for ($a = 0; $a<32; $a++) {
                   $key .= $patter[mt_rand(2, 61)];    //生成php随机数
                }
                $members['member_id'] = md5($key);
                $members['addtime'] = time();

                MemberCard::insert($members);
            }else{
                MemberCard::where('member_id',$member_id)->update($members);
            }

            //压缩图片
            $logo_url = $members['logo_url'];
            if($logo_url != '/img/hdj.png'){
                $logo_url = public_path().$logo_url;
                Tools::compressed_image($logo_url,$logo_url);
            }

            return redirect()->route('manage_member_main');
    }

    public function modifyDelete(){
        $id = request()->input('id');
        MemberCard::where("id",$id)->delete();
        return 1;
    }

//图片上传
    public function picUp(Request $request){
        try {
            if(!request()->file('file')->getSize()){
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
        $folder='uploads/h5/'.date('Ym');
        $name=date('His').mt_rand(100,999). '.jpg';
        return $request->file('file')->storeAs($folder , $name ,'o2o' );
    }


}
