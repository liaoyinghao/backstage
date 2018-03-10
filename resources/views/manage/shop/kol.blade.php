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
                var uu=$(this).attr("data-url");
                var h='<div class="text-center"><p>'+n+'</p><p>'+uu+'</p><img src="'+u+'"></div>';
                bootbox.alert(h);
            });


            $(".tap-allurl").click(function(){
                var t='<textarea class="form-control" rows="20" >';
                @foreach($lists as $v) @if($v->status==1) var t=t+"{{$v->realname}} : {{route('h5_person_main',['eid'=>$v->sn])}}\n"; @endif @endforeach
                t=t+"</textarea>";
                bootbox.alert(t);
            });

            $(".tap-one").click(function(){
                $(this).attr("disabled","disabled");
                var openid=$(this).attr("data-openid");
                $.post("{{route('manage_process_wxmember')}}",{"openid":openid},function(d){

                });
                alert("更新成功");
                location.href=location.href;
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
                        <button type="button" class="btn blue btn-xs tap-allurl">全部链接</button>

                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>手机</th>
                            <th>领卡</th>
                            <th>关注</th>
                            <th>加入时间</th>
                            <th>定位城市</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $v)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td><img src="{{$v->avatar}}" alt="" style="height:40px;"></td>
                                <td>{{$v->nickname}}</td>
                                <td>{{$v->phone}}</td>
                                <td>
                                    @if($v->bindtime>0)
                                    {{date('Y-m-d H:i',$v->bindtime)}}
                                    @else
                                    未领卡
                                    @endif
                                </td>
                                <td>
                                    @if($v->subscribe>0)
                                    {{date('Y-m-d H:i',$v->subscribe_time)}}
                                    @else
                                    未关注
                                    @endif
                                </td>
                                <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                                <td>@if($v->city){{$v->city}}@else暂未定位@endif</td>
                                <!-- <td>
                                    @if($v->status == 0) <span class="label label-warning">停用</span> @endif
                                    @if($v->status == 1) <span class="label label-success">正常</span> @endif
                                    @if($v->status == 2) <span class="label label-danger">已删除</span> @endif
                                </td> -->
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn blue btn-xs prev" data-name="{{$v->realname}}" data-url="{{route('h5_store_kol' , ['ksn'=>$v->sn])}}" data-src="http://pan.baidu.com/share/qrcode?w=300&h=300&url={{str_replace('&' , '%26' , route('h5_store_kol' , ['ksn'=>$v->sn]))}}">预览</button>
                                        <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="javascript:;" class="tap-one" data-openid="{{$v->openid}}"> 微信更新 </a></li>
                                        </ul>
                                        <!-- <ul class="dropdown-menu pull-right" role="menu">
                                            <li class="divider"> </li>
                                            <li><a href="javascript:;">删除</a></li>
                                        </ul> -->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {!! $lists->links() !!}
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
