@extends('manage.common.master')

@section('usercss')
<style media="screen">
    .k_img_image{height: 120px;}
</style>
@endsection
@section('userjs')
<script>
@include('manage.common.js_keupload')
$(function(){

});
</script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase">互动街商街</span>
                </div>
            </div>
            <div class="portlet-body">
                @if(isset($edits))
                <form action="{{route('manage_street_edit_post')}}" method="post" class="form-horizontal">
                    <input type="hidden" name="street[id]" value="{{$edits->id}}">
                @else
                <form action="{{route('manage_street_add_post')}}" method="post" class="form-horizontal">
                @endif

                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">商街名</label>
                            <div class="col-md-6">
                                <input type="text" name="street[name]" value="{{$edits->name or ''}}" class="form-control" placeholder="" maxlength="10">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">商街描述</label>
                            <div class="col-md-6">
                                <input type="text" name="street[desc]" value="{{$edits->desc or ''}}" class="form-control" placeholder="" maxlength="30">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">商街类型</label>
                            <div class="col-md-3">
                                <select class="form-control" name="street[type]">
                                @foreach($types as $k => $v)
                                <option value="{{$k}}" @if(isset($edits) && $edits->type == $k) selected @endif>{{$v}}</option>
                                @endforeach
                                </select>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input ">
                            <label class="col-md-2 control-label">商街地址</label>
                            <div class="col-md-3">
                                <input type="text" name="street[province]" value="{{$edits->province or ''}}" class="form-control" placeholder="" maxlength="30">
                                <div class="form-control-focus"> </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="street[city]" value="{{$edits->city or ''}}" class="form-control" placeholder="" maxlength="30">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>


                        <!-- <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="form_control_1">页面LOGO</label>
                            <div class="col-md-2"><a href="javascript:;" id="k_img" class="btn btn-success">选择图片</a></div>
                            <div class="col-md-6"><a href="{{$edits->icon_url or ''}}" id="k_img_a" target="_blank"><img src="{{$edits->icon_url or ''}}" id="k_img_image" class="k_img_image"></a></div>
                            <input type="hidden" name="street[icon_url]" id="k_img_hidden" value="{{$edits->icon_url or ''}}">
                        </div> -->
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <input type="submit" class="btn blue" value="保存">
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>


</div>
@endsection
