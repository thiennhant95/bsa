jQuery(document).ready(function($) {
    $('.upload_video_upload').click(function(e) {
        e.preventDefault();
        var custom_uploader = wp.media({
            title: 'Library Media',
            button: {
                text: 'Upload Video'
            },
            multiple: false
        })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('.upload_video').attr('src', attachment.url);
                $('.upload_video_upload').val(attachment.url);
                $('#display_iframe').css({"display":"block"});
            })
            .open();
    });
    $(".video_type").change(function(){
        var video_type = $(this).val();
        if(video_type == 0){
            $("#load-youtube").html('');
            $("#url-video").css({"display":"block"});
            $(".upload_video").attr("src","");
            $(".upload_video_upload").val("");
            $("#upload-video").css({"display":"none"});
        }
        if(video_type == 1){
            $("#load-youtube").html('');
            $("#upload-video").css({"display":"block"});
            $(".url-video").val("");
            $("#url-video").css({"display":"none"});
        }
    })
    $(".url-video").change(function(){
        var url_video = $(this).val();
        $("#load-youtube").html('');
        $("#load-youtube").html(url_video);
    });
});
