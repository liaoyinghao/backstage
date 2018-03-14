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
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline" href="{{route('manage_customer_main',['type'=>'qi'])}}">超过七天未更新跟进信息</a>
                        <a class="btn blue btn-outline" href="{{route('manage_customer_khadd')}}"> 查看组员客户信息</a>
                        <a class="btn blue btn-outline" href="{{route('manage_customer_khadd')}}"> 查看全部客户</a>
                        <a class="btn blue btn-outline" href="{{route('manage_customer_khadd')}}"><i class="fa fa-plus"></i> 客户录入</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>客户姓名</th>
                            <th>联系方式</th>
                            <th>报价</th>
                            <th>客户评级</th>
                            <th>谁的客户</th>
                            <th>客户状态</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <td>1</td>
                            <td>廖应浩</td>
                            <td>15172454646</td>
                            <td>5800000.00</td>
                            <td>5星</td>
                            <td>潘天南</td>
                            <td>正常</td>
                            <td>2018-03-14</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn blue btn-xs"><a style="color:#fff;text-decoration:none" href="{{route('manage_customer_khdetails')}}">编辑资料</a></button>
                                </div>
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
