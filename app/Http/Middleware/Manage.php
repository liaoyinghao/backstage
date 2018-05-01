<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\Calendar;
use App\Models\Accountnum;
use App\Models\Leave;
use App\Models\Project;

class Manage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

       if(!$request->cookie('backstage_user',0) && !in_array( array_pad( explode('/',request()->path()),2,0)[1] , ['login' , 'loginpost']) ){
           return redirect()->route('manage_login');
       }

       $GLOBALS['m']['user']=$request->cookie('backstage_user');
       $GLOBALS['m']['quanxian']=$request->cookie('backstage_user_quanxian');

        //检查未完成的备忘录
        $info = Accountnum::userinfo($GLOBALS['m']['user']);
        $infos = Calendar::where("uid",$info['id'])->where("status",1)->get();
        $count = 0;
        foreach ($infos as $key => $val) {
            $times = date("Y-m-d",time());
            if($val['betime'] <= $times){
              $count++;
            }
        }
        view()->share('calendarcount' , $count);

        //检查有请假申请审批
        if($info['position'] == '销售主管' || $info['position'] == '客服主管'){
            //如果是主管
            $userid = Accountnum::where("fromuser",$info['id'])->select("id")->get();
            $nameid = [];
            foreach ($userid as $k => $v) {
                if(!empty($v)){
                    $nameid[$k] = $v['id'];
                }
            }
            $stoer = Leave::where("status",'1')->whereIn("qid",$nameid)->get();
            $kong=[];
            foreach ($stoer as $key => $value) {
              $starttime = explode('T',$value['kstime']);
              $endtime = explode('T',$value['jstime']);
              if(strtotime($endtime[0]) - strtotime($starttime[0]) < 86400*3){
                array_push($kong,$value);
              }
            }
            $stoercount = count($kong);
            if($stoercount > 0){
              $stoercounts = "您有".$stoercount."条请假审批";
            }else{
              $stoercounts = '';
            }
            view()->share('stoercount' , $stoercounts);
        }

        if($info['position'] == '总经理'){
              //没有上级的
              $userid = Accountnum::where("status",1)->where("fromuser",'')->get();
                    $nameid = [];
                    foreach ($userid as $k => $v) {
                        if(!empty($v)){
                            $nameid[$k] = $v['id'];
                        }
                    }
                    $userids = Accountnum::where("status",1)->where("fromuser",'!=','')->get();
                    $nameids = [];
                    foreach ($userids as $ks => $vs) {
                        if(!empty($vs)){
                            $nameids[$ks] = $vs['id'];
                        }
                    }

                $stoers  = Leave::where("status",1)->whereIn("qid",$nameid)->count();//没有上级的

                $stoer = Leave::where("status",'1')->whereIn("qid",$nameids)->get();
                $kong=[];
                foreach ($stoer as $key => $value) {
                  $starttime = explode('T',$value['kstime']);
                  $endtime = explode('T',$value['jstime']);
                  if(strtotime($endtime[0]) - strtotime($starttime[0]) > 86400*3){
                    array_push($kong,$value);
                  }
                }
                $stoerst = count($kong);

                $stoercountst = $stoers + $stoerst;
                if($stoercountst > 0){
                  $stoercountst = "您有".$stoercountst."条请假审批";
                }else{
                  $stoercountst = '';
                }
                view()->share('stoercount' , $stoercountst);
        }


        //检查是否有需要被确认的项目
        if($info['position'] == '客服主管' || $info['position'] == '客服'){
          $querencounts = Project::where('kfid',$info['id'])->where('status',2)->count();//状态2是进行中
        }elseif($info['position'] == '财务'){
          $querencounts = Project::where('status',1)->count();//状态1是确认中
        }else{
          $querencounts = 0;
        }
        if($querencounts > 0){
          $querencountst = "您有".$querencounts."条项目未确认";
        }else{
          $querencountst = '';
        }
        view()->share('querencountst' , $querencountst);



        return $next($request);
    }
}
