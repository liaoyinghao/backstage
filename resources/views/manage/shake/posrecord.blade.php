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

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <button class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</button>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>店铺名称</th>
                            <th>设备编号</th>
                            <th>登录时间</th>
                            <th>登出时间</th>
                            <th>登录地点</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $v)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$shop[$v->shopid]}}</td>
                                <td>{{$v->possn}}</td>
                                <td>{{date("Y-m-d H:i:s",$v->logintime)}}</td>
                                @if($v->logouttime)
                                <td>{{date("Y-m-d H:i:s",$v->logouttime)}}</td>
                                @else
                                <td></td>
                                @endif
                                <td>{{$v->addr}}</td>
                                <td>{{date("Y-m-d H:i:s",$v->time)}}</td>
                                <td>@if(!$v->logouttime)<a href="{{route('manage_shake_posout',['id'=>$v->id])}}">退出</a>@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
