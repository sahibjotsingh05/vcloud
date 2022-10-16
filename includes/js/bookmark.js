$(document).ready(function() {
    $('.additional_info button').click(function() {
        var condition = '';
        if ($(this).attr('class') == 'bookmark') {
            condition = 'set';
        } else {
            condition = 'unset';
        }
        $.post('process_bookmark.php', {
            call: true,
            for_video: $(this).attr('for_video'),
            condition: condition
        }, function(data) {
            let new_class = data;
            $('.additional_info button').attr('class', new_class)
        });
    });
})