@extends('h5.common.master_weui')
@section('usercss')
<style media="screen">
.not_wx{background: #fff}
#nickname_p{color: red;text-align: right;padding-right: 5px;font-size: 12px}
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
                var h='<li class="weui-uploader__file weui-uploader__file_status" style="background-image:url(/'+d+')"><div class="weui-uploader__file-content weui-x-remove">x</div><input type="hidden" name="store[avatar]" value="/'+d+'" id="avatars"></li>';
                $("#logo-uls").append(h);
                $.toast("上传成功",1000);
            }
        });
    });

    $("#realnames").blur(function(){
        var nickname = $("#realnames").val();
        var title = "{{$title}}";
        $.ajax({
            type:"post",
            data:{"nickname":nickname},
            dataType:"json",
            url:"{{route('h5_store_execregistername')}}",
            success:function(d){
                if(d == 1){
                    if(nickname != ''){
                        $("#realnames").css('color','red');
                        $("#nickname_p").html(title+"名称重复");
                    }
                }else{
                    $("#realnames").css('color','#000');
                    $("#nickname_p").html("");
                }
            }
        });
    })


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

        var RegExps = /^((0\d{2,3}-\d{7,8})|(1[37584]\d{9}))$/;
        if(RegExps.test($("#tels").val()) ==false ){
            $.toast("请填写正确的手机号", "cancel");
            return false;
        }

        var pass = $("#pass").val();
        if(pass == ''){
            $.toptip("请填写登录密码" , "warning");
            return false;
        }

        var avatars = $("#avatars").val();
        if(!avatars){
            $.toptip("请上传个人头像");
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
    <h1 class="weui-msg__title">{{$title}}注册信息</h1>
</div>
@endif

@if(isset($yunying))
<!-- 如果是运营商注册的话 -->
<form action="{{route('h5_store_execregisterpost')}}" method="post" id="rform">
<input type="hidden" name="type" value="yunying">
@else
<!-- 如果是品牌商注册的话 -->
<form action="{{route('h5_store_execregisterpost')}}" method="post" id="rform">
<input type="hidden" name="type" value="pinpai">
@endif

<!-- <div class="weui-cells__title">店铺信息</div> -->
<div class="weui-cells weui-cells_form">

    <div class="weui-cell" id="weui_cell_realname">
        <div class="weui-cell__hd">
            <label class="weui-label">{{$title}}名称</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="store[nickname]" value="" placeholder="品牌商名称" id="realnames">
        </div>
        <p id="nickname_p"></p>
    </div>
    <div class="weui-cell" id="weui_cell_realname">
        <div class="weui-cell__hd">
            <label class="weui-label">联系人</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="store[name]" value="" placeholder="姓名">
        </div>
        <p id="nickname_p"></p>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">电话号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="store[phone]" value="" placeholder="手机号" id="tels">
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">登录密码</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="password" name="store[pas]" value="" placeholder="登录密码" id="pass">
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
                        <!-- <li class="weui-uploader__file weui-uploader__file_status" style="background-image:url({{$person->avatar or ''}})">
                            <div class="weui-uploader__file-content weui-x-remove">x</div>
                            <input type="hidden" name="store[avatar]" value="{{$person->avatar or ''}}">
                        </li> -->
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
