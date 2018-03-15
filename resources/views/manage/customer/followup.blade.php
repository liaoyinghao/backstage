@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $("#tianjia").on("click",function(){
                var div = ' <div class="form_d">'+
                                '<div class="form_d_1">'+
                                    '<span class="userk">选择时间：</span><input type="date" name="time">'+
                                '</div>'+
                                '<div class="form_d_2">'+
                                    '<textarea name=""></textarea>'+
                                '</div>'+
                            '</div>';
                $("#formkh").append(div);
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
        .textarea{width: 300px;height: 100px;}

        .form_d{width: 100%;margin-top: 10px;border-left: 1px solid #999}
        .form_d_1{display: inline-block;width: 45%;}
        .form_d_2{display: inline-block;width: 50%;vertical-align: top;}
        .form_d_1>input{width: 200px;height: 35px;border-radius: 5px;border: 1px solid #999;}
        .form_d_2>textarea{width: 90%;}

    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">修改客户跟进信息</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline" id="tianjia">添加客户跟进信息</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_customer_khaddpost')}}">
                    <input type="hidden" name="id" value="{{$info['id'] or ''}}">

                    <div id="formkh">

                        <div class="form_d">
                            <div class="form_d_1">
                                <span class="userk">选择时间：</span><input type="date" name="stoer[time1]">
                            </div>
                            <div class="form_d_2">
                                <textarea  name=""></textarea>
                            </div>
                        </div>  

                    </div>  
                                      

                    
                    
                    <p class="submit_p"><input type="submit" value="确认跟进" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
