<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Userlist;
class Accountnum extends Model
{
	public $timestamps = false;//取消updated_at字段

	public static function useris($username,$password){
		$data = self::where("username",$username)->where("password",md5($password))->where("status",1)->first();
		if($data){
			$quanxian = Userlist::userlist($data['position']);
			$data['is_account'] = $quanxian['is_account'];
			return $data;
		}else{
			return false;
		}
	}

	public static function userinfo($user){
		return self::where("username",$user)->first();
	}

}
