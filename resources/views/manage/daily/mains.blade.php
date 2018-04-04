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
.neirong{max-width: 333px;max-height: 38px;display: block;overflow: hidden;}
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline" href="{{route('manage_daily_adddaily')}}"><i class="fa fa-plus"></i> 添加日报</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th>职位</th>
                            <th>日报数量</th>
                            <th>查看详情</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($lists))
                            @foreach($lists as $v)
                            <tr>
                                <td width="50px">{{$v->id}}</td>
                                <td>{{$v->username}}</td>
                                <td>{{$v->nickname}}</td>
                                <td>{{$v->position}}</td>
                                <td>{{$v->count}}</td>
                                <td>
                                    <button type="button" class="btn blue btn-xs">
                                        <a href="{{route('manage_daily_main',['uid'=>$v->id])}}" class="pfp">查看详情</a>
                                  </button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
