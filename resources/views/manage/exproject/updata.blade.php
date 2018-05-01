@extends('manage.common.master')
@section('userjs')
    <script>
    </script>
@endsection

@section('content')
    <style type="text/css">
        .submit_p{width: 100%;text-align: center;margin-top: 50px !important;}
        .submit{width: 300px;
                height: 30px;
                background: #3598dc;
                color: #fff;
                border: none;
                border-radius: 1px;
                margin-top: 20px;
                }
        .job{width: 300px;height: 35px;border-radius: 5px;}
        .userk{text-align: right;width: 150px;display: inline-block;}
        .textarea{width: 500px;height: 250px;vertical-align:top}

        .form_d{width: 100%;margin-top: 10px;border-left: 1px solid #999}
        .form_d_1{display: inline-block;width: 45%;}
        .form_d_2{display: inline-block;width: 50%;vertical-align: top;}
        .form_p>input{width: 250px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_divi{margin-top: 20px;}
        .form_d_2>textarea{width: 90%;}
        .genjin{margin-top: 30px;}
        .form_tj{position: relative;}
        #tianjiai{  top: 3px;
                    left: 420px;
                    cursor: pointer;
                    display: inline-block;
                    width: 25px;
                    height: 25px;
                    background: #ccc;
                    font-size: 20px;
                    text-align: center;
                    line-height: 25px;
                    position: absolute;
                    color: #fff;
                    z-index: 5;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">修改低价表</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_exproject_updataprojectpost')}}">
                    <input type="hidden" name="id" value="{{$detail['exproject_id'] or ''}}">
                    <p class="form_p">
                        <span class="userk">名称：</span><input type="text" name="start[proname]" value="{{$detail['proname'] or ''}}" placeholder="名称">
                    </p>
                    <p class="form_p">
                        <span class="userk">所需材料：</span>
                        <textarea name="start[material]" placeholder="所需材料" class="textarea" style = "">{{$detail['material'] or ''}}</textarea>
                    </p>
                    <p class="form_p">
                        <span class="userk">底价金额：</span><input type="number" name="start[price]" step="0.01" value="{{$detail['price'] or ''}}" placeholder="输入金额" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">要求：</span>
                        <textarea name="start[demand]" placeholder="要求" class="textarea">{{$detail['demand'] or ''}}</textarea>
                    </p>
                    <p class="form_p">
                        <span class="userk">备注：</span>
                        <textarea name="start[remark]" placeholder="备注" class="textarea">{{$detail['remark'] or ''}}</textarea>
                    </p>
                    <p class="submit_p"><input type="submit" value="确认" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
