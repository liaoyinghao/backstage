<!DOCTYPE html>
<!--[if IE 8]> <html lang="zh-cn" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="zh-cn" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zh-cn">
<!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title>后台管理系统</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="后台管理系统" name="description" />
        <meta content="后台管理系统" name="author" />
        @include('manage.common.globalcss')
        @yield('usercss')
        <link rel="shortcut icon" href="/plugins/manage/img/logo_icon.png" /> </head>
        <link rel="stylesheet" href="//at.alicdn.com/t/font_456120_cmjsd3cmvxpyzaor.css">
        <link rel="stylesheet" href="//at.alicdn.com/t/font_456120_oqu5n95fdxlp7gb9.css">
        
    <body class="page-container-bg-solid page-sidebar-closed-hide-logo page-md @if(request()->cookie('manage_side')) page-sidebar-closed @endif">
        @include('manage.common.header')
        <div class="clearfix"> </div>
        <div class="page-container">
            @include('manage.common.leftmenu')
            <div class="page-content-wrapper">
                <div class="page-content">
                    @yield('content')
                </div>
            </div>
            @include('manage.common.rightmessage')
        </div>
        @include('manage.common.footer')
        @include('manage.common.globaljs')
        @yield('userjs')

    </body>
</html>
