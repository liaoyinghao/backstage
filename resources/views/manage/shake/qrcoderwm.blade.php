@extends('manage.common.master')
@section('usercss')
<style media="screen">
    .md200{width: 200px;margin-top: 20px;}
    .btn-info{width: 200px}
</style>
@endsection
@section('userjs')
    <script>
        $(function(){

            $("#news-table").DataTable({
                "aaSorting": [
                    [ 0, "desc" ]
                ]
            });
        });


        $("#downloaddrq").on('click',function(){
            var shopArray = '';
            var i = 0;
            $("input[name='ewm_name[]']:checked").each(function(){
                var zhi = $(this).val();
                if(i==0){
                  shopArray = zhi;
                }else{
                  shopArray += ","+zhi;
                }
                i++;
            });
            
            if(shopArray == ''){
                alert("请选择您需要下载的二维码！");
                return false;
            }

            var url = "{{route('manage_shake_qrcoderwm')}}?shopid="+shopArray+"&exec_id=erweima";
            window.open(url);

        })

    </script>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase">下载二维码</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn grey-mint btn-outline fullscreen" data-original-title="全屏" title=""><i class="icon-size-fullscreen"></i> 全屏</a>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="form-group form-md-checkboxes">
                        <div class="md-checkbox-inline checkbox_qwe">
                    @if(isset($lists))
                    @foreach($lists as $sp)
                            <div class="md-checkbox has-info md200">
                                <input type="checkbox" id="cb{{$sp->id}}" name="ewm_name[]" value="{{$sp->id}}" class="md-check">
                                <label for="cb{{$sp->id}}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{$sp->bianhao}} ({{$shop[$sp->sn] or '无绑定'}})</label>
                            </div>
                    @endforeach
                    @endif
                        </div>
                    </div>
                    <p><br>选中二维码，点击下载二维码，图片将以压缩包方式下载！</p>
                    <input type='submit' id="downloaddrq" class='btn btn-info'  value='下 载 二 维 码'>
                </div>

            </div>
        </div>
    </div>

@endsection
