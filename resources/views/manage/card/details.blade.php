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
<style type="text/css">.col-md-9>p{margin-top: 6px;padding: 0;font-size: 16px}</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 卡券详情</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-body">
                        <h3 class="form-section">卡券信息</h3><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">卡券名:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$lists->title or ''}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">店铺名:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$name or ''}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">品牌名:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{$lists->brand_name or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">限领:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$lists->get_limit or '0'}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">总库存:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$lists->quantity or '0'}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">领取:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$lists->used or '0'}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">核销:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{$veris[$lists->card_id] or '0'}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">状态:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> 
                                            @if($lists->status==1)
                                            正常
                                            @else
                                            下架
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">制作时间:</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static"> {{date('Y-m-d H:i',$lists->addtime)}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                </div>

            </div>
        </div>
    </div>

@endsection
