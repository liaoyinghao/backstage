@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $("#tianjia").on("click",function(){
                var hang = $("#hang").val();
                    hang = parseInt(hang) + 1;
                var div = ' <div class="form_d">'+
                                '<div class="form_d_1">'+
                                    '<span class="userk">选择时间：</span><input type="date" name="stoer[time'+hang+']" required="required">'+
                                '</div>'+
                                '<div class="form_d_2">'+
                                    '<textarea name="stoer[main'+hang+']"" required="required"></textarea>'+
                                '</div>'+
                            '</div>';
                $("#formkh").append(div);
                $("#hang").val(hang);
            })

        });


    </script>
@endsection

@section('content')
    <style type="text/css">
        .submit_p{width: 100%;margin-top: 50px !important;}
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
        .form_d_b{border: none;}
        .form_d_1{width: 45%;}
        .form_d_2{width: 50%;vertical-align: top;}
        .form_p>input{width: 300px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_d_2>textarea{width: 72%;margin: 15px 0 35px 24%;}
        .genjin{margin-top: 30px;}
        .form_d_1>input{width: 200px;height: 35px;border-radius: 5px;border: 1px solid #999;}
        #sy_width{display: block;width: 1050px;}
        .yigenjin{position: absolute;top: 80px;left: 55%;width: 500px;height: auto;border: 1px solid #ccc;box-shadow: 0 0 10px 1px #999;padding: 5px 0 20px 0}
        .yigenjin_pst{padding-left: 5px;}
        .userk_input{
            width: 50% !important;
        }
        .userk_textarea{
            width: 72% !important;
            margin: 15px 0 35px 38% !important;
        }
        .form_d_st1{
            width: 90%;
        }
        .form_d_st2{
            width: 80%;
        }
    </style>

    <div class="row" id="sy_width">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">修改客户跟进信息</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline" id="tianjia">添加客户跟进信息</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_customer_followuppost')}}">
                    <input type="hidden" name="zid" value="{{$zid or ''}}" placeholder="组员">
                    <input type="hidden" name="id" value="{{$start['id'] or ''}}">
                    <input type="hidden" id="hang" value="{{$count or '1'}}">

                    <p class="form_p">
                        <span class="userk">客户姓名：</span><input type="text" name="start[name]" value="{{$start['name'] or ''}}" placeholder="客户姓名" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">联系方式：</span><input type="text" name="start[info]" value="{{$start['info'] or ''}}" placeholder="电话或邮箱等其他" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">客户需求：</span>
                        <textarea name="start[demand]" placeholder="输入客户需求" class="textarea">{{$start['demand'] or ''}}</textarea>
                    </p>
                    <p class="form_p">
                        <span class="userk">报价(单位:元)：</span><input type="number" name="start[offer]" step="0.01" value="{{$start['offer'] or ''}}" placeholder="输入金额" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">备注：</span>
                        <textarea name="start[remarks]" placeholder="备注" class="textarea">{{$start['remarks'] or ''}}</textarea>
                    </p>
                    <p class="form_p">
                      <span class="userk">客户评级(单位:星)：</span><select name='start[grade]' class="job">
                        <option  value='D' @if(isset($start)) @if($start['grade']=='D') selected="selected" @endif @else selected="selected"  @endif >D</option>
                        <option  value='C' @if(isset($start) && $start['grade']=='C') selected="selected"  @endif >C</option>
                        <option  value='B' @if(isset($start) && $start['grade']=='B') selected="selected"  @endif >B</option>
                        <option  value='A' @if(isset($start) && $start['grade']=='A') selected="selected"  @endif >A</option>
                        <option  value='S' @if(isset($start) && $start['grade']=='S') selected="selected"  @endif >S</option>
                      </select>
                    </p>
                    <p class="form_p">
                      <span class="userk">客户状态：</span><select name='start[status]' class="job">
                        <option  value='1' @if(isset($start)) @if($start['status']==1) selected="selected" @endif @else selected="selected"  @endif >正常</option>
                        <option  value='0' @if(isset($start)) @if($start['status']==0) selected="selected" @endif @endif >放弃</option>
                      </select>
                    </p>

                    <p class="genjin">客户跟进信息：</p>


                    <div class="yigenjin">

                        @if(isset($progress) && !empty($progress))
                            <p class="yigenjin_pst">已跟进信息：</p>
                            @foreach($progress as $key=>$val)
                                <div class="form_d form_d_b">
                                    <div class="form_d_1 form_d_st1">
                                        <span class="userk">选择时间：</span><input type="date" name="stoer[{{$val['timename'] or ''}}]" value="{{$val['time'] or ''}}" required="required" class="userk_input">
                                    </div>
                                    <div class="form_d_2 form_d_st2">
                                        <textarea name="stoer[{{$val['mainname'] or ''}}]" required="required" class="userk_textarea">{{$val['main'] or ''}}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>




                    <div id="formkh">

                        @if(isset($progress) && !empty($progress))
                            <!-- @foreach($progress as $key=>$val)
                                <div class="form_d">
                                    <div class="form_d_1">
                                        <span class="userk">选择时间：</span><input type="date" name="stoer[{{$val['timename'] or ''}}]" value="{{$val['time'] or ''}}" required="required">
                                    </div>
                                    <div class="form_d_2">
                                        <textarea name="stoer[{{$val['mainname'] or ''}}]" required="required">{{$val['main'] or ''}}</textarea>
                                    </div>
                                </div>
                            @endforeach -->
                        @else
                            <div class="form_d">
                                <div class="form_d_1">
                                    <span class="userk">选择时间：</span><input type="date" name="stoer[time1]" value="">
                                </div>
                                <div class="form_d_2">
                                    <textarea name="stoer[main1]"></textarea>
                                </div>
                            </div>
                        @endif       
                        
                        
                    </div>  

                    
                    
                    <p class="submit_p"><input type="submit" value="确认跟进" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
