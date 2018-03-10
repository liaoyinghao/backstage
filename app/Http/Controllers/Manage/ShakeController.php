<?php

namespace App\Http\Controllers\Manage;
use ZipArchive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shake;
use App\Models\Shop;
use App\Models\Street;
// use App\Models\ShakeWx;
use App\Models\ShakePage;
use App\Models\ShakeToPage;
use App\Library\Wechat;
use App\Models\Poslogin;
use App\Models\Qrcode;
use App\Models\Executive;

class ShakeController extends Controller
{


    public function index(){
        return redirect()->route('manage_shake_main');
    }




    public function main(){
        $flag=request()->input('flag');
        switch ($flag) {
            case 'view':
                $pageid=request()->input('pageid');
                $deviceids=ShakeToPage::pageidToDeviceid($pageid);
                if(empty($deviceids)){
                    $data['lists']=[];
                }else{
                    $data['lists']=Shake::whereIn('device_id',$deviceids)->get();
                }
                break;

            default:
                $data['lists']=Shake::mLists();
                break;
        }

        $data['shopname']=Shop::shopNameByid();
        $data['streetname']=Street::mName();
        $data['types']=Shake::types();
        $data['nums']=ShakeToPage::shakeNum(1);

        return view('manage.shake.main' , $data);
    }


    public function shakepage(){
        $flag=request()->input('flag');
        switch ($flag) {
            case 'view':
                $deviceid=request()->input('deviceid');
                $pageids=ShakeToPage::deviceidToPageid($deviceid);
                // dd($pageids);
                if(empty($pageids)){
                    $data['lists']=[];
                }else{
                    $data['lists']=ShakePage::whereIn('page_id',$pageids)->get();
                }
                break;

            default:
                $data['lists']=ShakePage::manageList();
                break;
        }
        $data['nums']=ShakeToPage::shakeNum(2);
        return view('manage.shake.shakepage' , $data);
    }

    public function shakepageAdd(){
        // $deviceid=request()->input('deviceid',0);
        // $data['shake']=Shake::where('device_id',$deviceid)->first();
        $data['exec']=Executive::select("id","nickname","unionid")->where("status",1)->get();
        return view('manage.shake.form' , $data);
    }

    public function shakepageformAdd(){
        $store=request()->input('store');
        if($store){
            $data['execid'] = $store['execid'];
        }else{
            $data['execid'] = 0;
        }

        $data['status'] = 1;
        $data['addtime'] = time();
        $result = Qrcode::create($data);
        $id = $result->id;
        $info['url'] = 'http://dragon.o2opark.com/h5/store/register?qrno='.$id;
        $is_ok = Qrcode::where('id',$id)->update($info);
        if($is_ok){
            return redirect()->route('manage_shake_qrcodelist');
        }
    }

    public function shakeforms(){
        $data['exec']=Executive::select("id","nickname","unionid")->where("status",1)->get();
        return view('manage.shake.forms' , $data);
    }

    public function shakeformsAdd(){
        $store=request()->input('store');
        $number = request()->input('number');
        if($store){
            $data['execid'] = $store['execid'];
        }else{
            $data['execid'] = 0;
        }

        $data['status'] = 1;
        $data['addtime'] = time();

        for($i=0;$i<$number;$i++){
            $result = Qrcode::create($data);
            $id = $result->id;
            $info['url'] = 'http://dragon.o2opark.com/h5/store/register?qrno='.$id;
            $is_ok = Qrcode::where('id',$id)->update($info);
        }
        
        return redirect()->route('manage_shake_qrcodelist');
        
    }

    public function shakepageAddPost(){
        $page=request()->input('page');
        $deviceid=request()->input('deviceid');
        $we=new Wechat();
        $res=$we->shakePageAdd($page);
        if($res['errmsg']=='success.'){
            $page['page_id']=$res['data']['page_id'];
            ShakePage::manageAdd($page);
        }
        if($deviceid){//绑定设备
            $pages[]=$page['page_id'];
            $res=$we->shakeBind($deviceid,$pages);
            if($res['errmsg']=='success.'){
                ShakeToPage::updateByShake($deviceid,$pages);
            }
        }
        return redirect()->route('manage_shake_shakepage');
    }


