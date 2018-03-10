<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponCode;
use App\Models\CouponCodeCustom;
use App\Models\Shop;
use App\Models\Member;
use App\Library\Wechat;
use App\Models\Logs;
// use App\Models\CouponBrand;
// use App\Models\CouponCategory;


class FzController extends Controller
{
    //myj
    public function cardUse(){

        $a=request()->all();
        if(isset($a['flag'])){
            $d=Logs::orderBy('id','desc')->take(20)->where('type',2)->get();
            foreach ($d as $key => $value) {
                echo date('Y-m-d H:i:s',$value['addtime']).': ' .$value['note'].'<br>';
            }
            exit;
        }

        Logs::mainSave($a,2);
        if(!isset($a['TicketNo'])){
            return 'ResponseCode=SUCCESS&ResponseMsg=缺少code';
        }

        $code=$a['TicketNo'];

        $custom=CouponCodeCustom::where('code',$code)->where('status',0)->first();

        if($custom){
            $cardid=$custom->card_id;
        }else{
            return 'ResponseCode=SUCCESS&ResponseMsg=卡券不存在';
        }

        $shop=Shop::where('id',$custom->shopid)->first();

        $wechat= new Wechat;
        try {
            $result=$wechat->checkConsume($code,$cardid);//检查
        } catch (\Exception $e) {
            if($e->getCode()=='40056'){
                return 'ResponseCode=SUCCESS&ResponseMsg=无效的卡券';
            }else{
                Logs::mainSave($e->getMessage());
                return 'ResponseCode=SUCCESS&ResponseMsg='.$e->getMessage().$e->getCode();
            }
        }

        if(!$result->can_consume){
            return 'ResponseCode=SUCCESS&ResponseMsg=卡券已使用';
        }

        //dd($result);
        $card_id=$result->card['card_id'];
        $openid=$result->openid;
        $outer_str=$result->outer_str;
        $custom_unionid=$shop->unionid;

        // $fcc=CouponCode::where('openid',$openid)
        //             ->where('card_id',$card_id)
        //             ->where('verycode',$outer_str)
        //             ->update(['code'=>$code]);
        //
        // if($fcc==0){
        //     $mem=Member::getInfoByOpenid($openid);
        //     $cci['card_id']=$card_id;
        //     $cci['code']=$code;
        //     $cci['unionid']=$mem->unionid;
        //     $cci['openid']=$openid;
        //     $cci['shopid']=23;
        //     $cci['punionid']='b37cd263e07b8a39e8badab952b02f11';
        //     $cci['addtime']=substr($outer_str,-10,10);
        //     $cci['verycode']=$outer_str;
        //     CouponCode::insert($cci);
        // }

        $result=$wechat->codeConsume($code,$cardid);
        if($custom){
            $custom->status=2;
            $custom->save();
        }

        CouponCode::used($code,$custom_unionid);
        return 'ResponseCode=SUCCESS&ResponseMsg=ok';

    }

    public function wxConfig(){
        //
        // $openid=request()->input('openid');
        // $shopsn=request()->input('shopsn');
        // $channel=request()->input('channel',811);//渠道
        //
        // $card_id=request()->input('card_id');
        // $empsn=request()->input('empsn');//分发人
        // $shopid=request()->input('shopid');
        //
        // $flag=request()->input('flag',1);
        // if($flag=='ok'){
        //     $ext=json_decode(request('ext'));
        //     CouponCode::wxH5GetCode($shopid,$card_id,$ext->outer_str);
        //     return 1;
        // }
        //
        // $addtime=time();
        // $empsn=$empsn.'|'.$addtime;
        //
        // $wechat = new Wechat;
        // $res=$wechat->jsApiWxCard($card_id,$empsn);
        //
        //
        //
        //
        // $wechat=new Wechat;
        // $jssdk=$wechat->jssdk();
        // $config1='wx.config('.$jssdk.');';
        //
        // {"empsn":"p|"+a,"card_id":c}
        //
        // $config2='wx.addCard({cardList:'..'});'
        //
        // wx.addCard({
        //     cardList: d, // 需要打开的卡券列表
        //     success: function (res) {
        //         if(res.errMsg=="addCard:ok" ){
        //             $.post("{{route('h5_process_get_wx_card')}}",
        //             {"flag":"ok" , "card_id":res.cardList[0].cardId , "shopid":ss ,"ext":res.cardList[0].cardExt},
        //             function(d){});
        //         }
        //     }
        // });
    }

