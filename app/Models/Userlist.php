<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userlist extends Model
{
	public $timestamps = false;//取消updated_at字段

	public static function userlist($jobtitle){
		return self::where("jobtitle",$jobtitle)->first();
	}

}
