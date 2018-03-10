@extends('manage.common.master')

@section('usercss')
<style media="screen">
    .k_img_image{height: 120px;}
    .md200{width: 200px;margin: 50px 0 -10px 65px;}
    .blue{width: 200px;}
</style>
@endsection
@section('userjs')
<script>
@include('manage.common.js_keupload')
$(function(){
    $("#cb1").on('click',function(){
        if($(this).is(':checked')) {
            $("#single").prop("disabled",false);
        }else{
            $("#single").prop("disabled","disabled");
        }
    })

    // $(".form-horizontal").submit(function(){
    //     if($("#cb1").is(':checked')) {
    //         var single = $("#single").val();
    //         if(single == ''){
    //             alert('品牌商不能为空，请选择！');
    //             return false;
    //         }
    //     }else{
    //         alert('未选择品牌商，不能提交！');
    //             return false;
    //     }
    // })
});
</script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase">添加二维码</span>
                </div>
            </div>
            <div class="portlet-body">

                <form action="{{route('manage_shake_shakepageformadd')}}" method="post" class="form-horizontal">

                    <div class="md-checkbox md200">
                        <input type="checkbox" id="cb1" name="store[is_exec]" value="1" class="md-check checkbox_input" checked="checked" >
                        <label for="cb1">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            是否选择品牌商
                        </label>
                    </div>
 

                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label">品牌商选择</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id="single" class="form-control select2" name="store[execid]">
                                        <option value="0">请选择...</option>
                                        @if(isset($exec))
                                        @if(!empty($exec[0]))
                                            @foreach($exec as $v)
                                                <option value="{{$v->id}}">{{$v->nickname}}</option>
                                            @endforeach
                                        @endif
                                        @endif
                                    </select>
                                </div>
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
