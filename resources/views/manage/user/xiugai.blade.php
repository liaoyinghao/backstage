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
        .job{width: 300px;height: 35px;border-radius: 5px;}
        .userk{text-align: right;width: 100px;display: inline-block;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 修改用户</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="post" action="{{route('manage_user_userxiugai')}}">

                    <p class="form_p">
                        <span class="userk">用户名：</span><input type="text" name="name" value="{{$user['username']}}" placeholder="输入用户名">
                    </p>
                    <p class="form_p">
                        <span class="userk">密  码：</span><input type="password" name="password" value="{{$user['password']}}" placeholder="请输入新密码">
                    </p>
                    <p class="form_p">
                      <span class="userk">所属职位：</span><select name= 'job' value="{{$user['position']}}" class="job">
                        <option  value='总经理'  name ="generalmanager">总经理</option>
                        <option  value='销售主管'    name ="salesmanager">销售主管</option>
                        <option  value='销售'  name="minister">销售</option>
                        <option  value='客服主管' name="production">客服主管</option>
                        <option  value='客服' name="quality">客服</option>
                        <option  value='财务' name="workshop">财务</option>
                      </select>
                    </p>
                    <p class="form_p">
                        <span class="userk">帐号昵称：</span><input type="text" name="nickanme" value="{{$user['nickname']}}" placeholder="输入昵称">
                    </p>
                    <input type='hidden'  name= 'id' value='{{$id}}'>
                    <p><input type="submit" value="确认修改" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
