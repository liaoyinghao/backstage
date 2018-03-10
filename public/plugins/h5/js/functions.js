//h5上传图片

function h5PicRemove(){
    $(".weui-cells").on("click",".weui-x-remove",function(){
        var m=$(this);
        $.confirm("确定删除吗", function() {m.parent().remove();}, function() {});
    });
}

$.fn.h5PicUpload=function (c){
    this.UploadImg({
        url : "/h5/process/picupload",
        width : "640",
        quality : "1", //压缩率，默认值为0.7
        mixsize : c.size,//字节，1m
        before : function(blob){
            $.showLoading("图片上传中");
        },
        error : function(d){
            $.hideLoading();
            $.toast(d,"cancel");
        },
        success : function(d){
            $.hideLoading();
            c.ss(d)
        }
    });
}

function helpText(key){
    $.post("/h5/process/help",{"flag":"text","key":key},function(d){
        if(d){
            $.alert(d,"帮助");
        }else{
            $.alert("详情请咨询互动街","帮助");
        }

    });
}
