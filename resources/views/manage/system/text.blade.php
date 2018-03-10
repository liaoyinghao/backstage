@extends('manage.common.master')
@section('usercss')
<style media="screen">
    .bootbox-input-textarea{height: 300px!important;}
</style>
@endsection
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            bootbox.setLocale("zh_CN");
            $("table").on("click",".tap-edit",function(){
                var value=$(this).attr("data-content");
                var key=$(this).attr("data-key");
                bootbox.prompt({
                    title: "请输入编辑内容",
                    inputType: "textarea",
                    value: value,
                    callback: function (c) {
                        if (c === null) {}else{
                            $.post("{{route('manage_system_text_post')}}",{"text[key]":key , "text[content]":c},function(){

                                alert("修改成功");
                                location.href=location.href;
                            });
                        }
                    }
                });
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
                        <a href="{{route('manage_system_text_add')}}" class="btn blue btn-outline" target="_blank"><i class="fa fa-plus"></i> 添加 </a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>名称</th>
                            <th>key</th>
                            <th>内容</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                            @if($v->id)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$v->title}}</td>
                                <td>{{$v->key}}</td>
                                <td>{{str_limit($v->content,20)}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn blue btn-xs tap-edit" data-content="{{$v->content}}" data-key="{{$v->key}}">编辑</button>
                                    </div>
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
