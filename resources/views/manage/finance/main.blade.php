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
