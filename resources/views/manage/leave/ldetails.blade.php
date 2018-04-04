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
                        <span class="caption-subject bold uppercase">
                        @if(!isset($stoer))
                            申请请假/外勤
                        @else
                            查看详情
                        @endif
                    </span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_leave_addldetails')}}">

                    <p class="form_p">
                        <span class="userk">姓名：</span><input type="text" value="{{$info['nickname'] or ''}}" disabled='disabled'>
                    </p>
                    <p class="form_p">
                        <span class="userk">类型：</span>
                          <select name='start[type]' class="job" required="required">
                            <option value='1' @if(isset($stoer) && $stoer['type'] == '1') selected='selected' @endif >请假</option>
                            <option value='2' @if(isset($stoer) && $stoer['type'] == '2') selected='selected' @endif >外勤</option>
                          </select>
                    </p>
                    <p class="form_p">
                        <span class="userk">请假时间：</span>
                        <input type="datetime-local" name="start[kstime]" value="{{$stoer['kstime'] or ''}}" required="required"> 
                        至
                        <input type="datetime-local" name="start[jstime]" value="{{$stoer['jstime'] or ''}}" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">请假原因：</span>
                        <textarea name="start[progress]" placeholder="请假原因" class="textarea" required="required">{{$stoer['progress'] or ''}}</textarea>
                    </p>

                    @if(!isset($stoer))
                    <p class="submit_p"><input type="submit" value="确认" class="submit"></p>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
