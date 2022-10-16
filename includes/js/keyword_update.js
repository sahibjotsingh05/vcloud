$(document).ready(function() {
    $(".update").click(function() {
        var vid_name = $(this).siblings(".vid_name").text();
        var vid_id = $(this).siblings(".video").attr('id');
        var keyword = $(this).siblings("#keyword").val();

        if ($(this).siblings('.video').attr('content_type') == 'video') {
            var time_duration = document.getElementById(vid_id).duration;
        } else {
            var time_duration = 0.0;
        }

        if (keyword.length > 0) {
            $.post('process_keyword_update.php', {
                update: true,
                vid_name: vid_name,
                vid_id: vid_id,
                keyword: keyword,
                time_duration: time_duration
            }, function(data) {
                if (data == 'updated') {
                    document.location.reload();
                } else {
                    alert(data);
                }
            });
        } else {
            alert("Input the keywords");
        }
    });
    $(".video").on('play', function() {
        var current_click = $(this).attr('id');
        $(".video").each(function() {
            var current_element = $(this).attr('id');
            if (!this.paused && current_element != current_click) {
                this.pause();
            }
        });
    });
});