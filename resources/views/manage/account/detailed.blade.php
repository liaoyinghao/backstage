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
                        <span class="caption-subject bold uppercase"> @if(isset($exec)) {{$exec['nickname'] or ''}} @endif 品牌商账户详情列表</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>转账金额</th>
                                <th>转账时间</th>
                                <th>是否审核</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($lists))
                            @foreach($lists as $v)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$v->money}}</td>
                                <td>{{date("Y-m-d H:i",$v->addtime)}}</td>
                                <td>
                                @if($v->status == 0)
                                    <span class="label btn-warning">未审核</span>
                                @elseif($v->status == 1)
                                    <span class="label label-success"> 通 过 </span>
                                @else
                                    <span class="label label-danger">未通过 </span>
                                @endif
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
