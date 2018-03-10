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
                            <th>卡券名</th>
                            <th>店铺名</th>
                            <th>品牌名</th>
                            <th class="tb-num">限领</th>
                            <th class="tb-num">总库存</th>
                            <th class="tb-num">领取</th>
                            <th class="tb-num">核销</th>
                            <th>状态</th>
                            <th>制作时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                            @if($v->id)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td><a href="javascript:;" class="prev" data-cardid="{{$v->card_id}}">{{$v->title}}</a></td>
                                <td><a href="javascript:;" class="tap-view" data-sn="{{$v->sn}}" data-title="{{$v->name}}" data-cardid="">{{$v->name}}</a></td>
                                <td>{{$v->brand_name}}</td>
                                <td>{{$v->get_limit}}</td>
                                <td>{{$v->quantity}}</td>
                                <td><a href="{{route('manage_card_code',['card_id'=>$v->card_id])}}" class="btn blue-chambray btn-xs" target="_blank">{{$v->used}}</a></td>
                                <td>{{$veris[$v->card_id] or 0}}</td>
                                <td>
                                    @if($v->status==1)
                                    <span class="label label-success">正常</span>
                                    @else
                                    <span class="label label-danger">下架</span>
                                    @endif
                                </td>
                                <td>{{date('Y-m-d H:i',$v->addtime)}}</td>
                                <td>
                                    @if($v->status==1)
                                    <button type="button" class="btn blue btn-xs tap-view" data-sn="{{$v->sn}}" data-title="{{$v->title}}" data-cardid="{{$v->card_id}}">预览</button>
                                    @endif
                                    <a class="btn blue btn-xs" href="{{route('manage_card_details',['id'=>$v->id])}}" target="_blank">查看</a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
