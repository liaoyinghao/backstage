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
                    <span class="caption-subject font-dark sbold uppercase">添加说明文字</span>
                </div>
            </div>
            <div class="portlet-body">
                <form action="{{route('manage_system_text_add_post')}}" method="post" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">标题</label>
                            <div class="col-md-4">
                                <input type="text" name="text[title]" value="" class="form-control" placeholder="" maxlength="10">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">key</label>
                            <div class="col-md-4">
                                <input type="text" name="text[key]" value="" class="form-control" placeholder="" maxlength="30">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">type</label>
                            <div class="col-md-4">
                                <input type="number" name="text[type]" value="1" class="form-control" placeholder="" maxlength="30">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">内容</label>
                            <div class="col-md-6">
                                <textarea name="text[content]" rows="3" class="form-control"> </textarea>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

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
