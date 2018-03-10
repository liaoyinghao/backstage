@extends('manage.common.master')

@section('usercss')
@endsection
@section('userjs')
    <script>
        $(function(){
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });
            $(".tap-tongbu").click(function(){
                mLoading();
                $.ajax({
                    url: "{{route('manage_shake_get_shake_pages')}}",
                    dataType:"json",
                    data: {"_token":"{{ csrf_token() }}"},
                    type:"post",
                    success: function(d){
                        if(d>0){
                            alert("更新了"+d+"记录");
                            location.href=location.href;
                        }else{
                            alert("没有更多的数据");
                        }
                    }
                });
            });

            $("table").on("click",".tap-page",function(){
                mLoading();
                var p=$(this).attr("data-pageid");
                $.ajax({
                    url: "{{route('manage_shake_page_to_device')}}",
                    dataType:"json",
                    data: {"_token":"{{ csrf_token() }}","pageid":p},
                    type:"post",
                    success: function(d){
                        alert("更新成功");
                        location.href=location.href;
                    }
                });
            });

            $("table").on("click",".prev",function(){
                var u=$(this).attr("data-src");
                var h='<div class="text-center"><p>'+u+'</p><p><img src="http://pan.baidu.com/share/qrcode?w=300&h=300&url='+u.replace(/&/g,"%26")+'"></p></div>';
                bootbox.alert(h);
            });

            $("table").on("click",".tap-street",function(){
                var v=$(this).attr("data-v");
                var id=$(this).attr("data-id");
                $("#change-street").val(v);
                $("#change-id").val(id);
            });

        });


    </script>
@endsection

@section('content')
<link rel="stylesheet" href="//at.alicdn.com/t/font_456120_s05f1f5fo2tbuik9.css">
<div class="modal fade bs-example-modal-sm" id="tap-change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <form class="form-horizontal" action="{{route('manage_shake_qrcodeform')}}" method="post">
            <input type="hidden" name="id" value="" id="change-id">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">选择商街</h4>
                </div>
                <div class="modal-body">
                    <select class="form-control" name="execid" id="change-street">
                    @if(isset($exec))
                        @foreach($exec as $v)
                        <option value="{{$v->id}}">{{$v->nickname}}</option>
                        @endforeach
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
                        <!-- <a class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加</a> -->
                        <a href="{{route('manage_shake_shakepage_add')}}" class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加</a>
                        <a href="{{route('manage_shake_shakeforms')}}" class="btn blue btn-outline"><i class="fa fa-plus"></i> 批量添加</a>
                        <a href="{{route('manage_shake_qrcoderwm')}}" class="btn blue btn-outline"><i class="icon iconfont icon-xiazai"></i>二维码</a>
                        <button class="btn purple-studio btn-outline tap-tongbu"><i class="fa fa-refresh"></i> 同步</button>
                        <button class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</button>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>二维码编号</th>
                            <!-- <th>LOGO</th> -->
                            <th>绑定店铺</th>
                            <!-- <th>备注</th>
                            <th class="tb-num">设备</th> -->
                            <th>状态</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($lists))
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id or ''}}</td>
                            <td>{{$v->bianhao or ''}}</td>
                            <!-- <td><img src="{{$v->icon_url or ''}}" style="height:40px"></td> -->
                            <td>{{$shop[$v->sn] or ''}}</td>
                            <!-- <td>{{$v->comment}}</td>
                            <td>
                                <a href="{{route('manage_shake_main',['flag'=>'view' , 'pageid'=>$v->page_id])}}" target="_blank" class="btn blue-chambray btn-xs">{{$nums[$v->page_id] or 0}}</a>
                            </td> -->
                            <td>
                                @if($v->status==1)
                                <span class="label label-success ">正常</span>
                                @else
                                <span class="label label-danger ">删除</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn blue btn-xs prev" data-name="预览店铺" data-src="{{$v->bindurl or $v->url}}">预览</button>
                                    <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <!-- <li><a href="{{route('manage_shake_shakepage_edit',['pageid'=>$v->page_id])}}"> 编辑 </a></li> -->
                                        <li><a href="#" class="tap-street" data-toggle="modal" data-target="#tap-change" data-v="{{$v->execid}}" data-id="{{$v->id}}"> 更换品牌商 </a></li>
                                        <!-- <li class="divider"> </li>
                                        <li><a href="javascript:;">删除</a></li> -->
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

@endsection
