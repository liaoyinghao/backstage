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
        .row{text-align: center;margin-top: 200px;font-size: 20px;}
    </style>
@section('content')
    <div class="row">
        欢迎来到管理后台：{{request()->cookie('backstage_user_nickname')}}
    </div>

@endsection
