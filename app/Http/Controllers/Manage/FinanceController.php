<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Customer;
use App\Models\Project;

class FinanceController extends Controller
{

    public function main(){
        
        $accountnum = Accountnum::where("username",$GLOBALS['m']['user'])->get();
        if($accountnum[0]['position'] == '总经理' || $accountnum[0]['position'] == '财务' || $accountnum[0]['position'] == '客服' || $accountnum[0]['position'] == '客服主管'){

            $accountnum=Accountnum::get();

        }
        if ($accountnum[0]['position'] == '销售主管') {
            $accountnum = Accountnum::whereRaw('(fromuser = ? or id = ?)',[$accountnum[0]['id'],$accountnum[0]['id']])->get();
        }

        $arr = [];
        $i = 1;
        foreach ($accountnum as $key => $value) {
          $kid=Customer::where('fromuser',$value['id'])->pluck('id')->toArray();//找出属于同一个职员的
          $xsz=Project::whereIn('kid',$kid)->where('status', '>', '0')->sum('contractamount');//同一个职员下的总销售
          $dijia=Project::whereIn('kid',$kid)->where('status', '>', '0')->sum('floorprice');//同一个职员下的总利润
          $xslr=$xsz-$dijia;
          $arr[$i]['xsz']=$xsz;
          $arr[$i]['xslr']=$xslr;
          $arr[$i]['nickname']=$value['nickname'];
          $arr[$i]['position']=$value['position'];
          $BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
          $EndDate=date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
          $start=strtotime($BeginDate);
          $end=strtotime($EndDate);
          $xszdy=Project::whereIn('kid',$kid)->where('status', '>', '0')->sum('contractamount');//当月同一个职员下的总销售
          $dijiady=Project::whereIn('kid',$kid)->where('status', '>', '0')->sum('floorprice');//当月同一个职员下的总利润
          $xslrdy=$xsz-$dijia;
          $arr[$i]['xszdy']=$xszdy;
          $arr[$i]['xslrdy']=$xslrdy;
          $arr[$i]['id']=$i;
          $arr[$i]['kid']=$value['id'];
          $i ++ ;
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
