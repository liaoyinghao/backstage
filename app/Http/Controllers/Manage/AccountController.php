<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemberKol;
use App\Models\KolMoneycard;
use App\Models\Executive;
use App\Models\GoodsOrder;
use App\Models\Shop;
use App\Models\Reconciliation;
use App\Models\Kol;
use App\Models\MemberCard;
class AccountController extends Controller
{

    //支出
    public function defray(){
        $data['lists']=Executive::get();
        foreach ($data['lists'] as $key => $value) {
            //总支出
            $memlist=MemberKol::where('exec_id',$value->id)->get();
            if($memlist){
                $data['zong'] =0 ;
                foreach ($memlist as $key1 => $value1) {
                    //佣金总
                    if($value1->exec_id == $value->id){
                        $data['lists'][$key]['zong']+=$value1['brokerage'];
                    }
                }
            }
            //未收入，已收入
            // $list=KolMoneycard::where('exec_id',$value->id)->get();
            // if($list){
            //     $data['ysr']=0;
            //     $data['wsr']=0;
            //     foreach ($list as $key2 => $value2) {
            //         if($value1->exec_id == $value->id){
            //             $data['lists'][$key]['ysr']+=$value2['used'];
            //             $data['lists'][$key]['wsr']+=$value2['money'];
            //         }
            //
            //     }
            // }
            $list=Reconciliation::where('expenditure',$value->id)->where('status',1)->get();
            if($list){
                $data['ysr']=0;
                $data['wsr']=0;
                foreach ($list as $key2 => $value2) {
                    if($value2->exec_id == $value->id){
                        $data['lists'][$key]['ysr']+=$value2['money'];
                    }

                }
            }

            //销售总额
            $goods=GoodsOrder::where('status',1)->get();
            foreach ($goods as $key3 => $value3) {
                $execid=Shop::where('unionid',$value3->unionid)->first();
                if($execid){
                    if($execid->execid == $value->id){
                        $data['lists'][$key]['xsze']+=$value3['total'];
                    }
                }

            }
        }
        return view('manage.account.defray',$data);
    }

    //审核
    public function auditing(){
        $data['lists']=Reconciliation::get();
        foreach ($data['lists'] as $key => $value) {
            $name=Executive::where('id',$value['expenditure'])->first();
            if($name){
                $data['lists'][$key]['name']=$name->nickname;
            }
        }

        return view('manage.account.auditing',$data);
    }
    //品牌商收入
    public function shouru()
    {
        $execid=request()->input('id');
        //获取品牌商下所有佣金
        $name=Executive::where('id',$execid)->first();
        if($name->nickname){
            $data['nickname']=$name->nickname;
        }
        $memlist=MemberKol::where('exec_id',$execid)->get();
        if($memlist){
            $data['zong'] =0 ;
            foreach ($memlist as $key => $value) {
                //佣金总
                $data['zong']+=$value['brokerage'];
            }
        }
        $list=KolMoneycard::where('exec_id',$execid)->get();
        if($list){
            $data['ysr']=0;
            $data['wsr']=0;
            foreach ($list as $key1 => $value1) {
                $data['ysr']+=$value1['used'];
                $data['wsr']+=$value1['money'];
            }
        }

        return $data;
    }

    //佣金确认
    public function datails(){
        $id = request()->input();
        if(empty($id)){

        }
        $data['list']=Reconciliation::where('id',$id)->first();
        $name=Executive::where('id',$data['list']['expenditure'])->first();
            if($name){
                $data['list']['name']=$name->nickname;
                $data['list']['tel'] =$name->phone;
            }
        return view('manage.account.details',$data);
    }

    //佣金确认get提交
    public function datailsget(Request $request){
        $id = $request['id'];
        $type = $request['type'];

        if(empty($id) || empty($type)){
            return redirect()->route('manage_account_auditing');
        }
        if($type != 1 && $type != 2){
            return redirect()->route('manage_account_auditing');
        }


        Reconciliation::where('id',$id)->update(['status' => $type]);
        return redirect()->route('manage_account_auditing');
    }

    //品牌商付钱详情页面
    public function detailed(Request $request){
        $id = $request['id'];
        if(empty($id)){
            return redirect()->route('manage_account_defray');
        }
        $data['exec'] = Executive::where('id',$id)->first();
        if(!$data['exec']){
            return redirect()->route('manage_account_defray');
        }

        $data['lists']=Reconciliation::where('expenditure',$id)->get();
        return view('manage.account.detailed',$data);
    }

    //佣金积分明细
    public function comdetails()
    {
        $data['lists']=MemberKol::get();
        $data['kol']=Kol::pluck('nickname','unionid')->toArray();
        $data['membercard']=MemberCard::pluck('card_type','member_id')->toArray();
        $data['executive']=Executive::pluck('nickname','id')->toArray();
        return view('manage.account.comdetails',$data);
    }

}
