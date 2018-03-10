@extends('manage.common.master')
@section('userjs')
<script src="/plugins/h5/js/ajaxsubmit.js" charset="utf-8"></script>
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 4, "desc" ]
                ]
            });



            bootbox.setLocale("zh_CN");
            // dialog.modal('hide')
            $("table").on("dblclick",".tap-uuid",function(){
                var h='<p>device_id: '+$(this).attr("data-deviceid")+'</p>';
                    h=h+'<p>uuid: '+$(this).attr("data-uuid")+'</p>';
                    h=h+'<p>major: '+$(this).attr("data-major")+'</p>';
                    h=h+'<p>minor: '+$(this).attr("data-minor")+'</p>';
                bootbox.alert(h);
            });


            $(".table").on("click",".tap-shake",function(){
                var id=$(this).val();
                if($(this).is(':checked')){
                    var s={{$street->id}};
                }else{
                    var s=0;
                }

                $.ajax({
                    type:"post",
                    data:{"streetid":s , "shakeid":id},
                    dataType:"json",
                    url:"{{route('manage_street_bind_shake_post')}}",
                    success:function(s){
                    }
                });
            });



        });


    </script>
@endsection

@section('content')
<form class="" action="{{route('manage_shake_bind_post')}}" method="post" id="bind-form">
    <input type="hidden" name="streetid" value="{{$street->id}}">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}} - {{$street->name}}</span>
                    </div>
                    <div class="actions">

                        <button class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</button>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>设备备注</th>
                            <th>device_id</th>
                            <th>页面</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                            @if($v->streetid==0 || $v->streetid==$street->id)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$v->comment}}</td>
                                <td><span class="label label-info tap-uuid" data-deviceid="{{$v->device_id}}" data-uuid="{{$v->uuid}}" data-major="{{$v->major}}" data-minor="{{$v->minor}}">{{$v->device_id}}</span></td>
                                <td>
                                    <a href="{{route('manage_shake_shakepage',['flag'=>'view' , 'deviceid'=>$v->device_id])}}" target="_blank" class="btn red btn-xs">{{$nums[$v->device_id] or 0}}</a>
                                </td>
                                <td>
                                    <span class="hidden">@if($v->streetid==$street->id) 1 @endif</span>
                                    <div class="md-checkbox has-error">
                                        <input type="checkbox" value="{{$v->id}}" id="news-c{{$v->id}}"@if($v->streetid==$street->id) checked @endif class="md-check tap-shake" @if($v->shopid>0) disabled @endif>
                                        <label for="news-c{{$v->id}}">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
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
</form>
@endsection
