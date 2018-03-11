<!DOCTYPE html>
<!--[if IE 8]> <html lang="zh-cn" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="zh-cn" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zh-cn">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>后台管理系统</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="后台管理系统" name="description" />
        <meta content="后台管理系统" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="/assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="/plugins/manage/img/logo_icon.png" /> </head>
    <!-- END HEAD -->

    <style type="text/css">
        .zhuce,.denglu,.denglu_yzm{width: 100%;height: 100%;background:rgba(0,0,0,0.5);border: 1px solid #999;position: absolute;top: 0;left: 0;text-align: center;overflow: hidden;display: none}
        .guanbi_icon,.guanbi_icon2,.guanbi_icon3{position: absolute;right: 1px;top: 1px;cursor: pointer;z-index: 100}
        #zhuce_img{margin-top: -400px}
        .saoyisao{font-size: 30px;color: #fff;}
        .user_k,.yzm_k{color: #666 !important;margin-top: -6px !important;cursor: pointer;}
        .user_k{margin-right: 40px}
        .usek{width: 500px;height: 300px;background: #fff;margin: 150px auto;text-align: center;margin-top: -400px}
        .rows>div{margin: 0 90px}
        .alert{position: absolute;width: 500px;top: 180px}
        .login{overflow: hidden;}
        #yzm_pwd{width: 100px;display: inline-block;margin-right: 20px;}
        .hqyzm{background: #FFA500;line-height: 35px;border-radius: 2px;text-align: center;display: inline-block;color: #fff;width: 115px;cursor: pointer;}
        #yzm_name{display: inline-block;width: 235px}
        #denglus{width: 120px;}
        .form>.row{margin-top: 50px;}
        .form>.row input{border: none;border-bottom: 1px solid #999;}
    </style>

    <body class="login">
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 login-container bs-reset">
                    <div class="login-content text-center">
                        <h1> 登 录 </h1>
                        <div class="form">
                            {{ csrf_field() }}
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>请输入用户名密码</span>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" placeholder="用户名" id="username"/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" placeholder="密码" id="password"/> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10 text-right">
                                    <span class="btn blue" id="denglus">登录</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bs-reset">
                    <div class="login-bg"> </div>
                </div>
            </div>
        </div>

        <!-- BEGIN CORE PLUGINS -->
        <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="/assets/pages/scripts/login-52.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script type="text/javascript">
            $(function(){
                //账号登录ajax
                $("#denglus").on('click',function(){
                    var username = $("#username").val();
                    var password = $("#password").val();

                    if(username == ''){
                        $(".alert_span").html("账号不能为空！");
                        $(".alert").css("display","block");
                        return false;
                    }
                    if(password == ''){
                        $(".alert_span").html("密码不能为空！");
                        $(".alert").css("display","block");
                        return false;
                    }
                    $("#denglus").html("登录中...");

                    $.ajax({
                        url:"{{route('manage_loginpost')}}",
                        type:"post",
                        data:{"username":username,"password":password},
                        dataType:"json",
                        success:function(d){
                            if(d==1){
                                $("#denglus").html("登录成功");
                                location.href="{{route('manage_street_main')}}";
                            }else{
                                $("#denglus").html("登录");
                                $(".alert").css("display","block");
                                $(".alert_span").html("密码或账号错误，请重新输入！");
                            }
                        }
                    })
                })
            });
        </script>
    </body>

</html>
