@extends('manage.common.master')
@section('userjs')
    <script>
    	$(function(){

    		$("#preservation").on('click',function(){
    			var delivery = $(".delivery_span").find("input[type='radio']:checked").val();


    		})

    		$("#preservation").on('click',function(){
    			var delivery = $(".delivery_span").find("input[type='radio']:checked").val();
    			var ordernumber = $("#ordernumber").val();
    			var out_trade_no = $("#out_trade_no").html();

    			if(delivery == 1){
    				if(ordernumber == ''){
    					alert('请填写物流订单号！');
    					return false;
    				}
    			}

    			$.ajax({
    				type:"post",
    				url:"{{route('manage_recharge_payposmodify')}}",
    				data:{'delivery':delivery,"ordernumber":ordernumber,"out_trade_no":out_trade_no},
    				dataType:"json",
    				success:function(d){
    					if(d == 1){
    						alert('修改成功！');
    					}else if(d == 2){
    						alert('对不起，请先修改内容！');
    					}else{
    						alert("修改失败");
    					}
    				}

    			})
    		})
    	})


    </script>
@endsection

@section('content')

<style type="text/css">
#noadopt,#adopt{width: 150px;height: 30px;
    background: red;border: none;cursor: pointer;
    color: white;margin: 20px 10px 0 10px;border-radius: 3px;}
#adopt{background: #0dd607}
.portlet-body .col-md-8{margin-top: -7px;}
.portlet-body .row{margin-top: 10px}
.form-group .control-label{text-align: right;}
#delivery,#deliverys{width: 18px;height: 18px;vertical-align: middle;margin-top: -2px;}
#ordernumber{width: 200%;outline: none;height: 30px;border: none;border-bottom: 1px solid #999;}
#preservation{width: 100px;height: 35px;background: #FFA500;position: absolute;bottom: -90px;left: 80px;color: #fff;font-size: 15px;text-align: center;line-height: 35px;border-radius: 3px;cursor: pointer;z-index: 10;}
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
                        <h3 class="form-section">信息资料</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">姓名:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> {{$info->name or ''}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">电话号码:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> {{$info->tel or ''}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">身份证号码:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{$info->identification or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">门店地址:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> {{$info->desc or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">结算账户:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> {{$info->accountuser or ''}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">开户银行:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> {{$info->bank or ''}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">结算账户账号:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> {{$info->accountname or ''}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <h3 class="form-section">交易信息</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">店铺名称:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> {{$shop->name or ''}} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">支付状态:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> 
											@if($info->status == 1)
												已支付
											@else
												未支付
											@endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">发货状态:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> 
											@if($info->delivery == 1)
												已发货
											@else
												未发货
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
                                    <label class="control-label col-md-4">支付金额:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{$info->total_fee or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">订单号码:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static" id="out_trade_no"> {{$info->out_trade_no or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">购买时间:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> {{date("Y-m-d H:i:s",$info->addtime)}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/row-->
                        <h3 class="form-section">发货信息</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">是否已发货:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> 
                                        <span class='delivery_span'><input type="radio" name="radios" value="1" id="delivery" @if($info->delivery == 1) checked="checked" @endif >已发货</span>
                                        <span class='delivery_span'><input type="radio" name="radios" value="0" id="deliverys" @if($info->delivery == 0) checked="checked" @endif >未发货</span> 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">发货订单号:</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static"> <input type="text" value="{{$info->ordernumber or ''}}" id="ordernumber"> </p>
                                    </div>
                                    <p id="preservation">保存修改</p>
                                </div>
                            </div>
                        </div>
                        
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-3" style="padding: redirect;float: right;"><br><a href="{{route('manage_recharge_paypos')}}" style="color:#fff;text-decoration: none;">
                                        <button type="submit" class="btn blue col-md-9" style="width: 200px;;"> 返回POS机申请页</button>
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
