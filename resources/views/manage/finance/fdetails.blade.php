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
                        <span class="caption-subject bold uppercase">**的销售利润详情</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="main_top">
                        <div>
                            <p>月利润</p>
                            <p>1998元</p>
                        </div>
                        <div>
                            <p>总利润</p>
                            <p>1998元</p>
                        </div>
                        <div>
                            <p>月销售额</p>
                            <p>1998元</p>
                        </div>
                        <div>
                            <p>总销售额</p>
                            <p>1998元</p>
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
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="50px">1</td>
                                <td>土耳其项目</td>
                                <td>廖应浩</td>
                                <td>10000.00</td>
                                <td>50000.00</td>
                                <td>2018-12-15</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                </div>
            </div>
        </div>
    </div>

@endsection
