<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Userlist;
use App\Models\Customer;
use App\Models\Leave;
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

	public static function userid($id){
		return self::where("id",$id)->select("id","nickname",'position')->first();
	}

	public static function userfromuser($fromuser){
		$info = self::where("fromuser",$fromuser)->where("status",1)->get();
		foreach ($info as $key => $value) {
			if(!empty($value)){
				$info[$key]['khcount'] = Customer::where("status",1)->where("fromuser",$value['id'])->count();
			}
		}
		return $info;
	}

	public static function userfromleave($fromuser){
		$info = self::where("fromuser",$fromuser)->where("status",1)->get();
		foreach ($info as $key => $value) {
			if(!empty($value)){
				$info[$key]['khcount'] = Leave::where("status",'!=',0)->where("qid",$value['id'])->count();
			}
		}
		return $info;
	}

	public static function userfromXs(){
		$info = self::whereRaw(" position like ? or position like ?",['%销售%','总经理'])->where("status",1)->get();

		foreach ($info as $key => $value) {
			if(!empty($value)){
				$info[$key]['khcount'] = Customer::where("status",1)->where("fromuser",$value['id'])->count();
			}
		}
		return $info;
	}

}
