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
        .portlet-body{padding: 20px 0 20px 0}
        .form_p input{  width: 300px;
                        height: 35px;
                        border-radius: 5px;
                        border: 1px solid #999;
                        text-indent: 10px;
                        margin-left: 5px;}
        .submit{width: 200px;
                height: 35px;
                background: #3598dc;
                color: #fff;
                border: none;
                border-radius: 2px;}
        .job{width: 300px;height: 35px;border-radius: 5px;}
        .userk{text-align: right;width: 150px;display: inline-block;}
        .centers{text-align: center;margin-top: 50px;}
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
                    
                    @if(isset($ltype)) <!-- 如果定义了，就是修改密码，开始 -->
                    <p class="form_p">
                        <span class="userk">账号：</span><input type="text" value="{{$user['username'] or ''}}" readonly="readonly">
                    </p>
                    <p class="form_p">
                        <span class="userk">请输入您的新密码：</span><input type="password" name="password" value="" placeholder="******" required="required">
                    </p>
                    @else
                    <p class="form_p">
                        <span class="userk">用户名：</span><input type="text" name="name" value="{{$user['username']}}" placeholder="输入用户名" required="required">
                    </p>
                    <p class="form_p">
                        <span class="userk">密  码：</span><input type="password" name="password" value="" placeholder="请输入新密码" required="required">
                    </p>
                    <p class="form_p">
                      <span class="userk">所属职位：</span><select name= 'job' value="{{$user['position']}}" class="job">
                        <option  value='总经理'   name ="generalmanager" @if($user['position']=='总经理')  selected="selected" @endif >总经理</option>
                        <option  value='销售主管' name ="salesmanager" @if($user['position']=='销售主管')  selected="selected" @endif >销售主管</option>
                        <option  value='销售'     name="minister" @if($user['position']=='销售')  selected="selected" @endif >销售</option>
                        <option  value='客服主管' name="production" @if($user['position']=='客服主管')  selected="selected" @endif >客服主管</option>
                        <option  value='客服'     name="quality" @if($user['position']=='客服')  selected="selected" @endif >客服</option>
                        <option  value='财务'     name="workshop" @if($user['position']=='财务')  selected="selected" @endif >财务</option>
                      </select>
                    </p>
                    <p class="form_p">
                        <span class="userk">帐号昵称：</span><input type="text" name="nickanme" value="{{$user['nickname']}}" placeholder="输入昵称" required="required">
                    </p>

                    @endif <!-- 如果定义了，就不是总经理，结束 -->

                    <input type='hidden'  name= 'id' value='{{$id}}'>
                    <p class="centers"><input type="submit" value="确认修改" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
