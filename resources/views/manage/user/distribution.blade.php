@extends('manage.common.master')
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });

            $(".submit").on("click",function(){
                obj = $("input[name=zhuguan]");
                zhuguan = [];
                for(k in obj){
                    if(obj[k].checked)
                        zhuguan.push(obj[k].value);
                }

                objs = $("input[name=xiaoshou]");
                xiaoshou = [];
                for(ks in objs){
                    if(objs[ks].checked)
                        xiaoshou.push(objs[ks].value);
                }

                if(zhuguan == ''){
                    alert("请选择销售主管");
                    return false;
                }

                if(xiaoshou == ''){
                    alert("请选择销售人员");
                    return false;
                }

                var zhiwei = "{{$user->position}}";
                if(zhiwei == '销售'){
                    var zhuguanlen = zhuguan.length;
                    if(zhuguanlen != 1){
                        alert("一个销售人员只能选择一位主管！");
                        return false;
                    }
                }

                zhuguan = zhuguan.toString();
                xiaoshou = xiaoshou.toString();
                $.ajax({
                    url:"{{route('manage_user_distributionpost')}}",
                    type:"post",
                    data:{'zhuguan':zhuguan,'xiaoshou':xiaoshou,'zhiwei':zhiwei},
                    dataType:"json",
                    success:function(d){
                        if(d==1){
                            alert("修改成功！");
                            window.location.href="{{route('manage_user_main')}}";
                        }else{
                            alert("修改错误！");
                            return false;
                        }
                    }
                })
            })

          

        });


    </script>
@endsection

@section('content')
    <style type="text/css">
        .portlet-body{padding: 20px 0 20px 0}
        .form_p input{  width: 300px;
                        height: 35px;
                        border-radius: 5px;
                        border: 1px solid #999;
                        text-indent: 10px;
                        margin-left: 5px;}
        .submit{width: 150px;
                height: 30px;
                background: #3598dc;
                color: #fff;
                border: none;
                border-radius: 5px;}
        .job{width: 300px;height: 35px;border-radius: 5px;}
        .userk{text-align: right;width: 100px;display: inline-block;}
        .xuanz{width: 80%;margin-left: 15%; line-height: 30px;}
        .xuanz input{width: 20px;height: 20px;vertical-align: middle;margin: -5px 2px 0px 20px;}
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"> 修改分配人员</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- <form method="post" action="{{route('manage_user_distributionpost')}}"> -->

                        <p class="form_p">
                          <span class="userk">所属主管：</span>
                                <div class="xuanz">
                                    @if(isset($xsstore))
                                        @foreach($xsstore as $val)
                                            <input type="checkbox" name="zhuguan" value="{{$val->id}}" class="zhuguan" />{{$val->nickname}}
                                        @endforeach
                                    @else
                                            <input type="checkbox" name="zhuguan" checked="checked" value="{{$user->id}}" disabled='disabled'  class="zhuguan" />{{$user->nickname}}
                                    @endif
                                </div>

                          <!-- <select name='zhuguan' value="" class="job">
                            @if(isset($xsstore))
                                @foreach($xsstore as $val)
                                    <option  value='{{$val->id}}'>{{$val->nickname}}</option>
                                @endforeach
                            @else
                                    <option  value='{{$user->id}}'>{{$user->nickname}}</option>
                            @endif
                          </select> -->

                        </p>

                        <p class="form_p">
                          <span class="userk">选择销售：</span>
                                <div class="xuanz">
                                    @if(isset($xsinfo))
                                        @foreach($xsinfo as $val)
                                            <input type="checkbox" name="xiaoshou" value="{{$val->id}}"/>{{$val->nickname}}
                                        @endforeach
                                    @else
                                            <input type="checkbox" name="xiaoshou" checked="checked" value="{{$user->id}}" disabled='disabled'/>{{$user->nickname}}
                                    @endif
                                </div>

                          <!-- <select name='xiaoshou' value="" class="job">
                            @if(isset($xsinfo))
                                @foreach($xsinfo as $val)
                                    <option  value='{{$val->id}}'>{{$val->nickname}}</option>
                                @endforeach
                            @else
                                    <option  value='{{$user->id}}'>{{$user->nickname}}</option>
                            @endif
                          </select> -->

                        </p>

                    <p><input type="submit" value="确认修改" class="submit"></p>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>

@endsection
