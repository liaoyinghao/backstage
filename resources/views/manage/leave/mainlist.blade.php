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
li{list-style-type: none;}
.pfp{color:#fff;text-decoration:none}
.neirong{max-width: 300px;max-height: 38px;display: block;overflow: hidden;}
.leixingbg{background: #b2fcc7}
.leixingbgs{background: #b5b2fc}
.leixingbgst{background: #f6fcb2}
.inputs{width: 200px;height: 35px;border-radius: 5px;border: 1px solid #999;margin-right: 10px;}
.buttons{width: 90px;height: 35px;background: deepskyblue;border-radius: 5px;border: none;box-shadow: 2px 2px 8px #999;color: #fff}
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div>
                    <form method="post" action="{{route('manage_leave_mainlist')}}">
                        选择时间查询数据：
                        <input type="date" name="kstime" value="" class="inputs">
                        <input type="date" name="jstime" value="" class="inputs">
                        <button class="buttons">查 询</button>
                    </form>
                </div><br>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>姓名</th>
                            <th>职位</th>
                            <th>类型</th>
                            <th width="170px">时间</th>
                            <th>原因</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($list))
                            @foreach($list as $val)
                            @if(!empty($val))
                                <tr>
                                    <td>{{$val['id'] or ''}}</td>
                                    <td>{{$val['nickname'] or ''}}</td>
                                    <td>{{$val['position'] or ''}}</td>
                                    <td>
                                        @if($val['type'] == 1) 
                                         <button class="btn btn-xs leixingbg">请假</button>
                                        @else
                                         <button class="btn btn-xs leixingbgs">外勤</button>
                                        @endif
                                    </td>
                                    <td>{{$val['kstime'] or ''}} 至 {{$val['jstime'] or ''}}</td>
                                    <td><span class="neirong">{{$val['progress'] or ''}}</span></td>
                                    <td>
                                        @if($val['status'] == 1)
                                        <button class="btn btn-danger btn-xs">申请中</button>
                                        @elseif($val['status'] == 2)
                                        <button class="btn success btn-xs">已允许</button>
                                        @else
                                        <button class="btn btn-xs leixingbgst">被拒绝</button>
                                        @endif
                                    </td>
                                    <td>
                                       <div class="btn-group">
                                          <button type="button" class="btn blue btn-xs">
                                                <a href="{{route('manage_leave_ldetails',['id'=>$val['id']])}}" class="pfp">查看</a>
                                          </button>
                                      </div>
                                    </td>
                                </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
