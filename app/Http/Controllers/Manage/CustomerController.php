<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accountnum;
use App\Models\Customer;
use App\Models\Project;

class CustomerController extends Controller
{
    public function main(){
      $topuser=$GLOBALS['m']['user'];
      $type= request()->input('type');
      $quan= request()->input('quan');
      $shai= request()->input('shaixuan');
      $zuyuan= request()->input('zuyuan');
      $user=Accountnum::where('username',$topuser)->first();
      $data['user']=Accountnum::pluck('nickname','id')->toArray();
      $data['zuyuan']= Accountnum::where('fromuser',$user['id'])->get();
      //总经理
      if($user['position'] == '总经理'){

          $data['flag']=1;
          if($type == 'shaixuan'){
            if(empty($quan)){
              $data['lists']=Customer::where('fromuser',$user['id'])->where('grade',$shai)->where('status','!=',0)->get();
            }else{
              $data['quan']=1;
              $data['lists']=Customer::where('grade',$shai)->where('status','!=',0)->get();
            }
            // $lists=Customer::where('status','!=',0)->where('grade',$shai)->get();
          }else{
            $data['lists']=Customer::where('fromuser',$user['id'])->where('status','!=',0)->get();
            // $lists=Customer::where('status','=',0)->get();
          }
          $kong=[];
          foreach ($data['lists'] as $key => $value) {
            if(time() - $value['progresstime'] > 604800){
                    $value['khstatus'] = 1;
                }
            array_push($kong,$value);
          }
          // dd($data);
          // foreach ($lists as $key => $value) {
          //   if(time() - $value['progresstime'] > 604800){
          //           $value['khstatus'] = 1;
          //       }
          //   array_push($kong,$value);
          // }
          $data['lists'] = $kong;
          // dd($data);
      }

      //销售主管
      if($user['position'] == '销售主管'){
          $data['flag']=2;
          if($type == 'shaixuan'){
            $data['lists']=Customer::where('fromuser',$user['id'])->where('grade',$shai)->where('status','!=',0)->get();//放弃
            // $lists=Customer::where('status',0)->where('grade',$shai)->get();
          }else{
            $data['lists']=Customer::where('fromuser',$user['id'])->where('status','!=',0)->get();//放弃
            // $lists=Customer::where('status',0)->get();
          }
          $kong=[];
          foreach ($data['lists'] as $key => $value) {
              if(time() - $value['progresstime'] > 604800){
                  $value['khstatus'] = 1;
              }
              array_push($kong,$value);
          }
          // foreach ($lists as $key => $value) {
          //     if(time() - $value['progresstime'] > 604800){
          //           $value['khstatus'] = 1;
          //       }
          //     array_push($kong,$value);
          // }
          $data['lists'] = $kong;


      }

      //销售
      if($user['position'] == '销售'){

          $data['flag']=3;
          if($type == 'shaixuan'){
            $data['lists']=Customer::where('fromuser',$user['id'])->where('grade',$shai)->where('status','!=',0)->get();//放弃
            // $lists=Customer::where('status',0)->where('grade',$shai)->get();
          }else{
            $data['lists']=Customer::where('fromuser',$user['id'])->where('status','!=',0)->get();//放弃
            // $lists=Customer::where('status',0)->get();
          }
          $kong=[];
          foreach ($data['lists'] as $key => $value) {
            if(time() - $value['progresstime'] > 604800){
                    $value['khstatus'] = 1;
                }
            array_push($kong,$value);
          }
          // foreach ($lists as $key => $value) {
          //   if(time() - $value['progresstime'] > 604800){
          //           $value['khstatus'] = 1;
          //       }
          //   array_push($kong,$value);
          // }
          $data['lists'] = $kong;

      }

      //总经理查全部
      if($type == 'giveup'){
        $data['lists']=Customer::where('fromuser',$user['id'])->where('status','=',0)->get();//放弃
      }


      //总经理查全部
      if($type == 'quan'){
        $data['flag']=1;
        $data['quan']=1;
        $data['lists']=Customer::get();
        foreach ($data['lists'] as $key => $value) {
          if(!empty($value)){
            if(time() - $value['progresstime'] > 604800){
                $data['lists'][$key]['khstatus'] = 1;
            }
          }
        }
      }

      //销售主管加队员
      if($type == 'zu'){
        $data['flag']=2;
        $fromuser=Accountnum::where('fromuser',$user['id'])->pluck('id')->toArray();//找到队员
        $data['lists']=Customer::whereIn('fromuser',$fromuser)->where('status','!=',0)->get();//队员客户
        $lists=Customer::where('fromuser',$user['id'])->where('status','!=',0)->get();//自己客户
        // dd($user,$fromuser,$data['lists']);
        $kong=[];
        foreach ($data['lists'] as $key => $value) {
          if(time() - $value['progresstime'] > 604800){
              $value['khstatus'] = 1;
          }
          array_push($kong,$value);
        }
        foreach ($lists as $key => $value) {
          if(time() - $value['progresstime'] > 604800){
              $value['khstatus'] = 1;
          }
          array_push($kong,$value);
        }
        $data['lists'] = $kong;//自己+队员
      }

      //7天跟进
      if($type == 'qi'){
        $data['lists']=Customer::where('fromuser',$user['id'])->where('status',1)->get();
        $kong=[];
        foreach ($data['lists'] as $key => $value) {
          $time= time();
          if($time - $value['progresstime'] > 604800){
            $value['khstatus'] = 1;
            array_push($kong,$value);
          }
        }
        $data['lists'] = $kong;
      }

      if(!isset($data['lists'])){

        if($type == 'shaixuan'){
            $data['lists']=Customer::where('grade',$shai)->get();
          }else{
            $data['lists']=Customer::get();
          }

          foreach ($data['lists'] as $key => $value) {
            if(!empty($value)){
              if(time() - $value['progresstime'] > 604800){
                  $data['lists'][$key]['khstatus'] = 1;
              }
            }
          }
      }

      if($zuyuan){
          $data['lists']=Customer::where('fromuser',$zuyuan)->where('status','!=',0)->get();//放弃
          $lists=Customer::where('status',0)->get();
          $kong=[];
          foreach ($data['lists'] as $key => $value) {
            if(time() - $value['progresstime'] > 604800){
                    $value['khstatus'] = 1;
                }
            array_push($kong,$value);
          }
          foreach ($lists as $key => $value) {
            if(time() - $value['progresstime'] > 604800){
                    $value['khstatus'] = 1;
                }
            array_push($kong,$value);
          }
          $data['lists'] = $kong;
      }

      $data['userinfos'] = $user;
      return view('manage.customer.main',$data);
    }

