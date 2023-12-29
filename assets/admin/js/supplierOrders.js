$(document).ready(function () {
    // ========================================= ajax search for units=======================================
    // '#item_code_add' is the selection in which the items
    $(document).on("change", "#item_code_add", function (e) {
        //constant
        var token_search = $("#token_search").val();
        var ajax_get_item_units_url = $("#ajax_get_item_units_url").val();
        var item_code_add = $(this).val();
        //if there is no selection
        if (item_code_add != "") {
            //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
            jQuery.ajax({
                //url which the function will submit to, and send the request
                url: ajax_get_item_units_url,
                // used 'post' method to send the data to url, the default is "get"
                type: "post",
                //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
                dataType: "html",
                cache: false,
                //Data to be sent to the server (data sent in the request)as{key:value}
                //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.
                data: {
                    item_code_add: item_code_add,
                    _token: token_search,
                },
                //if the function in the controller succeded ,this function will return the
                // 'file.blade.php' with all data as "html text "
                //and we will receive the returned data in a variable ex:returned_data
                success: function (returned_data) {
                    //replace the content of the element 'ajax_search_div' only [in the 'main view' page] with the content of
                    // the "returned_data" which contains variables and the content of the page 'file.blade.php' in form of text
                    $("#unitDivAdd").html(returned_data);
                    //show the unit selection after success
                    $(".unit_div").show();
                    // 'type' is a custom attribute you added in the selection options to retain a value with your selection
                    var data_type = $("#item_code_add")
                        .children("option:selected")
                        .data("type");
                    //if the item has production date "'2' يعني استهلاكي"
                    if (data_type == 2) {
                        $(".date_div").show();
                    } else {
                        $(".date_div").hide();
                    }
                },
                error: function () {
                    $("#unitDivAdd").html("");
                    $(".unit_div").hide();
                    $(".date_div").hide();
                    alert("error");
                },
            });
        } else {
            $(".date_div").hide();
            $("#unitDivAdd").html("");
            $(".unit_div").hide();
        }
    }); // end ajax search of units 'on change function'
    // ========================================end ajax search for units====================================

    // ========================================= ajax search for units=======================================
    // '#item_code_add' is the selection in which the items
    function ajax_reload_items_details() {
        //constant
        var token_search = $("#token_search").val();
        var ajax_reload_items_details_url = $(
            "#ajax_reload_items_details_url"
        ).val();
        var auto_serial = $("#auto_serial").val();
        //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
        jQuery.ajax({
            //url which the function will submit to, and send the request
            url: ajax_reload_items_details_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.
            data: {
                auto_serial: auto_serial,
                _token: token_search,
            },
            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the element 'ajax_search_div' only [in the 'main view' page] with the content of
                // the "returned_data" which contains variables and the content of the page 'file.blade.php' in form of text
                $("#ajax_details_div").html(returned_data);
            },
            error: function () {},
        });
    } // end ajax search of units 'on change function'
    // ========================================end ajax search for units====================================

    // =========================================  ajax_reload_parent_bill=======================================
    // '#item_code_add' is the selection in which the items
    function ajax_reload_parent_bill() {
        //constant
        var token_search = $("#token_search").val();
        var ajax_reload_parent_bill_url = $(
            "#ajax_reload_parent_bill_url"
        ).val();
        var auto_serial = $("#auto_serial").val();
        //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
        jQuery.ajax({
            //url which the function will submit to, and send the request
            url: ajax_reload_parent_bill_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.
            data: {
                auto_serial: auto_serial,
                _token: token_search,
            },
            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the element 'ajax_search_div' only [in the 'main view' page] with the content of
                // the "returned_data" which contains variables and the content of the page 'file.blade.php' in form of text
                $("#ajax_reload_bill_div").html(returned_data);
            },
            error: function () {},
        }); //end if ajax
    } // end ajax search of units 'on change function'
    // ========================================end ajax_reload_parent_bill====================================
    function validation() {}
    // =====================================validation when you click add to bill================================

    $(document).on("click", "#addToBill_button", function (e) {
        //validation on inputs
        var item_code_add = $("#item_code_add").val();
        if (item_code_add == "") {
            alert("اختر الصنف من فضلك");
            $("#item_code_add").focus();
            return false;
        }

        var unit_id_add = $("#unit_id_add").val();
        if (unit_id_add == "") {
            alert("اختر الوحدة من فضلك");
            $("#unit_id_add").focus();
            return false;
        }
        //to get tha value of 'data-parent_unit 'from the selection "#unit_id_add"
        var is_parent_unit = $("#unit_id_add")
            .children("option:selected")
            .data("parent_unit");

        var quantity_add = $("#quantity_add").val();
        if (quantity_add == "" || quantity_add == 0) {
            alert("ادخل الكمية من فضلك");
            $("#quantity_add").focus();
            return false;
        }

        var price_add = $("#price_add").val();
        if (price_add == "") {
            alert("ادخل سعر الوحدة من فضلك");
            $("#price_add").focus();
            return false;
        }
        var total_add = $("#total_add").val();

        //2 استهلاكي
        if (data_type == 2) {
            var production_date = $("#production_date").val();
            if (production_date == "") {
                alert("ادخل تاريخ الانتاج من فضلك");
                $("#production_date").focus();
                return false;
            }

            var expire_date = $("#expire_date").val();
            if (expire_date == "") {
                alert("ادخل تاريخ انتهاء الصلاحية من فضلك");
                $("#expire_date").focus();
                return false;
            }

            if (expire_date < production_date) {
                alert("تاريخ الانتهاء لايمكن ان يسبق تاريخ الانتاج");
                $("#expire_date").focus();
                return false;
            }
        } else {
            var production_date = $("#production_date").val();
            var expire_date = $("#expire_date").val();
        } //end 'data_type' if

        var data_type = $("#item_code_add")
            .children("option:selected")
            .data("type");
        var auto_serial = $("#auto_serial").val();

        var token_search = $("#token_search").val();
        var ajax_add_details_url = $("#ajax_add_details_url").val();
        //if there is no selection
        //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
        jQuery.ajax({
            //url which the function will submit to, and send the request
            url: ajax_add_details_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "json",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.
            data: {
                auto_serial: auto_serial,
                _token: token_search,
                item_code_add: item_code_add,
                unit_id_add: unit_id_add,
                is_parent_unit: is_parent_unit,
                quantity_add: quantity_add,
                price_add: price_add,
                production_date: production_date,
                expire_date: expire_date,
                total_add: total_add,
                data_type: data_type,
            },
            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the element 'ajax_search_div' only [in the 'main view' page] with the content of
                // the "returned_data" which contains variables and the content of the page 'file.blade.php' in form of text
                ajax_reload_items_details();
                ajax_reload_parent_bill();
                alert("تم الاضافة بنجاح");
            },
            error: function () {
                alert("error");
            },
        });
    }); // end on click function addToBill_button
    //=================================end ajax add details to bill====================================

    // ========================================calculate the total cost=======================================
    $(document).on("input", "#quantity_add", function (e) {
        calculate_add();
    });

    $(document).on("input", "#price_add", function (e) {
        calculate_add();
    });

    function calculate_add() {
        var quantity_add = $("#quantity_add").val();
        var price_add = $("#price_add").val();
        if (quantity_add == 0) {
            quantity_add = 0;
        }
        if (price_add == 0) {
            price_add = 0;
        }
        $("#total_add").val(parseFloat(quantity_add) * parseFloat(price_add));
    }
    // ========================================calculate the total cost=======================================

    // ======================================== ajax edit item in bill========================================
    $(document).on("click", ".ajax_edit_item", function (e) {
        var id = $(this).data("id");
        var ajax_reload_edit_item_url = $("#ajax_reload_edit_item_url").val();
        var auto_serial = $("#auto_serial").val();

        var token_search = $("#token_search").val();
        //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
        jQuery.ajax({
            //url which the function will submit to, and send the request
            url: ajax_reload_edit_item_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.
            data: {
                auto_serial: auto_serial,
                _token: token_search,
                id: id,
            },
            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the element 'ajax_search_div' only [in the 'main view' page] with the content of
                // the "returned_data" which contains variables and the content of the page 'file.blade.php' in form of text
                $("#edit_item_modal_body").html(returned_data);
                $("#edit_item_modal").modal("show");

                //to hide add_item_modal and cleat its data
                $("#add_item_modal_body").html("");
                $("#add_item_modal").modal("hide");
            },
            error: function () {},
        }); //end if ajax
    });
    // ======================================== end ajax edit item in bill================================

    // ========================================  ajax_add_new_item========================================
    $(document).on("click", "#addToBillBtn", function (e) {
        var id = $(this).data("id");
        var ajax_add_new_item_url = $("#ajax_add_new_item_url").val();
        var auto_serial = $("#auto_serial").val();
        var token_search = $("#token_search").val();
        //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
        jQuery.ajax({
            //url which the function will submit to, and send the request
            url: ajax_add_new_item_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.
            data: {
                auto_serial: auto_serial,
                _token: token_search,
                id: id,
            },
            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the element 'ajax_search_div' only [in the 'main view' page] with the content of
                // the "returned_data" which contains variables and the content of the page 'file.blade.php' in form of text
                $("#add_item_modal_body").html(returned_data);
                $("#add_item_modal").modal("show");
                //to hide edit_item_modal  and cleat its data

                $("#edit_item_modal_body").html("");
                $("#edit_item_modal").modal("hide");
            },
            error: function () {},
        }); //end if ajax
    });
    // ======================================== end ajax_add_new_item=======================

    // ========================================  ajax_edit_item ============================

    $(document).on("click", "#editItem_button", function (e) {
        //validation on inputs
        var item_code_add = $("#item_code_add").val();

        if (item_code_add == "") {
            alert("اختر الصنف من فضلك");
            $("#item_code_add").focus();
            return false;
        }

        var unit_id_add = $("#unit_id_add").val();
        if (unit_id_add == "") {
            alert("اختر الوحدة من فضلك");
            $("#unit_id_add").focus();
            return false;
        }
        //to get tha value of 'data-parent_unit 'from the selection "#unit_id_add"
        var is_parent_unit = $("#unit_id_add")
            .children("option:selected")
            .data("parent_unit");

        var quantity_add = $("#quantity_add").val();
        if (quantity_add == "" || quantity_add == 0) {
            alert("ادخل الكمية من فضلك");
            $("#quantity_add").focus();
            return false;
        }

        var price_add = $("#price_add").val();
        if (price_add == "") {
            alert("ادخل سعر الوحدة من فضلك");
            $("#price_add").focus();
            return false;
        }
        var total_add = $("#total_add").val();

        //2 استهلاكي

        var id = $(this).data("id");
        var data_type = $("#item_code_add")
            .children("option:selected")
            .data("type");
        var auto_serial = $("#auto_serial").val();

        var token_search = $("#token_search").val();
        var edit_item_details_url = $("#edit_item_details_url").val();
        //if there is no selection
        //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
        jQuery.ajax({
            //url which the function will submit to, and send the request
            url: edit_item_details_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "json",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.
            data: {
                auto_serial: auto_serial,
                _token: token_search,
                item_code_add: item_code_add,
                unit_id_add: unit_id_add,
                is_parent_unit: is_parent_unit,
                quantity_add: quantity_add,
                price_add: price_add,
                production_date: production_date,
                expire_date: expire_date,
                total_add: total_add,
                data_type: data_type,
                id: id,
            },
            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the element 'ajax_search_div' only [in the 'main view' page] with the content of
                // the "returned_data" which contains variables and the content of the page 'file.blade.php' in form of text
                ajax_reload_items_details();
                ajax_reload_parent_bill();
                alert("تم التحديث بنجاح");
            },
            error: function () {
                alert("error");
            },
        });
    });
    // ======================================== end ajax_edit_item ====================================

    //=========================================ajax approve invoice====================================
    $(document).on("click", "#do_approve", function (e) {
        var ajax_add_new_item_url = $("#ajax_approve_invoice_url").val();
        var auto_serial = $("#auto_serial").val();
        var token_search = $("#token_search").val();
        //ajax code for search( jQuery.ajax == $.ajax ) both have the same effect
        jQuery.ajax({
            //url which the function will submit to, and send the request
            url: ajax_add_new_item_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.
            data: {
                auto_serial: auto_serial,
                _token: token_search,
            },
            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text "
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace the content of the element 'ajax_search_div' only [in the 'main view' page] with the content of
                // the "returned_data" which contains variables and the content of the page 'file.blade.php' in form of text
                $("#approve_body").html(returned_data);
                $("#approve_modal").modal("show");
            },
            error: function () {},
        }); //end if ajax
    });
    //=========================================end ajax approve invoice================================

    //======================================= approve invoice calculations=============================

    //---------------------------------tax calculation------------------------------------
    //automatically claculated the values when the user input the tax value
    $(document).on("input", "#tax_percent", function () {
        taxCalculation();
        discountCalculation();
    });

    function taxCalculation() {
        //if the tax field is empty assign it to zero
        var tax_percent = $("#tax_percent").val();
        if (tax_percent == "") {
            tax_percent = 0;
        }
        //parseFloat to convert string to number to make operation on it
        tax_percent = parseFloat(tax_percent);
        var item_total_price = parseFloat($("#item_total_price").val());
        //get tax value according to input tax
        var taxValue = item_total_price * (tax_percent / 100);
        // tofixed get two decimal number only after point and the outcome is string
        var totalPriceAfterTax = (item_total_price + taxValue).toFixed(2);
        //show up the output on the screen
        $("#bill_total_cost_before_discount").val(totalPriceAfterTax);
        // tofixed get two decimal number only after point and the outcome is string
        taxValue = taxValue.toFixed(2);
        //show up the output on the screen
        $("#tax_value").val(taxValue);
    }
    //----------------------------------------end tax calculation-------------------------------

    //----------------------------------------discount calculation------------------------------
    $("input[name=radio_discount]").change(function () {
        var discountType = $("input[name=radio_discount]:checked").val();
        // 1 is percentage
        if (discountType == 1) {
            //show بالنسبةالمئوية%
            $("#discountPercentage").show();
            //hide بالجنية
            $("#discountPound").hide();
            //show input field
            $(".discount_value").show();
            // 2 is pound
        } else if (discountType == 2) {
            //hide بالنسبةالمئوية%
            $("#discountPercentage").hide();
            // show  بالجنية
            $("#discountPound").show();
            //show input field
            $(".discount_value").show();
        } else {
            $("#discountPercentage").hide();
            $("#discountPound").hide();
            //hide input field
            $(".discount_value").hide();
            $("#discount_value").val("0");
        }
        discountCalculation();
    });

    $(document).on("input", "#discount_value", function () {
        discountCalculation();
    });
    function discountCalculation() {
        //get the type of the discount -percentage or value-
        var discountType = $("input[name=radio_discount]:checked").val();
        //get discount value from the user whether value or percentage
        var discount_value = $("#discount_value").val();
        //if the input is empty assign it to 0
        if (discount_value == "") {
            discount_value = 0;
        }
        //the conver string to float to make some math operations
        discount_value = parseFloat(discount_value);
        //the the value to bill after tax and before discount
        var bill_total_cost_before_discount = parseFloat(
            $("#bill_total_cost_before_discount").val()
        );
        //if user chosen percentage "1"---------------------------------------------
        if (discountType == 1) {
            var discount_value =
                bill_total_cost_before_discount * (discount_value / 100);
            finalDiscount = bill_total_cost_before_discount - discount_value;
            discount_value = discount_value.toFixed(2);
            //show up the output on the screen
            $("#discount_percent").val(discount_value * 1);
            $("#bill_final_total_cost").val(finalDiscount);
            //if user chosen manual value "2"---------------------------------------
        } else if (discountType == 2) {
            finalDiscount = bill_total_cost_before_discount - discount_value;
            discount_value = discount_value.toFixed(2);
            //show up the output on the screen
            $("#discount_percent").val(discount_value * 1);
            $("#bill_final_total_cost").val(finalDiscount);
            //if there is no discount
        } else {
            //no discount applied
            finalDiscount = bill_total_cost_before_discount;
            discount_value = 0;
            //show up the output on the screen
            $("#bill_final_total_cost").val(finalDiscount);
            $("#discount_percent").val(discount_value);
        }
    }
    //------------------------------------end discount calculation------------------------------

    //======================================end approve invoice calculations===========================
}); //end of the main ready function
