@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ],
                "info": false,
                "searching" : false,
                "ordering" : false,  //禁止排序
                // "columnDefs":[          //设置某一列不排序
                //        {"orderable":false,"targets":[1,2]}
                //     ]
            });

            $("table").on("click",".prev",function(){
                var h='<p>openid: '+$(this).attr("data-openid")+'</p>';
                    h=h+'<p>unionid: '+$(this).attr("data-unionid")+'</p>';
                bootbox.alert(h);
            });

            //让a标签失效
            $(".pagination li a").each(function () {
                $(this).attr("href", "javascript:;")
            });

            //点击一次加一个class
            $("#table_id").on("click",function(){
                $(this).siblings('th').removeClass('keyword');
                $(this).addClass('keyword');
            })
            $("#subscribe_time").on("click",function(){
                $(this).siblings('th').removeClass('keyword');
                $(this).addClass('keyword');
            })
            $("#addtime").on("click",function(){
                $(this).siblings('th').removeClass('keyword');
                $(this).addClass('keyword');
            })

            //时间转换方法
            function getTime(nS) {
                var date=new Date(parseInt(nS)* 1000);
                var year=date.getFullYear();
                var mon = date.getMonth()+1;
                var day = date.getDate();
                var hours = date.getHours();
                var minu = date.getMinutes();
                if(day.toString().length==1){day = '0' + day}
                if(mon.toString().length==1){mon = '0' + mon}
                if(hours.toString().length==1){hours = '0' + hours}
                if(minu.toString().length==1){minu = '0' + minu}
                return year+'-'+mon+'-'+day+' '+hours+':'+minu;
            }

            //将用ajax取回的数据将页面的内容覆盖
            function repeatData(index, dataList,data) {
                var shops = data['shops'][dataList[index].unionid];
                var emps = data['emps'][dataList[index].unionid];
                var kols = data['kols'][dataList[index].unionid];
                var subscribe_time = dataList[index].subscribe_time;
                var commonTime = getTime(subscribe_time);
                var addtime_time = dataList[index].addtime;
                var addtime = getTime(addtime_time);
                var subscribe = dataList[index].subscribe;

                if(shops == null){shops = ' '}else{shops = shops}
                if(emps == null){ emps = ' '}else{emps = emps}
                if(kols == null){ kols = ' '}else{kols = kols}
                if(subscribe == 1){
                    if(subscribe_time == 1){
                        subscribe_time = '未关注';
                    }else if(subscribe_time == 0){
                        subscribe_time = '0';
                    }else{
                        subscribe_time = commonTime;
                    }
                }else{
                    subscribe_time = '未关注';
                }

                $("#table_tbody tr").eq(index).html(
                    '<td class="sorting_1">' + dataList[index].id + '</td>' +
                    '<td><img src="'+ dataList[index].headimgurl +'"style="height:40px;"></td>' +
                    '<td><a href="javascript:;" class="prev" data-openid="' + dataList[index].openid + '" data-unionid="' + dataList[index].unionid + '">' + dataList[index].nickname +'</a>'+
                    '</td>' +

                    '<td>'+ shops +'</td>'+
                    '<td>'+ emps +'</td>'+
                    '<td>'+ kols +'</td>'+
                    '<td>'+dataList[index].city +'</td>'+

                    '<td>' + subscribe_time +'</td>' +
                    '<td>' + addtime + '</td>' +
                    '<td>' +
                        '<div class="btn-group">' +
                            '<a href="#" class="btn blue btn-xs">详情</a>' +
                            '<button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">' +
                                '<i class="fa fa-angle-down"></i>' +
                            '</button>' +
                            '<ul class="dropdown-menu pull-right" role="menu">' +
                                '<li><a href="javascript:;" class="tap-one" data-openid="1503390403a2JH"> 更新信息 </a></li>' +
                            '</ul>' +
                        '</div>' +
                    '</td>')
            }

            //表单内容和页码
            var PaginationOperate = function (pagiantionNumber) {
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_wechats')}}",
                    data:{ "page": pagiantionNumber},
                    success: function (data) {
                        $("ul.pagination").html(data);
                        $("ul.pagination").find("li a").attr("href", "javascript:;");
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_wechat_post')}}",
                    data:{ "page": pagiantionNumber},
                    dataType: "json",
                    success: function (data) {
                        var dataList = data.lists.data;
                        for(var i = 0; i < dataList.length; i++){
                            repeatData(i, dataList,data);
                        }
                        location.hash = data.lists.current_page;
                    }
                });
            };

            //点击页码调用ajax方法
            // 将事件委托到body上，等再次点击时触发
            $('body').on('click' , '#pagination li a' , function(){
                var activename = $("#pagination li.active").find("span").text();
                var pagiantionNumber = $(this).html();
                var name = $("#searchname").val();
                var nameNum = $(this).html();
                var table_ids = $("#table_id").text();
                var classnameid = $(".keyword").text();
                var activenames = $("#pagination li.active").find("span").text();
                    if(nameNum == '«'){
                        var nameNum = Number(activenames) - 1;
                    }else if(nameNum == '»'){
                        var nameNum = Number(activenames) + 1;
                    }
                //如果是正序
                if(classnameid == 'ID↑'){
                    //如果是正序，并且有查询条件
                    if(name != ''){
                        var sorting = 1;
                        repeatDatapagiantion(nameNum, activename,name,sorting);
                        return false;
                    }
                    //如果是正序，没有查询条件
                    $.ajax({
                        type: "post",
                        url: "{{Route('manage_user_sortingpagination')}}",
                        data:{ "id": 1,"page":nameNum},
                        success: function (data) {
                            $("ul.pagination").html(data);
                            $("ul.pagination").find("li a").attr("href", "javascript:;")
                        }
                    });
                    $.ajax({
                        type: "post",
                        url: "{{Route('manage_user_sortingdata')}}",
                        data:{ "id": 1,"page":nameNum},
                        dataType: "json",
                        success: function (data) {
                            var dataList = data.lists.data;
                            $("#table_tbody tr").html('');
                            for(var i = 0; i < dataList.length; i++){
                                repeatData(i, dataList,data);
                            }
                        }
                    });
                    return false;
                }
                //如果为关注正序
                else if(classnameid == '关注↑'){
                    var sorting = '2.5';
                    repeatDatainquiry(nameNum,name,sorting)
                    return false;
                }
                //如果为关注倒序
                else if(classnameid == '关注↓'){
                    var sorting = '2';
                    repeatDatainquiry(nameNum,name,sorting)
                    return false;
                }
                //如果为加入时间正序
                else if(classnameid == '加入时间↑'){
                    var sorting = '3.5';
                    repeatDatainquiry(nameNum,name,sorting)
                    return false;
                }
                //如果为加入时间倒序
                else if(classnameid == '加入时间↑'){
                    var sorting = '3';
                    repeatDatainquiry(nameNum,name,sorting)
                    return false;
                }
                //否则就按照倒序排列
                else{
                    //判断是否是在查询条件时点击事件
                    if(name == ''){
                        if(pagiantionNumber == '«'){
                            var nums = Number(activename) - 1;
                            PaginationOperate(nums);
                        }else if(pagiantionNumber == '»'){
                            var nums = Number(activename) + 1;
                            PaginationOperate(nums);
                        }else{
                            PaginationOperate(pagiantionNumber);
                        }
                    }else{
                        var nameNum = $(this).html();
                        var activename = $("#pagination li.active").find("span").text();
                        repeatDatapagiantion(nameNum, activename,name);
                    }
                }

            });

            //在有找查条件时翻页查询
            function repeatDatapagiantion(nameNum, activename,name,sorting=0) {
                if(nameNum == '«'){
                    var nameNum = Number(activename) - 1;
                }else if(nameNum == '»'){
                    var nameNum = Number(activename) + 1;
                }
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_search')}}",
                    data:{ "name": name,"page":nameNum,sorting:sorting},
                    dataType: "json",
                    success: function (data) {
                        var dataList = data.lists.data;
                        $("#table_tbody tr").html('');
                        for(var i = 0; i < dataList.length; i++){
                            repeatData(i, dataList,data);
                        }
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_searchpagination')}}",
                    data:{ "name": name,"page":nameNum},
                    success: function (data) {
                        $("ul.pagination").html(data);
                        $("ul.pagination").find("li a").attr("href", "javascript:;")
                    }
                });
            }

            //在有找查条件时翻页查询
            function repeatDatainquiry(nameNum,name,sorting) {
                $.ajax({
                        type: "post",
                        url: "{{Route('manage_user_search')}}",
                        data:{ "name": name,"page":nameNum,sorting:sorting},
                        dataType: "json",
                        success: function (data) {
                            var dataList = data.lists.data;
                            $("#table_tbody tr").html('');
                            for(var i = 0; i < dataList.length; i++){
                                repeatData(i, dataList,data);
                            }
                        }
                    });
                    $.ajax({
                        type: "post",
                        url: "{{Route('manage_user_searchpagination')}}",
                        data:{ "name": name,"page":nameNum},
                        success: function (data) {
                            $("ul.pagination").html(data);
                            $("ul.pagination").find("li a").attr("href", "javascript:;")
                        }
                    });
            }

            //姓名搜索
            $("#searchname").bind('input propertychange',function(){
                var name = $("#searchname").val();
                if(name==''){
                    PaginationOperate(1);
                }
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_search')}}",
                    data:{ "name": name},
                    dataType: "json",
                    success: function (data) {
                        var dataList = data.lists.data;
                        $("#table_tbody tr").html('');
                        for(var i = 0; i < dataList.length; i++){
                            repeatData(i, dataList,data);
                        }
                        $("#table_id").html("ID↓");
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_searchpagination')}}",
                    data:{ "name": name},
                    success: function (data) {
                        $("ul.pagination").html(data);
                        $("ul.pagination").find("li a").attr("href", "javascript:;")
                    }
                });
            });


            //点击id排序时，判断是正序还是倒序，再到里面判断是否有查询条件
            $("#table_id").on("click",function(){
                var values = $(this).html();
                var name = $("#searchname").val();
                var one = 1;
                //如果是倒序
                if(values == 'ID↓'){
                    if(name == ''){
                        $.ajax({
                            type: "post",
                            url: "{{Route('manage_user_sortingdata')}}",
                            data:{ "id": 1},
                            dataType: "json",
                            success: function (data) {
                                var dataList = data.lists.data;
                                $("#table_tbody tr").html('');
                                for(var i = 0; i < dataList.length; i++){
                                    repeatData(i, dataList,data);
                                }
                                $("#table_id").html("ID↑");
                            }
                        });
                        $.ajax({
                            type: "post",
                            url: "{{Route('manage_user_sortingpagination')}}",
                            data:{ "id": 1,"page":1},
                            success: function (data) {
                                $("ul.pagination").html(data);
                                $("ul.pagination").find("li a").attr("href", "javascript:;")
                            }
                        });
                    }else{
                        var tavle_name = "ID↑";
                        nameNum = 1;
                        searchsortings(name,one,tavle_name,nameNum);
                    }
                //如果是正序
                }else{
                    if(name == ''){
                        PaginationOperate(1);
                        $("#table_id").html("ID↓");
                    }else{
                        one = 1.5;
                        var tavle_name = "ID↓";
                        nameNum = 1;
                        searchsortings(name,one,tavle_name,nameNum);
                    }
                }
            })

            //点击关注排序时，判断是正序还是倒序，再到里面判断是否有查询条件
            $("#subscribe_time").on("click",function(){
                var values = $(this).html();
                var name = $("#searchname").val();
                var one = 1;
                //如果是倒序
                if(values == '关注↓'){
                    var one = '2.5';
                    var tavle_name = "关注↑";
                    searchsortingsfollow(name,one,tavle_name);
                    return false;
                //如果是正序
                }else{
                    var one = '2';
                    tavle_name = "关注↓";
                    searchsortingsfollow(name,one,tavle_name);
                    return false;
                }
            })

             //点击id关注排序时，判断是正序还是倒序，再到里面判断是否有查询条件
            $("#addtime").on("click",function(){
                var values = $(this).html();
                var name = $("#searchname").val();
                var one = 1;
                //如果是倒序
                if(values == '加入时间↓'){
                    var one = '3.5';
                    tavle_name = "加入时间↑";
                    searchsortingsaddtime(name,one,tavle_name);
                    return false;
                }else{ //如果是正序
                    var one = '3';
                    tavle_name = "加入时间↓";
                    searchsortingsaddtime(name,one,tavle_name);
                    return false;
                }
            })

            //当查询时正序和倒序的显示
            function searchsortings(name,one,tavle_name,nameNum){
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_search')}}",
                    data:{ "name": name,"page":1,"sorting":one},
                    dataType: "json",
                    success: function (data) {
                        var dataList = data.lists.data;
                        $("#table_tbody tr").html('');
                        for(var i = 0; i < dataList.length; i++){
                            repeatData(i, dataList,data);
                        }
                        $("#table_id").html(tavle_name);
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_searchpagination')}}",
                    data:{ "name": name,"page":nameNum,"sorting":one},
                    success: function (data) {
                        $("ul.pagination").html(data);
                        $("ul.pagination").find("li a").attr("href", "javascript:;")
                    }
                });
            }

            //当关注查询时正序和倒序的显示
            function searchsortingsfollow(name,one,tavle_name){
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_search')}}",
                    data:{ "name": name,"page":1,"sorting":one},
                    dataType: "json",
                    success: function (data) {
                        var dataList = data.lists.data;
                        $("#table_tbody tr").html('');
                        for(var i = 0; i < dataList.length; i++){
                            repeatData(i, dataList,data);
                        }
                        $("#subscribe_time").html(tavle_name);
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_searchpagination')}}",
                    data:{ "name": name,"page":1,"sorting":one},
                    success: function (data) {
                        $("ul.pagination").html(data);
                        $("ul.pagination").find("li a").attr("href", "javascript:;")
                    }
                });
            }

            //当加入时间查询时正序和倒序的显示
            function searchsortingsaddtime(name,one,tavle_name){
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_search')}}",
                    data:{ "name": name,"page":1,"sorting":one},
                    dataType: "json",
                    success: function (data) {
                        var dataList = data.lists.data;
                        $("#table_tbody tr").html('');
                        for(var i = 0; i < dataList.length; i++){
                            repeatData(i, dataList,data);
                        }
                        $("#addtime").html(tavle_name);
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{Route('manage_user_searchpagination')}}",
                    data:{ "name": name,"page":1,"sorting":one},
                    success: function (data) {
                        $("ul.pagination").html(data);
                        $("ul.pagination").find("li a").attr("href", "javascript:;")
                    }
                });
            }


            $(".tap-tongbu").click(function(){
                bootbox.alert('正在更新中，预计5分钟后结束');
                $(this).attr("disabled","disabled");
                $.post("{{route('manage_user_wechat_post')}}",{"flag":"openids"},function(d){

                });
            });

            $(".tap-one").click(function(){
                $(this).attr("disabled","disabled");
                var openid=$(this).attr("data-openid");
                $.post("{{route('manage_process_wxmember')}}",{"openid":openid},function(d){

                });
                alert("更新成功");
                location.href=location.href;
            });

        });


    </script>
