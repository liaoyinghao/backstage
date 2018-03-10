<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Wechat;
use App\Models\CouponCode;
use App\Models\Logs;
use App\Models\Shop;
use App\Models\ShopAccounts;

class ApiCardController extends Controller
{
    // bid 08003001
    // key b7fdde7d2f65f51628b9e7178f6651df
    //shopid 62

    public function checkCode(){
        //---------------------------------------------//check
        $input=request()->all();
        Logs::mainSave($input,11);
        $token=request()->input('token',1);
        $addtime=request()->input('addtime',1);
        $bid=request()->input('bid',1);
        if($bid !='08003001'){
            return response(['flag'=>false,'err'=>1,'msg'=>'密钥不正确']);
        }

        if(md5('b7fdde7d2f65f51628b9e7178f6651df'.$addtime) != $token){
            return response(['flag'=>false,'err'=>1,'msg'=>'密钥不正确']);
        }

        if(!isset($input['code'])){
            return response(['flag'=>false,'err'=>2,'msg'=>'缺少code']);
        }

        if(!isset($input['channel'])){
            return response(['flag'=>false,'err'=>3,'msg'=>'缺少channel']);
        }

        if(!isset($input['channel'])){
            return response(['flag'=>false,'err'=>3,'msg'=>'缺少channel']);
        }


        //---------------------------------------------//核销
        $code=$input['code'];

        $info=CouponCode::where('code',$code)->first();
        if(!$info){
            return response(['flag'=>false,'err'=>4,'msg'=>'code无效']);
        }


        if($info->status==2){
            return response(['flag'=>false,'err'=>5,'msg'=>'卡券已使用过']);
        }


        $cardid=$info->cardid;

        $wechat= new Wechat;
        try {
            $result=$wechat->checkConsume($code,$cardid);//检查
        } catch (\Exception $e) {
            if($e->getCode()=='40056'){
                return response(['flag'=>false,'err'=>31,'msg'=>'无效的code']);
            }else{
                Logs::mainSave($e->getMessage());
                return response(['flag'=>false,'err'=>32,'msg'=>'异常错误']);
            }
        }

        if(!$result->can_consume){
            return response(['flag'=>false,'err'=>6,'msg'=>'此卡券已使用']);
        }

        $shop=Shop::where('id',$info->shopid)->first();
        if($shop->is_inori){
            if(!ShopAccounts::checkNum($shop->id)){
                return response(['flag'=>false,'err'=>41,'msg'=>'店铺核销次数不足']);
            }
        }

        $card_id=$result->card['card_id'];
        $openid=$result->openid;
        $outer_str=$result->outer_str;
        $custom_unionid=$shop->unionid;

        $result=$wechat->codeConsume($code,$cardid);

        CouponCode::used($code,$custom_unionid);
        //---------------------------------------------


        return response(['flag'=>true,'err'=>0,'msg'=>'核销成功']);
    }
}
