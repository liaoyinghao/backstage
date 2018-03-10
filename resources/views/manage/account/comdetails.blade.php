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
                                <th>领卡人</th>
                                <th>会员卡</th>
                                <th>会员卡号</th>
                                <th>上级会员</th>
                                <th>品牌商</th>
                                <th>积分</th>
                                <th>佣金</th>
                                <th>领取时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($lists))
                            @foreach($lists as $v)
                            <tr>
                                <td>{{$v->id}}</td>
                                @if(isset($kol[$v->unionid]))
                                <td>{{$kol[$v->unionid]}}</td>
                                @else
                                <td>佚名</td>
                                @endif
                                @if(!empty($membercard))
                                <td>{{$membercard[$v->member_id]}}</td>
                                @else
                                <td></td>
                                @endif
                                <td>{{$v->member_num}}</td>
                                <td>@if($v->grading!= ''){{$kol[$v->grading]}}@else{{$v->grading}}@endif</td>
                                <td>@if($v->exec_id!= ''){{$executive[$v->exec_id]}}@else{{$v->exec_id}}@endif</td>
                                <td>{{$v->integral}}</td>
                                <td>{{$v->brokerage}}</td>
                                <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
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
