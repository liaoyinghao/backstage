@extends('manage.common.master')

@section('usercss')

@endsection
@section('userjs')
<script>

$(function(){

});
</script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase">充值详情 </span>
                </div>
            </div>
            <div class="portlet-body">
                <form class="form-horizontal" role="form" action="{{route('manage_recharge_order.update',['id'=>$order->out_trade_no])}}" method="post">
                    {{ method_field('PUT') }}
                    <div class="form-body">
                        <h2 class="margin-bottom-20"> {{$order->out_trade_no}} <small><span class="label label-info">{{$status[$order->status]}}</span></small></h2>
                        <h3 class="form-section">充值信息</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">店铺名:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$shopname[$order->shopid] or '店铺'}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">订单时间:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{date('Y-m-d H:i:s',$order->addtime)}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">产品名:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$goods->title}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">充值时间:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">@if($order->updatetime>0) {{date('Y-m-d H:i:s',$order->updatetime)}} @endif</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">充值人:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$membername[$order->unionid]}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">充值次数:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->num}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <h3 class="form-section">订单信息</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">微信单号:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->transaction_id}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">订单价格:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> &yen;{{$order->total_fee}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">订单标题:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->body}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">订单内容:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->detail}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">订单备注:</label>
                                    <div class="col-md-9">
                                        <textarea name="note2" rows="3" cols="80" class="form-control">{{$order->note2}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-3">
                                        <button type="submit" class="btn blue col-md-9"> 保存 </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