    //
    public function getTicket(){
        $openid=request()->input('openid');
        $shopsn=request()->input('shopsn');
        $channel=request()->input('channel',811);//渠道
        if(!$openid){
            return $this->isErr(2);
        }
        $shop=Shop::where('status',1)->where('sn',$shopsn)->where('streetid',5)->first();
        if(!$shop){
            return $this->isErr(13);
        }
        $coupons=Coupon::where('shopid',$shop->id)->where('status',1)->get();

        if(!$coupons->toArray()){
            return $this->isErr(14);
        }
        $i=0;
        $cardcodes=[];
        $m=[];
        foreach ($coupons as $k => $v) {
            $getd=CouponCode::where('openid',$openid)->where('card_id',$v->card_id)->count();

            if( $v->used < $v->quantity ){//判断个数
                if( $v->get_limit!=0 && $v->get_limit<=$getd) continue;
                $exp=@unserialize($v->date_info);
                $m[$k]['card_id']=$v->card_id;
                $m[$k]['code']='fzhdj'.$shop->id.str_random(6);
                $m[$k]['status']=1;
                $m[$k]['shopid']=$shop->id;
                $m[$k]['unionid']='';
                $m[$k]['openid']=$openid;
                $m[$k]['addtime']=time();
                $m[$k]['punionid']=$channel;
                $m[$k]['verycode']='fz|'.$channel.'|'.$m[$k]['addtime'];
                $m[$k]['expop']=time();
                $m[$k]['exped']=time()+86400*$exp['fixed_term'];
                $cardcodes[$v->card_id]=$m[$k]['code'];
                $i++;
                Coupon::where('id',$v->id)->increment('used',1);
            }

        }
        if(!empty($m)){
            CouponCode::insert($m);
        }

        $back = ['flag'=>true,'error'=>0,'msg'=>'共发放卡券'.$i.'张','data'=>$cardcodes];
        return response($back);
    }


    public function streetTicket(){
        $back=Coupon::leftJoin('shops','shops.id','=','coupons.shopid')
            ->select('sn','name','title','sub_title','coupons.card_id','brand_name','logo_url','notice','description','date_info','quantity','used','service_phone','extra')
            ->where('coupons.streetid',5)
            ->where('coupons.status',1)
            ->groupBy('coupons.id')
            ->orderBy('shops.sn','desc')
            ->get();


        if($back){
            foreach($back as $k =>$v){
                $back[$k]['date_info']=@unserialize($v->date_info);
                $back[$k]['extra']=@unserialize($v->extra);
            }
        }
        return response($back);
    }


    public function getShops(){
        $shop=Shop::where('status',1)->where('streetid','5')->select('name','sn','dev_sn')->get();
        $back = ['flag'=>true,'error'=>0,'msg'=>$shop];
        return response($back);
    }

    public function userTicket(){
        $openid=request()->input('openid');
        $usetype=request()->input('usetype',0);
        $code=request()->input('code',0);
        $card_id=request()->input('card_id',0);
        if(!in_array($usetype,['1','2'])){
            $usetype=0;
        }

        if(!$openid){
            return $this->isErr(2);
        }
        $codes=CouponCode::leftJoin('coupons','coupons.card_id','=','coupon_codes.card_id')
            ->where('openid',$openid)
            ->where('streetid',5)
            // ->where('coupons.status',1)
            ->select('title','sub_title','coupons.card_id','code','openid','brand_name','logo_url','notice','description','date_info','quantity','used','coupon_codes.status','service_phone','extra','coupon_codes.addtime');

        if($usetype){
            $codes=$codes->where('coupon_codes.status',$usetype);
        }

        if($code){
            $codes=$codes->where('code',$code);
        }

        if($card_id){
            $codes=$codes->where('coupons.card_id',$card_id);
        }

        $codes=$codes->groupBy('coupon_codes.id')->get();
        if($codes){
            foreach($codes as $k =>$v){
                $codes[$k]['date_info']=@unserialize($v->date_info);
                $codes[$k]['extra']=@unserialize($v->extra);
            }
        }
        $back = ['flag'=>true,'error'=>0,'msg'=>$codes];
        return response($back);

    }



    public function analyseTicket(){
        $card_id=request()->input('card_id');

        $data=Coupon::leftJoin('shops','shops.id','=','coupons.shopid')
            ->select('sn','name','title','sub_title','coupons.card_id','quantity','used','coupons.status')
            ->where('coupons.streetid',5);
            // ->where('coupons.status',1)

        if($card_id){
            $data=$data->where('coupons.card_id',$card_id);
        }
        $data=$data->groupBy('coupons.id')
        ->orderBy('shops.sn','desc')
        ->get()
        ->toArray();

        foreach($data as $k => $v){
            $data[$k]['verification']=CouponCode::where('card_id',$v['card_id'])->where('status',2)->count();
        }


        return response($data);
    }




