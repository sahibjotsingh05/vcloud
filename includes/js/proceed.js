//THIS CODE IS REQUIRED TO BE SEPARATE. FOR ELEMENTS APPENDED BY AJAX

$(document).ready(function() {
    $(".suggestion").on('click', function() {
        $("#search_bar").val($(this).val());
        $("#search_bar").focus().keyup();
    }).hover(function() {
        $(this).addClass('hl');
    }, function() {
        $(this).removeClass('hl');
    });
    $("#search_bar").on('keydown', function(event) {
        if (event.which == 13) {
            var to_search = $(this).val();
            var current_url = document.URL;
            var combine_table = ''; //FOR COMBINING THE TABLE NAME
            var first_equal = current_url.indexOf('=');
            var first_and = current_url.indexOf('&');

            for (i = first_equal + 1; i < first_and; i++) { //FOR TABLE NAME
                combine_table += current_url[i];
            }

            window.location = 'content.php?show=' + combine_table + '&condition=search&searchFor=' + to_search;
        }
    })
});

// up arrow:- 38
// down arrow:- 40