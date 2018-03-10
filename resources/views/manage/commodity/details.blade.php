@extends('manage.common.master')
@section('userjs')
    <script>
        

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
.alertspans{margin-left: 20px}
.weui-media-box__thumb{
    height:150px;
}
.groups_x{text-align: center;padding-top: 6px;}
.groups_m{float: right;margin:6px 10px 0 0}
.sectionrow{font-size: 13px}
.lihied{line-height: 4px}
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
                        <h3 class="form-section">订单详情</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-5">购买店铺名:</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static lihied"> {{$basic->name or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-5">购买时间:</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static lihied">
                                           {{date("Y-m-d H:i:s",$basic->addtime)}}
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
                                    <label class="control-label col-md-5">&nbsp;订&nbsp;&nbsp;单&nbsp;&nbsp;号&nbsp;&nbsp;:</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static lihied">{{$basic->out_trade_no or ''}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-5">购买价格:</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static lihied">￥{{$basic->total or '0 '}}元</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <h3 class="form-section">会员卡信息</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">是否使用会员卡:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static lihied">@if(empty($basic->member_card)) 未使用 @else 已使用 @endif </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">会员卡名称:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static lihied">@if(isset($membercard)) {{$membercard['card_type'] or  '无'}} @else 无 @endif</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">优惠类型:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static lihied">
                                           @if(isset($membercard)) 
                                                @if($membercard['discount'] == 1)
                                                    折扣
                                                @elseif($membercard['discount'] == 2)
                                                    最低价
                                                @endif
                                            @else
                                                无
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">此订单所增加的积分:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"></p>
                                    </div>
                                </div>
                            </div> -->
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">该会员卡共有积分:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static lihied">{{$memberkol->integral or '0'}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <div class="row">
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">此订单所增加的佣金:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"></p>
                                    </div>
                                </div>
                            </div> -->
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">该会员卡共有佣金:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static lihied">{{$memberkol->brokerage or '0'}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <h3 class="form-section">购买商品详情</h3>
                        <div class="row sectionrow">

                            <div class="col-md-6">
                                @if(isset($shopm))
                                    @foreach($shopm as $v)
                                <div class="form-group">
                                    <label class="control-label col-md-6 groups_x">{{$v[0]}}</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">x {{$v[2]}}</p>
                                        <span class="groups_m">￥{{$v[1]}}元</span>
                                    </div>
                                </div>
                                    @endforeach

                                <div class="form-group">
                                    <label class="control-label col-md-6 groups_x">&nbsp;</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">约计：</p>
                                        <span class="groups_m">￥{{$shopmoney}}元</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6 groups_x">&nbsp;</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">优惠后价格：</p>
                                        <span class="groups_m">￥{{$basic->total or '0 '}}元</span>
                                    </div>
                                </div>

                                @endif
    
                                


                            </div>


                        </div>
                        


                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-3" style="padding: redirect;float: right;"><br><a href="{{route('manage_recharge_commodity')}}" style="color:#fff;text-decoration: none;">
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
