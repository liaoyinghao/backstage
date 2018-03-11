@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });
        });


    </script>
@endsection

@section('content')
    <style type="text/css">
        .portlet-body{text-align: center;padding: 20px 0 20px 0}
        .form_p input{  width: 300px;
                        height: 35px;
                        border-radius: 5px;
                        border: 1px solid #999;
                        text-indent: 10px;
                        margin-left: 5px;}
        .submit{width: 150px;
                height: 30px;
                background: #3598dc;
                color: #fff;
                border: none;
                border-radius: 5px;}
    </style>
    
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 注册新用户</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="post" action="">

                    <p class="form_p">
                        用户名：<input type="text" name="name" value="" placeholder="输入用户名">
                    </p>

                    <p><input type="submit" value="确认注册" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
