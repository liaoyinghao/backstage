@extends('manage.common.master')
@section('userjs')
    <script>

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
        .userk{text-align: right;width: 250px;display: inline-block;}
        .textarea{width: 300px;height: 100px;}

        .form_d{width: 100%;margin-top: 10px;border-left: 1px solid #999}
        .form_d_1{display: inline-block;width: 45%;}
        .form_d_2{display: inline-block;width: 50%;vertical-align: top;}
        .form_p>input{width: 200px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_d_2>textarea{width: 90%;}
        .genjin{margin-top: 30px;}
        .portlet-body{text-align: center;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">项目名称：{{$info['proname'] or ''}}</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_project_updatastatus')}}">
                    <input type="hidden" name="id" value="{{$info['id'] or ''}}">
                    <input type="hidden" name="type" value="3">

                    <p class="form_p">
                      <span class="userk">需要该项目进行的状态：</span>
                      <select name='status' class="job" required="required">
                        @if(isset($user))
                        @if(isset($user['type']) && $user['type'] == 4)       <!-- 总经理 -->
                                <option value="1">确认中</option>
                                <option value="2">进行中</option>
                                <option value="3">完成</option>
                                <option value="4">申请退</option>
                            @elseif(isset($user['type']) && $user['type'] == 3)   <!-- 财务 -->
                                <option value="2">进行中</option>
                            @elseif(isset($user['type']) && $user['type'] == 2)   <!-- 客服 -->
                                <option value="3">完成</option>
                            @else
                        @endif
                        @endif
                      </select>
                    </p>

                    @if(isset($user) && $user['type'] == 3)
                    <p class="form_p">
                      <span class="userk">选择需要确认该项目的客服人员：</span>
                      <select name='kfid' class="job" required="required">
                        @if(isset($list))
                            @foreach($list as $val)
                              <option value="{{$val['id']}}">{{$val['nickname'] or $val['username']}}</option>  
                            @endforeach
                        @endif
                      </select>
                    </p>
                    @endif
                    
                    <p class="submit_p"><input type="submit" value="确认转成项目" class="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
