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
        .main_top{width: 100%;height: auto;padding: 20px 0 50px 0}
        .main_top>div{width: 20%;height: 100px;background: #fff;box-shadow: 1px 1px 20px 5px #ccc;;display: inline-block;margin-left: 4%;text-align: center;}
        .main_top>div>p:nth-child(1){margin: 15px 0px 10px 0;}
        .main_top>div>p:nth-child(2){font-size: 20px}
        .main{width: calc(100% - 10px);padding: 10px;margin-top: 20px;border-top: 2px solid #ccc}
        .main_p{margin-bottom: 5px;font-size: 13px;}
        #news-table_wrapper>.row>div:nth-child(1){display: none}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">{{$nickname or ''}}的销售利润详情</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="main_top">
                        <div>
                            <p>月利润</p>
                            <p>{{$xslrdy or 0.00}}元</p>
                        </div>
                        <div>
                            <p>总利润</p>
                            <p>{{$xslr or 0.00}}元</p>
                        </div>
                        <div>
                            <p>月销售额</p>
                            <p>{{$xszdy or 0.00}}元</p>
                        </div>
                        <div>
                            <p>总销售额</p>
                            <p>{{$xsz or 0.00}}元</p>
                        </div>
                    </div>

                    <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>项目名称</th>
                            <th>客户名称</th>
                            <th>获得利润</th>
                            <th>获得销售额</th>
                            <th>转入项目时间</th>
                            <th>项目完成时间</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if(isset($lists))
                          @foreach($lists as $v)
                            <tr>
                                <td width="50px">{{$v->id}}</td>
                                <td>{{$v->proname}}</td>
                                <td>{{$kid[$v->kid]}}</td>
                                <td>{{$v->contractamount - $v->floorprice}}</td>
                                <td>{{$v->contractamount}}</td>
                                <td>{{date('Y-m-d',$v->addtime)}}</td>
                                <td>    
                                    @if(!empty($v->wctime))
                                        {{date('Y-m-d H:i',$v->wctime)}}
                                    @else
                                        --
                                    @endif
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
    </div>

@endsection
