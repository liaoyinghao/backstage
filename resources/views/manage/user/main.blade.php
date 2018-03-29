@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });


            $(".delete").on('click', function(){
                event.returnValue = confirm("你确认要删除吗？");
                if(event.returnValue){
                    var id = $(this).attr("data-id");
                    $.ajax({
                        url:"{{route('manage_user_del')}}",
                        type:"post",
                        data:{'id':id},
                        dataType:'json',
                        success:function(d){
                            if(d==1){
                                alert('删除成功！');
                                location.href=location.href
                            }else{
                                alert('删除失败！');
                            }
                        }
                    })
                }
            })

            $(".hui").on('click', function(){
                event.returnValue = confirm("你确认要恢复吗？");
                if(event.returnValue){
                    var id = $(this).attr("data-id");
                    $.ajax({
                        url:"{{route('manage_user_hui')}}",
                        type:"post",
                        data:{'id':id},
                        dataType:'json',
                        success:function(d){
                            if(d==1){
                                alert('恢复成功！');
                                location.href=location.href
                            }else{
                                alert('恢复失败！');
                            }
                        }
                    })
                }
            })

            $(".positionfp").on("click",function(){
                alert("您无需分配组员！");
            })
        });


    </script>
@endsection

@section('content')
@if(isset($lists))
<style type="text/css">
    li{list-style-type: none;}
    .pfp{color:#fff;text-decoration:none}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{route('manage_user_userdetailed')}}" class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>账号</th>
                            <th>属于谁</th>
                            <th>职位</th>
                            <th>昵称</th>
                            <th>创建时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($lists as $v)
                          <tr>
                            <td class="bid">{{$v->id}}</td>
                            <td>{{$v->username}}</td>
                            @if(!empty($v->fromuser))
                            <td>{{$user[$v->fromuser]}}</td>
                            @else
                            <td></td>
                            @endif
                            <td>{{$v->position}}</td>
                            <td>{{$v->nickname}}</td>
                            <td>{{date("Y-m-d H:i:s",$v->addtime)}}</td>
                            <th>@if($v->status ==1 ) 正常@endif @if($v->status ==0 )离职@endif</th>
                            <td>
                              <div class="btn-group">
                              @if($v->status ==1 )
                                  @if($v->position == '销售' || $v->position == '销售主管' || $v->position == '客服' || $v->position == '客服主管')
                                      <button type="button" class="btn blue btn-xs">
                                            <a href="{{route('manage_user_distribution',['id'=>$v->id])}}" class="pfp">分配</a>
                                      </button>
                                    <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                  <ul class="dropdown-menu pull-right" role="menu">
                                  <li>
                                    <a href="{{route('manage_user_xiugai',['id'=>$v->id])}}">修改</a>
                                  <li>
                                  @else
                                        <button type="button" class="btn blue btn-xs">
                                            <a href="{{route('manage_user_xiugai',['id'=>$v->id])}}" class="pfp">修改</a>
                                        </button>
                                        <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                  @endif
                              @endif
                              @if($v->status ==1 )
                                @if($v->id != 1)
                                  <li><a class="delete" data-id="{{$v->id}}">删除</a><li>
                                @endif
                              @endif
                              @if($v->status ==0 )
                                  <li>
                                  <button type="button" class="btn blue btn-xs">
                                    <a class="hui pfp" data-id="{{$v->id}}">恢复</a>
                                  </button>
                                  <li>
                              @endif
                                  </ul>
                                  </div>
                                </td>
                          </tr>
                          @endforeach
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
