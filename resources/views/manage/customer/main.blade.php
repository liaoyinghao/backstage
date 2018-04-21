@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            @if(isset($flag))
            $(".td_select").change(function(){
                var grades = $(this).val();
                var id  = $(this).siblings(".tid").val();
                $.ajax({
                    url:"{{route('manage_customer_khgrades')}}",
                    type:"post",
                    data:{"grades":grades,"id":id},
                    dataType:"json",
                    success:function(d){
                        if(d==1){
                            alert("客户等级修改成功！");
                        }else{
                            alert("修改失败！");
                        }
                    }
                })
            })
            @endif

            //筛选
            $("#shaixuan").change(function(){
                var shaixuan = $(this).val();
                if(shaixuan == 0){
                    return false;
                }

                @if(isset($quan) && $quan ==1)
                    window.location.href="{{route('manage_customer_main')}}?shaixuan="+shaixuan+"&type=shaixuan&quan=1";
                @else
                    window.location.href="{{route('manage_customer_main')}}?shaixuan="+shaixuan+"&type=shaixuan";
                @endif
            })

            $("#zuyuan").change(function(){
                var zuyuan = $(this).val();
                if(zuyuan == 0){
                    return false;
                }

                @if(isset($quan) && $quan ==1)
                    window.location.href="{{route('manage_customer_main')}}?zuyuan="+zuyuan+"&type=zuyuan&quan=1";
                @else
                    window.location.href="{{route('manage_customer_main')}}?zuyuan="+zuyuan+"&type=zuyuan";
                @endif
            })

            $(".ahrefs").on("click",function(){
                event.returnValue = confirm("你确认要将此客户的状态转为项目吗？");
                if(event.returnValue){
                    var aid = $(this).siblings(".aid").val();
                    window.location.href="{{route('manage_project_addproject')}}?aid="+aid;
                }
            })

        });


    </script>
@endsection

@section('content')
<style type="text/css">
    .td_select{width: 100%;}
    .td_s_sp{font-size: 12px;}
    #news-table_length{display: none}
    #shaixuan{position: absolute;top: 73px;left: 35px;width: 140px;height: 30px;border-radius: 5px;}
    #zuyuan{width: 140px;height: 30px;border-radius: 5px;}
    .acolor{color:#fff;text-decoration:none}
    .td_span{width: 100%;height: 20px;display: block;overflow: hidden;}
    .outline{outline: 1px solid red;}
    .btnxs{margin-left: 5px !important;}
    .tishired{position: absolute;top: 95px;left: 35px;color: red;font-size: 12px;}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        @if(isset($flag))<a class="btn blue btn-outline" href="{{route('manage_customer_main',['type'=>'qi'])}}">超过七天未更新跟进信息</a>@endif
                        @if(isset($flag) && $flag ==2)<a class="btn blue btn-outline" href="{{route('manage_customer_chzuyuan')}}"> 查看组员客户</a>@endif
                        @if(isset($flag) && $flag ==1)<a class="btn blue btn-outline" href="{{route('manage_customer_main',['type'=>'quan'])}}"> 查看全部客户</a>@endif
                        @if(isset($flag))<a class="btn blue btn-outline" href="{{route('manage_customer_khadd')}}"><i class="fa fa-plus"></i> 客户录入</a>@endif
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>

                <select id="shaixuan">
                    <option value="0">请选择筛选条件</option>
                    <option value="D">D</option>
                    <option value="C">C</option>
                    <option value="B">B</option>
                    <option value="A">A</option>
                    <option value="S">S</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <P class='tishired'>*标有红框的客户是为七天内未跟进客户</P>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>客户姓名</th>
                            <th>联系方式</th>
                            <th>报价</th>
                            <th>客户评级</th>
                            <th>跟进人员</th>
                            <th>客户状态</th>
                            <th width="150px">备注</th>
                            <th width="170px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if(isset($lists))
                          @foreach($lists as $v)
                          <tr>
                            <td>{{$v->id}}</td>
                            <td><span @if($v->status != 2) @if(!empty($v->khstatus)) class="outline" @endif @endif >{{$v->name}}</span></td>
                            <td>{{$v->info}}</td>
                            <td>{{$v->offer}}</td>
                            <td>
                                <select class="td_select">
                                    <option value="D" @if($v->grade == "D") selected="selected" @endif >D</option>
                                    <option value="C" @if($v->grade == "C") selected="selected" @endif >C</option>
                                    <option value="B" @if($v->grade == "B") selected="selected" @endif >B</option>
                                    <option value="A" @if($v->grade == "A") selected="selected" @endif >A</option>
                                    <option value="S" @if($v->grade == "S") selected="selected" @endif >S</option>
                                </select>
                                <input type="hidden" class="tid" value="{{$v->id}}">
                            </td>
                            <td>{{$user[$v->fromuser]}}</td>
                            <td>
                                @if($v->status ==1)      正常
                                @elseif($v->status ==2)  已转入项目
                                @else                    放弃
                                @endif
                            </td>
                            <td><span class="td_span">{{$v->remarks or ''}}</span></td>
                            <td>
                                @if($v->status != 2)
                                <div class="btn-group">
                                    @if(isset($flag))
                                    <button type="button" class="btn blue btn-xs">
                                        <a href="{{route('manage_customer_followup',['id'=>$v->id])}}" class="tap-street acolor">修改跟进信息</a>
                                    </button>
                                    <button type="button" class="btn blue btn-xs btnxs">
                                        <a class="tap-street acolor ahrefs">转入项目</a>
                                        <input type="hidden" value="{{$v->id}}" class="aid">
                                    </button>
                                    @endif
                                </div>
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
