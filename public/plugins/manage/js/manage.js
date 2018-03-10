//actions
$(function(){
    $("table").on('click','.m-g-del',function(){
        var did=$(this).attr("data-did");
        if(did<0 || typeof(did) == "undefined"){
            alert("数据出错,请刷新重试");
            return false;
        }else{
            if(confirm("确认删除吗")){

                $.ajax({
                    type:"delete",
                    url:location.pathname+'/'+did,
                    success:function(s){
                        if(s){
                            alert("删除成功");
                            location.href=location.href;
                        }else{
                            alert("删除失败,请刷新重试");
                        }
                    }
                });
            }
        }
    });

    $(".menu-toggler.sidebar-toggler").click(function(){
        if($("body").hasClass('page-sidebar-closed')){
            var mf=0;
        }else{
            var mf=1;
        }

        $.ajax({
            type:"get",
            url:"/m/process/pagesidebar?flag="+mf,
            success:function(s){

            }
        });
    });


    $(".table").on("click",".manage-checkboxs",function(){
        var m=$(this).attr("data-model");
        var id=$(this).attr("data-sid");
        var col=$(this).attr("data-status");
        var val=$(this).attr("data-val");
        if(typeof(val)=="undefined"){
            if($(this).is(':checked')){
                var v=1;
            }else{
                var v=0;
            }
        }else{
            v=val;
        }
        $.ajax({
            type:"get",
            url:"/m/process/statuscheck?m="+m+"&id="+id+"&col="+col+"&v="+v,
            success:function(s){
            }
        });
    });


    $.extend( $.fn.dataTable.defaults, {
        "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "全部"]
            ],
        "autoWidth": false,
        "pageLength":25,
        language: {
            "sProcessing": "处理中...",
            "sLengthMenu": "显示 _MENU_ ",
            "sZeroRecords": "没有匹配结果",
            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
            "sInfoPostFix": "",
            "sSearch": "搜索:",
            "sUrl": "",
            "sEmptyTable": "目前没有数据",
            "sLoadingRecords": "载入中...",
            "sInfoThousands": ",",
            "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
            },
            "oAria": {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }
    });

});

//functions

function mLoading(){
    bootbox.dialog({ message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> 处理中...</div>' })
}
