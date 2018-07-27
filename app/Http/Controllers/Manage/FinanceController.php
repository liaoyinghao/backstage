<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Customer;
use App\Models\Project;

class FinanceController extends Controller
{

    public function main(Request $request){
        if($request['kstime'] && $request['jstime']){
            $starts=strtotime($request['kstime']);
            $ends=strtotime($request['jstime']) + 86400;
            $data['kstime'] = $request['kstime'];
            $data['jstime'] = $request['jstime'];
          }

        $accountnum = Accountnum::where("username",$GLOBALS['m']['user'])->get();
        if($accountnum[0]['position'] == '总经理' || $accountnum[0]['position'] == '财务'){
            // $accountnum=Accountnum::orderBy('id','desc')->get();
            $jingli2 = [];
            $jingli=Accountnum::where('position','总经理')->where("status",1)->get();
            foreach ($jingli as $key1 => $val1) {
                $jingli2[$key1] = $val1;
            }
            $zhuguan2 = [];
            $zhuguan=Accountnum::where('position','销售主管')->where("status",1)->get();
            foreach ($zhuguan as $key2 => $val2) {
                $zhuguan2[$key2] = $val2;
            }
            $kfzhuguan2 = [];
            $kfzhuguan=Accountnum::where('position','客服主管')->where("status",1)->get();
            foreach ($kfzhuguan as $key3 => $val3) {
                $kfzhuguan2[$key3] = $val3;
            }
            $xs2 = [];
            $xs=Accountnum::where('position','销售')->where("status",1)->get();
            foreach ($xs as $key4 => $val4) {
                $xs2[$key4] = $val4;
            }
            $kf2 = [];
            $kf=Accountnum::where('position','客服')->where("status",1)->get();
            foreach ($kf as $key5 => $val5) {
                $kf2[$key5] = $val5;
            }
            $cw2 = [];
            $cw=Accountnum::where('position','财务')->where("status",1)->get();
            foreach ($cw as $key6 => $val6) {
                $cw2[$key6] = $val6;
            }

            $accountnum  = array_merge_recursive($cw2,$kf2,$xs2,$kfzhuguan2,$zhuguan2,$jingli2);

            // dd($accountnum);

        }
        if ($accountnum[0]['position'] == '销售主管') {
            $accountnum = Accountnum::whereRaw('(fromuser = ? or id = ?)',[$accountnum[0]['id'],$accountnum[0]['id']])->get();
        }

        if ($accountnum[0]['position'] == '客服' || $accountnum[0]['position'] == '客服主管') {
            $accountnum = [];
        }

        $arr = [];
        $i = 1;
        foreach ($accountnum as $key => $value) {
          if(!empty($value)){
            $BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
            $EndDate=date('Y-m-01', strtotime(date("Y-m-d") . '+1 month'));
            // dd($EndDate);
            $start=strtotime($BeginDate);
            $end=strtotime($EndDate);
            if($request['kstime'] && $request['jstime']){
              $start=$starts;
              $end=$ends;
            }
          $kid=Customer::where('fromuser',$value['id'])->pluck('id')->toArray();//找出属于同一个职员的
          $xsz=Project::whereIn('kid',$kid)->whereIn('status',[2,3,4])->where('prosta', '=', '1')->sum('contractamount');//同一个职员下的总销售
          $dijia=Project::whereIn('kid',$kid)->whereIn('status',[2,3,4])->where('prosta', '=', '1')->sum('floorprice');//同一个职员下的总利润
          $xslr=$xsz-$dijia;
          $arr[$i]['xsz']=$xsz;
          $arr[$i]['xslr']=$xslr;
          $arr[$i]['nickname']=$value['nickname'];
          $arr[$i]['position']=$value['position'];
          $xszdy=Project::whereIn('kid',$kid)->whereIn('status',[2,3,4])->where('addtime','<',$end)->where('addtime','>',$start)->sum('contractamount');//当月同一个职员下的总销售
          $dijiady=Project::whereIn('kid',$kid)->whereIn('status',[2,3,4])->where('addtime','<',$end)->where('addtime','>',$start)->sum('floorprice');//当月同一个职员下的总利润
          $xslrdy=$xszdy-$dijiady;
          $arr[$i]['xszdy']=$xszdy;
          $arr[$i]['xslrdy']=$xslrdy;
          $arr[$i]['id']=$i;
          $arr[$i]['kid']=$value['id'];
          $i ++ ;
          }
        }
        $data['lists']=$arr;
        return view('manage.finance.main',$data);
    }

    public function fdetails(){
        $kids= request()->input('kid');
        $data['nickname'] = request()->input('nickname');
        $data['xslrdy'] = request()->input('xslrdy');
        $data['xszdy'] = request()->input('xszdy');
        $data['xslr'] = request()->input('xslr');
        $data['xsz'] = request()->input('xsz');
        $kid=Customer::where('fromuser',$kids)->pluck('id')->toArray();//找出属于同一个职员的
        $data['kid']=Customer::where('fromuser',$kids)->pluck('name','id')->toArray();//找出属于同一个职员的
        $data['lists']=Project::whereIn('kid',$kid)->where('status', '>', '0')->get();//同一个职员下的总销售
        return view('manage.finance.fdetails',$data);
    }

}
