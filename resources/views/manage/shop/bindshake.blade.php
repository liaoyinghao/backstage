@extends('manage.common.master')
@section('userjs')
<!-- <script src="/plugins/h5/js/ajaxsubmit.js" charset="utf-8"></script> -->
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 4, "desc" ]
                ]
            });



            bootbox.setLocale("zh_CN");
            bootbox.setDefaults({
                size:"small"
            })
            // dialog.modal('hide')
            $("table").on("dblclick",".tap-uuid",function(){
                var h='<p>device_id: '+$(this).attr("data-deviceid")+'</p>';
                    h=h+'<p>uuid: '+$(this).attr("data-uuid")+'</p>';
                    h=h+'<p>major: '+$(this).attr("data-major")+'</p>';
                    h=h+'<p>minor: '+$(this).attr("data-minor")+'</p>';
                bootbox.alert(h);
            });


            $(".tap-save").click(function(){
                bootbox.confirm({
                    message: "即将替换店铺设备!",
                    callback: function (result) {
                        if(result){
                            var v=$("input:radio:checked").val();
                            if(typeof(v)=="undefined"){
                                // dialog.modal('hide')
                                bootbox.alert("没有选中任何设备");
                            }else{
                                $.ajax({
                                    type:"post",
                                    data:{"shopid":"{{$shopid}}" , "deviceid":v},
                                    dataType:"json",
                                    url:"{{route('manage_shop_bind_shake_post')}}",
                                    success:function(s){
                                    }
                                });
                            }
                        }
                    }
                });
            });
        });


    </script>
@endsection

@section('content')
<form class="" action="" method="post" id="bind-form">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}  </span>
                    </div>
                    <div class="actions">
                        <button type="button" class="btn blue btn-outline tap-save"><i class="fa fa-save"></i> 保存</button>
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
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$v->comment}}</td>
                                <td><span class="label label-info tap-uuid" data-deviceid="{{$v->device_id}}" data-uuid="{{$v->uuid}}" data-major="{{$v->major}}" data-minor="{{$v->minor}}">{{$v->device_id}}</span></td>
                                <td>
                                    <a href="{{route('manage_shake_shakepage',['flag'=>'view' , 'deviceid'=>$v->device_id])}}" target="_blank" class="btn blue-chambray btn-xs">{{$nums[$v->device_id] or 0}}</a>
                                </td>
                                <td>
                                    <div class="md-radio has-error">
                                        <input type="radio" id="radio{{$v->id}}" name="radio1" class="md-radiobtn" value="{{$v->device_id}}">
                                        <label for="radio{{$v->id}}">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
                                    </div>
                                    <!-- <div class="md-checkbox has-error">
                                        <input type="checkbox" value="{{$v->id}}" id="news-c{{$v->id}}"@if($v->streetid==$streetid) checked @endif class="md-check tap-shake" @if($v->shopid>0) disabled @endif>
                                        <label for="news-c{{$v->id}}">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                        </label>
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
</form>
@endsection
