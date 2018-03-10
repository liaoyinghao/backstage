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


    $("table").on("click",".prev",function(){
        var u=$(this).attr("data-src");
        var n=$(this).attr("data-name");
        var h='<div class="text-center"><p>'+n+'</p><img src="'+u+'"></div>';
        bootbox.alert(h);
    });

    $("table").on("click",".tap-edit",function(){
        var deviceid=$(this).attr("data-id");
        bootbox.prompt({
            size:"small",
            title:"输入新备注,15个字以内",
            callback:function(res){
                if(res===null){}else{
                    if(res.length==0){
                        alert("不能为空");
                        return false;
                    }
                    if(res.length>15){
                        alert("字数过长");
                        return false;
                    }
                    $.ajax({
                        url: "{{route('manage_executive_updatermarks')}}",
                        dataType:"json",
                        data: {"_token":"{{ csrf_token() }}","remarks":res,"id":deviceid},
                        type:"post",
                        success: function(d){
                            alert("更新成功!");
                            window.location.reload();
                        }
                    });
                }

            }
        });
    });


    $(".queren").on('click',function(){
        $(".main").css("display","none");
    })

    $(".income").on('click',function(){
        var id = $(this).siblings(".iid").val();
        $.ajax({
            url:"{{route('manage_account_shouru')}}",
            type:"post",
            data:{"id":id},
            dataType:"json",
            success:function(d){
                if(d != 0){
                    $(".m_name").html(d.nickname);
                    $(".m_income").val(d.zong);
                    $(".m_rece").val(d.ysr);
                    $(".m_unco").val(d.wsr);
                    $(".main").css("display","block");
                }
            }
        })

    })

    </script>
@endsection

@section('content')

<style type="text/css">
    .main{padding: 20px 10px 50px 10px;width: 600px;height: 300px;background: #fff;position: absolute;top: calc(50% - 150px);left:calc(50% - 300px);z-index: 11;border: 1px solid #ccc;text-align: center;box-shadow: 2px 2px 8px #888;display: none}
    .main>div{margin-top: 15px}
    .main>div>span{width: 120px;height: 30px;display: inline-block;text-align: right;padding-right: 20px;}
    .main>div>input{width: 300px;height: 30px;border: none;border-bottom: 1px solid #999;outline: none;text-indent: 20px;background: #fff}
    .queren{display: block;width: 250px;height: 30px;background: #f08500;text-align: center;line-height: 30px;color:#fff;margin: 40px auto;cursor: pointer;border-radius: 3px}
    .main>h4{padding-bottom: 10px}
</style>


    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '列表'}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{route('manage_executive_add')}}" class="btn blue btn-outline"><i class="fa fa-plus"></i> 添加</a>
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>品牌商名</th>
                            <th>备注</th>
                            <th>已选择店铺数量</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $v)
                            @if($v->id)
                            <tr>
                                <td>{{$v->id}}</td>
                                <td>{{$v->nickname}}</td>
                                <td>{{$v->remarks}}</td>
                                <td>{{$v->count or 0}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn blue btn-xs" data-name="" data-src=""><a style="color:#fff;text-decoration:none" href="{{route('manage_executive_store',['id'=>$v->id])}}">编辑权限</a></button>
                                        <button type="button" class="btn blue-steel dropdown-toggle btn-xs" data-toggle="dropdown">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right dropdown-radiobuttons" role="menu">
                                            <li><a href="javascript:;" class="tap-edit" data-remarks="{{$v->remarks}}" data-id="{{$v->id}}"> 编辑备注 </a></li>
                                            @if(!$v->nickname)
                                            <li><a class="prev" data-name="{{$v->remarks}}" data-src="http://pan.baidu.com/share/qrcode?w=300&h=300&url={{str_replace('&' , '%26' , route('h5_store_wxregister' , ['id'=>$v->id]))}}">绑定</a></li>
                                            @endif

                                            <li>
                                            <a class="income">查看收入</a>
                                            <input type="hidden" value="{{$v->id}}" class="iid">
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach

                        </tbody>
                    </table>

                    <div class="main">
                        <h4 class="m_name">品牌商名称</h4>
                        <div><span>佣金总支出:</span><input type="text" value="" disabled="disabled" class="m_income"></div>
                        <div><span>佣金已收:</span><input type="text" value="" disabled="disabled" class="m_rece"></div>
                        <div><span>佣金未收:</span><input type="text" value="" disabled="disabled" class="m_unco"></div>
                        <span class="queren">知道了</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
