@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $(".ahrefsd").on("click",function(){
                event.returnValue = confirm("你确认要将此客户的状态转为代理记账项目吗？");
                if(event.returnValue){
                    var did = $(this).siblings(".did").val();
                    window.location.href="{{route('manage_project_editprojectpost')}}?did="+did;
                }
            })
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
                            <th width="50px">项目编号</th>
                            <th>项目名称</th>
                            <th>客户名称</th>
                            <th>联系方式</th>
                            <th>合同金额</th>
                            <th>已付定金</th>
                            <th>底价</th>
                            <th>项目类型</th>
                            <th>最新跟进信息</th>
                            <th>所属销售人员</th>
                            <th>所属客服人员</th>
                            <th>状态</th>
                            <th width="150px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if(isset($lists))
                          @foreach($lists as $v)
                            @if(isset($v->id))
                          <tr>
                            <td>{{$v->xmunion}}</td>
                            @if($v->success == 1)
                            <td style="color:red">{{$v->proname}}</td>
                            @else
                            <td>{{$v->proname}}</td>
                            @endif
                            <td>{{$v->customername}}</td>
                            <td>{{$v->contact}}</td>
                            <td>{{$v->contractamount}}</td>
                            <td>{{$v->paiddepositcount}}</td>
                            <td>{{$v->floorprice}}</td>
                            <td>@if($v->prosta == 1) 直接项目 @elseif($v->prosta ==2)代理记账 @endif</td>
                            <td>{{$v->progressname}}</td>
                            <td>{{$v->kid or ''}}</td>
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
                            <td>
                              <div class="btn-group">

                                  @if($v->status != 3) <!-- 销售不能更改状态 -->

                                  <button type="button" class="btn blue btn-xs @if($v->status == 0) huibg @endif">
                                        @if($lists['type'] == 1 && $v->status > 0 && $v->status < 3)
                                            <a href = "{{route('manage_project_process',['id'=>$v->id])}}" class="pfp">查看跟进信息</a>
                                        @else
                                            <a href = "{{route('manage_project_addprocess',['id'=>$v->id])}}"  class="pfp">添加跟进信息</a>
                                        @endif
                                  </button>
                                  <button type="button" class="btn blue-steel dropdown-toggle btn-xs @if($v->status == 0) huibg @endif" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>

                                  <ul class="dropdown-menu pull-right" role="menu">
                                      <li><a class="huifuxm pfp" href = "{{route('manage_project_addproject',['id'=>$v->id])}}" data-id="{{$v->id}}">编辑项目</a><li>
                                      @if($v->prosta == 1)
                                        <li>
                                            <a class="tap-street acolor ahrefsd" href="{{route('manage_project_adddlproject',['id'=>$v->id,'type'=>5])}}">转入代理记账</a>
                                            <input type="hidden" value="{{$v->id}}" class="did">
                                        </li>
                                      @endif

                                        @if($v->status == 0)
                                            <li><a class="huifuxm pfp" data-id="{{$v->id}}">恢复此项目</a><li>
                                        @else
                                            <li><a class="fangqixm pfp" data-id="{{$v->id}}">放弃此项目</a><li>
                                        @endif



                                        @if($lists['type'] == 1 && $v->status == 2) <!-- 销售 -->
                                        <li>
                                            <a href="{{route('manage_project_addprojectst',['id'=>$v->id])}}" class="genghuanzt pfp">添加定金</a>
                                        <li>
                                        @endif
                                        @if($lists['type'] == 2 && $v->status > 2)   <!-- 客服 -->
                                            <li><a class="genghuanzt pfp yggzt">更换状态</a><li>
                                        @elseif($lists['type'] == 2 && $v->status == 1)  <!-- 客服 -->
                                            <li><a class="genghuanzt pfp yggztyi">更换状态</a><li>
                                        @elseif($lists['type'] == 3 && $v->status > 1)
                                            <li><a class="genghuanzt pfp yggzter">更换状态</a><li>  <!-- 财务 -->
                                        @else
                                            <li><a class="genghuanzt pfp" href="{{route('manage_customer_khterxm',['id'=>$v->id])}}">更换状态</a><li>
                                        @endif

                                        @if($lists['type'] != 1 &&  $lists['type'] != 4) <!-- 财务和客服 -->
                                            <li><a href="{{route('manage_project_addproject',['id'=>$v->id,'type'=>1])}}" class="genghuanzt pfp yggzter">查看项目</a><li>
                                        @endif

                                        @if($lists['type'] == 2) <!-- 客服 -->
                                        <li><a class="genghuanzt pfp" href="{{route('manage_project_gaidijia',['id'=>$v->id])}}">更改底价</a><li>
                                        @endif
                                   </ul>
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
