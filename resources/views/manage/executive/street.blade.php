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

        function test() {
            var f = document.getElementsByName("name[]");

            for (var i = 0; i < f.length; i++) {
                if (f[i].checked == false) {
                    f[i].checked = true;
                }
            }
        }

        //反选
            function ftest() {
                var f = document.getElementsByName("name[]");
                for (var i = 0; i < f.length; i++) {

                    if (f[i].checked == false) {
                        f[i].checked = true;
                    }
                    else {
                        f[i].checked = false;
                    }
                }
            }

    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">商街权限列表</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <p>选中一条街，可赋予查看这条街的全部店铺的权限</p>
                    <form method='post' action="{{route('manage_executive_streetauthority')}}">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th>街道名</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                            <tr>
                                <td><input name='name[]' type='checkbox' value="{{$v->name}}"
                                @if(in_array($v->name,$num))
                                   checked="checked"
                                   @endif
                                > &nbsp;&nbsp;&nbsp;{{$v->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <input type='hidden' name='login' value="{{$v->login}}">
                    <input type='button' onclick="test()" class='btn btn-info' value='全选'>
                    <input type='button' onclick="ftest()"class='btn btn-info' value='反选'>
                    <input type='submit'class='btn btn-info'  value='确定'>
                </form>
                </div>
            </div>
        </div>
    </div>

@endsection
