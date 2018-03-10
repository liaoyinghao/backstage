@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            })

            $(".delete").on('click', function(){
                event.returnValue = confirm("删除是不可恢复的，你确认要删除吗？");
                if(event.returnValue){
                    var id = $(this).parent("td").siblings('.bid').html();
                    $.ajax({
                        url:"{{route('manage_member_modifydelete')}}",
                        type:"post",
                        data:{'id':id},
                        dataType:'json',
                        success:function(d){
                            if(d==1){
                                alert('删除成功！');
                            }else{
                                alert('删除失败！');
                            }
                        }
                    })
                    $(this).parents("tr").css('display','none');
                }
            })

        });


    </script>
@endsection

@section('content')

<style type="text/css">
.list_logo>img{width: 40px;height: 40px}
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> {{$left_menu[$view_path[1]]['son'][$view_path[2]]['name'] or '会员卡列表'}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{route('manage_member_modify')}}"><button class="btn grey-mint" style="padding: 5px 12px;margin-right: 5px">添加会员卡</button></a> 
                        <button class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</button>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table" id="news-table">
                        <thead>
                        <tr>
                            <th width="50px">ID</th>
                            <th>会员卡</th>
                            <th>会员卡logo</th>
                            <th>所归属品牌商</th>
                            <th>注册时间</th>
                            <th>是否显示</th>
                            <td>修改</td>
                            <td>删除</td>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($list))
                                @foreach($list as $v)
                                    <tr>
                                        <td class="bid">{{$v->id or ''}}</td>
                                        <td>{{$v->card_type or ''}}</td>
                                        <td class="list_logo"><img src="{{$v->logo_url or ''}}"></td>
                                        <td>{{$v->nickname or ''}}</td>
                                        <td>{{date('Y-m-d H:i',$v->addtime)}}</td>
                                        <td>@if($v->display == 1) 显示 @else <span style="color: red">隐藏</span> @endif</td>
                                        <td><a href="{{route('manage_member_modify',['id'=>$v->id])}}" class="btn btn-primary btn-xs">修改</a></td>
                                        <td><button class="btn btn-danger btn-xs delete">删除</button></td>
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
