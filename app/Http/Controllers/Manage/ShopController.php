<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Street;
use App\Models\Executive;
use App\Models\Shop;
use App\Models\Shake;
use App\Models\Coupon;
use App\Models\ShopEmployee;
use App\Models\ShakeToPage;
use App\Models\Kol;
use App\Library\Wechat;
use App\Models\weixinshop;
use EasyWeChat\Foundation\Application;
use App\Models\MemberWx;

class ShopController extends Controller
{

    protected $app;
    public function __construct(){
        $options=config('easywechat');
        $this->app = new Application($options);
    }

    public function index(){
        return redirect()->route('manage_shop_main');
    }


    public function main(){

        $flag=request()->input('flag');
        switch ($flag) {
            case 'view':
                $streetid=request()->input('streetid');
                $data['lists']=Shop::mGetByStreet($streetid);
                break;

            default:
                $data['lists']=Shop::mList();
                break;
        }

        $data['streets']=Street::mName();
        $data['nums']=ShopEmployee::mCount();
        $data['coupons']=Coupon::shopCouponNum();
        $data['shakes']=Shake::shopShakeNum();
        $data['kols']=Kol::shopNum();

        //两表查询到一起
        $count = count($data['lists']);
        for($i=0;$i<$count;$i++){
            $j = $data['lists'][$i]['poiid'];
            if(empty($j)){
                $data['lists'][$i]['weixin'] = 5;
            }else{
                $weixins = weixinshop::where('poi_id', $j)->select('weixin')->first();
                $data['lists'][$i]['weixin'] = $weixins['weixin'];
            }
        }

        return view('manage.shop.main' , $data);
    }


    public function employee(){
        $flag=request()->input('flag');
        switch ($flag) {
            case 'son':
                $shopid=request()->input('shopid');
                $data['lists']=ShopEmployee::mGetByShop($shopid);
                break;

            default:
                $data['lists']=ShopEmployee::mList();
                break;
        }

        $data['shops']=Shop::mName();
        $data['nums']=ShopEmployee::mCount();

        return view('manage.shop.employee' , $data);
    }


    public function kol(){
        $flag=request()->input('flag');
        switch ($flag) {
            case 'son':
                $shopid=request()->input('shopid');
                $data['lists']=Kol::where('shopid',$shopid)->orderBy('id','desc')->get();
                break;

            case 'street':
                $data['lists']=Kol::where('streetid',request()->input('streetid'))->orderBy('id','desc')->get();
                break;
            default:
                $data['lists']=Kol::orderBy('id','desc')->paginate(25);
                break;
        }

        $data['shops']=Shop::mName();
        $data['nums']=ShopEmployee::mCount();
        $data['streets']=Street::mName();
        $data['memberwx'] = MemberWx::orderBy('id','desc')->paginate(25);
        // dd($data['memberwx']);
        foreach ($data['memberwx'] as $key => $value) {
            foreach ($data['lists'] as $key1 => $value1) {
                if($value->unionid == $value1->unionid ){
                    $data['lists'][$key1]['subscribe']=$value['subscribe'];
                    $data['lists'][$key1]['openid']=$value['openid'];
                }
            }
        }
        return view('manage.shop.kol' , $data);
    }


    public function changeStreet(){
        $streetid=request()->input('streetid');
        $shopid=request()->input('shopid');

        Shop::changeStreet($shopid,$streetid);
        return redirect()->to(url()->previous());
    }

    public function bindShake(){
        $shopid=request()->input('shopid');
        $streetid=request()->input('streetid');
        $flag=request()->input('flag');
        if(!$flag && !$shopid)
            return redirect()->route('manage_shop_main');

        $data['flag']=$flag;
        $data['shopid']=$shopid;
        $data['streetid']=$streetid;
        $data['lists']=Shake::manageShopBindLists($streetid);
        $data['nums']=ShakeToPage::shakeNum(1);
        return view('manage.shop.bindshake' , $data);
    }


