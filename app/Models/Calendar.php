<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Calendar extends Model
{
	public $timestamps = false;//取消updated_at字段

	public static function Memoranduminfo($id){
		return self::where("id",$id)->first();
	}

	public static function datalistwz($uid){
		return self::where("uid",$uid)->where("status",1)->get();
	}

	public static function datalist($uid){
		return self::where("uid",$uid)->get();
	}

}
