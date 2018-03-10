<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderWx;
use App\Models\Shop;
use App\Models\GoodsRecharge;
use App\Models\Member;

class OrderRechargeReController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['lists']=OrderWx::manageLists();
        $data['shopname']=Shop::shopNameByid();
        $data['goodsname']=GoodsRecharge::goodsNameByid();

        return view('manage.recharge.orderlists' , $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $data['order']=OrderWx::where('out_trade_no',$id)->first();
        if(!$data['order'])
            return view('h5.common.error',['msg'=>'订单不存在','url'=>'javascript:history.back();']);
            
        $data['shopname']=Shop::shopNameByid();
        $data['goods']=GoodsRecharge::getInfo($data['order']->goodsid);
        $data['membername']=Member::memberNames();
        $data['status']=['未支付','已支付未充值','已充值','失败'];
        return view('manage.recharge.orderdetail',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $note2=$request->input('note2');
        OrderWx::where('out_trade_no',$id)->update(['note2'=>$note2]);
        return redirect()->route('manage_recharge_order.show',['sn'=>$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
