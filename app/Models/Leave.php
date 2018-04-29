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

				$time = time() - 86400*3;
				$stoers = self::where("status",1)->whereIn("qid",$nameid)->get();//没有上级的
				$stoerst = self::where("status",1)->where("addtime",'<',$time)->whereIn("qid",$nameids)->get();//有上级的超过三天了
				$stoer = [];
				$i = 0;
				foreach ($stoers as $key => $val) {
					if(!empty($val)){
						$stoer[$i] = $val;
						$str = Accountnum::userid($val['qid']);
						$stoer[$i]['nickname'] = $str['nickname'];
						$stoer[$i]['position'] = $str['position'];
						$i++;
					}
				}
				foreach ($stoerst as $key => $val) {
					if(!empty($val)){
						$stoer[$i] = $val;
						$str = Accountnum::userid($val['qid']);
						$stoer[$i]['nickname'] = $str['nickname'];
						$stoer[$i]['position'] = $str['position'];
						$i++;
					}
				}
			}else{
				//显示自己的状态为1未读和0拒绝的的申请列表
				$stoer = self::whereRaw("qid = ? and (status = ? or status = ?)",[$info['id'],'1','0'])->get();
				foreach ($stoer as $key => $val) {
					if(!empty($val)){
						$str = Accountnum::userid($val['qid']);
						$stoer[$key]['nickname'] = $str['nickname'];
						$stoer[$key]['position'] = $str['position'];
					}
				}
			}

		return $stoer;
	}

	public static function dailylistst($info,$request){
		if($request['kstime'] && $request['jstime']){
			$start=strtotime($request['kstime']);
			$end=strtotime($request['jstime']) + 86400;
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
