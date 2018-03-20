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
                        <a class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加</a>
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
                            <th>签单时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if(isset($lists))
                          @foreach($lists as $v)
                          <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->proname}}</td>
                            <td>{{$v->customername}}</td>
                            <td>{{$v->contact}}</td>
                            <td>{{$v->contractamount}}</td>
                            <td>{{$v->paiddeposit}}</td>
                            <td>{{$v->floorprice}}</td>
                            <td>{{$v->signingtime}}</td>
                            <td>
                            @if($v->status == 1) 
                                处理中
                            @elseif($v->status == 2)
                                结束
                            @else 
                                放弃
                            @endif
                            </td>
                            <td><a href="{{route('manage_project_addproject',['id'=>$v->id])}}">编辑项目</a></td>
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
