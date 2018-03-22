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
        .textarea{width: 300px;height: 100px;}

        .form_d{width: 100%;margin-top: 10px;border-left: 1px solid #999}
        .form_d_1{display: inline-block;width: 45%;}
        .form_d_2{display: inline-block;width: 50%;vertical-align: top;}
        .form_p input{width: 300px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_p textarea{width: 50%;}
        .genjin{margin-top: 30px;}

    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <!-- <span class="caption-subject bold uppercase">备忘录事件</span> -->
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="#">
                    <input type="hidden" name="id" value="{{$start['id'] or ''}}">

                    <p class="form_p">
                        <span class="userk">姓名：</span><input type="text" name="start[name]" value="{{$start['name'] or ''}}" placeholder="姓名" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">职位：</span>
                          <select name= 'job' class="job">
                            <option  value='总经理'  name ="generalmanager">总经理</option>
                            <option  value='销售主管'    name ="salesmanager">销售主管</option>
                            <option  value='销售'  name="minister">销售</option>
                            <option  value='客服主管' name="production">客服主管</option>
                            <option  value='客服' name="quality">客服</option>
                            <option  value='财务' name="workshop">财务</option>
                          </select>
                    </p>
                    <p class="form_p">
                        <span class="userk">类型：</span><input type="text" name="start[remarks]" value="{{$start['remarks'] or ''}}" placeholder="类型">
                    </p>
                    <p class="form_p">
                        <span class="userk">时间：</span>
                        <input type="date" name="start[jstime]" value="{{$start['jstime'] or ''}}" required="required"> 
                        至
                        <input type="date" name="start[jstime]" value="{{$start['jstime'] or ''}}" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">原因：</span>
                        <textarea name="start[content]" placeholder="原因" class="textarea" required="required">{{$start['content'] or ''}}</textarea>
                    </p>

                    <p class="submit_p"><input type="submit" value="确认" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
