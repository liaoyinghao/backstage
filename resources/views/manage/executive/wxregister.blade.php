@extends('h5.common.master_weui')
@section('usercss')
<style media="screen">
.not_wx{background: #fff}
</style>
@endsection

@section('userjs')
<script type="text/javascript" src="/plugins/h5/jquery-weui/city-picker.js" charset="utf-8"></script>
<script type="text/javascript" src="/plugins/h5/upload/mobileBUGFix.mini.js" charset="utf-8"></script>
<script type="text/javascript" src="/plugins/h5/upload/yxMobileSlider.js" charset="utf-8"></script>
<script type="text/javascript" src="/plugins/h5/upload/upload.js" charset="utf-8"></script>

<script type="text/javascript">

$(function(){
    h5PicRemove();//删除图片

    $("#logo").change(function(){
        if($("input[name='store[avatar]']").length>1){
            $.toast("只允许上传1张", "cancel");
            return false;
        }
        $.showLoading("图片上传中");
        var formData = new FormData();
        formData.append("file" , $(this)[0].files[0]);
        $.ajax({
            url: "{{route('h5_process_pic')}}",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success:function(d){
                $.hideLoading();
                if(d==0){
                    $.toast("文件过大","cancel");
                    return false;
                }
                var h='<li class="weui-uploader__file weui-uploader__file_status" style="background-image:url(/'+d+')"><div class="weui-uploader__file-content weui-x-remove">x</div><input type="hidden" name="store[avatar]" value="/'+d+'"></li>';
                $("#logo-uls").append(h);
                $.toast("上传成功",1000);
            }
        });
    });


    $("#rform").submit(function(){
        var l='';
        $("input[type='text']").each(function(){
            if($(this).val()==''){
                l=$(this).parent().prev().children(".weui-label").html();
                return false;
            }
        });
        if(l != ''){
            $.toptip("请填写"+l , "warning");
            return false;
        }

    });

});

</script>
@endsection

@section('title')
信息完善
@endsection

@section('content')

@if(!isset($person->sn))
<div class="weui-msg">
    <h1 class="weui-msg__title">信息完善</h1>
</div>
@endif

<form action="{{route('h5_store_wxregisterpost')}}" method="post" id="rform">
    <input type="hidden" name="id" value="{{$id}}">
<!-- <div class="weui-cells__title">店铺信息</div> -->
<div class="weui-cells weui-cells_form">

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">用户名</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="store[realname]" value="{{$person->realname or ''}}" placeholder="姓名">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="store[phone]" value="@if($person->phone >0){{$person->phone}}@endif" placeholder="手机号">
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__bd">
            <div class="weui-uploader">
                <div class="weui-uploader__hd">
                    <p class="weui-uploader__title">个人头像 </p>
                    <!-- <div class="weui-uploader__info" id="logo-info">0/1</div> -->
                </div>

                <div class="weui-uploader__bd">
                    <ul class="weui-uploader__files" id="logo-uls">
                        <li class="weui-uploader__file weui-uploader__file_status" style="background-image:url({{$person->avatar or ''}})">
                            <div class="weui-uploader__file-content weui-x-remove">x</div>
                            <input type="hidden" name="store[avatar]" value="{{$person->avatar or ''}}">
                        </li>
                    </ul>

                    <div class="weui-uploader__input-box">
                        <input id="logo" class="weui-uploader__input" type="file" accept="image/*">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="weui-btn-area">
    <button class="weui-btn weui-btn_primary" > 确 定 </button>
</div>

</form>


@include('h5.common.footer_weui')
@endsection
