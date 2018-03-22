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
<style type="text/css">
    .rowtop{padding-top: 10px;padding-bottom: 10px;background:#eee;text-align: center;margin-bottom: 20px;border-radius: 2px}
    .rowtop .Totaldata>div{border-left: 1px solid #999}
    .rowtop .Totaldata>div:nth-child(1){border: none}
    .dataTables_filter{text-align: right;}
    .ribao{padding: 20px 20px 40px 20px;}
    .ribao_p1{margin: 0 0 5px -20px}
    .ribao_inptu{width: 200px;height: 35px;border: 1px solid #ccc;border-radius: 5px;text-align: center;}
    .submits{width: 150px;height: 35px;background: #217ebd;margin-left: 20px;border: none;border-radius: 5px;color: #fff;}
    .pfp{color:#fff;text-decoration:none}
</style>
@section('content')
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
                <div class="ribao">
                    <form action="#">
                        <p class="ribao_p1">选择时间：年、月、日</p>
                        <input type="date" name='starttime' value="" class="ribao_inptu" id='startdate' /> 至
                        <input type="date" name="endtime" value="" class="ribao_inptu" id='enddate'/>
                        <input type='submit' value="生 成 文 件" class="submits">
                    </form>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>昵称</th>
                                <th>职位</th>
                                <th>当月销售额</th>
                                <th>总销售额</th>
                                <th>当月利润</th>
                                <th>总利润</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="50px">1</td>
                                <td>小销</td>
                                <td>销售主管</td>
                                <td>5000.00</td>
                                <td>10000.00</td>
                                <td>100.00</td>
                                <td>2000.00</td>
                                <td>
                                   <div class="btn-group">
                                      <button type="button" class="btn blue btn-xs">
                                            <a href="" class="pfp">操作</a>
                                      </button>
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
