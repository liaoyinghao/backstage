@extends('manage.common.master')
@section('userjs')
    <script>

    </script>
@endsection

@section('content')
    <style type="text/css">
        .submit_p{width: 100%;margin-top: 50px !important;}
        .submit{width: 300px;
                height: 30px;
                background: #3598dc;
                color: #fff;
                border: none;
                border-radius: 1px;
                margin-top: 20px;
                }
        .job{width: 300px;height: 35px;border-radius: 5px;}
        .userk{text-align: right;width: 150px;display: inline-block;}
        .textarea{width: 300px;height: 80px;vertical-align:top}

        .form_d{width: 100%;margin-top: 10px;border-left: 1px solid #999}
        .form_d_b{border: none;}
        .form_d_1{width: 45%;}
        .form_d_2{width: 50%;vertical-align: top;}
        .form_p>input{width: 300px;height: 35px;border-radius: 5px;border: 1px solid #999;text-indent: 5px;}
        .form_d_2>textarea{width: 72%;margin: 15px 0 35px 24%;}
        .genjin{margin-top: 30px;}
        .form_d_1>input{width: 200px;height: 35px;border-radius: 5px;border: 1px solid #999;}
        #sy_width{display: block;width: 1050px;background: #f3f5f9;box-shadow: none;}
        .bordered{background: #f3f5f9 !important;box-shadow: none !important;}
        .portlet.light.bordered{border: none !important;}
        .yigenjin{position: absolute;top: 80px;left: 55%;width: 500px;height: auto;border: 1px solid #ccc;box-shadow: 0 0 10px 1px #999;padding: 5px 0 20px 0}
        .yigenjin_pst{padding-left: 5px;}
        .userk_input{
            width: 50% !important;
        }
        .userk_textarea{
            width: 72% !important;
            margin: 15px 0 35px 38% !important;
        }
        .form_d_st1{
            width: 90%;
        }
        .form_d_st2{
            width: 80%;
        }
    </style>

    <div class="row" id="sy_width">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">查看项目跟进信息</span>
                    </div>
                </div>
                <div class="portlet-body">

                    <form method="post" action="{{route('manage_project_addproceepost')}}">
                    <input type="hidden" name="zid" value="{{$zid or ''}}" placeholder="组员">
                    <input type="hidden" name="id" value="{{$start['id'] or ''}}">
                    <input type="hidden" id="hang" value="{{$count or '1'}}">

                    <p class="genjin">项目跟进信息：</p>


                    <div class="yigenjin">

                        @if(isset($progress) && !empty($progress))
                            <p class="yigenjin_pst">已跟进信息：</p>
                            @foreach($progress as $key=>$val)
                                <div class="form_d form_d_b">
                                    <div class="form_d_1 form_d_st1">
                                        <span class="userk">选择时间：</span><input type="date" name="stoer[{{$val['timename'] or ''}}]" value="{{$val['time'] or ''}}" required="required" class="userk_input">
                                    </div>
                                    <div class="form_d_2 form_d_st2">
                                        <textarea name="stoer[{{$val['mainname'] or ''}}]" required="required" class="userk_textarea">{{$val['main'] or ''}}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
