<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Accountnum;

class ProjectController extends Controller
{

    public function main(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);

        if($data['user']['position'] == '财务' or $data['user']['position'] == '总经理'){
            $data['flag'] = 1;
            $data['lists'] =Project::where('status',1)->get();
        }else{
            $data['lists'] =Project::where('status',1)->where('kfid',$data['user']['id'])->get();
            $data['flag'] = 2;
        }

        foreach ($data['lists'] as $key => $vla) {
            $paiddeposit = 0;
            if(!empty($vla['paiddeposit'])){
                $paidd = unserialize($vla['paiddeposit']);
                foreach ($paidd as $k => $v) {
                    $paiddeposit += $v;
                }
            }
            $data['lists'][$key]['lastding'] = $v;
            $data['lists'][$key]['paiddepositcount'] = $paiddeposit;
        }
        return view('manage.project.main',$data);
    }

    //从客户变成项目
    public function adddlproject(){
    	  $aid = request()->input('aid');
        $did = request()->input('did');
        $id = request()->input('id');
        $type = request()->input('type');
        if(!empty($type)){
    	   $data['type'] = $type;
        }
        $data['list'] = Accountnum::whereRaw("status = ? and (position = ? or position = ?)",['1','财务','总经理'])->get();
        if(!empty($aid)){
    		$start = Customer::customerinfo($aid);
    		if($start){
    			$time = date("Y-m-d",time());
    			$data['start']['id'] = $start['id'];
    			$data['start']['customername'] = $start['name'];
    			$data['start']['contact'] = $start['info'];
    			$data['start']['contractamount'] = $start['offer'];
    			$data['start']['remarks'] = $start['remarks'];
    			$data['start']['status'] = 1;
    			$data['start']['signingtime'] = $time;
    			$data['start']['timepayment'] = $time;
    			$data['aid'] = $aid;
    			return view('manage.project.adddlproject',$data);
    		}
    	}

        if(!empty($did)){
    		$start = Customer::customerinfo($did);
    		if($start){
    			$time = date("Y-m-d",time());
    			$data['start']['id'] = $start['id'];
    			$data['start']['customername'] = $start['name'];
    			$data['start']['contact'] = $start['info'];
    			$data['start']['contractamount'] = $start['offer'];
    			$data['start']['remarks'] = $start['remarks'];
    			$data['start']['status'] = 1;
    			$data['start']['signingtime'] = $time;
    			$data['start']['timepayment'] = $time;
    			$data['did'] = $did;
    			return view('manage.project.adddlproject',$data);
    		}
    	}

    	$data['start'] = Project::projectinfo($id);
        $paiddepositcount = 0;
        if(!empty($data['start']['paiddeposit'])){
            $data['start']['paiddeposit'] = unserialize($data['start']['paiddeposit']);
            $paiddepositcount= count($data['start']['paiddeposit']);
        }
            $data['start']['paiddepositcount'] = $paiddepositcount;
        return view('manage.project.adddlproject',$data);
    }

    //从客户变成项目
    public function addproject(){
    	  $aid = request()->input('aid');
        $did = request()->input('did');
        $id = request()->input('id');
        $type = request()->input('type');
        if(!empty($type)){
    	   $data['type'] = $type;
        }
        $data['list'] = Accountnum::whereRaw("status = ? and (position = ? or position = ? or position = ?)",['1','客服主管','客服','总经理'])->get();
        if(!empty($aid)){
    		$start = Customer::customerinfo($aid);
    		if($start){
    			$time = date("Y-m-d",time());
    			$data['start']['id'] = $start['id'];
    			$data['start']['customername'] = $start['name'];
    			$data['start']['contact'] = $start['info'];
    			$data['start']['contractamount'] = $start['offer'];
    			$data['start']['remarks'] = $start['remarks'];
    			$data['start']['status'] = 1;
    			$data['start']['signingtime'] = $time;
    			$data['start']['timepayment'] = $time;
    			$data['aid'] = $aid;
    			return view('manage.project.addproject',$data);
    		}
    	}

        if(!empty($did)){
    		$start = Customer::customerinfo($did);
    		if($start){
    			$time = date("Y-m-d",time());
    			$data['start']['id'] = $start['id'];
    			$data['start']['customername'] = $start['name'];
    			$data['start']['contact'] = $start['info'];
    			$data['start']['contractamount'] = $start['offer'];
    			$data['start']['remarks'] = $start['remarks'];
    			$data['start']['status'] = 1;
    			$data['start']['signingtime'] = $time;
    			$data['start']['timepayment'] = $time;
    			$data['did'] = $did;
    			return view('manage.project.addproject',$data);
    		}
    	}

    	$data['start'] = Project::projectinfo($id);
        $paiddepositcount = 0;
        if(!empty($data['start']['paiddeposit'])){
            $data['start']['paiddeposit'] = unserialize($data['start']['paiddeposit']);
            $paiddepositcount= count($data['start']['paiddeposit']);
        }
            $data['start']['paiddepositcount'] = $paiddepositcount;
        return view('manage.project.addproject',$data);
    }

    //项目增加和修改
    public function editprojectpost(){
      $did = request()->input('did');
      Project::where("id",$did)->update(['prosta'=>2,'status'=>1]);

    	return redirect()->back();
    }

    //项目增加和修改
    public function adddlprojectpost(){
    	$id = request()->input('id');
    	$aid = request()->input('aid');
      $did = request()->input('did');
      $start = request()->input('start');
      $start['prosta'] = 2;

    	$type = request()->input('type');//这是销售添加的已付定金
        if(!empty($type)){
            $paiddeposit = serialize($start['paiddeposit']);
            $projects = Project::where("id",$id)->first();
            if($start['paiddeposit'] != $projects['paiddeposit']){
                Project::where("id",$id)->update(['paiddeposit'=>$paiddeposit,'status'=>1]);
            }
            return redirect()->back();
        }

        $dijia = request()->input('dijia');//这是客服修改底价
        if(!empty($dijia)){
            Project::where("id",$id)->update(['floorprice'=>$start['floorprice']]);
            return redirect()->back();
        }
        if($did){
            $aid = $did;
        }
        if(!empty($aid)){
            //增加
            $paiddeposit[0] = $start['paiddeposit'];
            $start['paiddeposit'] = serialize($paiddeposit);
            $start['addtime'] = time();
    		$start['kid'] = $aid;

        //添加编号
            $flag = 1;
            //查找数据库是否存在该编号
            while ($flag) {
              $code = date("YmdHis",time()).rand(1000,9999);
              $verCode = Project::where("xmunion",$code)->select("id")->first();
              if(!$verCode){
                  $flag=0;
              }
            }
            $start['xmunion'] = $code;
            if($did){
                $start['prosta'] = 2;
            }
    		Project::insert($start);
    		Customer::where("id",$aid)->update(['status'=>2]);
    	}else{
    		//修改
            $start['paiddeposit'] = serialize($start['paiddeposit']);
            $projects = Project::where("id",$id)->first();
            if($start['paiddeposit'] != $projects['paiddeposit']){
                $start['status'] = 1;
            }
    		Project::where("id",$id)->update($start);
    	}
    	return redirect()->back();
    }

    //项目增加和修改
    public function addprojectpost(){
    	$id = request()->input('id');
    	$aid = request()->input('aid');
      $did = request()->input('did');
      $start = request()->input('start');

    	$type = request()->input('type');//这是销售添加的已付定金
        if(!empty($type)){
            $paiddeposit = serialize($start['paiddeposit']);
            $status = $start['status'];
            $projects = Project::where("id",$id)->first();
            if($start['paiddeposit'] != $projects['paiddeposit']){
                Project::where("id",$id)->update(['paiddeposit'=>$paiddeposit,'status'=>$status]);
                // Project::where("id",$id)->update(['paiddeposit'=>$paiddeposit,'status'=>$start]);
            }
            return redirect()->back();
        }

        $dijia = request()->input('dijia');//这是客服修改底价
        if(!empty($dijia)){
            Project::where("id",$id)->update(['floorprice'=>$start['floorprice']]);
            return redirect()->back();
        }
        if($did){
            $aid = $did;
        }
        if(!empty($aid)){
            //增加
            $paiddeposit[0] = $start['paiddeposit'];
            $start['paiddeposit'] = serialize($paiddeposit);
            $start['addtime'] = time();
    		$start['kid'] = $aid;

        //添加编号
            $flag = 1;
            //查找数据库是否存在该编号
            while ($flag) {
              $code = date("YmdHis",time()).rand(1000,9999);
              $verCode = Project::where("xmunion",$code)->select("id")->first();
              if(!$verCode){
                  $flag=0;
              }
            }
            $start['xmunion'] = $code;
            if($did){
                $start['prosta'] = 2;
            }
            $start['status'] = 1;
    		Project::insert($start);
    		Customer::where("id",$aid)->update(['status'=>2]);
    	}else{
    		//修改
            $start['paiddeposit'] = serialize($start['paiddeposit']);
            $projects = Project::where("id",$id)->first();
            if($start['paiddeposit'] != $projects['paiddeposit']){
                $start['status'] = 1;
            }
    		Project::where("id",$id)->update($start);
    	}
    	return redirect()->back();
    }

    //项目改变状态
    public function updatastatus(){
    	$id = request()->input('id');
    	$type = request()->input('type');//1.丢弃，2找回，3选择其他状态
        $status = request()->input('status');
        $kfid = request()->input('kfid');
    	$cwid = request()->input('cwid');
    	if($type == 1){
    		$isok = Project::where("id",$id)->update(['status'=>0]);
    		if($isok){
    			return 1;
    		}else{
    			return 0;
    		}
    	}
    	if($type == 2){
    		$isok = Project::where("id",$id)->update(['status'=>1]);
    		if($isok){
    			return 1;
    		}else{
    			return 0;
    		}
    	}
    	if($type == 3){
            if(empty($status)){ return redirect()->back(); }
            if(empty($cwid)){
                if($status == 3){
                    $statusinfo['status'] = 3;
                    $statusinfo['wctime'] = time();
                }else{
                    $statusinfo['status'] = $status;
                }
                $isok = Project::where("id",$id)->update($statusinfo);
            }else{
                if($status == 3){
                    $statusinfo['status'] = 3;
                    $statusinfo['wctime'] = time();
                    $statusinfo['cwid'] = $cwid;
                }else{
                    $statusinfo['status'] = $status;
                    $statusinfo['cwid'] = $cwid;
                }
    		   $isok = Project::where("id",$id)->update($statusinfo);
            }
    		return redirect()->back();
    	}
    }

    //全部项目
    public function list(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['lists'] =Project::projectlist($data['user'],1);
        // dd($data['lists']);

        return view('manage.project.list',$data);
    }

    //全部项目
    public function process(){
        $id=request()->input('id');
        $data['start']=Project::projectinfo($id);
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
                $countVal = count($val);
                for ($i=count($val); $i > 0 ; $i--) {
                   $data['progress'][$i]['time'] = $key[$i];
                   $data['progress'][$i]['main'] = $val[$i];
                   $data['progress'][$i]['timename'] = 'time'.$countVal;
                   $data['progress'][$i]['mainname'] = 'main'.$countVal;
                   $countVal--;
                }
            }
        }
        return view('manage.project.process',$data);
    }

    //全部项目
    public function addprocess(){
        $id=request()->input('id');
        $data['start']=Project::projectinfo($id);
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
                $countVal = count($val);
                for ($i=count($val); $i > 0 ; $i--) {
                   $data['progress'][$i]['time'] = $key[$i];
                   $data['progress'][$i]['main'] = $val[$i];
                   $data['progress'][$i]['timename'] = 'time'.$countVal;
                   $data['progress'][$i]['mainname'] = 'main'.$countVal;
                   $countVal--;
                }
            }
        }
        return view('manage.project.addprocess',$data);
    }

    //全部项目
    public function addproceepost(){
      $id=request()->input('id');           //id
      $stoer = request()->input('stoer');   //跟进信息

      $customers = Project::projectinfo($id);
      if($customers['status'] == 0){
          $user=Accountnum::userinfo($GLOBALS['m']['user']);
      }
      if(count($stoer) == 2 && empty($stoer['time1']) && empty($stoer['main1'])){
          return redirect()->back();
      }
      foreach ($stoer as $key => $value) {
        if(empty($value)){
            $stoer[$key] = 0;
        }
      }
      $progress = serialize($stoer);
      $isok = Project::where("id",$id)->update(["progress"=>$progress]);
      return redirect()->back();
    }

    //全部项目
    public function listdl(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['lists'] =Project::projectlist($data['user'],2);
        // dd($data['lists']);
        return view('manage.project.listdl',$data);
    }

    //需要确认退单项目
    public function retreatlist(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['lists'] =Project::projectlistall($data['user'],4);
        // dd($data['lists']);
        return view('manage.project.retreatlist',$data);
    }

    //已退单项目
    public function retreatedlist(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['lists'] =Project::projectlistall($data['user'],5);
        // dd($data['lists']);
        return view('manage.project.retreatedlist',$data);
    }

    //已完成项目
    public function successlist(){
        $user=$GLOBALS['m']['user'];
        $data['user'] = Accountnum::userinfo($user);
        $data['lists'] =Project::projectlistall($data['user'],3);
        // dd($data['lists']);
        return view('manage.project.successlist',$data);
    }

    //添加定金
    public function addprojectst(){
        $id = request()->input('id');
        $data['start'] = Project::projectinfo($id);
        $paiddepositcount = 0;
        if(!empty($data['start']['paiddeposit'])){
            $data['start']['paiddeposit'] = unserialize($data['start']['paiddeposit']);
            $paiddepositcount= count($data['start']['paiddeposit']);
        }
        $data['start']['paiddepositcount'] = $paiddepositcount;
        return view('manage.project.addprojectst',$data);
    }

    //更改底价
    public function gaidijia(){
        $id = request()->input('id');
        $data['start'] = Project::projectinfo($id);
        return view('manage.project.gaidijia',$data);
    }

    //更改状态
    public function updateprosta()
    {
        $id = request()->input('id');
        $type = request()->input('type');
        $pro = Project::projectinfo($id);
        if($type == 2){
          Project::where('id',$id)->update(['status'=>5]);
          return redirect()->back();
        }
        if($pro['prosta']  ==2){
             Project::where('id',$id)->update(['status'=>2]);
        }else{
            Project::where('id',$id)->update(['status'=>2]);
        }
        return redirect()->back();
    }

}
