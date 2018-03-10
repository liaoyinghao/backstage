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
.portlet-body{padding:50px;padding-bottom: 250px}
#bordereds{padding-bottom: 80px}
.portlet-body p.col-md-10{display: block;}
.portlet-body p.col-md-10>span{display: inline-block;text-align: right;}
.portlet-body2{text-align: right;}
.shoplist_top>a{font-size: 12px;float: right;}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered" id="bordereds">
                <div class="col-md-12 shoplist_top">
                    <b>推广明细</b>
                    <a href="{{route('manage_recharge_promotionfee')}}"><<返回推广费订单页</a>
                </div>

                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="70px">类型</th>
                            <th>推广人</th>
                            <th>推广时间</th>
                            <th>推广卡券</th>
                            <th>推广金额(元)</th>
                            <th>推广方式</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>达人</td>
                            <td>{{$kol[$v->unionid] or ''}}</td>
                            <td>{{date('Y-m-d H:i:s',$v->addtime) or ''}}</td>
                            <td>{{$coupons[$order->card_id] or ''}}</td>
                            <td>{{$v->money or ''}}</td>
                            <td>{{$pricetype[$order->pricetype] or ''}}</td>
                        </tr>
                        @endforeach

                        @foreach($list as $v)
                        <tr>
                            <td>异业</td>
                            <td>{{$shop[$v->unionid] or ''}}</td>
                            <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                            <td>{{$coupons[$order->card_id] or ''}}</td>
                            <td>{{$v->money or ''}}</td>
                            <td>{{$pricetype[$order->pricetype] or ''}}</td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection
