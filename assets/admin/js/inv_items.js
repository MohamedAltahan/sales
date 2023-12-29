$(document).ready(function () {
    // when you use validation and go back you need to restore "#primary_unit_id" and "#retail_unit_id" and use thire values without
    // any addtional actions from the user
    var unit = $("#primary_unit_id").val();
    if (unit != "") {
        var name = $("#primary_unit_id option:selected").text();
        $(".parentUnitName").text(name);
    }
    var unit = $("#retail_unit_id").val();
    if (unit != "") {
        var name = $("#retail_unit_id option:selected").text();
        $(".childUnitName").text(name);
    }

    $(document).on("change", "#has_retailunit", function (e) {
        var parentUnit = $("#primary_unit_id").val();
        if (parentUnit == "") {
            alert("اختار الوحدة الاساسية اولا");
            $("#has_retailunit").val("");
            return false;
        }
        if ($(this).val() == 1) {
            $(".retial").show();
        } else {
            $(".retial").hide();
            $(".secondary_retial").hide();
            $("#retail_unit_id").val(null);
            $("#secondary_retail_price").val(null);
            $("#secondary_half_wholesale_price").val(null);
            $("#secondary_wholesale_price").val(null);
            $("#secondary_cost").val(null);
            $("#units_per_parent").val(null);
        }
    });

    $(document).on("change", "#item_stock_type", function (e) {
        var inStockInput = $("#item_stock_type").val();
        //1 is unlimited quantity
        if (inStockInput == 1) {
            $("#inStockInput").hide();
            //2 is limited quantity so show up the input field
        } else {
            $("#inStockInput").show();
        }
    });

    $(document).on("change", "#primary_unit_id", function (e) {
        if ($(this).val() != "") {
            $("#has_retailunit").show();
            var name = $("#primary_unit_id option:selected").text();
            $(".parentUnitName").text(name);
            $(".primary_retial").show();
        } else {
            $(".secondary_retial").hide();
            $("#has_retailunit").val("");
            $("#retail_unit_id").val("");
            $(".parentUnitName").text("");
            $(".retial").hide();
            $(".primary_retial").hide();
        }
    });

    $(document).on("change", "#retail_unit_id", function (e) {
        if ($(this).val() != "") {
            var name = $("#retail_unit_id option:selected").text();
            $(".childUnitName").text(name);
            $(".secondary_retial").show();
        } else {
            $("#retail_unit_id").val("");
            $(".secondary_retial").hide();
            $(".childUnitName").text("");
        }
    });

    //use on input because it is an input field
    $(document).on("input", "#search_by_text", function (e) {
        make_search();
    });
    //use on input because it is an input field
    $(document).on("change", "#item_type_search", function (e) {
        make_search();
    });

    $("input[name=radio_search]").change(function () {
        make_search();
    });

    //  =========================================pagination in ajax search=======================================
    // "a" means if you click on any anchor
    $(document).on("click", " #ajax_pagination_in_search a ", function (e) {
        // to prevent the default method 'get' when you click on the link
        //  but in ajax we use post method
        e.preventDefault();
        //get values which user entered
        var search_by_text = $("#search_by_text").val();

        // to to check radio button and get its value
        var radio_search = $("input[name=radio_search]:checked").val();
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
                radio_search: radio_search,
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

    // =====================================================search_function============================================
    function make_search() {
        //get the value of the text and is_master selection
        var search_by_text = $("#search_by_text").val();
        var item_type_search = $("#item_type_search").val();
        var inv_category_id_search = $("#inv_category_id_search").val();
        //  to check radio button and get its value
        var radio_search = $("input[name=radio_search]:checked").val();
        //constant
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
                item_type_search: item_type_search,
                inv_category_id_search: inv_category_id_search,
                radio_search: radio_search,
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
    }
}); //end of the main ready function
