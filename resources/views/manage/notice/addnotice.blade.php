@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });
            $(".submit").on("click",function(){
                var obj = $("input[name=jsid]");
                jsid = [];
                for(k in obj){
                    if(obj[k].checked)
                        jsid.push(obj[k].value);
                }
                if(jsid=='' || jsid==undefined){
                    alert("您还为选择接收者人员！");
                    return false;
                }
                jsid = jsid.toString();

                var title = $("#title").val();
                if(title=='' || title==undefined){
                    alert("请填写通知标题！");
                    return false;
                }
                var progress = $("#progress").val();
                if(progress=='' || progress==undefined){
                    alert("请填写通知内容！");
                    return false;
                }

                alert(jsid);
                alert(title);
                alert(progress);
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
        .form_p>input{width: 200px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_d_2>textarea{width: 90%;}
        .genjin{margin-top: 30px;}
        .xuanz{width: 80%;margin-left: 15%; line-height: 30px;}
        .xuanz input{width: 20px;height: 20px;vertical-align: middle;margin: -5px 2px 0px 20px;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">通知</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <input type="hidden" name="id" value="{{$start['id'] or ''}}">

                    <p class="form_p">
                        <span class="userk">接收人：</span>
                        <div class="xuanz">
                            @if(isset($user))
                                @foreach($user as $val)
                                @if(!empty($val))
                                    <input type="checkbox" name="jsid" value="{{$val['id']}}"/>{{$val['nickname']}}
                                @endif
                                @endforeach
                            @else
                                无选择人员...
                            @endif
                        </div>
                    </p>

                    <p class="form_p">
                        <span class="userk">通知标题：</span><input type="text" id="title" value="{{$start['title'] or ''}}" placeholder="通知标题">
                    </p>
                    <p class="form_p">
                        <span class="userk">通知内容：</span>
                        <textarea id="progress" placeholder="通知内容" class="textarea">{{$start['progress'] or ''}}</textarea>
                    </p>

                    <p class="submit_p"><input type="submit" value="确认发送通知" class="submit"></p>

                </div>
            </div>
        </div>
    </div>

@endsection