    //添加用户
    public function khadd(){
        return view('manage.customer.khadd');
    }

    //添加用户post
    public function khaddpost(){
      $start=request()->input('start');
      $user = Accountnum::userinfo($GLOBALS['m']['user']);

      if(empty($start) || empty($start['name'])){
        return redirect()->route('manage_customer_khaddpost');
      }

      $user = Accountnum::userinfo($GLOBALS['m']['user']);
      $start['addtime'] = time();
      $start['progresstime'] = time();
      $start['fromuser'] = $user['id'];

        //添加编号
        $flag = 1;
        //查找数据库是否存在该编号
        while ($flag) {
          $code = date("YmdHis",time()).rand(1000,9999);
          $verCode = Customer::where("khunion",$code)->select("id")->first();
          if(!$verCode){
              $flag=0;
          }
        }
        $start['khunion'] = $code;

      $m = Customer::insert($start);
      if($m){
        return redirect()->route('manage_customer_main');
      }else{
        return view('manage.common.error',['msg'=>'修改失败!']);
      }
    }

    //修改客户等级
    public function khgrades(){
      $id=request()->input('id');
      $grades=request()->input('grades');
      $sta = Customer::where('id',$id)->select("grade")->first();
      if($sta['grade'] == $grades){
        return 1;
      }
      $start=Customer::where('id',$id)->update(['grade'=>$grades]);
      if($start){
        return 1;
      }else{
        return 0;
      }
    }

    //修改跟进信息
    public function followup(){
      $id=request()->input('id');
      $data['zid']=request()->input('zid');
      $data['start']=Customer::customerinfo($id);
      if(!empty($data['start']['progress'])){
          $tprogresst = @unserialize($data['start']['progress']);
          $count = count($tprogresst);
          if($count > 1){
              $data['count'] = $count / 2;
              $data['progress'] = [];
              $key = [];
              $val = [];
              $i = 1;
              $j = 1;
              $h = 1;
              $t = 1;
              foreach ($tprogresst as $k => $v) {
                if ($i%2==0){
                    $val[$h] = $v;
                    $h++;
                }else{
                    $key[$j] = $v;
                    $j++;
                }
                $i++;
              }

              foreach ($key as $v1 => $v2) {
                 $data['progress'][$v1]['time'] = $v2;
                 $data['progress'][$v1]['main'] = $val[$v1];
                 $data['progress'][$v1]['timename'] = 'time'.$t;
                 $data['progress'][$v1]['mainname'] = 'main'.$t;
                 $t++;
              }
          }
      }
      return view('manage.customer.followup',$data);
    }

