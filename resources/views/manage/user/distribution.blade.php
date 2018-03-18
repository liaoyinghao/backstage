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
        .job{width: 300px;height: 35px;border-radius: 5px;}
        .userk{text-align: right;width: 100px;display: inline-block;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 修改分配人员</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="post" action="{{route('manage_user_distributionpost')}}">

                        <p class="form_p">
                          <span class="userk">所属主管：</span><select name='zhuguan' value="" class="job">

                            @if(isset($xsstore))
                                @foreach($xsstore as $val)
                                    <option  value='{{$val->id}}'>{{$val->nickname}}</option>
                                @endforeach
                            @else
                                    <option  value='{{$user->id}}'>{{$user->nickname}}</option>
                            @endif
                            
                          </select>
                        </p>

                        <p class="form_p">
                          <span class="userk">选择销售：</span><select name='xiaoshou' value="" class="job">
                            
                            @if(isset($xsinfo))
                                @foreach($xsinfo as $val)
                                    <option  value='{{$val->id}}'>{{$val->nickname}}</option>
                                @endforeach
                            @else
                                    <option  value='{{$user->id}}'>{{$user->nickname}}</option>
                            @endif

                          </select>
                        </p>

                    <p><input type="submit" value="确认修改" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
