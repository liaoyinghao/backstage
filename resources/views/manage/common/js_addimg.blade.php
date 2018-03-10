KindEditor.ready(function(K) {
    var editor = K.editor({
        uploadJson : "{{route('m_process_keupload')}}",
        fileManagerJson : "{{route('m_process_kefile')}}",
        allowFileManager : true
    });
    K("#k_img{{$img_id or ''}}").click(function() {
        editor.loadPlugin("image", function() {
            editor.plugin.imageDialog({
                imageUrl : K("#k_img_hidden{{$img_id or ''}}").val(),
                clickFn : function(url, title, width, height, border, align) {
                    var num=$('.aaaa').length;
                    var newValue = parseInt(num) +1;
var obj='img_'+newValue;
var obj="'"+obj+"'";
                   var html='';
                   html+="<span class='aaaa' onclick='del(this);'>X</span><img src="+url+" id='img_"+newValue+"' width='100px;' height='100px;'><input type='hidden' name='imgs[]' value="+url+"><span class='bbbb'><a href='#' class='btn red-mint btn-outline btn-xs' data-toggle='modal'  onclick='url(this)' hidden_id="+newValue+">添加图片链接</a></span><input type='hidden' name='url[]' id='url_"+newValue+"' class='url'> ";
                    $('#showimgs').append(html);
                    editor.hideDialog();
                }
            });
        });
    });
});