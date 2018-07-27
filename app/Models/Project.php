<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Accountnum;

class Project extends Model
{
	public $timestamps = false;//取消updated_at字段

	public static function projectinfo($id){
		return self::where("id",$id)->first();
	}

	public static function projectlist($user,$prosta){
		//状态0放弃1确认中2进行中3完成4申请退
		$list = [];
		if($user['position'] == '销售主管' || $user['position'] == '销售'){
			$sukh = Customer::where('fromuser',$user['id'])->select("id")->get();
			if(!empty($sukh[0])){
				foreach ($sukh as $key => $val) {
					$cust[$key] = $val['id'];
				}
				$list = self::whereIn('kid',$cust)->where('prosta',$prosta)->where('status',2)->orderBy('signingtime','desc')->get();
				$type = 1;
			}
		}else{
			if($user['position'] == '客服主管' || $user['position'] == '客服'){
				$list = self::where('kfid',$user['id'])->where('prosta',$prosta)->where('status','2')->orderBy('signingtime','desc')->get();
				$type = 2;
			}elseif($user['position'] == '财务'){
				$list = self::whereRaw('(cwid = ? or cwid is null)',[$user["id"]])->where('prosta',$prosta)->where('status',2)->orderBy('signingtime','desc')->get();
				$type = 3;
			}else{
				$list = self::where('prosta',$prosta)->where('status',2)->orderBy('signingtime','desc')->get();
				$type = 4;		//总经理
			}
		}
		foreach ($list as $key => $val) {
			if(!empty($val['cwid'])){
				$infos = Accountnum::where('id',$val['cwid'])->select("nickname")->first();
				$list[$key]['cwid'] = $infos['nickname'];
			}
			if(!empty($val['kfid'])){
				$infost = Accountnum::where('id',$val['kfid'])->select("nickname")->first();
				$list[$key]['kfid'] = $infost['nickname'];
			}
			if(!empty($val['kid'])){
				$infost = Customer::where('id',$val['kid'])->first();
				$infost = Accountnum::where('id',$infost['fromuser'])->select("nickname")->first();

				$list[$key]['kid'] = $infost['nickname'];
			}
		}

		foreach ($list as $key => $vla) {
				$success = 0;
			$paiddeposit = 0;
            if(!empty($vla['paiddeposit'])){
    			$paidd = unserialize($vla['paiddeposit']);
    			foreach ($paidd as $k => $v) {
                    $paiddeposit += $v;
                }
    		}
				if($paiddeposit >= $vla['contractamount']){
					$success = 1;
				}
    		$list[$key]['paiddepositcount'] = $paiddeposit;
				$list[$key]['success'] = $success;
      }

      $listi = 0;
      foreach ($list as $key => $value) {
        if(!empty($value['progress'])){
            $tprogresst = @unserialize($value['progress']);
            $count = count($tprogresst);
            if($count > 1){
                $val = [];
                $i = 1;
                $j = 1;
                $h = 1;
                $t = 1;
                foreach ($tprogresst as $k => $v) {
                  if ($i%2==0){
                      $val[$h] = $v;
                      $h++;
                  }
                  $i++;
                }
                $countVal = count($val);
                $list[$key]['progressname'] = $val[$countVal];
            }
        }
        $listi++;
      }

		$list['type'] = $type;

		return $list;
	}

	public static function projectlistgr($user){
		//状态0放弃1确认中2进行中3完成4申请退
		$list = [];
		if($user['position'] == '销售主管' || $user['position'] == '销售'){
			$sukh = Customer::where('fromuser',$user['id'])->select("id")->get();
			if(!empty($sukh[0])){
				foreach ($sukh as $key => $val) {
					$cust[$key] = $val['id'];
				}
				$list = self::whereIn('kid',$cust)->where('status',2)->orderBy('signingtime','desc')->get();
				$type = 1;
			}
		}else{
			if($user['position'] == '客服主管' || $user['position'] == '客服'){
				$list = self::where('kfid',$user['id'])->where('status',2)->orderBy('signingtime','desc')->get();//状态2是进行中
				$type = 2;
			}elseif($user['position'] == '财务'){
				$list = self::where('status',2)->orderBy('signingtime','desc')->get();//状态1是确认中
				$type = 3;
			}else{
				$list = self::where('status',2)->orderBy('signingtime','desc')->get();
				$type = 4;		//总经理
			}
		}

		foreach ($list as $key => $vla) {
			$paiddeposit = 0;
            if(!empty($vla['paiddeposit'])){
    			$paidd = unserialize($vla['paiddeposit']);
    			foreach ($paidd as $k => $v) {
                    $paiddeposit += $v;
                }
    		}
    		$list[$key]['paiddepositcount'] = $paiddeposit;
        }

		$list['type'] = $type;

		return $list;
	}

	public static function projectlistall($user,$status){
		//状态0放弃1确认中2进行中3完成4申请退5退单成功
		$list = [];
			if($user['position'] == '销售主管' || $user['position'] == '销售'){
				$sukh = Customer::where('fromuser',$user['id'])->select("id")->get();
				if(!empty($sukh[0])){
					foreach ($sukh as $key => $val) {
						$cust[$key] = $val['id'];
					}
					$list = self::whereIn('kid',$cust)->where('status',$status)->get();
					$type = 1;
				}
			}else{
				if($user['position'] == '客服主管' || $user['position'] == '客服'){
					$list = self::where('kfid',$user['id'])->where('status',$status)->get();
					$type = 2;
				}elseif($user['position'] == '财务'){
					$list = self::whereRaw('(cwid = ? or cwid is null)',[$user["id"]])->where('status',$status)->get();
					$type = 3;
				}else{
					$list = self::where('status',$status)->get();
					$type = 4;		//总经理
				}
			}

		foreach ($list as $key => $val) {
			if(!empty($val['cwid'])){
				$infos = Accountnum::where('id',$val['cwid'])->select("nickname")->first();
				$list[$key]['cwid'] = $infos['nickname'];
			}
			if(!empty($val['kfid'])){
				$infost = Accountnum::where('id',$val['kfid'])->select("nickname")->first();
				$list[$key]['kfid'] = $infost['nickname'];
			}
			if(!empty($val['kid'])){
				$infost = Customer::where('id',$val['kid'])->first();
				$infost = Accountnum::where('id',$infost['fromuser'])->select("nickname")->first();

				$list[$key]['kid'] = $infost['nickname'];
			}
		}

		foreach ($list as $key => $vla) {
			$paiddeposit = 0;
            if(!empty($vla['paiddeposit'])){
    			$paidd = unserialize($vla['paiddeposit']);
    			foreach ($paidd as $k => $v) {
                    $paiddeposit += $v;
                }
    		}
    		$list[$key]['paiddepositcount'] = $paiddeposit;
        }

		$list['type'] = $type;

		return $list;
	}

}
