@extends('manage.common.master')
@section('userjs')
    <script>
    bootbox.setLocale("zh_CN");
        $(function(){
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $("table").on("click",".prev",function(){
                var u=$(this).attr("data-src");
                var n=$(this).attr("data-name");
                var h='<div class="text-center"><p>'+n+'</p><img src="'+u+'"></div>';
                bootbox.alert(h);
            });

            $("table").on("click",".tap-street",function(){
                var v=$(this).attr("data-v");
                var id=$(this).attr("data-id");
                $("#change-street").val(v);
                $("#change-id").val(id);
            });

            $("table").on("click",".add-num",function(){
                var shopid=$(this).attr("data-shopid");
                bootbox.prompt({
                    size:"small",
                    title:"请输入充值数量",
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
                                url: "{{route('manage_recharge_shop.index')}}/"+shopid,
                                dataType:"json",
                                data: {"_token":"{{ csrf_token() }}","num":res},
                                type:"put",
                                success: function(d){
                                    alert('充值成功');
                                    location.href=location.href;
                                }
                            });
                        }

                    }
                });
            });
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

                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>店铺名</th>
                            <th>负责人</th>
                            <th>商街</th>
                            <th>可用核销数</th>
                            <th>已用核销数</th>
                            <th>启用核销</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->name}}</td>
                            <td>{{$v->own_name}}</td>
                            <td>{{$streets[$v->streetid] or ''}}</td>
                            <td>{{$v->num}}</td>
                            <td>{{$v->numed}}</td>
                            <td>
                                <span class="hidden">{{$v->is_inori}}</span>
                                <div class="md-checkbox has-error">
                                    <input type="checkbox" id="news-c{{$v->id}}"@if($v->is_inori==1) checked @endif class="md-check manage-checkboxs" data-model="shops" data-sid="{{$v->id}}" data-status="is_inori">
                                    <label for="news-c{{$v->id}}">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn blue btn-xs add-num" data-shopid="{{$v->id}}">增加次数</button>
                                    <!-- <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#" class="tap-street" data-toggle="modal" data-target="#tap-change" data-v="{{$v->streetid}}" data-id="{{$v->id}}"> 更改商街 </a></li>
                                        <li><a href="javascript:;" class="prev" data-name="{{$v->name}}" data-src="http://pan.baidu.com/share/qrcode?w=300&h=300&url={{str_replace('&' , '%26' , route('h5_store_change_own' , ['shopsn'=>$v->sn,'time'=>time()]))}}"> 更改店长 </a></li>
                                        <li class="divider"> </li>
                                        <li><a href="javascript:;">删除</a></li>
                                    </ul> -->
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
