$(document).ready(function () {
    $(document).on("input", "#search_by_text", function (e) {
        //get the value of the text
        var search_by_text = $(this).val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();

        //ajax code for search
        jQuery.ajax({
            // url that we prepared before
            url: ajax_search_url,
            type: "post",
            dataType: "html",
            cache: false,
            data: {
                search_by_text: search_by_text,
                _token: token_search,
            },
            success: function (data) {
                //replace the content of the 'ajax_search_div' with the content of the "ajax_search_url" which contains
                // the content of the page 'ajax_search.blade.php'
                $("#ajax_search_div").html(data);
            },
            error: function () {},
        });
    });

    // "a" means if you click on any anchor
    $(document).on("click", " #ajax_pagination_in_search a ", function (e) {
        e.preventDefault();
        var search_by_text = $("#search_by_text").val();
        var url = $(this).attr("href");
        var token_search = $("#token_search").val();
        //ajax code for search
        jQuery.ajax({
            url: url,
            type: "post",
            dataType: "html",
            cache: false,
            data: {
                search_by_text: search_by_text,
                _token: token_search,
            },
            success: function (data) {
                //replace the content of the 'ajax_search_div' with the content of the "ajax_search_url" which contains
                // the content of the page 'ajax_search.blade.php'
                $("#ajax_search_div").html(data);
            },
            error: function () {},
        });
    });
});
