@extends('manage.common.master')
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
                    url: "{{route('manage_shake_get_shakes')}}",
                    dataType:"json",
                    data: {"_token":"{{ csrf_token() }}"},
                    type:"post",
                    // async:false,
                    success: function(d){
                        if(d>0){
                            alert("更新了"+d+"记录");
                            location.href=location.href;
                        }else{
                            alert("没有更多的设备");
                        }
                    }
                });
            });

            $("table").on("click",".tap-page",function(){
                mLoading();
                var d=$(this).attr("data-deviceid");
                $.ajax({
                    url: "{{route('manage_shake_device_to_page')}}",
                    dataType:"json",
                    data: {"_token":"{{ csrf_token() }}","deviceid":d},
                    type:"post",
                    // async:false,
                    success: function(d){
                        alert("更新成功");
                        location.href=location.href;
                    }
                });
            });

            // $("table").on("click",".tap-viewpage",function(){
            //     var d=$(this).attr("data-deviceid");
            //     $.ajax({
            //         url: "{{route('manage_shake_view_page')}}",
            //         dataType:"json",
            //         data: {"_token":"{{ csrf_token() }}","deviceid":d},
            //         type:"post",
            //         success: function(d){
            //             var h='';
            //             if(d.length == 0){
            //                 h='<p></p>'
            //             }else{
            //                 $.each(d,function(k,v){
            //
            //                 })
            //             }
            //
            //             bootbox.alert(h);
            //         }
            //     });
            //
            //
            // });


            bootbox.setLocale("zh_CN");
            // dialog.modal('hide')
            $("table").on("dblclick",".tap-uuid",function(){
                var h='<p>device_id: '+$(this).attr("data-deviceid")+'</p>';
                    h=h+'<p>uuid: '+$(this).attr("data-uuid")+'</p>';
                    h=h+'<p>major: '+$(this).attr("data-major")+'</p>';
                    h=h+'<p>minor: '+$(this).attr("data-minor")+'</p>';
                bootbox.alert(h);
            });

            $("table").on("click",".prev",function(){
                var u=$(this).attr("data-src");
                var h='<div class="text-center"><p>'+u+'</p></div>';
                bootbox.alert(h);
            });

            $("table").on("click",".tap-edit",function(){
                var deviceid=$(this).attr("data-deviceid");
                bootbox.prompt({
                    size:"small",
                    title:"输入新备注,15个字以内",
                    callback:function(res){
                        if(res===null){}else{
                            if(res.length==0){
                                alert("不能为空");
                                return false;
                            }
                            if(res.length>15){
                                alert("字数过长");
                                return false;
                            }
                            $.ajax({
                                url: "{{route('manage_shake_update_comment')}}",
                                dataType:"json",
                                data: {"_token":"{{ csrf_token() }}","comment":res,"deviceid":deviceid},
                                type:"post",
                                success: function(d){
                                    alert("更新成功!");
                                }
                            });
                        }

                    }
                });
            });

            $("table").on("click",".tap-change-emp",function(){
                var deviceid=$(this).attr("data-deviceid");
                var shopid=$(this).attr("data-shopid");
                $("#mchange-select").val(shopid);
                $("#change-emp-deviceid").val(deviceid);
                $("#mchange-emp").modal("show")
            });

            $("table").on("click",".tap-replace-emp",function(){
                var deviceid=$(this).attr("data-deviceid");
                var shopid=$(this).attr("data-shopid");
                $("#mchange-select").val(shopid);
                $("#change-emp-deviceid").val(deviceid);
                $("#mchange-emp").modal("show")
            });

            $("table").on("click",".tap-change-pub",function(){
                var v=$(this).val();
                var deviceid=$(this).attr("data-deviceid");
                if(v==1){
                    $(".s-"+deviceid).html('<span class="label label-primary">店铺版</span>');
                }else{
                    $(".s-"+deviceid).html('<span class="label label-warning ">店员版</span>');
                }
                $.post(
                    "{{route('manage_shake_dev_process')}}",
                    {"flag":'change-pub',"deviceid":deviceid,"v":v}
                );
            });


        });


    </script>
@endsection

@section('content')