    public function khdetail(){
      $id=request()->input('id');
      $data['zid']=request()->input('zid');
      $data['start']=Customer::customerinfo($id);
      if(!empty($data['start']['progress'])){
          $tprogresst = @unserialize($data['start']['progress']);
          $count = count($tprogresst);
          if($count > 1){
              $data['count'] = $count / 2;
              $data['progress'] = [];
              $key = [];
              $val = [];
              $i = 1;
              $j = 1;
              $h = 1;
              $t = 1;
              foreach ($tprogresst as $k => $v) {
                if ($i%2==0){
                    $val[$h] = $v;
                    $h++;
                }else{
                    $key[$j] = $v;
                    $j++;
                }
                $i++;
              }

              foreach ($key as $v1 => $v2) {
                 $data['progress'][$v1]['time'] = $v2;
                 $data['progress'][$v1]['main'] = $val[$v1];
                 $data['progress'][$v1]['timename'] = 'time'.$t;
                 $data['progress'][$v1]['mainname'] = 'main'.$t;
                 $t++;
              }
          }
      }
      return view('manage.customer.khdetail',$data);
    }

    //资料修改跟进信息post
    public function followuppost(){
      $id=request()->input('id');           //id
      $zid=request()->input('zid');           //组员
      $stoer = request()->input('stoer');   //跟进信息
      $start=request()->input('start');     //基础资料

      $customers = Customer::customerinfo($id);
      if($customers['status'] == 0){
          $user=Accountnum::userinfo($GLOBALS['m']['user']);
          $start['fromuser'] = $user['id'];
      }
      Customer::where("id",$id)->update($start);
      if(count($stoer) == 2 && empty($stoer['time1']) && empty($stoer['main1'])){
          if(empty($zid)){
              return redirect()->route('manage_customer_main');
          }else{
              return redirect()->route('manage_customer_zuyuankh',['id'=>$zid]);
          }
      }
      foreach ($stoer as $key => $value) {
        if(empty($value)){
            $stoer[$key] = 0;
        }
      }
      $progress = serialize($stoer);
      $isok = Customer::where("id",$id)->update(["progress"=>$progress]);
      if($isok){
          $time = time();
          Customer::where("id",$id)->update(["progresstime"=>$time]);
      }
      if(empty($zid)){
          return redirect()->route('manage_customer_main');
      }else{
          return redirect()->route('manage_customer_zuyuankh',['id'=>$zid]);
      }
    }

    //主管查看自己的全部组员列表
    public function chzuyuan(){
        $user = Accountnum::userinfo($GLOBALS['m']['user']);
        if($user['position'] == '销售主管'){
            $data['zuyuan'] = Accountnum::userfromuser($user['id']);
            return view('manage.customer.chzuyuan',$data);
        }
        if($user['position'] == '总经理'){
            $data['zuyuan'] = Accountnum::userfromXs();
            return view('manage.customer.chzuyuan',$data);

        }
    }

    //组员的客户
    public function zuyuankh(){
        $id=request()->input('id');
        $data['lists'] = Customer::userkh($id);
        $data['user']=Accountnum::pluck('nickname','id')->toArray();
        $data['name'] = $data['user'][$id];
        $data['zid'] = $id;
        return view('manage.customer.zuyuankh',$data);
    }

    //财务确定完之后选择客服人员
    public function khterxm(){
        $id=request()->input('id');

        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);//进来这个人的信息
        // $data['info'] = Customer::where('id',$id)->select("id","name")->first();//项目信息
        $data['info'] = Project::where('id',$id)->select("id","proname","kfid","status")->first();//项目信息
        $data['list'] = Accountnum::where("id",$data['info']['kfid'])->get();//查询指定的客服
        if($data['user']['position'] == '销售主管' || $data['user']['position'] == '销售'){
            $data['user']['type'] = 1;
        }else if($data['user']['position'] == '客服主管' || $data['user']['position'] == '客服'){
          $data['user']['type'] = 2;
        }elseif($data['user']['position'] == '财务'){
          $data['user']['type'] = 3;
        }else{
          $data['user']['type'] = 4;    //总经理
        }

        return view('manage.customer.khterxm',$data);
    }
}
