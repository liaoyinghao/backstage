@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            // $("table").on("click",".prev",function(){
            //     var u=$(this).attr("data-src");
            //     var n=$(this).attr("data-name");
            //     var h='<div class="text-center"><p>'+n+'</p><img src="'+u+'"></div>';
            //     bootbox.alert(h);
            // });

            // $("table").on("click",".tap-check",function(){
            //     var sn=$(this).attr("data-sn");
            //     $.post("{{route('h5_process_wx_pay_return')}}",{"sn":sn},function(){});//search
            //     alert("操作成功!");
            //     location.href=location.href;
            // });


        });

    </script>
@endsection

@section('content')
<style type="text/css">
#news-table_filter{text-align: right;}
.operation>a{display: block;color: #337ab7;font-size: 12px}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>推广店铺</th>
                            <th>卡券名</th>
                            <th>总价格(元)</th>
                            <th>状态</th>
                            <th>下单时间</th>
                            <th>订单号</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $v)
                            <tr>
                            <td width="50px">{{$v->id}}</td>
                            <td>{{$shops[$v->shopid]}}</td>
                            <td>{{$coupons[$v->card_id]}}</td>
                            <td>{{$v->total_fee}}</td>
                            <td>{{$status[$v->status]}}</td>
                            <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                            <td>{{$v->out_trade_no}}</td>
                            <td class="operation">
                                <a href="{{route('manage_recharge_detailed',['id'=>$v->id])}}">推广订单详情</a>
                                <a href="{{route('manage_recharge_details',['id'=>$v->out_trade_no])}}">推广明细</a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
