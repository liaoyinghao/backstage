@extends('manage.common.master')
@section('userjs')
    <script>
    $(function(){

//颜色选择
        var color = $(".members_color").val();
        $(".m_top").css("background",color);

        $(".members_color").change(function(){
            var colors=$(this).val();
            $(".m_top").css("background",colors);
        })

//logo上传
        $("#logo").change(function(){
            var formData = new FormData();
            formData.append("file" , $(this)[0].files[0]);
            $.ajax({
                url: "{{route('manage_member_pic')}}",
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                success:function(d){
                    if(d==0){
                        alert("文件过大!");
                        return false;
                    }
                    var h='<li id="logo-lis"><img src="/'+d+'"></li>';
                    $("#logo-uls").html(h);
                    $("#logo_input_img").val('/'+d);
                }
            });
        });

//使用优惠隐藏设置
        var rebate = $(".rebate:checked").val();
        if(rebate == 1){
            $(".zj_youhui").css('display','block');
        }else{
            $(".zj_youhui").css('display','none');
        }

        $(".rebate").on("click",function(){
            rebates = $(".rebate:checked").val();
            if(rebates == 1){
                $(".zj_youhui").css('display','block');
            }else{
                $(".zj_youhui").css('display','none');
            }
        })

//积分规则隐藏设置
        var supply_bonu = $(".supply_bonus:checked").val();
        if(supply_bonu == 1){
            $(".zj_jifen").css('display','block');
        }else{
            $(".zj_jifen").css('display','none');
        }

        $(".supply_bonus").on("click",function(){
            supply_bonus = $(".supply_bonus:checked").val();
            if(supply_bonus == 1){
                $(".zj_jifen").css('display','block');
            }else{
                $(".zj_jifen").css('display','none');
            }
        })

//佣金规则隐藏设置
        var brokerage = $(".brokerage:checked").val();
        if(brokerage == 1){
            $(".zj_yongjin").css('display','block');
        }else{
            $(".zj_yongjin").css('display','none');
        }

        $(".brokerage").on("click",function(){
            brokerages = $(".brokerage:checked").val();
            if(brokerages == 1){
                $(".zj_yongjin").css('display','block');
            }else{
                $(".zj_yongjin").css('display','none');
            }
        })

// 是否允许此卡升级为上级卡
        var superior = $(".superior:checked").val();
        if(superior == 1){
            $(".zj_shengji").css('display','block');
        }else{
            $(".zj_shengji").css('display','none');
        }

        $(".superior").on("click",function(){
            superiors = $(".superior:checked").val();
            if(superiors == 1){
                $(".zj_shengji").css('display','block');
            }else{
                $(".zj_shengji").css('display','none');
            }
        })
  
// 是否绑定上级会员卡
        var is_grading = $(".is_grading:checked").val();
        if(is_grading == 1){
            $(".shengji").css('display','block');
        }else{
            $(".shengji").css('display','none');
        }

        $(".is_grading").on("click",function(){
            is_gradings = $(".is_grading:checked").val();
            if(is_gradings == 1){
                $(".shengji").css('display','block');
            }else{
                $(".shengji").css('display','none');
            }
        })

// 持卡人有上级 
        var formulate = $(".formulate:checked").val();
        if(formulate == 1){
            $(".zj_guanxi").css('display','block');
        }else{
            $(".zj_guanxi").css('display','none');
        }

        $(".formulate").on("click",function(){
            formulates = $(".formulate:checked").val();
            if(formulates == 1){
                $(".zj_guanxi").css('display','block');
            }else{
                $(".zj_guanxi").css('display','none');
            }
        })

// 持卡人必须有上级 
        var shangji = $(".shangji:checked").val();
        if(shangji == 1){
            $(".zj_guanxi2").css('display','block');
        }else{
            $(".zj_guanxi2").css('display','none');
        }

        $(".shangji").on("click",function(){
            var shangjis = $(".shangji:checked").val();
            if(shangjis == 1){
                $(".zj_guanxi2").css('display','block');
            }else{
                $(".zj_guanxi2").css('display','none');
            }
        })

//判断不能为空
    $("#formdata").submit(function(){
        var logo = $("input[name='members[logo_url]']").val();
        var card_type =$("input[name='members[card_type]']").val();
        var brand_name=$("input[name='members[brand_name]']").val();
        var members_color = $(".members_color").val();
        var prerogative = $("textarea[name='members[prerogative]'").val();

        if(logo == ''){alert('会员卡logo没有上传！'); return false;}
        if(card_type == ''){alert('会员卡名没有填写！'); return false;}
        if(brand_name == ''){alert('品牌商名称没有填写！'); return false;}
        if(members_color == ''){alert('会员卡颜色没有选择！'); return false;}
        if(prerogative == ''){alert('会员卡使用说明没有填写！'); return false;}

        var rebate = $("input[name='members[rebate]']:checked").val();
        if(rebate == 1){
            var scope = $("input[name='members[scope]']").val();
            if(scope == ''){
                alert('本卡优惠，折扣优惠请填写完整！');
                return false;
            }
        }

        var supply_bonus = $("input[name='members[supply_bonus]']:checked").val();
        if(supply_bonus == 1){
            var bae1 = $("textarea[name='members[balance_rule]']").val();
            var bae2 = $("input[name='members[balance_corr_money]']").val();
            var bae3 = $("input[name='members[balance_corr_integral]']").val();
            var bae4 = $("input[name='members[balance_init]']").val();
            if(bae1 == ''){alert('会员卡积分规则没有填写！'); return false;}
            if(bae2 == ''){alert('持卡人最低消费额度没有填写！'); return false;}
            if(bae3 == ''){alert('会员卡积分比例设置没有填写！'); return false;}
            if(bae4 == ''){alert('会员卡初始积分没有填写！'); return false;}
        }


        var brokerage = $("input[name='members[brokerage]']:checked").val();
        if(brokerage == 1){
            var brok1 = $("textarea[name='members[brokerage_rule]']").val();
            var brok2 = $("input[name='members[brokerage_corr_money]']").val();
            var brok3 = $("input[name='members[brokerage_corr_integral]']").val();
            var brok4 = $("input[name='members[brokerage_init]']").val();
            if(brok1 == ''){alert('会员卡返现规则没有填写！'); return false;}
            if(brok2 == '' || brok3 == ''){
                alert('会员卡设置返现，每笔消费所返现金额规则没有填写完整！'); return false;
            }
            if(brok4 == ''){alert('领到此会员卡，钱包送多少金额，没有填写！'); return false;}
        }

        var is_grading = $("input[name='members[is_grading]']:checked").val();
        if(is_grading == 1){
            var members_card = $(".members_card").val();
            if(members_card == ''){
                alert('请选择会员卡上级！'); return false;
            }   
            var superior = $("input[name='members[superior]']").val();
            if(superior == 1){
                var condition1 = $("input[name='members[condition1]']").val();
                var condition2 = $("input[name='members[condition2]']").val();
                if(condition1 == '' || condition2 == ''){
                    alert('请将升级为上级卡的升级条件填写完整！'); return false;
                }
            }
        }

        var members_exec = $(".members_exec").val();
        if(members_exec == ''){
            alert('请选择品牌商！'); return false;
        }  

        var formulate = $("input[name='members[formulate]']:checked").val();
        if(formulate == 1){
        var shangji = $(".shangji:checked").val();
        if(shangji == 1){

            var f_supply = $("input[name='members[f_supply]']").val();
            var zuidi = $("input[name='members[zuidi]']").val();
            var zd = $("input[name='integral[zd]']").val();
            var xf = $("input[name='integral[xf]']").val();
            var jf = $("input[name='integral[jf]']").val();
            if(f_supply == ''){alert('领了此卡就给上级卡多少元元奖励请填写！'); return false;}
            if(zuidi == ''){
                alert('持卡人最低消费多少元元开始给上级佣金请填写！'); return false;
            }
            if(zd == '' || xf == '' || jf == ''){
                alert('持卡人每消费多少元给上级的积分规则请填写完整！'); return false;
            }
            
            var f_brokerage1 = $("input[name='members[f_brokerage1]']").val();
            var f_brokerage2 = $("input[name='members[f_brokerage2]']").val();
            var f_brokerage = $("input[name='members[f_brokerage]']").val();
            
            var f_broke_bonus = $("input[name='members[f_broke_bonus]']:checked").val();
            if(f_broke_bonus == 1){
                if(f_brokerage1 == '' || f_brokerage2 == ''){
                    alert('给上级的佣金规则请填写完整！'); return false;
                }
            }else{
                if(f_brokerage == ''){
                    alert('给上级的佣金规则请填写完整！'); return false;
                }
            }

        }  
    }

   })

    })

    </script>
