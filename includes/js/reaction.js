$(document).ready(function() {
    $(".side_content").hide();

    $(".aside_item").css('display', 'none');

    $(".collapser").click(function() {
        $("hr").css('display', 'none');
        $("aside").css('width', '0');
        $(".aside_item").css('display', 'none');
    });

    $(".un_collapser").click(function() {
        $("hr").css('display', 'block');
        $("aside").css('width', '22%');
        $(".aside_item").css('display', 'block');
    });

    $(".user").click(function() {
        $(".side_content").toggle();
    });

    //FOR SEARCH BAR
    $("#search_bar").on('keyup', function() {
        var to_search = $(this).val();
        if (to_search.length > 2) {
            var combine_search_string = ''; //FOR COLLECTING THE SEARCH AS A REFINED STRING.

            var current_url = document.URL;
            var combine_table = ''; //FOR COMBINING THE TABLE NAME
            var first_equal = current_url.indexOf('=');
            var first_and = current_url.indexOf('&');

            for (i = 0; i < to_search.length; i++) {
                combine_search_string += to_search[i];
            }

            for (i = first_equal + 1; i < first_and; i++) { //FOR TABLE NAME
                combine_table += current_url[i];
            }
            $.post('process_search_suggestion.php', {
                call: true,
                table_name: combine_table,
                to_search: combine_search_string
            }, function(data) {
                $(".search_suggestion").html(data);
            });
        } else {
            $(".search_suggestion").html('');
        }
    });

    //FOR REDIRECTING THE PAGE ACCORDING TO THE GIVEN CONDITION
    var condition = '';
    $("button.feature").click(function() {
        var to_show = $(this).attr('value');
        condition = $(this).attr('id');
        window.location = 'content.php?show=' + to_show + '&condition=' + condition;
    });
    $("button.subject").click(function() {
        var to_show = $(this).attr('value');
        condition = $(this).attr('id');
        window.location = 'content.php?show=' + to_show + '&condition=' + condition;
    });
    $("button.pseudo_feature").click(function() {
        var to_show = $(this).attr('value');
        var condition = $(this).attr('id');
        window.location = 'content.php?show=' + to_show + '&condition=' + condition;
    });
});