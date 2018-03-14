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
        .submit{width: 300px;
                height: 30px;
                background: #3598dc;
                color: #fff;
                border: none;
                border-radius: 1px;
                margin-top: 20px;}
        .job{width: 300px;height: 35px;border-radius: 5px;}
        .userk{text-align: right;width: 150px;display: inline-block;}
        .textarea{width: 300px;height: 100px;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        @if(isset($start))
                            <span class="caption-subject bold uppercase">修改客户资料</span>
                        @else
                            <span class="caption-subject bold uppercase">录入客户</span>
                        @endif
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    
                    @if(isset($start))
                        <form method="post" action="{{route('manage_customer_khaddpost')}}">
                        <input type="hidden" name="form_type" value="form_type">
                        <input type="hidden" name="start[id]" value="{{$start['id'] or ''}}">
                    @else
                        <form method="post" action="{{route('manage_customer_khaddpost')}}">
                    @endif

                    <p class="form_p">
                        <span class="userk">客户姓名：</span><input type="text" name="start[name]" value="{{$start['name'] or ''}}" placeholder="客户姓名" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">联系方式：</span><input type="text" name="start[info]" value="{{$start['info'] or ''}}" placeholder="电话或邮箱等其他" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">客户需求：</span>
                        <textarea name="start[demand]" placeholder="输入客户需求" class="textarea">{{$start['demand'] or ''}}</textarea>
                    </p>
                    <p class="form_p">
                        <span class="userk">报价(单位:元)：</span><input type="number" name="start[offer]" value="{{$start['offer'] or ''}}" placeholder="输入金额" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">备注：</span><input type="text" name="start[remarks]" value="{{$start['remarks'] or ''}}">
                    </p>
                    <p class="form_p">
                      <span class="userk">客户评级(单位:星)：</span><select name='start[grade]' class="job">
                        <option  value='1' @if(isset($start)) @if($start['grade']==1) selected="selected" @endif @else selected="selected"  @endif >1</option>
                        <option  value='2' @if(isset($start) && $start['grade']==2) selected="selected"  @endif >2</option>
                        <option  value='3' @if(isset($start) && $start['grade']==3) selected="selected"  @endif >3</option>
                        <option  value='4' @if(isset($start) && $start['grade']==4) selected="selected"  @endif >4</option>
                        <option  value='5' @if(isset($start) && $start['grade']==5) selected="selected"  @endif >5</option>
                      </select>
                    </p>
                    <p class="form_p">
                      <span class="userk">客户状态：</span><select name='start[status]' class="job">
                        <option  value='1' @if(isset($start)) @if($start['status']==1) selected="selected" @endif @else selected="selected"  @endif >正常</option>
                        <option  value='0' @if(isset($start)) @if($start['status']==0) selected="selected" @endif @endif >放弃</option>
                      </select>
                    </p>

                    @if(isset($start))
                        <p class="form_p">
                            <span class="userk">客户跟进信息：</span>
                            <textarea name="start[progress]" placeholder="添加客户跟进信息" class="textarea">{{$start['progress'] or ''}}</textarea>
                        </p>
                    @endif
                    

                    <p><input type="submit" value="确认添加" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
