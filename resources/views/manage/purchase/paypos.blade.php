@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $("table").on("click",".prev",function(){
                var u=$(this).attr("data-src");
                var n=$(this).attr("data-name");
                var h='<div class="text-center"><p>'+n+'</p><img src="'+u+'"></div>';
                bootbox.alert(h);
            });

            $("table").on("click",".tap-check",function(){
                var sn=$(this).attr("data-sn");
                $.post("{{route('h5_process_wx_pay_return')}}",{"sn":sn},function(){});//search
                alert("操作成功!");
                location.href=location.href;
            });


        });

    </script>
@endsection

@section('content')
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
                            <th>订单号</th>
                            <th>价格</th>
                            <th>店铺名</th>
                            <th>支付状态</th>
                            <th>发货状态</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->out_trade_no}}</td>
                            <td>￥{{$v->total_fee}}</td>
                            <td>{{$shops[$v->shopid] or ''}}</td>

                            <td> <a class=" label @if($status[$v->status] == '未购买') label-danger @else label-success @endif"> {{$status[$v->status]}}</a></td>

                            @if($v->delivery == 1)
                                <td> <a class="label label-success">已发货</a> </td>
                            @else
                                <td> <a class="label label-danger">未发货</a> </td>
                            @endif
                            
                            <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                            <td><a href="{{route('manage_recharge_payposdetails',['out_trade_no'=>$v->out_trade_no])}}" style="color: #fff;text-decoration: none" class="btn blue btn-xs">查看详情</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
