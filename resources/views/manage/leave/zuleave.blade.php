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
        .portlet-body{text-align: center;padding: 20px 0 20px 0}
        .form_div{width: calc(100% - 40px);height: 80px;margin: 20px 0 10px 0;padding: 15px;font-size: 18px;text-align: left;font-weight: 300;box-shadow: 3px 3px 8px #ccc;border: 1px solid #ccc;display: block;text-decoration: none !important;}
        .form_div>p{margin: 0;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                            <span class="caption-subject bold uppercase">全部组员</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">

                    @if(isset($zuyuan))
                        @foreach($zuyuan as $val)
                            <a class="form_div" href="{{route('manage_leave_zuyuanqj',['id'=>$val->id])}}">
                                <p>组员昵称： {{$val->nickname or ''}}</p>
                                <p>请假数量： {{$val->khcount or '0'}}</p>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
