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
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}列表</span>
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
                                <th>品牌商名称</th>
                                <th>收入</th>
                                <th>类型</th>
                                <th>是否同意</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $v)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$v->name}}</td>
                                <td>{{$v->money}}</td>
                                <td>@if($v->type == 1) 收入 @else 支出 @endif</td>
                                <td>
                                @if($v->status == 0) 
                                    <span class="label btn-warning">未审核</span>
                                @elseif($v->status == 1) 
                                    <span class="label label-success"> 通 过 </span>
                                @else 
                                    <span class="label label-danger">未通过 </span>
                                @endif
                                </td>
                                <td><a type="button" class="btn blue btn-xs" href="{{route('manage_account_datails',['id'=>$v->id])}}">查看明细</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