    public function shakepageEdit(){
        $deviceid=request()->input('deviceid');
        if($deviceid){
            $dev=ShakeToPage::deviceidToPageid($deviceid);
        }
        $pageid=request()->input('pageid',$dev[0]);

        $data['edits']=ShakePage::getByPageid($pageid);
        $data['shake']=[];
        return view('manage.shake.form' , $data);
    }


    public function shakepageEditPost(){
        $page=request()->input('page');
        $we=new Wechat();
        $res=$we->shakePageEdit($page);
        if($res['errmsg']=='success.'){
            ShakePage::where('page_id',$page['page_id'])->update($page);
        }
        return redirect()->route('manage_shake_main');
    }


    public function shakeBind(){
        $deviceid=request()->input('deviceid');
        $data['pagesid']=array_flip(ShakeToPage::where('device_id',$deviceid)->pluck('page_id')->toArray());
        $data['lists']=ShakePage::get();
        $data['deviceid']=$deviceid;
        // dd($data);
        return view('manage.shake.shakebind' , $data);
    }

    public function shakeBindPost(){
        $deviceid=request()->input('deviceid');
        $page=request()->input('pages');
        $pages=[];
        if($page){
            foreach ($page as $k => $v) {
                $pages[]=$k;
            }
        }

        $we=new Wechat();
        $res=$we->shakeBind($deviceid,$pages);
        if($res['errmsg']=='success.'){
            ShakeToPage::updateByShake($deviceid,$pages);
            return 1;
        }else{
            return 0;
        }

    }


    public function updateComment(){
        $comment=request()->input('comment');
        $deviceid=request()->input('deviceid');
        $we=new Wechat();
        $res=$we->shakeCommentUpdate($deviceid,$comment);
        if($res['errmsg']=='success.'){
            Shake::where('device_id',$deviceid)->update(['comment'=>$comment]);
        }
        return 1;
    }




    public function getShakes(){
        $lastid=Shake::lastDid();
        $we=new Wechat();
        $res=$we->shakePagination($lastid,30);
        $n=count($res->data['devices']);
        // dd($res->data['devices']);
        if($n>0){
            Shake::mUpdates($res->data['devices']);
        }
        return $n;
    }

    public function getShakePages(){
        $lastnum=ShakePage::count();
        $we=new Wechat();
        $res=$we->shakePaginationGetPage($lastnum,30);
        $n=count($res->data['pages']);
        // dd($res->data['pages']);
        if($n>0){
            ShakePage::mUpdates($res->data['pages']);
        }
        return $n;
    }

    //更新设备与页面
    public function deviceToPage(){
        $deviceid=intval(request()->input('deviceid'));
        if($deviceid>0){
            $we=new Wechat();
            $deviceIdentifier['device_id']=$deviceid;
            $res=$we->shakeGetPageByDeviceId($deviceIdentifier);
            ShakeToPage::updateByShake($deviceid,$res);
        }
        return 1;
    }

    //更新页面与设备
    public function pageToDevice(){
        $pageid=intval(request()->input('pageid'));
        if($pageid>0){
            $we=new Wechat();
            $res=$we->shakeGetDeviceByPageId($pageid,0,30);
            ShakeToPage::updateByPage($pageid,$res);
        }
        return 1;
    }


    public function viewPage(){
        $deviceid=intval(request()->input('deviceid'));
        $res=ShakePage::deviceViewPage($deviceid);
        return response()->json($res);
    }


    public function devProcess(){
        $flag=request()->input('flag');
        switch ($flag) {
            case 'change-emp':
                $shopid=request()->input('change-emp');
                $deviceid=request()->input('deviceid');
                $shop=Shop::sInfo($shopid);
                $host=Shake::where('device_id',$shop->dev_sn)->first();
                $m['parentid']=$host->id;
                $m['shopid']=$shop->id;
                $m['streetid']=$shop->streetid;
                $m['bindtime']=time();
                $m['change_num']=2;
                Shake::where('device_id',$deviceid)->update($m);
                break;

            case 'change-pub':
                $deviceid=request()->input('deviceid');
                $v=request()->input('v');
                Shake::where('device_id',$deviceid)->update(['is_published'=>$v]);
            default:
                # code...
                break;
        }
    }

