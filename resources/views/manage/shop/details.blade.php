@extends('manage.common.master')
@section('userjs')
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
    <script>
    function searchByStationName() {
        var dis = '{{$order->city}}';
        var addr = '{{$order->addr}}';
        var localSearch = new BMap.LocalSearch(dis);
        localSearch.setSearchCompleteCallback(function(searchResult) {
            var poi = searchResult.getPoi(0);
            console.log(poi.point.lat);
            console.log(poi.point.lng);
            $("#latitude").val(poi.point.lat);
            $("#longitude").val(poi.point.lng);
        });
        localSearch.search(addr);
    }
        $(function(){
          searchByStationName();
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $("#adopt").on('click',function(){
              console.log($("#latitude").val());
              console.log($("#longitude").val());
              location.href="{{route('manage_shop_editexamine')}}?id="+$("#order_id").val()+"&type=2&latitude="+$("#latitude").val()+"&longitude="+$("#longitude").val();
              return false;
            })

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

        $("#noadopt").on('click',function(){
            $("#alertid").css("display","block");
        })

        $("#alertspans").on('click',function(){
            $("#alertid").css("display","none");
        })

        $('#alertspan').on('click',function(){
            var result = $("#result").val();
            if(result == ''){alert('原因不能为空');return false;}
        })

        $(function(){
            $(".weui-media-box__hd a").hover(function(){
                $(this).append("<p id='pic'><img src='"+this.href+"' id='pic1'></p>");
                $(".weui-media-box__hd  a").mousemove(function(e){
                    $("#pic").css({
                        "top":(e.pageY+100)+"px",
                        "left":(e.pageX+100)+"px"
                    }).fadeIn("fast");
                    // $("#pic").fadeIn("fast");
                });
            },function(){
                $("#pic").remove();
            });
        });

    </script>
@endsection

@section('content')

<style type="text/css">
#noadopt,#adopt{width: 150px;height: 30px;
    background: red;border: none;cursor: pointer;
    color: white;margin: 20px 10px 0 10px;border-radius: 3px;}
#adopt{background: #0dd607}
#alertid{position: absolute;top: 0;left: 0;width: 100%;height: 100%;background:rgba(0,0,0,0.2);display: none}
.alertclass{margin: 120px auto;width: 300px;height: 200px;background: #f8f8f8;text-align: center;}
#result{width: 80%;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;margin-top: 40px;margin-bottom: 40px;}
.alertspan{width: 30%;height: 30px;background: #FFA500;display: inline-block;line-height: 30px;color: #fff;border: none;}
.alertspans{margin-left: 20px;background: red}
.weui-media-box__thumb{
    height:150px;
}
</style>
<input type="hidden" id = 'latitude' value=''>
<input type="hidden" id = 'longitude' value=''>
<input type="hidden" id = 'order_id' value='{{$order->id}}'>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 详情页面</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="form-body">
                        <h3 class="form-section">店铺信息</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">店铺名:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->name}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">是否微信店铺:</label>
                                    <div class="col-md-9">
                                        <!-- <p class="form-control-static"> <img src="/uploads/h5/201708/160625701.jpg" style="width: 80px" /> </p> -->
                                        <p class="form-control-static">
                                            @if($order->weixin == 3)
                                                是
                                            @elseif($order->weixin == 2)
                                                审核中
                                            @else
                                                否
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">店铺电话:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->tel}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">店铺省市:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->province}} - {{$order->city}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">店铺店址:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->addr}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">店铺简介:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->desc}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <h3 class="form-section">店长信息</h3><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">店长姓名:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->own_name}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">联系电话:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->own_tel}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">设备编号:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$order->dev_sn}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="form-section">图片信息</h3><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">logo:</label>
                                    <div class="weui-media-box__hd">
                                        <a href="{{$order->logo or '/image/hdj.png'}}"><img class="weui-media-box__thumb" src="{{$order->logo or '/image/hdj.png'}}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">门头图:</label>
                                    <div class="weui-media-box__hd">
                                        @foreach($pics as $v)
                                        <a href="{{$v or '/image/hdj.png'}}"><img class="weui-media-box__thumb" src="{{$v or '/image/hdj.png'}}"></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">营业执照:</label>
                                    <div class="weui-media-box__hd">
                                        <a href="{{$order->license or '/image/hdj.png'}}"><img class="weui-media-box__thumb" src="{{$order->license  or '/image/hdj.png'}}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id='alertid'>
                            <div class='alertclass'>
                            <form method="post" action="{{route('manage_shop_editexamine')}}">
                            <input type="hidden" name="id" value="{{$order->id}}">
                            <input type="hidden" name="type" value="1">
                                <input type="type" name="result" id="result" value="" placeholder="审核不通过原因">
                                <p>
                                <button class='alertspan' id="alertspan">确认</button></span>
                                <span class='alertspan alertspans' id="alertspans">取消</span>
                                </p>
                            </form>
                            </div>
                        </div>

                        @if($order->examinetype != 2)
                        <!-- <a href="{{route('manage_shop_editexamine',['id'=>$order->id,'type'=>1])}}"></a> -->
                    <div><button id="noadopt">不通过</button><button id="adopt">通过</button></div>
                    @endif
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-3" style="padding: redirect;float: right;"><br><a href="{{route('manage_shop_examine')}}" style="color:#fff;text-decoration: none;">
                                        <button type="submit" class="btn blue col-md-9" style="width: 200px;;"> 返回列表页</button>
                                    </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
