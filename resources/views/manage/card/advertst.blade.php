@extends('manage.common.master')
@section('usercss')
<style>
.midt{height: auto;background: #fff;margin-top: -8px;padding-left: 20px;box-shadow: 2px 2px 8px #ddd;padding-bottom: 20px}
.quan{cursor: pointer;}
.quans{background: #f2f6f9;color: color}
#fixedtime{display: none}
.voucher{display: none}
.vouchertuan{display: block;}

#settingstyles,#useentry,#covertitle{display: none}

#abs-lis,#logo-lis,#advert_logo-lis{width: 100px;height: 100px;list-style-type: none}
#abs-lis>img{width: 100%}
#logo-lis>img{width: 100%}
#advert_logo-lis>img{width: 100%}
.pull-rights>li>a{color: #fff}
#form-controls{color: #fff}
#abs,#logo{margin-top: 75px;}
.SetDate{width: 200px;height: 30px;border-radius: 5px;border: 1px solid #999;text-indent: 3px;margin-right: 10px;margin-top: 10px}
.ajax_submit{width: 250px}
</style>
@endsection
@section('userjs')
    <script>
    $(function(){


        $("#advert_logo").change(function(){
            var formData = new FormData();
            formData.append("file" , $(this)[0].files[0]);
            $.ajax({
                url: "{{route('manage_member_pic')}}",
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                success:function(d){

                    if(d==0){
                        $.toast("文件过大","cancel");
                        return false;
                    }
                    var h='<li id="advert_logo-lis"><img src="/'+d+'"></li>';
                    $("#advert_logo-uls").html(h);
                    $("#advert_logo_img").val('/'+d);
                }
            });
        });





        //ajax提交外部券
        $(".ajax_submit").on('click',function(){
            var advert_title = $("#advert_title").val();
            var advert_des = $("#advert_des").val();
            var advert_url = $("#advert_url").val();
            var advert_logo_img = $("#advert_logo_img").val();
            if(advert_title == '' ||advert_des == '' ||advert_url == '' ||advert_logo_img == ''){
                alert('请填写完整');
                return false;
            }

            $.ajax({
                url:"{{route('manage_card_cardaddpost')}}",
                type:"post",
                data:{"title":advert_title,"des":advert_des,"url":advert_url,"logo":advert_logo_img},
                dataType:"json",
                success:function(d){
                    if(d==1){
                        window.location.href="{{route('manage_card_advert')}}";
                    }else{
                        alert('添加失败，请刷新后再重试！');
                        return false;
                    }
                }
            })
        })

    })

    </script>
@endsection
@section('content')


<div class='midt col-md-11 col-xs-7'>
    <form id="card-add" enctype="multipart/form-data">
        <h3>制作卡券</h3>

        <!-- 外部券，广告位 -->
        <div class="form-footer">
            <div class="form-group form-md-line-input">
                <input type="text" class="form-control" name="advert[title]" id="advert_title" placeholder="9个字以内" maxlength="9">
                <label for="form_control_1">标题</label>
                <span class="help-block">9个字以内</span>
            </div>

            <div class="form-group form-md-line-input">
                <input type="text" class="form-control" id="advert_des" name="advert[des]" placeholder="18个字以内" maxlength="18">
                <label for="form_control_1">副标题</label>
                <span class="help-block">18个字以内</span>
            </div>

            <div class="form-group form-md-line-input">
                <input type="text" class="form-control" id="advert_url" name="advert[url]">
                <label for="form_control_1">url连接地址</label>
                <span class="help-block">点击进入的链接地址</span>
            </div>

            <div>
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__hd">
                                <p class="weui-uploader__title">卡券LOGO</p>
                            </div>
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files" id="advert_logo-uls">
                                    <li id="advert_logo-lis">
                                        <img src="/img/hdj.png">
                                    </li>
                                </ul>
                                <input type="hidden" name="advert[logo]" value="/img/hdj.png" id="advert_logo_img">
                                <div class="weui-uploader__input-box" style="margin: 60px 0 0 30px;">
                                    <input id="advert_logo" class="weui-uploader__input" type="file">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><br><br>
            </div>

        <div class="form_ajax">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn green submit_form ajax_submit">确 认 提 交</div>
                </div>
            </div>
        </div>


        </div>


    </form>
</div>
<script src="/assets/global/scripts/date.js" type="text/javascript"></script>

@endsection
