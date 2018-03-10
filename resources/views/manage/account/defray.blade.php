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
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>品牌商</th>
                                <th>销售总额</th>
                                <th>佣金总支出</th>
                                <th>佣金已付</th>
                                <th>佣金未付</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->nickname}}</td>
                            <td>{{$v->xsze}}</td>
                            <td>{{$v->zong}}</td>
                            <td>{{$v->ysr}}</td>
                            <td>{{$v->zong - $v->ysr}}</td>
                            <th><a type="button" class="btn blue btn-xs" href="{{route('manage_account_detailed')}}?id={{$v->id}}">查看明细</a></th>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
