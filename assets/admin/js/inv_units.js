$(document).ready(function () {
    //use on input because it is an input field
    $(document).on("input", "#search_by_text", function (e) {
        make_search();
    });
    //use on change because it is a select menu
    $(document).on("change", "#is_master_search", function (e) {
        make_search();
    });

    //  =========================================pagination in ajax search=======================================
    // "a" means if you click on any anchor
    $(document).on("click", " #ajax_pagination_in_search a ", function (e) {
        // to prevent the default method 'get' when you click on the link
        //  but in ajax we use post method
        e.preventDefault();
        //get values which user entered
        var is_master_search = $("#is_master_search").val();
        var search_by_text = $("#search_by_text").val();
        //attr("href") >> this will extract the page link when you click on pagination[1,2,3,....]
        //the results will be like this
        // http://localhost/sales/admin/units/ajax_search?page=1
        // http://localhost/sales/admin/units/ajax_search?page=2
        var url = $(this).attr("href");

        var token_search = $("#token_search").val();
        //ajax code for search
        jQuery.ajax({
            //url which the function will submit to
            url: url,
            // used post method 'the default is get
            type: "post",
            //if the ajax request success, this function will receive the returned data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request){key:value}
            //If the HTTP method is one that cannot have an entity body, such as GET, the data is appended to the URL.
            data: {
                search_by_text: search_by_text,
                is_master_search: is_master_search,
                _token: token_search,
            },
            //if the function in the controller succeded ,this function will return the
            // 'ajax_search.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the 'ajax_search_div'[in the index page] with the content of
                // the "returned_data" which contains the content of the page 'ajax_search.blade.php' will all data
                //in form of text
                $("#ajax_search_div").html(returned_data);
            },
            error: function () {},
        });
    }); //end pagination in ajax search
    //============================================== make_search function===========================================
    function make_search() {
        //get the value of the text and is_master selection
        var search_by_text = $("#search_by_text").val();
        var is_master_search = $("#is_master_search").val();

        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();

        //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
        jQuery.ajax({
            //url which the function will submit to, and send the request
            url: ajax_search_url,
            // used post method, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request){key:value}
            //If the HTTP method is one that cannot have an entity body, such as GET, the data is appended to the URL.
            data: {
                search_by_text: search_by_text,
                is_master_search: is_master_search,
                _token: token_search,
            },
            //if the function in the controller succeded ,this function will return the
            // 'ajax_search.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the 'ajax_search_div'[in the index page] with the content of
                // the "returned_data" which contains the content of the page 'ajax_search.blade.php' will all data
                //in form of text
                $("#ajax_search_div").html(returned_data);
            },
            error: function () {},
        });
    } //end make_search
}); //end document.ready
