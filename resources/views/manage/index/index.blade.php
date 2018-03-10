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
                        <span class="caption-subject bold uppercase"> {{$page['title'] or ''}}列表</span>
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
                            <th>商户名称</th>
                            <th>商户姓名</th>
                            <th>商户手机</th>
                            <th>可用余额</th>
                            <th>已充值</th>
                            <th>已提现</th>
                            <!-- <th>已冻结</th> -->
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                            @if($v->id)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$v->merchant_name}}</td>
                                <td>{{$v->merchant_owner}}</td>
                                <td>{{$v->merchant_phone}}</td>
                                <td><a href="{{route('m_account_history',['mid'=>$v->id])}}" target="_blank">{{$v->use}}</a></td>
                                <td><a href="{{route('m_account_recharge',['mid'=>$v->id])}}" target="_blank">{{$v->recharge}}</a></td>
                                <td><a href="{{route('m_account_taken',['mid'=>$v->id])}}" target="_blank">{{$v->taken}}</a></td>
                                <!-- <td><a href="{{route('m_account_taken',['mid'=>$v->id , 'status'=>0])}}" target="_blank">{{$v->forzen}}</a></td> -->
                                <td>
                                    <a href="{{route('m_account_recharge',['mid'=>$v->id])}}" class="btn green btn-xs" target="_blank">充值</a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
