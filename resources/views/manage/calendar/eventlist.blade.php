@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $(".zhuantai").on("click",function(){
                $id = $(this).attr("data-id");
                $status = $(this).attr("data-v");
                $.ajax({
                    url:"{{route('manage_calendar_updatestatus')}}",
                    type:"post",
                    data:{"id":$id,"status":$status},
                    dataType:"json",
                    success:function(d){
                        if(d==1){
                            alert("状态修改成功！");
                            location.href="{{route('manage_calendar_main')}}";
                        }else{
                            alert("状态修改失败！");
                        }
                    }
                })
            })
        });


    </script>
@endsection

@section('content')
<style type="text/css">
li{list-style-type: none;}
.pfp{color:#fff;text-decoration:none}
.spanbz,.spannr{max-height: 38px;display: block;overflow: hidden;}
.spanbz{max-width: 150px;}
.spannr{max-width: 280px;}
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline" href="{{route('manage_calendar_main')}}">查看未完成事件</a>
                        <a class="btn blue btn-outline" href="{{route('manage_calendar_eventdetails')}}"><i class="fa fa-plus"></i> 添加</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>标题</th>
                            <th>时间</th>
                            <th>备注</th>
                            <th>事件</th>
                            <th>状态</th>
                            <th width="111px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($info))
                            @foreach($info as $val)
                            @if(!empty($val))
                                    <tr>
                                        <td>{{$val['id'] or ''}}</td>
                                        <td>{{$val['title'] or ''}}</td>
                                        <td>{{$val['betime'] or ''}}</td>
                                        <td><span class="spanbz">{{$val['remarks'] or ''}}</span></td>
                                        <td><span class="spannr">{{$val['progress'] or ''}}</span></td>
                                        <td>
                                            @if($val['status'] == 1)
                                                <button class="btn btn-danger btn-xs">未完成</button>
                                            @elseif($val['status'] == 2)
                                                <button class="btn success btn-xs">已完成</button>
                                            @else
                                                <button class="btn success btn-xs">已删除</button>
                                            @endif
                                            
                                        </td>
                                        <td>
                                           <div class="btn-group">
                                              <button type="button" class="btn blue btn-xs">
                                                    <a href="{{route('manage_calendar_eventdetails',['upid'=>$val['id']])}}" class="pfp">修改事件</a>
                                              </button>
                                              <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                              <ul class="dropdown-menu pull-right" role="menu">
                                                  @if($val['status'] == 1)
                                                      <li>
                                                        <a class="zhuantai" data-v="2" data-id="{{$val['id']}}">已完成</a>
                                                      </li>
                                                  @elseif($val['status'] == 2)
                                                      <li>
                                                        <a class="zhuantai" data-v="1" data-id="{{$val['id']}}">转为未完成</a>
                                                      </li>
                                                  @else
                                                  @endif
                                                  
                                                  <li>
                                                  @if($val['status'] == 0)
                                                    <a class="zhuantai" data-v="1" data-id="{{$val['id']}}">恢复此备忘录</a>
                                                  @else
                                                    <a class="zhuantai" data-v="0" data-id="{{$val['id']}}">删除此备忘录</a>
                                                  @endif
                                                  </li>
                                              </ul>
                                          </div>
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
