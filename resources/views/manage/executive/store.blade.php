@extends('manage.common.master')
@section('usercss')
<style media="screen">
    .md200{width: 200px;}
</style>
@endsection
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });
        });

        $(".checkbox_box").click(function(){
            var $isChecked = $(this).is(":checked");
                if($isChecked){
                    $(this).parent().parent(".md-checkbox").next(".checkbox_qwe").find(".md-checkbox").find(".checkbox_input").prop("checked", true);
                }else{
                    $(this).parent().parent(".md-checkbox").next(".checkbox_qwe").find(".md-checkbox").find(".checkbox_input").prop("checked", false);
                }
        })
    </script>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">店铺权限列表</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>

                <div class="portlet-body">
                    <form method='post' action="{{route('manage_executive_storeauthority')}}">
                    @foreach($streets as $st)
                    <div class="form-group form-md-checkboxes">
                            @if($st->num != 0)
                            <div class="md-checkbox  md200">
                                <div class="md-checkbox-inline">
                                    <input type="checkbox" id="{{$st->id}}" name= 'parent' class="md-check checkbox_box"><label for="{{$st->id}}">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>{{$st->name}}</label>
                                    </div>
                                </div>
                            @endif
                        <div class="md-checkbox-inline checkbox_qwe">
                            @foreach($shops as $sp)
                            @if($st->id == $sp->streetid)
                                <div class="md-checkbox has-info md200">
                                <input type="checkbox" id="cb{{$sp->id}}" name="name[]" value="{{$sp->id}}" class="md-check checkbox_input"
                                @if(in_array($sp->id,$num ))
                                checked="checked"
                                @endif
                                >
                                <label for="cb{{$sp->id}}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{$sp->name}} </label>
                            </div>
                            @endif
                            @endforeach
                        </div>

                    </div>
                    @endforeach

                    <p>选中店铺，可赋予该品牌商查看该店铺的权限</p>
                    <input type='hidden' name='id' value="{{$id}}">
                    <input type = "hidden" name="oldcheckedName" value = "{{$shopauthority}}">
                    <input type='submit'class='btn btn-info'  value='确定'>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
