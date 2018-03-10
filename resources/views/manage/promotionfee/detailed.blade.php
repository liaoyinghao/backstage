@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });
        });
    </script>
@endsection

@section('content')
<link href="/assets/apps/css/data_street.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
.portlet-body{padding:50px}
#bordereds{padding-bottom: 80px}
.portlet-body p .col-md-6{margin-bottom:10px}
.portlet-body2{float: right;}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered" id="bordereds">
                <div class="col-md-12 shoplist_top">
                    <b>卡券信息</b>
                </div>
                <div class="portlet-body">
                    <p><span class="col-md-6">卡券名：{{$coupons[$lists->card_id] or ''}}</span><span class="col-md-6">推广店铺：{{$shops[$lists->shopid] or ''}}</span></p>
                    <p><span class="col-md-12">推广方式:{{$pricetype[$lists->pricetype] or ''}}</span></p>
                </div>

                <div class="col-md-12 shoplist_top">
                    <b>价格信息</b>
                </div>

                <div class="portlet-body">
                    <p><span class="col-md-6">数量：{{$lists->num or ''}}</span>
                    <span class="col-md-6">单价(元)：{{$lists->price or ''}}</span></p>
                    <p><span class="col-md-6">总价(元)：{{$lists->total_fee or ''}}</span>
                    <span class="col-md-6">领取数：{{$lists->numed or ''}}</span></p>
                    <p><span class="col-md-6">已支付推广费(元):{{$lists->numed*$lists->price}}</span><span class="col-md-6">剩余推广费(元):{{$lists->total_fee - $lists->numed*$lists->price}}<span style="color:red">@if($lists->status ==2)(已退回)@endif</span></span></p>
                </div>

                <div class="col-md-12 shoplist_top">
                    <b>订单信息</b>
                </div>

                <div class="portlet-body">
                    <p><span class="col-md-12">下单时间：{{date("Y-m-d H:i:s",$lists->addtime)}}</span></p>
                    <p><span class="col-md-6">支付方式：{{$pay[$lists->pay] or ''}}</span>
                    <span class="col-md-6">订单状态：{{$status[$lists->status] or ''}}</span></p>
                    <p><span class="col-md-6">充值编号：{{$lists->out_trade_no or ''}}</span>
                    <span class="col-md-6">微信订单号：{{$lists->transaction_id or ''}}</span></p>
                </div>
                <div class="portlet-body2"><a href="{{route('manage_recharge_promotionfee')}}"><button class="btn grey-mint btn-outline fullscreen"><<返回推广费订单页</button></a></div>
            </div>
        </div>
    </div>

@endsection