@endsection

@section('usercss')
<style media="screen">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{vertical-align: middle!important;}
    #news-table_length{display: none}
    #news-table_paginate{display: none}
    #news-table_filter{text-align: right;}
    #pagination{margin-bottom: 20px}
    #pagination>div{float: right;}
    #pagination>div>a{padding: 4px 8px;display: inline-block;background: #fff;margin-right: 3px;border-radius: 3px;border: 1px solid #ccc}
    #searchname{border: 1px solid #ccc;height: 30px;border-radius: 3px;padding-left: 5px}
    #table_id,#table_name,#subscribe_time,#addtime{cursor: pointer;}
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <button class="btn purple-studio btn-outline tap-tongbu" style="display:none"><i class="fa fa-refresh"></i> 同步</button>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div><p>昵称搜索：<input type="text" name='searchname' value="" id="searchname" /></p></div>
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th id="table_id" width="50px" class="keyword">ID↓</th>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>店铺</th>
                            <th>店员</th>
                            <th>达人</th>
                            <th>定位城市</th>
                            <th id="subscribe_time" >关注↓</th>
                            <th id="addtime">加入时间↓</th>
                            <th width='82px'>操作</th>
                        </tr>
                        </thead>
                        <tbody id="table_tbody">
                        @foreach($lists as $v)
                            @if($v->id)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td><img src="{{$v->headimgurl}}" alt="" style="height:40px;"></td>
                                <td><a href="javascript:;" class="prev" data-openid="{{$v->openid}}" data-unionid="{{$v->unionid}}">{{$v->nickname}}</a></td>
                                <td>{{$shops[$v->unionid] or ''}}</td>
                                <td>{{$emps[$v->unionid] or ''}}</td>
                                <td>{{$kols[$v->unionid] or ''}}</td>
                                <td>@if($v->city){{$v->city}}@endif</td>
                                <td>
                                    @if($v->subscribe>0)
                                    {{date('Y-m-d H:i',$v->subscribe_time)}}
                                    @else
                                    未关注
                                    @endif
                                </td>
                                <td>{{date('Y-m-d H:i',$v->addtime)}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="btn blue btn-xs">详情</a>
                                        <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="javascript:;" class="tap-one" data-openid="{{$v->openid}}"> 更新信息 </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <ul id="pagination">
                        {{ $lists->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
