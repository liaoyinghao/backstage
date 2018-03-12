@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });
        });


    </script>
@endsection

@section('content')
    <style type="text/css">
        .portlet-body{text-align: center;padding: 20px 0 20px 0}
        .form_p input{  width: 300px;
                        height: 35px;
                        border-radius: 5px;
                        border: 1px solid #999;
                        text-indent: 10px;
                        margin-left: 5px;}
        .submit{width: 150px;
                height: 30px;
                background: #3598dc;
                color: #fff;
                border: none;
                border-radius: 5px;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 注册新用户</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="post" action="{{route('manage_user_userzhuce')}}">

                    <p class="form_p">
                        用户名：<input type="text" name="name" value="" placeholder="输入用户名">
                    </p>
                    <p class="form_p">
                        密  码：<input type="password" name="password" value="" placeholder="请输入密码">
                    </p>
                    <p class="form_p">
                      所属职位：<select name= 'job'>
                        <option  value='总经理'  name ="generalmanager">总经理</option>
                        <option  value='销售经理'    name ="salesmanager">销售经理</option>
                        <option  value='技术部长'  name="minister">技术部长</option>
                        <option  value='生产部长' name="production">生产部长</option>
                        <option  value='采购主管' name="purchase">采购主管</option>
                        <option  value='品质主管' name="quality">品质主管</option>
                        <option  value='车间主任' name="workshop">车间主任</option>
                        <option  value='财务主管' name="finance">财务主管</option>
                        <option  value='人事行政主管' name="personnel ">人事行政主管</option>
                        <option  value='职员'  name="staff">职员</option>
                      </select>
                    </p>
                    <p class="form_p">
                        帐号昵称：<input type="text" name="nickanme" value="" placeholder="输入昵称">
                    </p>

                    <p><input type="submit" value="确认注册" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
