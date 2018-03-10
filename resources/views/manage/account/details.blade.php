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
#alertid{position: absolute;top: 0;left: 0;width: 100%;height: 100%;background:rgba(0,0,0,0.2);display: none;padding-top: 150px}
.alertclass{margin: 120px auto;width: 300px;height: 200px;background: #f8f8f8;text-align: center;}
#result{width: 80%;height: 35px;border-radius: 2px;border: 1px solid #999;text-indent: 5px;margin-top: 40px;margin-bottom: 40px;}
.alertspan{width: 30%;height: 30px;background: #FFA500;display: inline-block;line-height: 30px;color: #fff;border: none;}
.alertspans{margin-left: 20px;background: red}
.weui-media-box__thumb{
    height:150px;
}
</style>

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
                        <h3 class="form-section">品牌商信息</h3>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label col-md-5">品牌商名称:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">{{$list->name or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label col-md-5">联系电话:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">{{$list->tel or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label col-md-5">提交审核时间:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">{{date("Y-m-d H:i:s",$list->addtime)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--/row-->
                        <h3 class="form-section">收入详情</h3><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">转账金额:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{$list->money or ''}}元</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="form-section">图片信息</h3><br>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">凭证图片:</label>
                                    <div class="weui-media-box__hd">
                                        <a href="{{$list->pic or ''}}"><img class="weui-media-box__thumb" src="{{$list->pic or ''}}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <!-- 如果通过了，就不显示这个 -->
                    @if($list['status'] != 1)
                    <div><a href="{{route('manage_account_datailsget')}}?id={{$list->id or ''}}&type=2"><button id="noadopt">不通过</button></a><a href="{{route('manage_account_datailsget')}}?id={{$list->id or ''}}&type=1"><button id="adopt">通 过</button></a></div>
                    @endif

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-3" style="padding: redirect;float: right;"><br><a href="{{route('manage_account_auditing')}}" style="color:#fff;text-decoration: none;">
                                        <button type="submit" class="btn blue col-md-9" style="width: 200px;"> 返回列表页</button>
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
