@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $(".fangqixm").on('click', function(){
                event.returnValue = confirm("你确认要丢弃此项目吗？");
                if(event.returnValue){
                    var id = $(this).attr("data-id");
                    $.ajax({
                        url:"{{route('manage_project_updatastatus')}}",
                        type:"post",
                        data:{'id':id,"type":'1'},
                        dataType:'json',
                        success:function(d){
                            if(d==1){
                                alert('项目已丢弃！');
                                location.href=location.href
                            }else{
                                alert('丢弃失败！');
                            }
                        }
                    })
                }
            })

            $(".huifuxm").on('click', function(){
                event.returnValue = confirm("你确认要恢复此项目吗？");
                if(event.returnValue){
                    var id = $(this).attr("data-id");
                    $.ajax({
                        url:"{{route('manage_project_updatastatus')}}",
                        type:"post",
                        data:{'id':id,"type":'2'},
                        dataType:'json',
                        success:function(d){
                            if(d==1){
                                alert('项目已恢复！');
                                location.href=location.href
                            }else{
                                alert('恢复失败！');
                            }
                        }
                    })
                }
            })

            $("table").on("click",".genghuanzt",function(){
                var id=$(this).attr("data-id");
                $("#change-id").val(id);
            });

        });


    </script>
@endsection

@section('content')
@if(isset($lists))
<style type="text/css">
    li{list-style-type: none;}
    .pfp{color:#fff;text-decoration:none}
</style>

<div class="modal fade bs-example-modal-sm" id="tap-change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <form class="form-horizontal" action="{{route('manage_project_updatastatus')}}" method="post">
            <input type="hidden" name="id" value="" id="change-id">
            <input type="hidden" name="type" value="3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">选择对该项目的操作</h4>
                </div>
                <div class="modal-body">
                    <select class="form-control" name="status" id="change-street">
                        @if($user['position'] == '财务' || $user['position'] == '总经理')
                            <option value="1">确认中</option>
                            <option value="2">进行中</option>
                        @endif
                        @if($user['position'] == '客服' || $user['position'] == '客服主管' || $user['position'] == '总经理')
                            <option value="3">完成</option>
                        @endif
                        @if($user['position'] == '总经理')
                            <option value="4">申请退</option>
                        @endif
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn red" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn blue">确定</button>
                </div>
            </div>
        </form>
    </div>
</div>

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
                                    确认中
                                @elseif($v->status == 2)
                                    进行中
                                @elseif($v->status == 3)
                                    完成
                                @elseif($v->status == 4)
                                    申请退
                                @else 
                                    放弃
                                @endif
                            </td>
                            <td>
                              <div class="btn-group">
                                  <button type="button" class="btn blue btn-xs">
                                        <a href="{{route('manage_project_addproject',['id'=>$v->id])}}" class="pfp">编辑项目</a>
                                  </button>
                                  <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                  <ul class="dropdown-menu pull-right" role="menu">
                                      <li><a class="genghuanzt pfp" data-toggle="modal" data-target="#tap-change" data-id="{{$v->id}}">更换状态</a></li>
                                       @if($v->status == 0) 
                                            <li><a class="huifuxm pfp" data-id="{{$v->id}}">恢复此项目</a><li>
                                        @else 
                                            <li><a class="fangqixm pfp" data-id="{{$v->id}}">放弃此项目</a><li>
                                        @endif
                                      
                                  </ul>
                               </div>
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
@else
    <div>您没有对此操作的权限</div>
@endif
@endsection
