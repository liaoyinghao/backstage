<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	public $timestamps = false;//取消updated_at字段

	public static function customerinfo($id){
		return self::where("id",$id)->first();
	}


	public static function userkh($id){
		return self::where("status",1)->where("fromuser",$id)->get();
	}

}
