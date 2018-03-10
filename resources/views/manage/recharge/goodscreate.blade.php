@extends('manage.common.master')

@section('usercss')

@endsection
@section('userjs')
<script>

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
                    <span class="caption-subject font-dark sbold uppercase">添加充值产品</span>
                </div>
            </div>
            <div class="portlet-body">
                @if(isset($edits))
                <form action="{{route('manage_recharge_goods.update',['id'=>$edits->id])}}" method="post" class="form-horizontal">
                    {{ method_field('PUT') }}
                @else
                <form action="{{route('manage_recharge_goods.store')}}" method="post" class="form-horizontal">
                @endif

                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">产品名</label>
                            <div class="col-md-4">
                                <input type="text" name="goods[title]" value="{{$edits->title or ''}}" class="form-control" placeholder="" maxlength="10">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">产品价格</label>
                            <div class="col-md-4">
                                <input type="number" name="goods[price]" value="{{$edits->price or ''}}" class="form-control" placeholder="" maxlength="30" step="0.1">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">核销数量</label>
                            <div class="col-md-4">
                                <input type="number" name="goods[num]" value="{{$edits->num or ''}}" class="form-control" placeholder="" maxlength="30">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">产品描述</label>
                            <div class="col-md-6">
                                <textarea name="goods[desc]" rows="3" class="form-control">{{$edits->desc or ''}}</textarea>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>


                        <!-- <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="form_control_1">页面LOGO</label>
                            <div class="col-md-2"><a href="javascript:;" id="k_img" class="btn btn-success">选择图片</a></div>
                            <div class="col-md-6"><a href="{{$edits->icon_url or ''}}" id="k_img_a" target="_blank"><img src="{{$edits->icon_url or ''}}" id="k_img_image" class="k_img_image"></a></div>
                            <input type="hidden" name="goods[icon_url]" id="k_img_hidden" value="{{$edits->icon_url or ''}}">
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
