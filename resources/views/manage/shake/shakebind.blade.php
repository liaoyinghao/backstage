@extends('manage.common.master')

@section('usercss')
<style media="screen">
    table td{vertical-align: middle!important;}
</style>
@endsection
@section('userjs')
<script src="/plugins/h5/js/ajaxsubmit.js" charset="utf-8"></script>
    <script>
        $(function(){
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 5, "desc" ]
                ]
            });


            $("#bind-form").submit(function(){
                mLoading();
                $("#bind-form").ajaxSubmit({
                    type:"post",
                    url:"{{route('manage_shake_bind_post')}}",
                    data:$(this).serialize(),
                    dataType:"json",
                    success:function(d){
                        if(d==1){
                            alert("绑定成功!");
                        }else{
                            alert("绑定失败!");
                        }

                        $(".bootbox").modal("hide");
                    }
                });
                return false;

            });

            $("table").on("click",".prev",function(){
                var u=$(this).attr("data-src");
                var h='<div class="text-center"><p>'+u+'</p><p><img src="http://pan.baidu.com/share/qrcode?w=300&h=300&url='+u.replace(/&/g,"%26")+'"></p></div>';
                bootbox.alert(h);
            });

        });


    </script>
@endsection

@section('content')
<form class="" action="{{route('manage_shake_bind_post')}}" method="post" id="bind-form">
    <input type="hidden" name="deviceid" value="{{$deviceid}}">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}} - {{$deviceid}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{route('manage_shake_shakepage_add',['flag'=>'shake','deviceid'=>$deviceid])}}" class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加并绑定设备</a>

                        <button type="submit" class="btn blue btn-outline tap-save"><i class="fa fa-save"></i> 保存</button>
                        <button class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</button>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>page_id</th>
                            <th>LOGO</th>
                            <th>标题</th>
                            <th>备注</th>
                            <th>绑定</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->page_id}}</td>
                            <td><img src="{{$v->icon_url}}" style="height:40px"></td>
                            <td>{{$v->title}}</td>
                            <td>{{$v->comment}}</td>
                            <td>
                                <span class="hidden">@if(isset($pagesid[$v->page_id])) 1 @endif</span>
                                <div class="md-checkbox has-error">
                                    <input type="checkbox" name="pages[{{$v->page_id}}]" id="news-c{{$v->id}}"@if(isset($pagesid[$v->page_id])) checked @endif class="md-check">
                                    <label for="news-c{{$v->id}}">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
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
</form>
@endsection
