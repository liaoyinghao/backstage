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
    .huibg{background: #999 !important;border-color: #999 !important;}
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
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>项目名称</th>
                            <th>客户名称</th>
                            <th>联系方式</th>
                            <th>合同金额</th>
                            <th>已付定金</th>
                            <th>底价</th>
                            <th>管辖财务人员</th>
                            <th>管辖客服人员</th>
                            <th>状态</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if(isset($lists))
                          @foreach($lists as $v)
                            @if(isset($v->id))
                          <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->proname}}</td>
                            <td>{{$v->customername}}</td>
                            <td>{{$v->contact}}</td>
                            <td>{{$v->contractamount}}</td>
                            <td>{{$v->paiddepositcount}}</td>
                            <td>{{$v->floorprice}}</td>
                            <td>{{$v->cwid or ''}}</td>
                            <td>{{$v->kfid or ''}}</td>
                            <td>
                                @if($v->status == 1) 
                                    <button class="btn blue btn-xs">确认中</button>
                                @elseif($v->status == 2)
                                    <button class="btn btn-success btn-xs">进行中</button>
                                @elseif($v->status == 3)
                                    <button class="btn btn-danger btn-xs">完成</button>
                                @elseif($v->status == 4)
                                    <button class="btn btn-warning btn-xs">申请退</button>
                                @else 
                                    <button class="btn success btn-xs">放弃</button>
                                @endif
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
