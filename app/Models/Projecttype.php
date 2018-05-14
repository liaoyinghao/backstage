<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Accountnum;

class Projecttype extends Model
{
	public $timestamps = false;//取消updated_at字段

	public static function exproList(){
		return self::where("status",1)->get();
	}

	public static function detail($id){
		return self::where("id",$id)->first();
	}

}
