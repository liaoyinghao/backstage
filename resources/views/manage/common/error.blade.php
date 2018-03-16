@extends('manage.common.master')

@section('usercss')
@endsection

@section('userjs')

@endsection

@section('title')
    {{$msg or '出现了些错误'}}
@endsection

@section('content')
<style type="text/css">
    .page-content{margin: 0;padding: 0;background: #fff url("/assets/global/img/errorbg.jpg") no-repeat;overflow: hidden;position: relative;}
    .weui-msg__title{position: absolute;top: 270px;left: 281px;font-size: 26px;font-weight: bold;color: #66b98d;}
</style>
<div class="weui-msg">
    <div class="weui-msg__icon-area">
        <i class="weui-icon-warn weui-icon_msg"></i>
    </div>
    <div class="weui-msg__text-area">
        <h2 class="weui-msg__title">{{$msg or '出现了些错误'}}</h2>
    </div>
    <div class="weui-msg__opr-area">
        <p class="weui-btn-area">
            <a href="javascript:window.history.go(-1);" class="weui-btn weui-btn_primary">返回上一层</a>
        </p>
    </div>
</div>
@endsection
