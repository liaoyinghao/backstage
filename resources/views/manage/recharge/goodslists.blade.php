@extends('manage.common.master')
@section('userjs')
    <script>
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
                        <a href="{{route('manage_recharge_goods.create')}}" class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加 </a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>产品名</th>
                            <th>价格</th>
                            <th>核销数量</th>
                            <th>状态</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->title}}</td>
                            <td>&yen;{{$v->price}}</td>
                            <td>{{$v->num}}</td>
                            <td>
                                <span class="hidden">{{$v->status}}</span>
                                <div class="md-checkbox has-error">
                                    <input type="checkbox" id="news-c{{$v->id}}"@if($v->status==1) checked @endif class="md-check manage-checkboxs" data-model="goods_recharges" data-sid="{{$v->id}}" data-status="status">
                                    <label for="news-c{{$v->id}}">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('manage_recharge_goods.edit' , ['id'=>$v->id])}}" class="btn blue btn-xs">编辑</a>
                                    <!-- <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                        <i class="fa fa-angle-down"></i>
                                    </button> -->
                                    <!-- <ul class="dropdown-menu pull-right" role="menu">
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
