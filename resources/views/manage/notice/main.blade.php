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
li{list-style-type: none;}
.pfp{color:#fff;text-decoration:none}
.neirong{max-width: 333px;max-height: 38px;display: block;overflow: hidden;}
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline" href="{{route('manage_notice_addnotice')}}"><i class="fa fa-plus"></i> 添加通知(只有总经理才能添加，去掉这行字)</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">id</th>
                            <th>发送者</th>
                            <th>标题</th>
                            <th>内容</th>
                            <th>状态</th>
                            <th>通知开始时间</th>
                            <th>通知结束时间</th>
                            <th>查看详情</th>
                        </tr>
                        </thead>
                        <tbody>   

                            <tr>
                                <td>1</td>
                                <td>总经理名字</td>
                                <td>后天开会</td>
                                <td><span class="neirong">开会通知</span></td>
                                <!-- 通知状态按照时间定：未开始，进行中，已过期 -->
                                <td><button class="btn btn-danger btn-xs">进行中</button></td>
                                <td>2018-3-21</td>
                                <td>2018-3-28</td>
                                <td><a href="{{route('manage_notice_addnotice',['id'=>1])}}">查看详情</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
