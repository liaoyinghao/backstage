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
                        @if(isset($flag))
                        <a href="{{route('manage_user_userdetailed')}}" class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加</a>
                        @endif
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>账号</th>
                            <th>谁创建</th>
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
                            @if(!empty($v->fromuser)))
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
                                <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                  <i class="fa fa-angle-down"></i>
                                </button>
                                @if(isset($flag))
                                <ul class="dropdown-menu pull-right" role="menu">
                                  @if($v->status ==1 )
                                  <li>
                                  <a href="{{route('manage_user_xiugai',['id'=>$v->id])}}"> 修改</a>
                                  <li>
                                    @endif
                                    @if($v->status ==1 )
                                    @if($v->id != 1)
                                  <li>
                                  <a class="delete" data-id="{{$v->id}}">  删除</a>
                                  <li>
                                    @endif
                                    @endif
                                    @if($v->status ==0 )
                                  <li>
                                  <a class="hui" data-id="{{$v->id}}">恢复</a>
                                  <li>
                                    @endif
                                  </ul>
                                  @endif
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

@endsection
