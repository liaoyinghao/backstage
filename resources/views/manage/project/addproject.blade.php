@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

        });
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
        .textarea{width: 300px;height: 100px;}

        .form_d{width: 100%;margin-top: 10px;border-left: 1px solid #999}
        .form_d_1{display: inline-block;width: 45%;}
        .form_d_2{display: inline-block;width: 50%;vertical-align: top;}
        .form_p>input{width: 200px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_d_2>textarea{width: 90%;}
        .genjin{margin-top: 30px;}

    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">修改客户状态为项目状态</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_project_addprojectpost')}}">
                    <input type="hidden" name="id" value="{{$start['id'] or ''}}">
                    <input type="hidden" name="aid" value="{{$aid or ''}}">

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
                    <p class="form_p">
                        <span class="userk">已付定金：</span><input type="number" name="start[paiddeposit]" step="0.01" value="{{$start['paiddeposit'] or ''}}" placeholder="输入金额" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">底价：</span><input type="number" name="start[floorprice]" step="0.01" value="{{$start['floorprice'] or ''}}" placeholder="输入金额" required="required">
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
                      <span class="userk">选择需要确认该项目的财务人员：</span>
                      <select name='start[cwid]' class="job" required="required">
                        @if(isset($list))
                            @foreach($list as $val)
                              <option value="{{$val['id']}}" @if(isset($start['cwid']) && $start['cwid']==$val['id']) selected="selected" @endif">{{$val['nickname'] or $val['username']}}</option>
                            @endforeach
                        @endif
                      </select>
                    </p>
                    

                    <p class="submit_p"><input type="submit" value="确认" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
