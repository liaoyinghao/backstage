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
                            <th>店铺名</th>
                            <th>充值产品</th>
                            <th>充值数量</th>
                            <th>充值价格</th>
                            <th>时间</th>
                            <th>状态</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->out_trade_no}}</td>
                            <td>{{$shopname[$v->shopid] or ''}}</td>
                            <td>{{$goodsname[$v->goodsid]}}</td>
                            <td>{{$v->num}}</td>
                            <td>&yen;{{$v->total_fee}}</td>
                            <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                            <td>
                                @if($v->status==0) <span class="label label-info">未支付</span> @endif
                                @if($v->status==2) <span class="label label-success">成功</span> @endif
                                @if($v->status==3) <span class="label label-danger">失败</span> @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('manage_recharge_order.show',['sn'=>$v->out_trade_no])}}" class="btn blue btn-xs">详情</a>
                                    @if($v->status<2)
                                    <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="javascript:;" class="tap-check" data-sn="{{$v->out_trade_no}}"> 检查订单 </a></li>
                                        <!-- <li class="divider"> </li>
                                        <li><a href="javascript:;">删除</a></li> -->
                                    </ul>
                                    @endif
                                </div>
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
