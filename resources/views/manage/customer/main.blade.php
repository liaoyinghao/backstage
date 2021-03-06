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

            // $(".ahrefsd").on("click",function(){
            //     event.returnValue = confirm("你确认要将此客户的状态转为代理记账项目吗？");
            //     if(event.returnValue){
            //         var did = $(this).siblings(".did").val();
            //         window.location.href="{{route('manage_project_addproject')}}?did="+did;
            //     }
            // })

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
@if(isset($userinfos) && ($userinfos['position'] == '客服主管' || $userinfos['position'] == '客服'))
    <div class="rowst">对不起，您暂无权限查看客户列表！</div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline" href="{{route('manage_customer_main',['type'=>'giveup'])}}">查看已放弃客户</a>
                        @if(isset($flag))<a class="btn blue btn-outline" href="{{route('manage_customer_main',['type'=>'qi'])}}">超过七天未更新跟进信息</a>@endif
                        @if(isset($flag) && $flag ==2)<a class="btn blue btn-outline" href="{{route('manage_customer_chzuyuan')}}"> 查看组员客户</a>@endif
                        @if(isset($flag) && $flag ==1)<a class="btn blue btn-outline" href="{{route('manage_customer_chzuyuan')}}"> 查看全部客户</a>@endif
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
                            <th width="150px">客户编号</th>
                            <th>客户姓名</th>
                            <th>联系方式</th>
                            <!-- <th>报价</th> -->
                            <th>客户评级</th>
                            <th>客户需求</th>
                            <th>录入时间</th>
                            <th width="350px">最新更近信息</th>
                            <th width="150px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if(isset($lists))
                          @foreach($lists as $v)
                          <tr>
                            <td>{{$v->khunion or '--'}}</td>
                            <td><span @if($v->status != 2) @if(!empty($v->khstatus)) class="outline" @endif @endif >{{$v->name}}</span></td>
                            <td>{{$v->info}}</td>
                            <!-- <td>{{$v->offer}}</td> -->
                            <td>
                              {{$v->grade}}
                            </td>
                            <td>{{$v->demand}}</td>
                            <td>{{$v->addtime}}</td>
                            <td><span class="td_span">{{$v->progressname or ''}}</span></td>
                            <td>
                                <div class="btn-group">

                                  @if($v->status != 2)
                                  @if(isset($flag))

                                  <button type="button" class="btn blue-steel dropdown-toggle btn-xs " data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                  <ul class="dropdown-menu pull-right" role="menu">
                                     <li><a href="{{route('manage_customer_followup',['id'=>$v->id])}}" class="tap-street acolor">修改跟进信息</a></li>
                                     <li>
                                         <a class="tap-street acolor ahrefs">转入项目</a>
                                         <input type="hidden" value="{{$v->id}}" class="aid">
                                     </li>
                                     <!--<li>
                                         <a class="tap-street acolor ahrefsd">转入代理记账</a>
                                         <input type="hidden" value="{{$v->id}}" class="did">
                                     </li>-->

                                  </ul>
                                  @endif

                                  @endif
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
@endif
@endsection
