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
    .acolor{color:#fff;text-decoration:none}
    .inputs{width: 200px;height: 35px;border-radius: 5px;border: 1px solid #999;margin-right: 10px;}
    .buttons{width: 90px;height: 35px;background: deepskyblue;border-radius: 5px;border: none;box-shadow: 2px 2px 8px #999;color: #fff}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <!-- <a class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加</a> -->
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div>
                    <form method="post" action="{{route('manage_finance_main')}}">
                        选择时间查询数据：
                        <input type="date" name="kstime" value="" class="inputs">
                        <input type="date" name="jstime" value="" class="inputs">
                        <button class="buttons">查 询</button>
                    </form>
                </div><br>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>姓名</th>
                            <th>职位</th>
                            <th>当月利润</th>
                            <th>当月销售额</th>
                            <th>总利润</th>
                            <th>总销售额</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if(isset($lists))
                          @foreach($lists as $v)
                            <tr>
                                <td width="50px">{{$v['id']}}</td>
                                <td>{{$v['nickname']}}</td>
                                <td>{{$v['position']}}</td>
                                <td>{{$v['xslrdy']}}</td>
                                <td>{{$v['xszdy']}}</td>
                                <td>{{$v['xslr']}}</td>
                                <td>{{$v['xsz']}}</td>
                                <td>
                                    <button type="button" class="btn blue btn-xs">
                                        <a href="{{route('manage_finance_fdetails',['kid'=>$v['kid'],'nickname'=>$v['nickname'],'xslrdy'=>$v['xslrdy'],'xszdy'=>$v['xszdy'],'xslr'=>$v['xslr'],'xsz'=>$v['xsz']])}}" class="tap-street acolor">查看详情</a>
                                    </button>
                                </td>
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
