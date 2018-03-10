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
                            <th>购买店铺名</th>
                            <th>订单号</th>
                            <th>购买时间</th>
                            <th>购买总价</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($list))
                            @foreach($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->out_trade_no}}</td>
                                    <td>{{date("Y-m-d H:i:s",$v->addtime)}}</td>
                                    <td><span class="label label-success">￥{{$v->total or '0 '}}元</span></td>
                                    <td> <a class="btn blue btn-xs" href="{{route('manage_recharge_cdetails',['id'=>$v->id])}}">查看明细</button></td>
                                </tr>
                            @endforeach
                        @endif
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
