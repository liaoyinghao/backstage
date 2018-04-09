<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Userlist;
use App\Models\Accountnum;

class Leave extends Model
{
	public $timestamps = false;//取消updated_at字段

	public static function dailyinfo($id){
		return self::where("id",$id)->first();
	}

	public static function dailylist($info){
			if($info['position'] == '总经理'){
				//显示全部人的状态为1未读的的申请列表
				$stoer = self::where("status",1)->get();
			}else{
				//显示自己的状态为1未读和0拒绝的的申请列表
				$stoer = self::whereRaw("qid = ? and (status = ? or status = ?)",[$info['id'],'1','0'])->get();
			}


		foreach ($stoer as $key => $val) {
			if(!empty($val)){
				$str = Accountnum::userid($val['qid']);
				$stoer[$key]['nickname'] = $str['nickname'];
				$stoer[$key]['position'] = $str['position'];
			}
		}

		return $stoer;
	}

	public static function dailylistst($info,$request){
		if($request['kstime'] && $request['jstime']){
			$start=strtotime($request['kstime']);
			$end=strtotime($request['jstime']);
			if($info['position'] == '总经理'){
				$stoer = self::where('addtime','<',$end)->where('addtime','>',$start)->get();
			}else{
				$stoer = self::where("qid",$info['id'])->where('addtime','<',$end)->where('addtime','>',$start)->get();
			}
		}else{
			if($info['position'] == '总经理'){
				$stoer = self::get();
			}else{
				$stoer = self::where("qid",$info['id'])->get();
			}
		}

		foreach ($stoer as $key => $val) {
			if(!empty($val)){
				$str = Accountnum::userid($val['qid']);
				$stoer[$key]['nickname'] = $str['nickname'];
				$stoer[$key]['position'] = $str['position'];
			}
		}
		return $stoer;
	}

}
