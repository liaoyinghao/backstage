@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){
            $(function(){
                $("#tianjiai").on("click",function(){
                    var count = $("#paiddepositcount").val();
                    var div = '<div class="form_p form_divi"><span class="userk">已付定金：</span><input type="number" name="start[paiddeposit][]" step="0.01" value="" placeholder="输入金额" required="required"></div>';
                    $("#form_tj").append(div);
                    hang = parseInt(count) + 1;
                    $("#paiddepositcount").val(hang);
                })
            })
        });
        function check(){
          var sum = 0;
          $("input[name='start[paiddeposit][]']").each(function(){
            sum += $(this).val();
          })
          if(parseInt(sum) >= parseInt($("input[name='start[contractamount]']").val())){
            var r=confirm("确认项目是否完成");
            if (r==true)
              {
              var div = '  <input type="hidden" name="start[status]" value="3" id = "status">';
              $("#form_tj").append(div);
                // console.log($("#status").val());
                // return false;
              }
            else
              {
                console.log("You pressed Cancel!")
              }
            // return false;
          }
        }
    </script>
@endsection

@section('content')
    <style type="text/css">
        .submit_p{width: 100%;text-align: center;margin-top: 50px !important;}
        .submit{width: 300px;
                height: 30px;
                background: #3598dc;
                color: #fff;
                border: none;
                border-radius: 1px;
                margin-top: 20px;
                }
        .job{width: 300px;height: 35px;border-radius: 5px;}
        .userk{text-align: right;width: 150px;display: inline-block;}
        .textarea{width: 300px;height: 80px;vertical-align:top}

        .form_d{width: 100%;margin-top: 10px;border-left: 1px solid #999}
        .form_d_1{display: inline-block;width: 45%;}
        .form_d_2{display: inline-block;width: 50%;vertical-align: top;}
        .form_p>input{width: 250px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_divi{margin-top: 20px;}
        .form_d_2>textarea{width: 90%;}
        .genjin{margin-top: 30px;}
        .form_tj{position: relative;}
        #tianjiai{  top: 3px;
                    left: 420px;
                    cursor: pointer;
                    display: inline-block;
                    width: 25px;
                    height: 25px;
                    background: #ccc;
                    font-size: 20px;
                    text-align: center;
                    line-height: 25px;
                    position: absolute;
                    color: #fff;
                    z-index: 5;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                    @if(isset($type))
                        <span class="caption-subject bold uppercase">查看项目</span>
                    @else
                        @if(isset($aid))
                            <span class="caption-subject bold uppercase">将客户状态转为项目</span>
                        @elseif(isset($did))
                            <span class="caption-subject bold uppercase">将客户状态转为项目</span>
                        @else
                            <span class="caption-subject bold uppercase">修改项目</span>
                        @endif
                    @endif

                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_project_addprojectpost')}}"  onsubmit="return check()">
                    <input type="hidden" name="id" value="{{$start['id'] or ''}}">
                    <input type="hidden" name="aid" value="{{$aid or ''}}">
                    <input type="hidden" name="did" value="{{$did or ''}}">

                    <p class="form_p">
                        <span class="userk">项目名称：</span><input type="text" name="start[proname]" value="{{$start['proname'] or ''}}" placeholder="项目名称" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">客户姓名：</span><input type="text" name="start[customername]" value="{{$start['customername'] or ''}}" placeholder="客户姓名" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">联系方式：</span><input type="text" name="start[contact]" value="{{$start['contact'] or ''}}" placeholder="联系方式" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">项目内容：</span>
                        <textarea name="start[projectcontent]" placeholder="项目内容" class="textarea" required="required">{{$start['projectcontent'] or ''}}</textarea>
                    </p>
                    <p class="form_p">
                        <span class="userk">合同金额：</span><input type="number" name="start[contractamount]" step="0.01" value="{{$start['contractamount'] or ''}}" placeholder="输入金额" required="required">
                    </p>
                    <p class="form_p form_tj">
                        @if(isset($aid))
                            <div class="form_p form_divi"><span class="userk">已付定金：</span><input type="number" name="start[paiddeposit]" step="0.01" value="{{$start['paiddeposit'] or '0'}}" placeholder="输入金额" required="required"></div>
                        @elseif(isset($did))
                        <div class="form_p form_divi"><span class="userk">已付定金：</span><input type="number" name="start[paiddeposit]" step="0.01" value="{{$start['paiddeposit'] or '0'}}" placeholder="输入金额" required="required"></div>
                        @else
                            <span id="tianjiai">+</span>
                            <input type="hidden" id="paiddepositcount" value="{{$start['paiddepositcount'] or 0}}" />
                           @if(!empty($start['paiddeposit']))
                                @foreach($start['paiddeposit'] as $key=>$val)
                                    <div class="form_p form_divi"><span class="userk">已付定金：</span><input type="number" name="start[paiddeposit][]" step="0.01" value="{{$val or 0}}" placeholder="输入金额" required="required" readonly unselectable="on"></div>
                                @endforeach
                           @else
                                <div class="form_p form_divi"><span class="userk">已付定金：</span><input type="number" name="start[paiddeposit][]" step="0.01" value="0" placeholder="输入金额" required="required"></div>
                           @endif

                        @endif

                    </p>
                    <p class="form_p" id="form_tj"></p>
                    <p class="form_p">
                        <span class="userk">底价：</span><input type="number" name="start[floorprice]" step="0.01" value="{{$start['floorprice'] or '0'}}" placeholder="输入金额" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">签单时间：</span><input type="date" name="start[signingtime]" value="{{$start['signingtime'] or ''}}">
                    </p>
                    <p class="form_p">
                        <span class="userk">付款时间：</span><input type="date" name="start[timepayment]" value="{{$start['timepayment'] or ''}}">
                    </p>
                    <p class="form_p">
                        <span class="userk">备注：</span>
                        <textarea name="start[remarks]" placeholder="备注" class="textarea">{{$start['remarks'] or ''}}</textarea>
                    </p>


                    <p class="form_p">
                      <span class="userk">选择确认的客服人员：</span>
                      <select name='start[kfid]' class="job" required="required">
                        @if(isset($list))
                            @foreach($list as $val)
                              <option value="{{$val['id']}}" @if(isset($start['kfid']) && $start['kfid']==$val['id']) selected="selected" @endif">{{$val['nickname'] or $val['username']}}</option>
                            @endforeach
                        @endif
                      </select>
                    </p>

                    @if(!isset($type))
                    <p class="submit_p"><input type="submit" value="确认" class="submit"></p>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
