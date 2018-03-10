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


    $(".table").on('click','.manage-checkboxs',function(){
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


});

//functions