@endsection
<style type="text/css">
.tishi{font-size: 12px;color:red}
.m_top{width: 800px;height: 200px;border-radius: 8px;margin:10px 0 10px 50px;padding: 10px}
.m_top>div{height: 100%;display: inline-block;overflow: hidden;}
.m_top_d1{width: 199px;border-right: 1px solid #fff}
.m_top_d2{width: 370px;}
.m_top_d3{width: 200px;}
#logo{width: 73px;margin-left: 62px;}
#logo-uls{width: 100%;height: 143px;}
#logo-lis{width: 140px;height: 140px;border-radius: 50%;-moz-border-radius:50%;-webkit-border-radius:50%;overflow: hidden;text-align: center;margin-left: -10px}
#logo-lis>img{width: 100%;height: 100%}
.m_top_d2>input{width: 200px;height: 35px;border: 1px solid #fff;border-radius: 5px;margin: 20px 0 0 20px;text-indent: 5px;}
.m_top_d2>input[name='members[card_type]']{margin-top: 30px}
.m_top_d2>input[name='members[brand_name]']{width: 300px;}
.members_color{width: 80%;height: 40px;margin-left: 19%;border-radius: 5px;}
.members_card,.members_exec{width: 310px;height: 40px;border-radius: 5px;margin-left: 50px;}
.left_top{width: 130px;height: 35px;display: inline-block;text-align: center;line-height: 35px;border-radius: 5px;border:1px solid #999;}
.left_top1{
        background: linear-gradient(to bottom, #adea83, #f8f8f8 30%, #79d545); 
        background: -webkit-linear-gradient(to bottom, #adea83, #f8f8f8 30%, #79d545); /* Safari 5.1 - 6 */
        background: -o-linear-gradient(to bottom, #adea83, #f8f8f8 30%, #79d545); /* Opera 11.1 - 12*/
        background: -moz-linear-gradient(to bottom, #adea83, #f8f8f8 30%, #79d545); /* Firefox 3.6 - 15*/
}
.left_top2{
        background: linear-gradient(to bottom, #ffc625, #f8f8f8 30%, #dba601); 
        background: -webkit-linear-gradient(to bottom, #ffc625, #f8f8f8 30%, #dba601); /* Safari 5.1 - 6 */
        background: -o-linear-gradient(to bottom, #ffc625, #f8f8f8 30%, #dba601); /* Opera 11.1 - 12*/
        background: -moz-linear-gradient(to bottom, #ffc625, #f8f8f8 30%, #dba601); /* Firefox 3.6 - 15*/
}
.left_top3{
        background: linear-gradient(to bottom, #ff5956, #f8f8f8 30%, #ff0000); 
        background: -webkit-linear-gradient(to bottom, #ff5956, #f8f8f8 30%, #ff0000); /* Safari 5.1 - 6 */
        background: -o-linear-gradient(to bottom, #ff5956, #f8f8f8 30%, #ff0000); /* Opera 11.1 - 12*/
        background: -moz-linear-gradient(to bottom, #ff5956, #f8f8f8 30%, #ff0000); /* Firefox 3.6 - 15*/
}

.xiekuang{  width: 800px;min-height: 50px;margin-left: 50px;border: 1px solid #666;
            padding: 10px;text-indent: 10px;border-radius: 20px 0 20px 0px;background: rgba(0,0,0,0.03);
            -moz-border-radius:20px 0 20px 0px;-webkit-border-radius:20px 0 20px 0px;}
.xiekuang>textarea{width: 99%;height: 45px;resize: none;outline: none;border: none;background: rgba(0,0,0,0.0001);}
.left_top_sradio{margin-left: 30px}
.left_top_sradio>.inputs{width: 15px;height: 15px;vertical-align: middle;margin-top: -3px;margin-right: 3px;margin-left:5px}
.zj_pinput{width: 800px;margin-left: 50px;}
.zj_pinput>input{width: 90px;text-align: center;border: none;outline: none;border-bottom: 1px solid #670101}
#zj_youhui_radio1,#zj_youhui_radio2,#zj_youhui_radio3,#zj_youhui_radio4,#zj_youhui_radio5,#zj_youhui_radio6{width: 15px;height: 15px;vertical-align: middle;margin-top: -3px;margin-right: 3px;margin-left: 118px;}
#zj_youhui_radio5,#zj_youhui_radio6{margin-left:10px;}
.portlet_span{margin-right: 50px}
.portlet_span>input{width: 90px;text-align: center;border: none;outline: none;border-bottom: 1px solid #670101}
#buttons{width: 50%;height: 35px;color: #fff;border: none;border-radius: 5px;margin-top: 50px;margin-left: 25%}
</style>

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '会员卡操作'}}</span>
                    </div>
                    <div class="actions">
                        <button class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</button>
                    </div>
                </div>
                <form method="post" action="{{route('manage_member_modifypost')}}" enctype="multipart/form-data" id="formdata"><br>

                    <!-- 头的部分 -->
                    <div class="m_top">
                        <div class="m_top_d1">
                            <ul id="logo-uls">
                                @if(!empty($modify->logo_url))
                                    <li id="logo-lis">
                                        <img src="{{$modify->logo_url or ''}}">
                                    </li> 
                                @else
                                    <li id="logo-lis">
                                        <img src="/img/hdj.png">
                                    </li> 
                                @endif
                            </ul>
                            <input type="hidden" name="members[logo_url]" id="logo_input_img" value="{{$modify->logo_url or '/img/hdj.png'}}" >
                            <input type="file" value="" id="logo" class='logo_input'>
                        </div>

                        <div class="m_top_d2">
                            <input type="text" name="members[card_type]" value="{{$modify->card_type or ''}}" required="required" placeholder="会员卡名">
                            <input type="text" name="members[brand_name]" value="{{$modify->brand_name or ''}}" required="required" maxlength="12" placeholder="品牌商名称">
                        </div>

                        <div class="m_top_d3">
                            <select class='members_color' name="members[color]">
                                @if(isset($color))
                                @foreach($color as $k=>$v)
                                    <option style="background: {{$k}};" value="{{$k}}" name="members[color]" @if(isset($modify)) @if($modify->color == $k) selected="selected" @endif @endif >{{$v}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- 使用说明 -->
                    <br><p class="left_top left_top1">使用说明</p>
                    <div class='xiekuang'>
                        <textarea  maxlength="80" placeholder="会员卡使用说明，最多80个字符！" name="members[prerogative]"  required="required">{{$modify->prerogative or ''}}</textarea>
                    </div>

                    <!-- 本卡优惠 -->
                    <p class="left_top left_top1">本卡优惠</p>
                    <span class="left_top_sradio">
                        <input type="radio" name="members[rebate]" value="1" class="inputs rebate"
                        @if(isset($modify)) 
                            @if($modify->rebate == '1') checked="checked" @endif 
                        @else
                            checked="checked"
                        @endif >允许优惠
                        <input type="radio" name="members[rebate]" value="0" class="inputs rebate"
                        @if(isset($modify)) @if($modify->rebate == '0') checked="checked" @endif @endif >不允许优惠
                    </span>

                    <div class='zj_youhui'>
                        <div class='zj_is_youhui'>
                            <p class="zj_pinput">
                                <input type="radio" name="members[discount]" value="1" id="zj_youhui_radio1" @if(isset($modify)) @if($modify->discount == '1') checked="checked" @endif @else  checked="checked" @endif >折扣
                                <span class="portlet_span">此类卡享受<input type="text" name="members[scope]" value="{{$modify->scope or '1'}}">折优惠</span>
                            </p> 

                            <p class="zj_pinput">
                                <input type="radio" name="members[discount]" value="2" id="zj_youhui_radio2" @if(isset($modify)) @if($modify->discount == '2') checked="checked" @endif @endif >商品最低价
                            </p> 
                        </div>
                    </div>

                    <p><span class="zj_pinput">是否让该会员卡显示在会员卡列表中：</span>
                        <input type="radio" name="members[display]" value="1" class="default_input" 
                        @if(isset($modify)) @if($modify->display == '1') checked="checked" @endif 
                        @else
                        checked="checked"
                        @endif >显示  &nbsp;
                        <input type="radio" name="members[display]" value="0" @if(isset($modify)) @if($modify->display == '0') checked="checked" @endif @endif >不显示
                    </p>

                    <!-- 积分规则 -->
                    <p class="left_top left_top1">积分规则</p>
                    <span class="left_top_sradio">
                        <input type="radio" name="members[supply_bonus]" value="1" class="inputs supply_bonus" 
                        @if(isset($modify)) 
                            @if($modify->supply_bonus == 1) 
                                checked="checked" 
                            @endif 
                        @else
                            checked="checked" 
                        @endif>允许积分 
                        <input type="radio" name="members[supply_bonus]" value="0" class="inputs supply_bonus" 
                        @if(isset($modify)) 
                            @if($modify->supply_bonus == 0) 
                                checked="checked" 
                            @endif 
                        @endif >不允许积分
                    </span>
                    <div class='zj_jifen'>

                        <div class='xiekuang'>
                            <textarea  maxlength="80" placeholder="积分规则最多80个字符！" name="members[balance_rule]">{{$modify->balance_rule or ''}}</textarea>
                        </div>

                        <p class="zj_pinput">持卡人最低消费 <input type="number" name="members[balance_corr_money]" value="{{$modify->balance_corr['balance_corr_money'] or '0'}}" step="0.01">元，开始累积积分 ( 0 默认消费就有积分)</p> 

                        <p class="zj_pinput"><input type="text" name="members[balance_corr_integral]" value="{{$modify->balance_corr['balance_corr_integral'] or ''}}">元=1积分</p>

                        <p class="zj_pinput">领到此会员卡，初始就有<input type="text" name="members[balance_init]" value="{{$modify->balance_init or '0'}}">积分</p> 
                    </div>
                    <p></p>
                    <!-- 返现规则 -->
                    <p class="left_top left_top1">设置返现</p>
                    <span class="left_top_sradio">
                        <input type="radio" name="members[brokerage]" value="1" class="inputs brokerage" 
                        @if(isset($modify)) @if($modify->brokerage == 1) checked="checked" @endif 
                        @else
                            checked="checked" 
                        @endif >允许消费返现
                        <input type="radio" name="members[brokerage]" value="0" class="inputs brokerage"  
                        @if(isset($modify)) @if($modify->brokerage == 0) checked="checked" @endif @endif >不允许消费返现
                    </span>
                    <div class='zj_yongjin'>

                        <div class='xiekuang'>
                            <textarea  maxlength="80" placeholder="返现规则最多80个字符！" name="members[brokerage_rule]">{{$modify->brokerage_rule or ''}}</textarea>
                        </div>

                        <p class="zj_pinput">每笔消费满 <input type="number" name="members[brokerage_corr_money]" value="{{$modify->brokerage_corr['brokerage_corr_money'] or ''}}" step="0.01"> 元，返现金 

                        <input type="text" name="members[brokerage_corr_integral]" value="{{$modify->brokerage_corr['brokerage_corr_integral'] or ''}}">元</p>

                        <p class="zj_pinput">领到此会员卡，钱包就送<input type="text" name="members[brokerage_init]" value="{{$modify->brokerage_init or '0'}}">元钱 (默认为0)</p> 
                    </div>
                    <p></p>

                    <!-- 会员卡升级规则 -->
                    <p class="left_top left_top2">会员卡升级规则</p>
                    
                    <p class="zj_pinput">
                    <span class="portlet_span">是否绑定上级会员卡：</span>
                        <input type="radio" name="members[is_grading]" id="zj_youhui_radio5" value="1" class="inputs is_grading"
                        @if(isset($modify)) 
                            @if($modify->is_grading == '1') checked="checked" @endif 
                        @else
                         checked="checked"
                        @endif >是
                        <input type="radio" name="members[is_grading]" id="zj_youhui_radio6" value="0" class="inputs is_grading" @if(isset($modify)) @if($modify->is_grading == '0') checked="checked" @endif @endif >否
                    </p>

                    <div class='shengji'>
                        <p class="zj_pinput"><b>此卡选择上级卡</b></p>
                        <select class='members_card' name="members[top_card]">
                             <option value="">请选择...</option>
                             @foreach($cards as $v)
                                <option value="{{$v->member_id}}"
                                 @if(isset($modify)) 
                                    @if($modify->top_card == $v->member_id) selected = "selected" 
                                    @endif 
                                @endif >
                                {{$v->card_type}}
                                </option>
                            @endforeach
                        </select>

                        <p class="zj_pinput" style="margin-left: 15px">
                            <span class="left_top_sradio">是否允许此卡升级为上级卡
                                <input type="radio" name="members[superior]" value="1" class="inputs superior" 
                                @if(isset($modify)) 
                                    @if($modify->superior == '1') checked="checked" @endif 
                                @else checked="checked"
                                @endif >此卡允许升级
                                <input type="radio" name="members[superior]" value="0" class="inputs superior" 
                                @if(isset($modify)) @if($modify->superior == '0') checked="checked" @endif @endif >此卡不允许升级
                            </span>
                        </p>
                        <div class="zj_shengji">
                            <p class="zj_pinput"><b>升级条件</b></p>

                            <p class="zj_pinput" style="margin-left: 15px">
                                <span class="left_top_sradio">是否自动升级上级卡
                                    <input type="radio" name="members[automatic]" value="1" class="inputs" 
                                    @if(isset($modify)) 
                                        @if($modify->automatic == '1') checked="checked" @endif 
                                    @else checked="checked"
                                    @endif >允许自动升级
                                    <input type="radio" name="members[automatic]" value="0" class="inputs" 
                                    @if(isset($modify)) @if($modify->automatic == '0') checked="checked" @endif @endif >不允许自动升级
                                </span>
                            </p>

                            <p class="zj_pinput">持卡人 单笔 消费 <input type="number" name="members[condition1]" value="{{$modify->condition['condition1'] or ''}}" step="0.01"> 元，升级成高级卡</p> 

                            <p class="zj_pinput">持卡人 累计 消费 <input type="number" name="members[condition2]" value="{{$modify->condition['condition2'] or ''}}" step="0.01"> 元，升级成高级卡</p> 
                        </div>
                    </div>

                    <!-- 品牌商选择 -->
                    <p class="left_top left_top2">品牌商选择</p>
                        <div style="margin-bottom: 20px">
                        <p class="zj_pinput"><b>品牌商选择</b></p>
                        <select class='members_exec' name="members[exec_id]">
                             <option value="">请选择...</option>
                             @if(isset($exec))
                                @foreach($exec as $v)
                                    <option value="{{$v->id}}" 
                                    @if(isset($modify)) 
                                        @if($modify->exec_id == $v->id) selected = "selected" 
                                        @endif 
                                    @endif >
                                    {{$v->nickname or ''}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        </div>


                    <!-- 会员之间的关系 -->
                    <p class="left_top left_top3">会员之间的关系</p>
                    <span class="left_top_sradio">
                        <input type="radio" name="members[formulate]" value="1" class="inputs formulate" @if(isset($modify)) 
                        @if($modify->formulate == '1') checked="checked" @endif 
                        @else
                            checked="checked" 
                        @endif >持卡人有推荐人
                        <input type="radio" name="members[formulate]" value="0" class="inputs formulate" @if(isset($modify)) @if($modify->formulate == '0') checked="checked" @endif @endif >持卡人没有推荐人
                    </span>


                    <div class='zj_guanxi'>

                        <p class="zj_pinput" style="margin-left: 20px">
                            <span class="left_top_sradio">是否必须有推荐人
                                <input type="radio" name="members[shangji]" value="1" class="inputs shangji" 
                                @if(isset($modify)) 
                                    @if($modify->shangji == '1') checked="checked" @endif 
                                @else checked="checked"
                                @endif >必须有
                                <input type="radio" name="members[shangji]" value="0" class="inputs shangji" 
                                @if(isset($modify)) @if($modify->shangji == '0') checked="checked" @endif @endif >可以没有
                            </span>
                        </p>
                        <div class="zj_guanxi2">
                        <!-- 关系全改 -->
                        <p class="zj_pinput">领了此卡，就给上级卡 <input type="number" name=" members[f_supply]" value="{{$modify->f_supply or '0'}}" step="0.01"> 元奖励 (默认0元)</p> 

                        <p class="zj_pinput">持卡人最低消费 
                        <input type="number" name="members[zuidi]" value="{{$modify->f_brokerage['zuidi'] or '0'}}" step="0.01">
                        元，开始给上级佣金 (0默认只要消费就给上级佣金)</p> 

                        <p class="zj_pinput">
                            <p class="zj_pinput">
                                <input type="radio" name="members[f_broke_bonus]" value="1" id="zj_youhui_radio3"  @if(isset($modify)) @if($modify->f_broke_bonus == 1) checked="checked" @endif @else checked="checked" @endif>持卡人消费每满 <input type="number" name="members[f_brokerage1]" value="{{$modify->f_brokerage['f_brokerage1'] or ''}}" step="0.01"> 元，就给上级<input type="number" name="members[f_brokerage2]" value="{{$modify->f_brokerage['f_brokerage2'] or ''}}" step="0.01"> 元佣金
                            </p> 
                            <p class="zj_pinput">
                                <input type="radio" name="members[f_broke_bonus]" value="2" id="zj_youhui_radio4" @if(isset($modify)) @if($modify->f_broke_bonus == 2) checked="checked" @endif @endif>持卡人只要消费，就按本次消费总金额的百分之 <input type="number" name="members[f_brokerage]" value="{{$modify->f_brokerage['f_brokerage'] or ''}}" step="0.01"> 给上级佣金
                            </p> 
                        </p> 

                        <p class="zj_pinput">持卡人最低消费 <input type="number" name="integral[zd]" value="{{$modify->f_balance['zd'] or '0'}}" step="0.01"> 元，开始给上级积分 (0默认只要消费就给上级积分)</p> 

                        <p class="zj_pinput">
                            <p class="zj_pinput">
                                持卡人每消费 
                                <input type="text" name="integral[xf]" value="{{$modify->f_balance['xf'] or ''}}" step="0.01">
                                元，就给上级累积
                                <input type="text" name="integral[jf]" value="{{$modify->f_balance['jf'] or ''}}" step="0.01">
                                积分
                            </p> 
                        </p> 
                        </div>
                    </div>
                        <input type="hidden" name="member_id" value="{{$modify->member_id or ''}}">
                    <div>
                        <button id="buttons" class="btn blue btn-xs tap-allurl">@if(empty($modify->member_id)) 制作会员卡 @else 确认修改 @endif </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


@endsection
