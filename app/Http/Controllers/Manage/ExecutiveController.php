<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Executive;
use App\Models\Street;
use App\Models\Shop;
use App\Models\Authority;
use App\Library\Wechat;
class ExecutiveController extends Controller
{
    public function index(){
        return redirect()->route('manage_executive_main');
    }


    public function main(){
        $data['lists']=Executive::aLists();
        foreach ($data['lists'] as $key => $value) {
            $data['types']=Street::streetType();
            $data['num']=explode(",",$value->shopauthority);
            if($data['num'][0]){
                $count=count($data['num']);
                $data['lists'][$key]['count'] =$count;
            }
        }
        return view('manage.executive.main' , $data);
    }

    //店铺
    public function store()
    {
        $id =request()->input('id');
        $data['shops'] = Shop::where('status',1)->get();
        $data['streets'] = Street::mList();
        foreach ($data['streets'] as $key => $value) {
            $streetid=$value->id;
            $num = Shop::where('streetid',$streetid)->count();
            $data['streets'][$key]['num']=$num;
        }
        $login =Executive::where('id',$id)->first();
        $data['id']=$id;
        //权限勾选
        $storeauthority=Executive::where('id',$id)->first();
        $data['shopauthority']=$storeauthority->shopauthority;
        if($storeauthority){
            $data['num']=explode(",",$storeauthority->shopauthority);
        }else{
            $data['num'] = array();
        }
        return view('manage.executive.store',$data);
    }

    //店铺权限
    public function storeAuthority(Request $request)
    {
        $checkbox = empty($_POST['name']) ? null : $_POST['name'];
        $oldcheckbox = empty($_POST['oldcheckedName']) ? null : $_POST['oldcheckedName'];
        if(!$checkbox){
            return view('h5.common.error',['msg'=>'权限分配不能为空']);
        }
        // dd($oldcheckbox."|||".implode(',',$checkbox));
        // dd($checkbox[0]);
        $ocShop = explode(",",$oldcheckbox);
        $newCheck = [];
        $delCheck = [];
        for ($i=0; $i < count($checkbox); $i++){
          if(!in_array($checkbox[$i],$ocShop)){
            $newCheck[] = $checkbox[$i];
          }
        }
        for ($i=0; $i < count($ocShop); $i++){
          if(!in_array($ocShop[$i],$checkbox)){
            $delCheck[] = $ocShop[$i];
          }
        }
        $storeauthority = implode(',',$checkbox);
        if(strlen($storeauthority)>255){
            return view('h5.common.error',['msg'=>'选择商铺数量大于最大值！']);
        }
        Executive::where('id',$request->id)->update(
        array(
            'shopauthority' => $storeauthority,
        ));
        //解绑店铺
        $delShopList = Shop::select('execid','id')->whereIn('id',$delCheck)->get();
        for ($i=0; $i <count($delShopList); $i++) {
          $ds = explode(",",$delShopList[$i]['execid']);
          // dd($delShopList);
          foreach ($ds as $key => $value) {
            if ($value === $request->id){
                unset($ds[$key]);
            }
          }
          $dsp = implode(',',$ds);
          // dd($dsp);
          Shop::where('id',$delShopList[$i]['id'])->update(['execid'=>$dsp]);
        }
        //绑定新店铺
        $newShopList = Shop::select('execid','id')->whereIn('id',$newCheck)->get();
        // dd($newShopList);
        for ($i=0; $i <count($newShopList) ; $i++) {
          if($newShopList[$i]['execid']){
            $execid = $newShopList[$i]['execid'].",".$request->id;
          }else{
            $execid =$request->id;
          }
          Shop::where('id',$newShopList[$i]['id'])->update(['execid'=>$execid]);
        }
        return redirect()->route('manage_executive_main');
    }


    //注册
    public function add()
    {
        return view('manage.executive.add');
    }

    public function addpost(Request $request)
    {

            Executive::insert(
                array(
                    'remarks' => $request->name,
                ));

            return redirect()->route('manage_executive_main');
    }


    //修改备注
    public function updateRmarks()
    {
        $remarks=request()->input('remarks');
        $id=request()->input('id');
        Executive::where('id',$id)->update(['remarks'=>$remarks]);
        return 1;
    }



}
