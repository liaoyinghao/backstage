<?php

namespace App\Library;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use App\Models\CouponCode;
use App\Models\ShopWxpic;
use App\Models\Coupon;
use App\Models\CouponCodeCustom;
use App\Models\Logs;
use App\Models\OrderWx;
use App\Models\OrderAd;
use App\Models\MemberWx;
use App\Models\Member;
use App\Models\ShopAccounts;
use App\Models\Shop;
use App\Models\Shake;
use App\Models\Kol;
use App\Models\CouponAd;
use App\Models\ShopHistories;
use App\Models\MemberCard;
use App\Models\MemberKol;
use App\Models\ViewPage;

class Wechat
{

    protected $app;

    public function __construct(){
        $options=config('easywechat');
        $this->app = new Application($options);
        // dd(config('easywechat'));
    }

    public function unipay($attributes){
        $app=$this->app;
        $payment = $app->payment;
        $order = new Order($attributes);

        $result = $payment->prepare($order);
        //return $result;
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
            $config = $payment->configForJSSDKPayment($prepayId);
            return $config;
        }else{
            return false;
        }
    }

    public function notify(){
        $app=$this->app;
        $payment = $app->payment;

        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            try {
                Logs::mainSave($notify);
            } catch (\Exception $e) {

            }

            $order = OrderWx::where('out_trade_no',$notify->out_trade_no)->first();
            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status==2) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                ShopAccounts::processPay($order);
                $order->status=2;
                $order->updatetime=time();
                $order->transaction_id=$result->transaction_id;
                $order->openid=$result->openid;
            } else { // 用户支付失败
                $order->status = 3;
            }
            $order->save(); // 保存订单
            return true; // 返回处理完成
        });
        return $response;
    }


    public function wxPayStatus($orderNo){
        $order = OrderWx::where('out_trade_no',$orderNo)->first();
        $flag=request()->input('flag','');

        if($order && $order->status<2){
            //tmp
            $flag=request()->input('flag');
            if($flag=='tmp'){
                $order->transaction_id='';
                $order->openid='';
                $order->status=2;
                $order->updatetime=time();
                $order->save();
                ShopAccounts::processPay($order);

                try {
                    $app=$this->app;
                    $payment = $app->payment;
                    $result=$payment->query($orderNo);
                    //Logs::mainSave($result);
                    $order->transaction_id=$result->transaction_id;
                    $order->openid=$result->openid;
                    $order->save();
                } catch (\Exception $e) {

                }
                //tmp
            }else{
                $app=$this->app;
                $payment = $app->payment;
                $result=$payment->query($orderNo);

                if($result->trade_state=='SUCCESS' && $result->total_fee==intval($order->total_fee*100)){
                    $order->transaction_id=$result->transaction_id;
                    $order->openid=$result->openid;
                    $order->status=2;
                    $order->updatetime=time();
                    $order->save();
                    ShopAccounts::processPay($order);
                }
            }
        }
    }


    //卡券推广订单
    public function wxPayAd($orderNo){
        $order = OrderAd::where('out_trade_no',$orderNo)->first();

        $app=$this->app;
        $payment = $app->payment;
        $result=$payment->query($orderNo);

        Logs::mainSave($result,3);
        // if($order && $order->status<2){
        //     $order->transaction_id='';
        //     $order->openid='';
        //     $order->status=1;//1支付成功
        //     $order->updatetime=time();
        //     $order->save();//更新订单
        //
        //     ShopAccounts::processAd($order);//记录日志
        //     try {
        //         $app=$this->app;
        //         $payment = $app->payment;
        //         $result=$payment->query($orderNo);
        //
        //         $order->transaction_id=$result->transaction_id;
        //         $order->openid=$result->openid;
        //         $order->save();
        //     } catch (\Exception $e) {
        //
        //     }
        //
        // }
    }


    public function shakePagination($f=0,$e=30){
        $app=$this->app;
        $shakearound = $app->shakearound;

        return $shakearound->device()->pagination($f,$e);
    }

    public function shakePaginationGetPage($f=0,$e=30){
        $app=$this->app;
        $shakearound = $app->shakearound;

        return $shakearound->page()->pagination($f,$e);
    }

    public function shakeGetPageByDeviceId($deviceid){
        $app=$this->app;
        $shakearound = $app->shakearound;

        return $shakearound->relation()->getPageByDeviceId($deviceid,false);
    }

    public function shakeGetDeviceByPageId($pageId, $begin, $count){
        $app=$this->app;
        $shakearound = $app->shakearound;

        return $shakearound->relation()->getDeviceByPageId($pageId, $begin, $count);
    }

    public function shakePageAdd($m){
        $app=$this->app;
        $shakearound = $app->shakearound;
        $title=$m['title'];
        $description=$m['description'];
        $pageUrl=$m['page_url'];
        $iconUrl=ShopWxpic::fileToWx($m['icon_url']);
        $comment=$m['comment'];
        return $shakearound->page()->add($title, $description, $pageUrl, $iconUrl, $comment);
    }


    public function shakePageEdit($m){
        $app=$this->app;
        $shakearound = $app->shakearound;
        $pageId=$m['page_id'];
        $title=$m['title'];
        $description=$m['description'];
        $pageUrl=$m['page_url'];
        if(strchr($m['icon_url'],"http://")){
            $iconUrl=$m['icon_url'];
        }else{
            $iconUrl=ShopWxpic::fileToWx($m['icon_url']);
        }

        $comment=isset($m['comment'])?$m['comment']:'';
        return $shakearound->page()->update($pageId, $title, $description, $pageUrl, $iconUrl, $comment);
    }

    public function shakeBind($deviceid,$pages){
        $shakeinfo=Shake::where('device_id',$deviceid)->first();
        $app=$this->app;
        $shakearound = $app->shakearound;
        $deviceIdentifier['device_id']=intval($deviceid);
        $deviceIdentifier['uuid']=$shakeinfo->uuid;
        $deviceIdentifier['major']=intval($shakeinfo->major);
        $deviceIdentifier['minor']=intval($shakeinfo->minor);
        return $shakearound->relation()->bindPage($deviceIdentifier,$pages);
    }

    public function shakeCommentUpdate($deviceid,$comment){
        $app=$this->app;
        $shakearound = $app->shakearound;
        $deviceIdentifier['device_id']=intval($deviceid);
        return $shakearound->device()->update($deviceIdentifier, $comment);
    }



    public function setTestWhitelist($openId){
        $app=$this->app;
        $card = $app->card;

        return $card->setTestWhitelist($openId);
    }


    //卡券，会员卡创建
    public function cardAdd($cardType, $baseInfo, $especial , $advancedInfo=[]){
        $app=$this->app;
        $card = $app->card;

        return $card->create($cardType, $baseInfo, $especial , $advancedInfo);
    }

    public function updateAdd($cardId, $type, $baseInfo , $especial=[]){
        $app=$this->app;
        $card = $app->card;

        return $card->update($cardId, $type, $baseInfo , $especial);
    }


    public function material($type,$file){
        $app=$this->app;
        $material = $app->material;
        $temporary = $app->material_temporary;
        if($type==1){
            $result = $material->uploadImage($file);
        }
        return json_decode($result);
    }

    //自定义CODE
    public function wxCode($card_id,$num,$codes=[]){
        $app=$this->app;
        $card = $app->card;
        $shopid=request()->cookie('h5_shopid');
        $c=0;
        $f=0;
        $cn=count($codes);
        if($cn>0){
            $num=$cn;
        }
        $mo=$cn/100;
        for($i=0;$i<$mo;$i++){
            $code=array_splice($codes,0,100);
            try {
                $result = $card->deposit($card_id, $code);//code导入微信
            } catch (\Exception $e) {
                // dd($e->getMessage());
                return -3;
            }

            $d=count($result->succ_code);
            $d2=count($result->duplicate_code);
            if($d>0){//成功卡券
                $m=[];
                // $c+=$d;
                foreach($result->succ_code as $k =>$v){
                    $m[$k]['card_id']=$card_id;
                    $m[$k]['shopid']=$shopid;
                    $m[$k]['code']=$v;
                    $m[$k]['status']=0;
                    // $m[$k]['addtime']=time();
                    // $m[$k]['allotid']=0;
                    $f++;
                }
                $card->increaseStock($card_id, $d);
                CouponCodeCustom::insert($m);
            }
            if($d2>0){//重复卡券
                $dpcode=CouponCodeCustom::where('card_id',$card_id)->whereIn('code',$result->duplicate_code)->pluck('code')->toArray();
                $dpins=array_diff($result->duplicate_code,$dpcode);
                // dd($dpins);
                $m=[];
                // $c+=$d;
                foreach($dpins as $k =>$v){
                    $m[$k]['card_id']=$card_id;
                    $m[$k]['shopid']=$shopid;
                    $m[$k]['code']=$v;
                    $m[$k]['status']=0;
                    // $m[$k]['addtime']=time();
                    // $m[$k]['allotid']=0;
                    $f++;
                }
                $card->increaseStock($card_id, count($dpins));
                CouponCodeCustom::insert($m);
            }
        }


        // while ($c < $num) {
        //     $code=[];
        //     $j=(($num-$c) >100)?100 : ($num-$c);//计算最大可生成CODE数
        //     if($cn>0){
        //         $code=array_splice($codes,0,$j);
        //     }else{
        //         for($i=0;$i<$j;$i++){
        //             $code[]=CouponCode::makeCode();
        //         }
        //     }
        //
        //
        //     try {
        //         $result = $card->deposit($card_id, $code);//code导入微信
        //     } catch (\Exception $e) {
        //         return -3;
        //     }
        //
        //     $d=count($result->succ_code);
        //     $m=[];
        //     if($d>0){
        //         $c+=$d;
        //         foreach($result->succ_code as $k =>$v){
        //             $m[$f]['card_id']=$card_id;
        //             $m[$f]['shopid']=$shopid;
        //             $m[$f]['code']=$v;
        //             $m[$f]['status']=0;
        //             // $m[$f]['addtime']=time();
        //             // $m[$f]['allotid']=0;
        //             $f++;
        //         }
        //         $card->increaseStock($card_id, $d);
        //         CouponCodeCustom::insert($m);
        //     }
        // }


        return $f;
    }


    public function cardQr($cardid){
        $app=$this->app;
        $card = $app->card;

        $cards = [
            'action_name' => 'QR_CARD',
            'expire_seconds' => 1800,
            'action_info' => [
                'card' => [
                    'card_id' => $cardid,
                    'is_unique_code' => false,
                    'outer_id' => 1,
                ],
            ],
        ];
        return $card->QRCode($cards);
    }


    public function increase($card_id,$num){
        $app=$this->app;
        $card = $app->card;

        return $result = $card->increaseStock($card_id,$num);
    }


    public function codeCheck($card_id){
        $app=$this->app;
        $card = $app->card;
        $result = $card->getDepositedCount($card_id);
        return $result;
    }

    public function codeConsume($code,$cardid=''){
        $app=$this->app;
        $card = $app->card;
        return $card->consume($code,$cardid);
    }

    //检查状态
    public function checkConsume($code,$cardid=''){
        $app=$this->app;
        $card = $app->card;
        return $card->getCode($code, false, $cardid);
    }

    public function getCard($cardId){
        $app=$this->app;
        $card = $app->card;
        return $card->getCard($cardId);
    }


    public function sendLuck($m){
        $app=$this->app;
        $luckyMoney = $app->lucky_money;

        $luckyMoneyData = [
            'mch_billno'       => $m['mch_billno'],
            'send_name'        => '互动街' ,//'互动街红包',
            're_openid'        => $m['openid'],
            'total_num'        => 1,  //普通红包固定为1，裂变红包不小于3
            'total_amount'     => $m['money']*100,  //单位为分，普通红包不小于100，裂变红包不小于300
            'wishing'          => '互动街红包',
            'client_ip'        => request()->ip(),  //可不传，不传则由 SDK 取当前客户端 IP
            'act_name'         => $m['act_name'] ,//'测试活动',
            'remark'           => '',
            // ...
        ];
        return $luckyMoney->sendNormal($luckyMoneyData);
    }

    public function sendMerchant($m)
    {
        $app=$this->app;
        $merchantPay = $app->merchant_pay;
        $merchantPayData = [
            'mch_appid' =>'wx6f9fd20592118244',
            'mchid' => '1352111401',
            'partner_trade_no' => str_random(16), //随机字符串作为订单号，跟红包和支付一个概念。
            'openid' => $m['openid'], //收款人的openid
            'check_name' => 'NO_CHECK',  //文档中有三种校验实名的方法 NO_CHECK OPTION_CHECK FORCE_CHECK
            're_user_name'=>'互动街',     //OPTION_CHECK FORCE_CHECK 校验实名的时候必须提交
            'amount' => $m['money']*100,  //单位为分
            'desc' => '企业付款',
            'spbill_create_ip' => request()->ip(),  //发起交易的IP地址
        ];
        return $merchantPay->send($merchantPayData);
    }


    public function searchLuck($sn){
        $app=$this->app;
        $luckyMoney = $app->lucky_money;
        return $luckyMoney->query($sn);
    }


    public function jsApiCode($card_id,$code){
        $app=$this->app;
        $card = $app->card;
        $cards=[['card_id'=>$card_id, 'outer_id'=>4 , 'code'=>$code]];
        return $card->jsConfigForAssign($cards);
    }

    public function jsApiWxCard($card_id,$empsn='911'){
        $app=$this->app;
        $card = $app->card;

        $num='1';
        while ($num) {
            $num_rand="C".str_pad(mt_rand(0, 999999), 11, "0", STR_PAD_BOTH);//membercard表第1条
            $num=MemberKol::where('member_card',$num_rand)->first();
        }

        $cards=[['code'=>$num_rand,'card_id'=>$card_id, 'outer_id'=>$empsn,'outer_str'=>$empsn]];
        return $card->jsConfigForAssign($cards);
    }


    public function jscardlist($cards){
        $app=$this->app;
        $card = $app->card;
        $card_config=[];
        foreach($cards as $k=> $v){
            $card_config[$k]['card_id']=$v->card_id;
            $card_config[$k]['outer_id']=$k;
        }
        return $card->jsConfigForAssign($card_config);
    }

    public function getUserInfo($openids=[]){
        $app=$this->app;
        $userService = $app->user;
        return $userService->batchGet($openids);
    }

    public function firstUserInfo($openid=''){
        $app=$this->app;
        $userService = $app->user;
        return $userService->get($openid);
    }

    public function messageBack($app){
        $app->server->setMessageHandler(function ($message) {
            try {
                Logs::mainSave($message);
            } catch (\Exception $e) {

            }

            switch ($message->MsgType) {

                case 'event':
                //------------------card
                // if($message->Event=='card_pass_check'){
                //     Coupon::where('card_id',$message->CardId)->update(['status'=>1]);//通过
                // }
                // if($message->Event=='card_not_pass_check'){
                //     Coupon::where('card_id',$message->CardId)->update(['status'=>2]);//不通过
                // }

                //用户关注
                if($message->Event=='subscribe'){
                    MemberWx::subscribe($message->FromUserName);
                }

                //取消关注
                if($message->Event=='unsubscribe'){
                    MemberWx::unsubscribe($message->FromUserName);
                }


                //转增卡券
                if($message->Event=='user_gifting_card'){
                    return '';//暂时不做业务处理
                }


                //门店返回事件推送
                if($message->Event=='poi_check_notify'){
                    try {
                        // $s='C:29:"EasyWeChat\Support\Collection":313:{a:9:{s:10:"ToUserName";s:15:"gh_688bccc416fd";s:12:"FromUserName";s:28:"o00zLwXEXi507YvAKNAhAfIllTwA";s:10:"CreateTime";s:10:"1502098525";s:7:"MsgType";s:5:"event";s:5:"Event";s:16:"poi_check_notify";s:6:"UniqId";N;s:5:"PoiId";s:9:"478367496";s:6:"result";s:4:"fail";s:3:"msg";s:27:"测试数据，不予受理";}}';
                        // $message=unserialize($s);

                    } catch (\Exception $e) {

                    }
                }


                //用户领取卡券
                if($message->Event=='user_get_card'){
                    if($message->CardId == 'p00zLwa3A56MvHhImrPLRt9PWqlk'){//达人会员卡
                        Kol::membershipBind($message);
                        return '';
                    }

                    $coupon=Coupon::bInfo($message->CardId);
                    if($coupon){ //普通卡券
                        // $app=$this->app;
                        // $user = $app->oauth->user();
                        // $userinfo=$user->getOriginal();//获取返回数据
                        // $memberid=Member::auth($userinfo);//与数据库对比
                        // MemberWx::where('unionid',$userinfo['unionid'])->update(['openid'=>$userinfo['openid']]);
                        // Member::where('unionid',$userinfo['unionid'])->update(['openid'=>$userinfo['openid']]);
                        $memberwx=MemberWx::where('openid',$message->FromUserName)->first();
                        if($message->IsGiveByFriend == 1){ //获赠卡券
                            //如果领取人在数据库中没数据
                            if(!$memberwx){
                                //获取accesstoken
                                $appid = 'wx6f9fd20592118244';
                                $appsecret = 'c8878895c1414c445a9468ab94f1283b';
                                $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
                                $apps = $this->http_curl($url,'get','json','');
                                $accesstoken = $apps['access_token'];

                                //获取用户信息
                                $openid = $message->FromUserName;
                                $token = $accesstoken;
                                $urls = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN";
                                $resJson = "";
                                $fp = @fopen($urls, 'r') or die("error");
                                stream_get_meta_data($fp);
                                while(!feof($fp)) {
                                    $resJson .= fgets($fp, 1024);
                                }
                                fclose($fp);
                                $jsoninfo = json_decode($resJson);//json_decode($resJson, true);解码接口数据，将json格式字符串转换成php变量或数组。默认是变量，加true后是数组。       //+"subscribe": 0
                                  // +"openid": "o00zLwUlp6NGP7tumPcd6RO59FTk"
                                  // +"unionid": "op0Vav5XIHGuV6_BKn1oOpjvqGng"
                                  // +"tagid_list": []佚名


                                //添加到memberwx表数据
                                $m['openid'] = $jsoninfo->openid;
                                $m['unionid'] = $jsoninfo->unionid;
                                $m['nickname'] = '佚名';
                                $m['sex'] = '0';
                                $m['language'] = 'zh_CN';
                                $m['headimgurl'] = '/img/hdj.png';
                                $m['subscribe'] = $jsoninfo->subscribe;
                                $m['subscribe_time'] = '1';
                                $m['addtime']=time();
                                $m['update']=time();
                                $memberwx=MemberWx::create($m);

                                // Logs::mainSave($accesstoken);
                                // Logs::mainSave($m);
                                // Logs::mainSave($memberwx);
                            }

                            CouponCode::where('card_id',$message->CardId)->where('code',$message->OldUserCardCode)
                            ->update(
                                [
                                    'friend'=>$message->FriendUserName,//领取券的人
                                    'is_giving'=>1,
                                    'unionid'=>isset($memberwx->unionid)?$memberwx->unionid:'',
                                    'openid'=>$message->FromUserName,
                                    'code'=>$message->UserCardCode,
                                    'addtime'=>$message->CreateTime
                                ]
                            );
                            // //以券送卡
                            // //判断该券有没有品牌商
                            $execid = Coupon::where('card_id',$message->CardId)->where('power_type',0)->where('voutocard',1)->first();

                            if($execid){
                                if($execid->power == 0){
                                    //获取品牌商的id
                                    // $execid=Coupon::where('card_id',$message->CardId)->where('power_type',0)->where('voutocard',1)->first();
                                    //获取品牌商下的会员卡
                                    $memcard=MemberCard::where('exec_id',$execid->shopid)->first();
                                    if($memcard){
                                        //上级的unionid
                                        $grading=MemberWx::where('openid',$message->FriendUserName)->first();
                                        $xiaji =MemberCard::where('top_card',$memcard['member_id'])->first();

                                        //判断该人有没有该品牌商会员卡
                                        $memberkol=MemberKol::where('unionid',$memberwx->unionid)->where('exec_id',$execid->shopid)->first();
                                        //如果存在下级卡
                                        if(!$memberkol){
                                            //判断有没有下级卡
                                            if($xiaji){
                                                //有就发下级卡
                                                $cm['unionid']=$memberwx->unionid;
                                                $cm['addtime']=time();
                                                $cm['member_id']=$xiaji->member_id;
                                                $cm['member_num']=str_pad(mt_rand(0, 9999999), 12, "0", STR_PAD_BOTH);
                                                $cm['exec_id']=$execid->shopid;
                                                $cm['grading']=$grading['unionid'];
                                                MemberKol::insert($cm);
                                            }else{
                                                //没有就发第一张卡
                                                $cm['unionid']=$memberwx->unionid;
                                                $cm['addtime']=time();
                                                $cm['member_id']=$xiaji->member_id;
                                                $cm['member_num']=str_pad(mt_rand(0, 9999999), 12, "0", STR_PAD_BOTH);
                                                $cm['exec_id']=$execid->shopid;
                                                MemberKol::insert($cm);
                                            }
                                        }

                                    }
                                }
                            }
                            return '';
                        }


                        //--------------------------第一次领取
                        $s=explode('|' , $message->OuterStr);
                        if(!isset($s[2])){
                            $s[2]=$s[1];
                            $s[1]=$s[0];
                        }

                        //领取信息
                        $m['card_id']=$message->CardId;
                        $m['code']=$message->UserCardCode;
                        $m['unionid']=$memberwx->unionid;//领取人
                        $m['shopid']=$s[2];
                        $m['openid']=$message->FromUserName;
                        $m['punionid']=$s[1];//派发人
                        if($s[0]=='m' ||$s[0]=='911'){
                                $m['addtime']=time();
                        }else{
                            $m['addtime']=$s[3];
                        }
                        $m['status']=1;
                        $m['verycode']=$message->OuterStr;

                        $coupon_codes=CouponCode::create($m);
                        //佣金信息
                        $orderad=OrderAd::where('card_id',$message->CardId)->where('shopid',$s[2])->where('status',1)->first();
                        if($orderad && $orderad->pricetype==1){
                            if($orderad->num > $orderad->numed){
                                $m['pricetype']=$orderad->pricetype;
                                $m['price']=$orderad->price;
                                $orderad['punionid']=$m['punionid'];
                                if($s[0]!='911'){
                                    ShopHistories::zhichu($orderad->shopid,$orderad->unionid,$orderad->out_trade_no,$orderad->price,$orderad->body);//店铺支出记录
                                }
                                if($s[0]=='m'){//店铺
                                    ShopAccounts::adIncrement($orderad);
                                    OrderAd::incrementNumed($orderad->out_trade_no);
                                }

                                if($s[0]=='k'){//达人
                                    Kol::adIncrement($orderad);
                                    OrderAd::incrementNumed($orderad->out_trade_no);
                                }
                            }
                        }
                        Coupon::where('card_id',$message->CardId)->increment('used',1);//领取数+1
                        $couponInfo = Coupon::where('card_id',$message->CardId)->first();
                        if($couponInfo['used'] >= $couponInfo['quantity']){
                          Coupon::where('card_id',$message->CardId)->update(['status' =>0]);//自动下架
                        }
                        //记录领取记录
                        $ip=request()->ip();
                        $source='';
                        $p['unionid']=$memberwx->unionid;
                        if($s[0]=='m' ||$s[0]=='911'){
                            $p['type']=1;
                        }
                        if($s[0]=='k'){
                            $p['type']=3;
                        }
                        $p['sn']=$s[1];
                        $p['ip']=$ip;
                        $p['shopid']=$coupon_codes['id'];
                        $p['source']=$source;
                        $p['addtime']=time();
                        $p['ling']=1;
                        $p['cardid']=$message->UserCardCode;
                        if($s[0]=='m' ||$s[0]=='911'){
                            $p['from']=$s[3];
                        }else{
                            $p['from']=0;
                        }
                        ViewPage::insert($p);
                        //以券送卡
                        //判断该券有没有品牌商
                        $execid = Coupon::where('card_id',$message->CardId)->where('power_type',0)->where('voutocard',1)->first();

                        if($execid){
                            if($execid->power == 0){
                                //获取品牌商的id
                                // $execid=Coupon::where('card_id',$message->CardId)->where('power_type',0)->where('voutocard',1)->first();
                                //获取品牌商下的会员卡
                                $memcard=MemberCard::where('exec_id',$execid->shopid)->first();
                                if($memcard){
                                    //上级的unionid
                                    if($s[0] == 'm' || $s[0] == '911'){
                                        $unionid=Shop::where('id',$s[2])->first();
                                    }
                                    if($s[0] == 'k' || $s[0] == 'hd' ){
                                        $unionid=Kol::where('sn',$s[1])->first();
                                    }
                                    $xiaji =MemberCard::where('top_card',$memcard['member_id'])->first();

                                    //判断该人有没有该品牌商会员卡
                                    $memberkol=MemberKol::where('unionid',$memberwx->unionid)->where('exec_id',$execid->shopid)->first();
                                    //如果存在下级卡
                                    if(!$memberkol){
                                        //判断有没有下级卡
                                        if($xiaji){
                                            //有就发下级卡
                                            $cm['unionid']=$memberwx->unionid;
                                            $cm['addtime']=time();
                                            $cm['member_id']=$xiaji->member_id;
                                            $cm['member_num']=str_pad(mt_rand(0, 9999999), 12, "0", STR_PAD_BOTH);
                                            $cm['exec_id']=$execid->shopid;
                                            $cm['grading']=$unionid['unionid'];
                                            MemberKol::insert($cm);
                                        }else{
                                            //没有就发第一张卡
                                            $cm['unionid']=$memberwx->unionid;
                                            $cm['addtime']=time();
                                            $cm['member_id']=$xiaji->member_id;
                                            $cm['member_num']=str_pad(mt_rand(0, 9999999), 12, "0", STR_PAD_BOTH);
                                            $cm['exec_id']=$execid->shopid;
                                            MemberKol::insert($cm);
                                        }
                                    }

                                }
                            }
                        }
                        return '';
                    }
                }
                //------------------card
                return '';//统一返回
                break;
                case 'text':
                if($message->Content=='清除缓存'){
                    return route('wx_clear');
                }
                // if($message->Content=='店铺入驻'){
                //     return route('h5_leading_verify');
                // }

                break;
                // case 'image':
                //     return '收到图片消息';
                //     break;
                // case 'voice':
                //     return '收到语音消息';
                //     break;
                // case 'video':
                //     return '收到视频消息';
                //     break;
                // case 'location':
                //     return '收到坐标消息';
                //     break;
                // case 'link':
                //     return '收到链接消息';
                //     break;
                // // ... 其它消息
                default:
                //return '';
                break;
            }
            // ...
        });
        return $app;
    }

    //获取accesstoken
    function http_curl($url,$request_type='get',$data_type='json',$arr='')
    {
        $ch=curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//定义一些curl参数
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($request_type=='post') {//如果是post请求
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        $output=curl_exec($ch);//执行请求
        if ($data_type=='json') {
            if ( curl_errno($ch) ) {//如果请求出错，返回错误信息
                return curl_error($ch);
            }
            else{//请求成功获取数据
                $res=json_decode($output,true);
            }
        curl_close($ch);//curl关闭
        return $res;//返回数据
        }
    }

    //模版消息
    public function notice($param){
        $app=$this->app;
        $notice = $app->notice;
        try {
            return $notice->send($param);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function noticeAll(){
        $app=$this->app;
        $notice = $app->notice;
        return $notice->getPrivateTemplates();
    }


    public function jssdk($param=[]){
        $lists=[
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone',
            'startRecord',
            'stopRecord',
            'onVoiceRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'onVoicePlayEnd',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'translateVoice',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ];
        $app=$this->app;
        $js = $app->js;
        $param=empty($param)?$lists:$param;
        return $js->config($param);
    }


    //创建微信门店并获取信息
    public function createStores($info)
    {
        $app=$this->app;
        $poi=$app->poi;
        $result = $poi->create($info);
        return $result;
    }

    //获取门店信息
    public function getStoreInformation($id)
    {
        $app=$this->app;
        $poi=$app->poi;
        $info = $poi->get($id);
        return $info;
    }

    //修改微信门店
    public function modifyWeChatStores($poiid,$data)
    {
        $app=$this->app;
        $poi=$app->poi;
        // $data = array(
        //    "telephone" => "020-12345678",
        //    "recommend" => "",
        //   );
        $res = $poi->update($poiid, $data); //poi_id 修改数组
        return $res;
    }

    //获取微信门店
    public function getStoresList()
    {
        $app=$this->app;
        $poi=$app->poi;
        $res=$poi->lists(0, 40);// begin:0, limit:9
        return $res;
    }

    //删除微信门店
    public function deleteWechatStores($id)
    {
        $app=$this->app;
        $poi=$app->poi;
        $res=$poi->delete($id);//填入poiid
        return $res;
    }

    public function categoriesWechatStores()
    {
        $app=$this->app;
        $poi=$app->poi;
        $res=$poi->getCategories();//填入poiid
        return $res;
    }


}
