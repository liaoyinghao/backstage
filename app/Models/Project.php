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
		// if($user['position'] == '销售主管' || $user['position'] == '销售'){
		// 	$type = 1;
		// 	$sukh = Customer::where('fromuser',$user['id'])->where("id")->get();
		// }
		// return 1;
	}

}
