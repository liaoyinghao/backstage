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
                            <th>本地订单号</th>
                            <th>微信订单号</th>
                            <th>店铺名</th>
                            <th>提现级别</th>
                            <th>提现人</th>
                            <th>提现金额</th>
                            <th>实际金额</th>
                            <th>状态</th>
                            <th>时间</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->mch_billno or ''}}</td>
                            <td>{{$v->partner_trade_no or ''}}</td>
                            <td>{{$shops[$v->shopid] or ''}}</td>
                            <td>{{$level[$v->type] or ''}}</td>
                            <td>{{$members[$v->unionid] or ''}}</td>
                            <td>&yen;{{$v->origin}}</td>
                            <td>&yen;{{$v->money}}</td>
                            <td>{{$status[$v->status]}}</td>
                            <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                            <td>
                                <!-- <div class="btn-group">
                                    <a href="{{route('manage_recharge_luck.show',['sn'=>$v->mch_billno])}}" class="btn blue btn-xs">详情</a>
                                </div> -->
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
