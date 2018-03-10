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
                var h='<p>card_id: '+$(this).attr("data-cardid")+'</p>';
                    // h=h+'<p>uuid: '+$(this).attr("data-uuid")+'</p>';
                    // h=h+'<p>major: '+$(this).attr("data-major")+'</p>';
                    // h=h+'<p>minor: '+$(this).attr("data-minor")+'</p>';
                bootbox.alert(h);
            });

            $("table").on("click",".tap-view",function(){
                var sn=$(this).attr("data-sn");
                var title=$(this).attr("data-title");
                var cardid=$(this).attr("data-cardid");
                var h='<div class="text-center"><p>'+title+'</p><img src="http://pan.baidu.com/share/qrcode?w=300&h=300&url={{route('h5_store_main_host')}}?sid='+sn+'&card_id='+cardid+'"></div>';
                bootbox.alert(h);
            });
        });


    </script>
@endsection

@section('content')
<style type="text/css">
#news-table_paginate{opacity: 0}
.portlet-body .pagination{position: absolute;bottom: 40px;left: 35px;z-index: 100;}
.light{padding-bottom: 80px !important;}
#news-table_length{opacity: 0}
#news-table_filter{text-align: right;}
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
                            <th>店铺名</th>
                            <th>访问人</th>
                            <th>访问类别</th>
                            <!-- <th>来源渠道</th> -->
                            <th>访问时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                            @if($v->id)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$shops[$v->shopid] or ''}}</td>
                                <td>{{$members[$v->unionid] or ''}}</td>
                                <td>
                                    @if($v->type==1) 店铺 @endif
                                    @if($v->type==2) 店员 @endif
                                    @if($v->type==3) 达人 @endif
                                    @if($v->type==0) 其他 @endif
                                </td>
                                <td>{{date('Y-m-d H:i',$v->addtime)}}</td>
                                <td>

                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                        {!! $lists->links() !!}
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