<div class="modal fade" id="madd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加设备</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn red" data-dismiss="modal">取消</button>
                    <button type="button" class="btn blue">确定</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mchange-emp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{route('manage_shake_dev_process')}}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">改为店员设备</h4>
                </div>
                <div class="modal-body">
                    <select class="form-control" name="change-emp" id="mchange-select">
                        <option value="0">选择店铺</option>
                        @foreach($shopname as $k => $v)
                        <option value="{{$k}}">[{{$k}}]{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="flag" value="change-emp">
                    <input type="hidden" name="deviceid" value="" id="change-emp-deviceid">
                    <button type="button" class="btn red" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn blue">确定</button>
                </div>
            </form>
        </div>
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
                        <!-- <button class="btn blue btn-outline" data-toggle="modal" data-target="#madd"><i class="fa fa-plus"></i> 添加</button> -->
                        <button class="btn purple-studio btn-outline tap-tongbu"><i class="fa fa-refresh"></i> 同步</button>

                        <button class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</button>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>设备备注</th>
                            <th>device_id</th>
                            <th>商街</th>
                            <th>店铺</th>
                            <!-- <th class="tb-num">页面</th> -->
                            <!-- <th>类型</th> -->
                            <th>版本</th>
                            <!-- <th>状态</th> -->
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                            @if($v->id)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$v->comment}}</td>
                                <td><span class="label label-info tap-uuid" data-deviceid="{{$v->device_id}}" data-uuid="{{$v->uuid}}" data-major="{{$v->major}}" data-minor="{{$v->minor}}">{{$v->device_id}}</span></td>
                                <td>{{$streetname[$v->streetid] or '未绑定'}}</td>
                                <td>{{$shopname[$v->shopid] or '未关联店铺'}}</td>
                                
                                <td class="s-{{$v->device_id}}">
                                    @if($v->is_published==0)
                                    <span class="label label-warning ">店员版</span>
                                    @else
                                        @if($v->parentid==0) <span class="label label-primary">店铺版</span> @endif
                                        @if($v->parentid>0) <span class="label label-warning ">店员版</span> @endif
                                    @endif
                                </td>
                                <!-- <td>
                                    @if($v->status==1)
                                    <span class="label label-success ">已激活</span>
                                    @else
                                    <span class="label label-danger ">未激活</span>
                                    @endif
                                </td> -->
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn blue btn-xs prev" data-name="{{$v->name}}" data-src="{{route('h5_store_enter_byshake' , ['devsn'=>$v->device_id])}}">预览</button>
                                        @if($v->type==1)
                                        <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right dropdown-radiobuttons" role="menu">
                                            <li><a href="javascript:;" class="tap-edit" data-comment="{{$v->comment}}" data-deviceid="{{$v->device_id}}"> 编辑备注 </a></li>
                                            <li><a href="{{route('manage_shake_shakepage_edit',['deviceid'=>$v->device_id])}}" target="_blank"> 编辑页面 </a></li>
                                            <!-- <li><a href="{{route('manage_shake_bind',['deviceid'=>$v->device_id])}}"  target="_blank"> 绑定页面 </a></li> -->
                                            <li><a href="{{route('manage_shake_shakepage_add',['flag'=>'shake','deviceid'=>$v->device_id])}}"  target="_blank"> 绑定新页面 </a></li>
                                            <!-- <li><a href="javascript:;" class="tap-page" data-deviceid="{{$v->device_id}}"> 更新绑定页面 </a></li> -->
                                            @if($v->shopid==0)
                                            <li class="divider"> </li>
                                            <label><input type="radio" name="is_published[{{$v->id}}]" value="1" class="tap-change-pub" @if($v->is_published==1) checked @endif data-deviceid="{{$v->device_id}}">店铺版</label>
                                            <label><input type="radio" name="is_published[{{$v->id}}]" value="0" class="tap-change-pub" @if($v->is_published==0) checked @endif data-deviceid="{{$v->device_id}}">店员版</label>
                                            @endif
                                            <!-- <li><a href="javascript:;">删除</a></li> -->
                                        </ul>
                                        <!-- <div class="dropdown-menu hold-on-click dropdown-radiobuttons" role="menu">


                                        </div> -->
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
