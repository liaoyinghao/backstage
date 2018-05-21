@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){
            $(function(){
                $("#tianjiai").on("click",function(){
                    var count = $("#paiddepositcount").val();
                    var div = '<div class="form_p form_divi"><span class="userk">已付定金：</span><input type="number" name="start[paiddeposit]['+count+']" step="0.01" value="" placeholder="输入金额" required="required"></div>';
                    $("#form_tj").append(div);
                    hang = parseInt(count) + 1;
                    $("#paiddepositcount").val(hang);
                })
            })
        });
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
        .textarea{width: 300px;height: 80px;vertical-align:top}

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
                        <span class="caption-subject bold uppercase">添加定金</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_project_addprojectpost')}}">
                    <input type="hidden" name="id" value="{{$start['id'] or ''}}">
                    <input type="hidden" name="start[status]" value="1">
                    <input type="hidden" name="type" value="dingjin">

                    <p class="form_p">
                        <span class="userk">项目名称：</span><input type="text" name="start[proname]" value="{{$start['proname'] or ''}}" placeholder="项目名称" required="required" readonly unselectable="on">
                    </p>

                    <p class="form_p form_tj">

                            <span id="tianjiai">+</span>
                            <input type="hidden" id="paiddepositcount" value="{{$start['paiddepositcount'] or 0}}" />
                           @if(!empty($start['paiddeposit']))
                                @foreach($start['paiddeposit'] as $key=>$val)
                                    <div class="form_p form_divi"><span class="userk">已付定金：</span><input type="number" name="start[paiddeposit][{{$key}}]" step="0.01" value="{{$val or 0}}" placeholder="输入金额" required="required" readonly unselectable="on"></div>
                                @endforeach
                           @else
                                <div class="form_p form_divi"><span class="userk">已付定金：</span><input type="number" name="start[paiddeposit][0]" step="0.01" value="0" placeholder="输入金额" required="required"></div>
                           @endif

                    </p>
                    <p class="form_p" id="form_tj"></p>

                    <p class="submit_p"><input type="submit" value="确认" class="submit"></p>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