    // openid
    // nickname
    // ticketType
    // key
    public function add(){
        $input=request()->all();
        if(!isset($input['key'])){
            // return $this->isErr(1);
        }

        if(!isset($input['openid'])){
            return $this->isErr(2);
        }

        if(!isset($input['nickname'])){
            return $this->isErr(3);
        }

        if(!isset($input['tickettype'])){
            return $this->isErr(4);
        }

        // if($input['key'] != md5($input['openid'] . $input['nickname'] . $input['tickettype'] . 'o2opark' )){
        if($input['key'] != md5($input['openid'] . 'o2opark' )){
            //return $this->isErr(5);
        }

        if(!CouponCategory::isType($input['tickettype'])){
            return $this->isErr(6);
        }

        if(Coupon::isOpenid($input['tickettype'] , $input['openid'])){
            return $this->isErr(7);
        }


        $cate=CouponCategory::isType($input['tickettype']);
        $j=0;
        foreach ($cate as  $v) {
            for($i=0;$i<$v['num'];$i++){
                $data['openid']=$input['openid'];
                $data['nickname']=isset($input['nickname'])?$input['nickname']:'';
                $data['title']=$v['title'];
                $data['cid']=$v['id'];
                $data['type']=$v['type'];
                $data['mid']=$v['mid'];
                $data['value']=$v['value'];
                $data['status']=$v['status'];
                $data['brand']=$v['brand'];
                $data['desc']=$v['desc'];
                $data['expiry1']=strtotime(date('today'));
                $data['expiry2']=strtotime(date('today'));+ 86400*14;//双周
                $data['addtime']=time();
                Coupon::create($data);
                $j++;
            }
        }
        //dd($data);

        $back = ['flag'=>true,'error'=>0,'msg'=>'共发放卡券'.$j.'张'];

        return response($back);

    }



    // openid
    // ticketid
    // ticketname
    // key
    // brandid
    public function uses(){
        $input=request()->all();

        if(!isset($input['openid'])){
            return $this->isErr(2);
        }

        if(!isset($input['ticketid'])){
            return $this->isErr(8);
        }

        if(!isset($input['ticketname'])){
            return $this->isErr(9);
        }

        if(!isset($input['ticketname'])){
            return $this->isErr(10);
        }

        if(!isset($input['key'])){
            return $this->isErr(1);
        }

        // if($input['key'] != md5($input['openid'] . $input['ticketid'] . 'o2opark' )){
        if($input['key'] != md5($input['openid'] . 'o2opark' )){
            //return $this->isErr(5);
        }

        $today=strtotime('today');

        $d=Coupon::where('openid',$input['openid'])
                    ->where('id',$input['ticketid'])
                    ->first();

        if(!$d){
            return $this->isErr(12);
        }

        $info=Coupon::where('openid',$input['openid'])
                    ->where('brand',$d->brand)
                    ->where('updatetime','>=',$today)
                    ->where('updatetime','<',$today+86400)
                    ->first();
        if($info){
            return $this->isErr(11);
        }

        $update['validate']='核销人';
        $update['updatetime']=time();
        $update['status']=0;
        Coupon::where('id',$input['ticketid'])->update($update);
        $msg=$input['ticketname'].'已被使用';

        try {
            $url='http://www.ihhzc.com/ticket/Use';
            //$this->getCurl($url);
            $data['key']=md5($input['openid'].$input['ticketid'].'o2opark');
            $data['openid']=$input['openid'];
            $data['ticketid']=$input['ticketid'];
            $data['ticketname']=$input['ticketname'];
            $this->postCurl($url,$data);

        } catch (\Exception $e) {

        }




        $back = ['flag'=>true,'error'=>0,'msg'=>$msg,'currentid'=>$input['ticketid']];

        return response($back);

    }



    // openid
    // usetype
    // brandid
    // key

    public function search(){
        $input=request()->all();

        if(!isset($input['openid'])){
            return $this->isErr(2);
        }

        if(!isset($input['key'])){
            return $this->isErr(1);
        }

        if($input['key'] != md5($input['openid'] .  'o2opark' )){
            //return $this->isErr(5);
        }

        $data=Coupon::readCoupon($input);

        $back = ['flag'=>true,'error'=>0,'msg'=>'ok','data'=>$data];

        return response($back);
    }

    public function fztable(){

        $input=request()->all();
        if(isset($input['ti'])){
            CouponCategory::create($input['ti']);
            return redirect()->to('/api/fztable');
        }

        $data['brands']=CouponBrand::lists('name','id')->toArray();
        $data['lists']=CouponCategory::orderBy('id','desc')->get();
        $data['type']=[1=>'类别1', 2=>'类别2', 3=>'类别3', 4=>'类别4', 5=>'类别5'];

        return view('manage.news.fztable',$data);
    }


    public function getCurl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        //dd($output);
    }

    public function postCurl($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        //dd($output);
    }


    //统一返回
    public function isErr($err){
        $error=[
            0=>'ok',
            1=>'缺少key',
            2=>'缺少openid',
            3=>'缺少nickname',
            4=>'缺少tickettype',
            5=>'密钥验证失败',
            6=>'不存在的卡券类别',
            7=>'此用户已经发过该类型卡券',
            8=>'缺少ticketid',
            9=>'缺少ticketname',
            10=>'缺少brandid',
            11=>'今天已经使用过该品牌卡券',
            12=>'卡券不存在',
            13=>'无效的shopsn',
            14=>'该店铺/品牌没有任何可用卡券',

        ];


        return response( ['flag'=>false, 'error'=>$err,'msg'=>$error[$err]] );
    }





}
