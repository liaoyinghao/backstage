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

<div class="modal fade bs-example-modal-sm" id="tap-change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <form class="form-horizontal" action="{{route('manage_shop_change_street')}}" method="post">
            <input type="hidden" name="shopid" value="" id="change-id">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">选择商街</h4>
                </div>
                <div class="modal-body">
                    <select class="form-control" name="streetid" id="change-street">
                        @foreach($streets as $k =>$v)
                        <option value="{{$k}}">{{$v}}</option>
                        @endforeach
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
                            <th>手机</th>
                            <th>设备</th>
                            <th class="tb-num">卡券</th>
                            <th class="tb-num">店员</th>
                            <th class="tb-num">达人</th>
                            <th class="tb-num">设备</th>
                            <th>商街</th>
                            <!-- <th>地址</th> -->
                            <th>通过时间</th>
                            <th>省-市</th>
                            <th class="tb-cz">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($lists))
                        @foreach($lists as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->name}}</td>
                            <td>{{$v->own_name}}</td>
                            <td>{{$v->own_tel}}</td>
                            <td><a href="{{route('manage_shake_main',['deviceid'=>$v->dev_sn])}}" target="_blank">{{$v->dev_sn}}</a></td>
                            <td><a href="{{route('manage_card_main',['shopid'=>$v->id])}}" target="_blank" class="btn blue-chambray btn-xs">{{$coupons[$v->id] or 0}}</a></td>
                            <td><a href="{{route('manage_shop_employee',['flag'=>'son','shopid'=>$v->id])}}" target="_blank" class="btn blue-chambray btn-xs">{{$nums[$v->id] or 0}}</a></td>
                            <td><a href="{{route('manage_shop_kol',['flag'=>'son','shopid'=>$v->id])}}" target="_blank" class="btn blue-chambray btn-xs">{{$kols[$v->id] or 0}}</a></td>
                            <td><a href="{{route('manage_shake_main',['shopid'=>$v->id])}}" target="_blank" class="btn blue-chambray btn-xs">{{$shakes[$v->id] or 0}}</a></td>

                            <td>{{$streets[$v->streetid] or ''}}</td>
                            <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                            <td>{{$v->province}} - {{$v->city}}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn blue btn-xs prev" data-name="{{$v->name}}" data-src="http://pan.baidu.com/share/qrcode?w=300&h=300&url={{str_replace('&' , '%26' , route('h5_store_main' , ['sid'=>$v->sn]))}}">预览</button>
                                    <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#" class="tap-street" data-toggle="modal" data-target="#tap-change" data-v="{{$v->streetid}}" data-id="{{$v->id}}"> 更换商街 </a></li>
                                        <li><a href="javascript:;" class="prev" data-name="{{$v->name}}" data-src="http://pan.baidu.com/share/qrcode?w=300&h=300&url={{str_replace('&' , '%26' , route('h5_store_change_own' , ['shopsn'=>$v->sn,'time'=>time()]))}}"> 更换店长 </a></li>
                                        <li>
                                            <a href="{{route('manage_shop_details',['id'=>$v->id])}}" >查看详情</a>
                                        <li>
                                        <!-- @if($v->weixin != 3 && $v->weixin != 2)
                                            <li>
                                                <a href="{{route('manage_shop_modify',['id'=>$v->id,'weixin'=>$v->weixin])}}" >成为微信商铺</a>
                                            <li>
                                         @else
                                            <li>
                                                <a href="{{route('manage_shop_deleteShop',['poiid'=>$v->poiid])}}" >删除微信商铺</a>
                                            <li>
                                         @endif -->

                                        <!-- <li><a href="{{route('manage_shop_bind_shake',['flag'=>'store','shopid'=>$v->id,'streetid'=>$v->streetid])}}" target="_blank"> 更换设备 </a></li>
                                        <li><a href="{{route('manage_shop_bind_shake',['flag'=>'employee','shopid'=>$v->id])}}" target="_blank"> 添加设备 </a></li> -->
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
