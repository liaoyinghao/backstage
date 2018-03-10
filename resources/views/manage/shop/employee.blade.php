@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 1, "desc" ]
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
                        <button type="button" class="btn blue btn-xs tap-allurl">全部链接</button>

                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>店铺名</th>
                            <th>店员名</th>
                            <th>真名</th>
                            <th>手机</th>
                            <th>设备</th>
                            <th>状态</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($lists))
                        @foreach($lists as $v)
                        @if(!empty($v['id']))
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$shops[$v->shopid]}}</td>
                            <td>{{$v->nickname}}</td>
                            <td>{{$v->realname}}</td>
                            <td>{{$v->phone}}</td>
                            <td>
                                @if($v->dev_sn>0)
                                <a href="{{route('manage_shake_main',['deviceid'=>$v->dev_sn])}}" class="btn blue btn-xs" target="_blank">{{$v->dev_sn}}</a>
                                @endif
                            </td>
                            <td>
                                @if($v->status == 0) <span class="label label-warning">停用</span> @endif
                                @if($v->status == 1) <span class="label label-success">正常</span> @endif
                                @if($v->status == 2) <span class="label label-danger">已删除</span> @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn blue btn-xs prev" data-name="{{$v->realname}}" data-url="{{route('h5_person_main' , ['eid'=>$v->sn])}}" data-src="http://pan.baidu.com/share/qrcode?w=300&h=300&url={{str_replace('&' , '%26' , route('h5_person_main' , ['eid'=>$v->sn]))}}">预览</button>
                                    <!-- <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                        <i class="fa fa-angle-down"></i>
                                    </button> -->
                                    <!-- <ul class="dropdown-menu pull-right" role="menu">
                                        <li class="divider"> </li>
                                        <li><a href="javascript:;">删除</a></li>
                                    </ul> -->
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
