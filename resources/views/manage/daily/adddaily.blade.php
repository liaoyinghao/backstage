@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

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

        .form_d{width: 100%;margin-top: 10px;border-left: 1px solid #999}
        .form_d_1{display: inline-block;width: 45%;}
        .form_d_2{display: inline-block;width: 50%;vertical-align: top;}
        .form_p input{width: 300px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_p textarea{width: 300px;height: 150px;vertical-align: top;}
        .genjin{margin-top: 30px;}
        /*.portlet-body{text-align: center;}*/
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">添加日报</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_daily_rb')}}">

                    <p class="form_p">
                        <span class="userk">日报标题：</span><input type="text" name="title" value="" placeholder="日报标题" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">日报内容：</span>
                        <textarea name="progress" placeholder="日报内容"></textarea>
                    </p>
                    <input type='hidden' name='id' value='{{$id->id}}'>

                    <p class="submit_p"><input type="submit" value="确认发送" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
