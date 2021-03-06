@extends('manage.common.master')
@section('userjs')
    <script>


    </script>
@endsection

@section('content')
<style type="text/css">
    .td_select{width: 100%;}
    .td_s_sp{font-size: 12px;}
    #news-table_length{display: none}
    #shaixuan{position: absolute;top: 73px;left: 35px;width: 140px;height: 30px;border-radius: 5px;}
    #zuyuan{width: 140px;height: 30px;border-radius: 5px;}
    .acolor{color:#fff;text-decoration:none}
    .td_span{width: 100%;height: 20px;display: block;overflow: hidden;}
    .outline{outline: 1px solid red;}
    .btnxs{margin-left: 5px !important;}
    .tishired{position: absolute;top: 95px;left: 35px;color: red;font-size: 12px;}
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
                            <th width="50px">ID</th>
                            <th width="150px">名称</th>
                            <th width="250px">价格</th>
                            <th width="250px">分类</th>
                            <th>备注</th>
                            <th width="180px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if(isset($list))
                          @foreach($list as $v)
                          <tr>
                            <td>{{$v->exproject_id}}</td>
                            <td>{{$v->proname or '--'}}</td>
                            <td>{{$v->price or '--'}}</td>
                            <td>{{$v->typename or '--'}}</td>
                            <td>{{$v->remark or '--'}}</td>
                            <td>
                                <div class="btn-group">

                                  @if($v->status != 2)
                                  <button type="button" class="btn blue-steel dropdown-toggle btn-xs " data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
                                  <ul class="dropdown-menu pull-right" role="menu">
                                  <li><a href="{{route('manage_exproject_detail',['id'=>$v->exproject_id])}}" class="tap-street acolor">查看详情</a></li>
                                  @if($flag == 1)
                                     <li><a href="{{route('manage_exproject_updata',['id'=>$v->exproject_id])}}" class="tap-street acolor">修改事例</a></li>
                                  @endif

                                  </ul>
                                  @endif
                                 </div>
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