    //pos机登录记录
    public function posRecord(){
        $data['lists']=Poslogin::get();
        $data['shop']=Shop::pluck('name','id')->toArray();
        return view('manage.shake.posrecord',$data);
    }

    //pos机登录记录
    public function qrCodeList(){
        $data['lists']=Qrcode::get();
        $shopsn = [];
        if(!empty($data['lists'][0])){

            foreach ($data['lists'] as $k => $v) {
                $bianhao = explode('=', $v->url);
                $data['lists'][$k]['bianhao'] = 400000 + $bianhao[1];

                if(!empty($v->bindurl)){
                    $bind = explode("sid=",$v->bindurl);
                    $data['lists'][$k]['sn'] = $bind[1];
                    $shopsn[$k] = $bind[1];
                } 
            }
        }

        $data['shop'] = Shop::select("name","sn")->whereIn("sn",$shopsn)->pluck('name','sn')->toArray();

        $data['exec']=Executive::select("id","nickname")->get();
        return view('manage.shake.qrcodelist',$data);
    }

    //二维码
    public function qrcodeRwm(){

        //生成二维码并下载
        $shopid = request()->input('shopid');
        $exec_id = request()->input('exec_id');

        if(!empty($shopid) && !empty($exec_id)){
            $exec_id =$exec_id.'/'.time().rand(1000,9999);//文件上一级目录
            $shop = explode(',',$shopid);
            $n_url = '';
            for ($i=0; $i < count($shop) ; $i++) {
                $shopSn = Qrcode::where('id',$shop[$i])->first();
                if(!empty($shopSn['bindurl'])){
                    $n_url = $shopSn['bindurl'];
                }else{
                    $n_url = $shopSn['url'];
                }
                $bianhao = 400000 + $shop[$i]; // 二维码编号
                $data['qrcode']=\App\Library\Tools::downloaddqrs(['str'=>$n_url],1,1,$bianhao,$exec_id);
            }

                $filename = public_path("uploads/m/".$exec_id.'.zip');
                $zip = new ZipArchive (); // 使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
                if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
                    exit ('无法打开文件，或者文件创建失败');
               }
               $handler = opendir("uploads/m/".$exec_id);
               // dd($handler);
               while (($filename = readdir($handler)) !== false) {
                 if ($filename != "." && $filename != "..") {// 文件夹文件名字为'.'和‘..’，不要对他们进行操作
                   $zip->addFile("uploads/m/".$exec_id . "/" . $filename);
                 }
               }
               @closedir(public_path("uploads/m/".$exec_id));
               $zip->close(); // 关闭
               return response()->download(realpath(public_path("uploads/m").'/'.$exec_id.".zip"),'二维码.zip');
        }






        $data['lists']=Qrcode::get();
        $shopsn = [];
        if(!empty($data['lists'][0])){
            foreach ($data['lists'] as $k => $v) {
                $bianhao = explode('=', $v->url);
                $data['lists'][$k]['bianhao'] = 400000 + $bianhao[1];
                if(!empty($v->bindurl)){
                    $bind = explode("sid=",$v->bindurl);
                    $data['lists'][$k]['sn'] = $bind[1];
                    $shopsn[$k] = $bind[1];
                } 
            }
        }
        $data['shop'] = Shop::select("name","sn")->whereIn("sn",$shopsn)->pluck('name','sn')->toArray();

        return view('manage.shake.qrcoderwm',$data);
    }

    public function qrcodeForm(){
        $id = request()->input("id");
        $execid = request()->input('execid');
        Qrcode::where("id",$id)->update(['execid'=>$execid]);
        return redirect()->route("manage_shake_qrcodelist");
    }

    public function posout()
    {
        $id=request()->input('id');
        $time=time();
        Poslogin::where('id',$id)->update(['logouttime'=>$time,'secretkey'=>'']);
        return redirect()->route("manage_shake_posrecord");
    }

}