    //替换店铺dev_sn
    //替换设备shopid
    //替换店员设备parentid
    //取出原设备页面
    //查询新设备绑定页面
    //上报微信原页面与新设备覆盖绑定 1:1
    public function bindShakePost(){
        $shopid=request()->input('shopid');
        $deviceid=request()->input('deviceid');

        $new=Shake::where('device_id',$deviceid)->where("is_pos",0)->first();//新绑定
        $origin=Shake::where('shopid',$shopid)->where("is_pos",0)->first();//原绑定设备信息
        if($origin){
            Shake::where('parentid',$origin->id)->where("is_pos",0)->update(['parentid'=>$new->id]);
        }
        Shop::where('id',$shopid)->update(['dev_sn'=>$deviceid]);
        Shake::where('id',$new->id)->where("is_pos",0)->update(['shopid'=>$shopid]);

    }


    public function details(Request $request){
           $id =$request['id'];
           $data['order']=Shop::deTailsShops($id);
          //  dd($data['order']->pics);
           $data['pics']=unserialize($data['order']->pics);
           return view('manage.shop.details',$data);
    }

    public function modify(Request $request){
        $id =$request['id'];
        $weixin =$request['weixin'];
        if($weixin != 3 && $weixin != 2){

            $flag = Shop::modifyShops($id);

            switch ($flag) {
                case '1':
                    echo "<script>alert('店铺电话认证失败，请检查号码格式是否正确'),history.go(-1);</script>";
                    break;
                case '2':
                    echo "<script>alert('店铺所在位置错误，请检查是否格式失败，正确格式：xx市(县) xx 路...'),history.go(-1);</script>";
                    break;
                case '3':
                    echo "<script>alert('店铺地址经纬度不能为空！'),history.go(-1);</script>";
                    break;
                default:
                    return redirect()->back();
                    break;
            }

        }
    }

    public function deleteShop(Request $request){
        $poiid =$request['poiid'];
        if(!empty($poiid)){
            $flag = Shop::deleteShop($poiid);
            echo "<script>alert('微信店铺删除成功！'),history.go(-1);</script>";
        }
    }

    public function examine()
    {
        $data['lists']=Shop::where('examinetype','!=','2')->get();
        $data['streets']=Street::mName();
        $data['examine']=array('0' =>'未审核', '1' =>'审核未通过');
        return view('manage.shop.examine',$data);
    }

    public function editexamine()
    {
        $id=request()->input('id');
        $type=request()->input('type');
        $result=request()->input('result');
        $latitude=request()->input('latitude');
        $longitude=request()->input('longitude');
        Shop::where('id',$id)->update([
            'examinetype'=>$type,
            'latitude'=>$latitude,
            'longitude'=>$longitude,
            'result'=>$result
        ]);
        $shop=Shop::where('id',$id)->first();
        $openid=MemberWx::getOpenid1($shop->unionid);
        $result=$shop->result;
        if($type ==1){
            $options=config('easywechat');
            $app = new Application($options);
            $notice = $app->notice;
            $time =time();
            $userId =$openid;
            $templateId = '0l9SDy2INPQ4Nx_8ZVz58BPCKLuX__YdtJQhU9THnYM';
            $url = route('h5_leading_main');
            $data = array(
            "first"    => array("很遗憾您的店铺未通过审核，请再次修改提交！", '#555555'),
            "keyword1" => '互动街店铺审核通知',
            "keyword2" => '未通过(原因)'.$result,
            "keyword3" => date('Y年m月d日 H:i:s'),
            "remark"   => array("客流不停歇，就用互动街！", "#5599FF"),
        );
            $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
        if($type ==2){
            $options=config('easywechat');
            $app = new Application($options);
            $notice = $app->notice;
            $time =time();
            $userId =$openid;
            $templateId = '0l9SDy2INPQ4Nx_8ZVz58BPCKLuX__YdtJQhU9THnYM';
            $url = route('h5_leading_main');
            $data = array(
            "first"    => array("恭喜店铺审核通过！", '#555555'),
            "keyword1" => '互动街店铺审核通知',
            "keyword2" => '通过',
            "keyword3" => date('Y年m月d日 H:i:s'),
            "remark"   => array("客流不停歇，就用互动街！", "#5599FF"),
        );
            $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    return redirect()->route('manage_shop_examine');
    }


}
