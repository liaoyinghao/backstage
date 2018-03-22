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
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn blue btn-outline">查看全部事件</a>
                        <a class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>标题</th>
                            <th>时间</th>
                            <th>备注</th>
                            <th>事件</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="50px">1</td>
                                <td>某某某</td>
                                <td>2018-12-13 15:12</td>
                                <td>思思思</td>
                                <td>某某某</td>
                                <td>
                                    <button class="btn btn-danger btn-xs">未完成</button>
                                    <!-- <button class="btn success btn-xs">已完成</button> -->
                                </td>
                                <td>
                                   <div class="btn-group">
                                      <button type="button" class="btn blue btn-xs">
                                            <a href="{{route('manage_calendar_eventdetails')}}" class="pfp">修改事件</a>
                                      </button>
                                      <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                      <ul class="dropdown-menu pull-right" role="menu">
                                          <li>
                                            <a href="">已完成</a>
                                          </li>
                                      </ul>
                                  </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
