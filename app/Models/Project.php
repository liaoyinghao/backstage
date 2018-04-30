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

	public static function projectlist($user){
		//状态0放弃1确认中2进行中3完成4申请退
		$list = [];
		if($user['position'] == '销售主管' || $user['position'] == '销售'){
			$sukh = Customer::where('fromuser',$user['id'])->select("id")->get();
			if(!empty($sukh[0])){
				foreach ($sukh as $key => $val) {
					$cust[$key] = $val['id'];
				}
				$list = self::whereIn('kid',$cust)->get();
				$type = 1;
			}
		}else{
			if($user['position'] == '客服主管' || $user['position'] == '客服'){
				$list = self::where('kfid',$user['id'])->get();
				$type = 2;
			}elseif($user['position'] == '财务'){
				$list = self::whereRaw('(cwid = ? or cwid is null)',[$user["id"]])->get();
				$type = 3;
			}else{
				$list = self::get();
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

	public static function projectlistgr($user){
		//状态0放弃1确认中2进行中3完成4申请退
		$list = [];
		if($user['position'] == '销售主管' || $user['position'] == '销售'){
			$sukh = Customer::where('fromuser',$user['id'])->select("id")->get();
			if(!empty($sukh[0])){
				foreach ($sukh as $key => $val) {
					$cust[$key] = $val['id'];
				}
				$list = self::whereIn('kid',$cust)->get();
				$type = 1;
			}
		}else{
			if($user['position'] == '客服主管' || $user['position'] == '客服'){
				$list = self::where('kfid',$user['id'])->where('status',2)->get();//状态2是进行中
				$type = 2;
			}elseif($user['position'] == '财务'){
				$list = self::where('status',1)->get();//状态1是确认中
				$type = 3;
			}else{
				$list = self::get();
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

}
