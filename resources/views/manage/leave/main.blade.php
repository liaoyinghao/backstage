@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $(".shengqing").on("click",function(){
                var id = $(this).attr("data-id");
                var status = $(this).attr("data-status");
                
                if(id=='' || status==''){
                    return false;
                }
                $.ajax({
                    url:"{{route('manage_leave_leavestatus')}}",
                    type:"post",
                    data:{"id":id,"status":status},
                    dataType:"json",
                    success:function(d){
                        if(d==1){
                            alert("状态更改成功！");
                            location.href="{{route('manage_leave_main')}}";
                        }else{
                            alert("更改状态失败！");
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
.neirong{max-width: 300px;max-height: 38px;display: block;overflow: hidden;}
.leixingbg{background: #b2fcc7}
.leixingbgs{background: #b5b2fc}
.leixingbgst{background: #f6fcb2}
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline" href="{{route('manage_leave_ldetails')}}"><i class="fa fa-plus"></i> 添加</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>姓名</th>
                            <th>职位</th>
                            <th>类型</th>
                            <th width="150px">时间</th>
                            <th>原因</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($list))
                            @foreach($list as $val)
                            @if(!empty($val))
                                <tr>
                                    <td>{{$val['id'] or ''}}</td>
                                    <td>{{$val['nickname'] or ''}}</td>
                                    <td>{{$val['position'] or ''}}</td>
                                    <td>
                                        @if($val['type'] == 1) 
                                         <button class="btn btn-xs leixingbg">请假</button>
                                        @else
                                         <button class="btn btn-xs leixingbgs">外勤</button>
                                        @endif
                                    </td>
                                    <td>{{$val['kstime'] or ''}} 至 {{$val['jstime'] or ''}}</td>
                                    <td><span class="neirong">{{$val['progress'] or ''}}</span></td>
                                    <td>
                                        @if($val['status'] == 1)
                                        <button class="btn btn-danger btn-xs">申请中</button>
                                        @elseif($val['status'] == 2)
                                        <button class="btn success btn-xs">已允许</button>
                                        @else
                                        <button class="btn btn-xs leixingbgst">被拒绝</button>
                                        @endif
                                    </td>
                                    <td>
                                       <div class="btn-group">
                                          <button type="button" class="btn blue btn-xs">
                                                <a href="{{route('manage_leave_ldetails',['id'=>$val['id']])}}" class="pfp">查看</a>
                                          </button>
                                        @if(isset($info))
                                            @if($info['position'] == '总经理')
                                          <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                          <ul class="dropdown-menu pull-right" role="menu">
                                              <li>
                                                <a data-id="{{$val['id']}}" data-status="2" class="shengqing">允许申请</a>
                                              </li>
                                              <li>
                                                <a data-id="{{$val['id']}}" data-status="0" class="shengqing">拒绝申请</a>
                                              </li>
                                          </ul>
                                            @endif
                                        @endif
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
