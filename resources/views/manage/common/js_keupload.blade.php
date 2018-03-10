KindEditor.ready(function(K) {
    var editor = K.editor({
        uploadJson : "{{route('manage_process_keupload')}}",
        fileManagerJson : "{{route('manage_process_kefile')}}",
        allowFileManager : true
    });
    K("#k_img{{$img_id or ''}}").click(function() {
        editor.loadPlugin("image", function() {
            editor.plugin.imageDialog({
                imageUrl : K("#k_img_hidden{{$img_id or ''}}").val(),
                clickFn : function(url, title, width, height, border, align) {
                    $("#k_img_hidden{{$img_id or ''}}").val(url);
                    $("#k_img_image{{$img_id or ''}}").attr("src",url);
                    $("#k_img_image{{$img_id or ''}}").show();
                    $("#k_img_a{{$img_id or ''}}").attr("href",url);
                    editor.hideDialog();
                }
            });
        });
    });
});
