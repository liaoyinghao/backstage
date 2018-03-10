@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){
            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $(".caozuo").on('click','.list_del',function(){
                
                event.returnValue = confirm("确定要将此条删除吗？");
                if(event.returnValue){
                    var id = $(this).parent("td").siblings(".list_id").html();
                    var hr = $(this).parent("td").siblings(".statuss");
                    var tr = $(this).parent("td");

                    $.ajax({
                        url:"{{route('manage_card_advertdel')}}",
                        type:"post",
                        data:{"id":id},
                        dataType:"json",
                        success:function(d){
                            if(d==1){
                                var h = "<span class='red'>删 除</span>"
                                hr.html(h);
                                var t = "<span class='label label-success list_add'> 恢 复 </span>"
                                tr.html(t);
                            }else{
                                alert("删除失败，请重新刷新试试！");
                            }
                        }
                    })
                    

                }
            })

            $(".caozuo").on('click','.list_add',function(){
                var id = $(this).parent("td").siblings(".list_id").html();
                var hr = $(this).parent("td").siblings(".statuss");
                var tr = $(this).parent("td");

                $.ajax({
                    url:"{{route('manage_card_advertadd')}}",
                    type:"post",
                    data:{"id":id},
                    dataType:"json",
                    success:function(d){
                        if(d==1){
                            var h = "<span class='green'>正 常</span>"
                            hr.html(h);

                            var t = "<span class='label label-danger list_del'> 删 除 </span>"
                            tr.html(t);
                            alert('已成功恢复！');
                        }else{
                            alert("恢复失败，请重新刷新试试！");
                        }
                    }
                })

                
            })
        });

    </script>
@endsection

@section('content')
<style type="text/css">
.ribao{padding: 20px 20px 40px 20px;}
.ribao_p1{margin: 0 0 5px -20px}
.ribao_inptu{width: 200px;height: 35px;border: 1px solid #ccc;border-radius: 5px;text-align: center;}
.submits{width: 150px;height: 35px;background: #217ebd;margin-left: 20px;border: none;border-radius: 5px;color: #fff;}
#news-table_filter{text-align: right;}
.label{cursor: pointer;}
.green{color: green}
.red{color: red}
</style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{route('manage_card_advertst')}}"><button class="btn grey-mint" style="padding: 5px 12px;margin-right: 5px">添加外部券</button></a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>



                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="100px">ID</th>
                            <th>标题</th>
                            <th>副标题</th>
                            <!-- <th width="250px">url连接地址</th> -->
                            <th>状态</th>
                            <th>类型</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($list))
                                @foreach($list as $v)
                                    <tr>
                                        <td class="list_id">{{$v->id}}</td>
                                        <td>{{$v->title}}</td>
                                        <td>{{$v->des}}</td>
                                        <!-- <td>{{$v->url}}</td> -->
                                        <td class="statuss">
                                            @if($v->status == 1) 
                                            <span class="green">正 常</span>  
                                            @else 
                                            <span class="red">删 除</span> 
                                            @endif
                                        </td>
                                        <td>@if($v->exec_id == 0) 
                                        全局外部券 
                                        @else 
                                        品牌商外部券 
                                        @endif</td>
                                        <td>{{date("Y-m-d H:i:s",$v->addtime)}}</td>

                                        <td class="caozuo">
                                            @if($v->status == 1) 
                                            <span class="label label-danger list_del"> 删 除 </span> 
                                            @else 
                                            <span class="label label-success list_add"> 恢 复 </span>
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

@endsection
