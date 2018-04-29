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
.neirong{width: 100%;max-height: 38px;display: block;overflow: hidden;}
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> @if(isset($listsuser)) {{$listsuser}} @endif {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        @if(!isset($listsuser))
                        <a class="btn blue btn-outline" href="{{route('manage_daily_adddaily')}}"><i class="fa fa-plus"></i> 添加日报</a>
                        @endif
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th width="100px">发送人</th>
                            <th width="115px">标题</th>
                            <th>内容</th>
                            <th width="100px;">发送时间</th>
                            <th>查看</th>
                            <th>删除</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($lists))
                            @foreach($lists as $v)
                            <tr>
                                <td width="50px">{{$v->id}}</td>
                                <td>{{$user[$v->nid]}}</td>
                                <td>{{$v->title}}</td>
                                <td><span class="neirong">
                                    {{$v->progress}}
                                </span></td>
                                <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                                <td>
                                    <button type="button" class="btn blue btn-xs">
                                        <a href="{{route('manage_daily_adddailynew',['id'=>$v->id])}}" class="pfp">查看详情</a>
                                  </button>
                                </td>
                                @if($flag == 1)
                                <td>
                                    <button type="button" class="btn blue btn-xs">
                                        <a href="{{route('manage_daily_shan',['id'=>$v->id])}}" class="pfp">删除</a>
                                  </button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
