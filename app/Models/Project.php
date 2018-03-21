<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

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
				$list['type'] = 1;
			}
		}else{
			$list = self::get();
			if($user['position'] == '客服主管' || $user['position'] == '客服'){
				$list['type'] = 2;
			}elseif($user['position'] == '财务'){
				$list['type'] = 3;
			}else{
				$list['type'] = 4;		//总经理
			}
		}

		return $list;
	}

}
