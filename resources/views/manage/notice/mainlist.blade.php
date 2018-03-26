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
<<<<<<< HEAD
                        <tbody>
                            @if(isset($lists))
                            @foreach($lists as $v)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$user[$v->fsid]}}</td>
                                <td>{{$v->title}}</td>
                                <td><span class="neirong">{{$v->progress}}</span></td>
                                <!-- 通知状态按照时间定：未开始，进行中，已过期 -->
                                <td>
                                @if($time > $v->kstime && $time < $v->jstime)
                                <button class="btn btn-danger btn-xs">
                                进行中
                                </button>
                                @endif

                                @if($time < $v->kstime )
                                <button class="btn btn-success btn-xs">
                                未开始
                                </button>
                                @endif

                                @if($time > $v->jstime )
                                <button class="btn warning btn-xs">
                                已过期
                                </button>
                                @endif
                                </td>
                                <td>{{$v->kstime}}</td>
                                <td>{{$v->jstime}}</td>
                                <td><a href="{{route('manage_notice_addnotice',['flag'=>2,'kid'=>$v->id])}}">查看详情</a></td>
                            </tr>
                            @endforeach
                            @endif
=======
                        <tbody>   

                            <tr>
                                <td>1</td>
                                <td>总经理名字</td>
                                <td>明天开会</td>
                                <td><span class="neirong">开会通知开会通知开会通知开会通知开会通知开会通知开会通知开会通知开会通知开会通知开会通知</span></td>
                                <!-- 通知状态按照时间定：未开始，进行中，已过期 -->
                                <td><button class="btn warning btn-xs">已过期</button></td>
                                <td>2018-3-21</td>
                                <td>2018-3-23</td>
                                <td><a href="{{route('manage_notice_addnotice',['id'=>1])}}">查看详情</a></td>
                            </tr>
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
>>>>>>> origin
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
