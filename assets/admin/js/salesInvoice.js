$(document).ready(function () {
    //=================================getting data about the chosen user=============================================
    $(document).on("change", "#customer_id", function () {
        //if the user choose any value or not
        var customer_id = $("#customer_id").val();
        //get the choosen user balance
        var current_balance = $("#customer_id option:selected").data("balance");
        //if user not choose anything set the old input to empty
        if (customer_id == "") {
            $("#oldRemain").val("");
        } else {
            //check if the account if debit to show up a massage 'مدين'
            if (current_balance < 0) {
                $("#debit").show();
                $("#credit").hide();
                //if the user is credit hide 'مدين'
            } else if (current_balance > 0) {
                $("#debit").hide();
                $("#credit").show();
            } else {
                $("#debit").hide();
                $("#credit").hide();
            }
            //then set the old remain to the current user balance
            $("#oldRemain").val(current_balance);
        }
    });
    //===============================end getting data about the chosen user=============================================

    //================================even of adding or subtracting buttons=============================================
    $(document).on("click", "#addToQuantity", function () {
        var quantity = $("#quantity").val();
        quantity++;
        $("#quantity").val(quantity);
    });

    $(document).on("click", "#subFromQuantity", function () {
        var quantity = $("#quantity").val();
        if (quantity > 1) {
            quantity--;
            $("#quantity").val(quantity);
        }
    });
    //================================even of adding or subtracting buttons=============================================
    $(document).on("click", "#print", function () {
        window.print();
    });

    // ============================================ ajax add item to invoice===========================================
    $(document).on("click", "#printTarget", function (e) {
        // e.preventDefault();

        var ajax_print_url = $("#ajax_print_url").val();
        alert(ajax_print_url);
        var token_search = $("#token_search").val();
        var invoiceDate = $("#invoiceDate").val();

        //if the user does't chose the customer name alert him
        if (customer_id == "") {
            alert("اختار اسم العميل");
            $("#customer_id").focus();
            return false;
        } else {
            //after the user chosen customer name once click add one item to
            //invoicee prevent the user form changein the customer name
            // $("#customer_id").attr("disabled", "disabled");
            $("#customer_id").attr("style", "pointer-events: none;");
        }

        if (item_code == "") {
            alert("اختار اسم الصنف");
            $("#item_code").focus();
            return false;
        }
        if (what_paid == "") {
            $("#what_paid").val(0);
        }
        //=======this ajax used to store the chosen item to database one by one (once the user click on '#addToInvoice')=========
        jQuery.ajax({
            //url which the function will submit to, and send the request to.
            url: ajax_add_new_item_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.

            data: {
                item_name: item_name,
                _token: token_search,
                invoice_total_price: invoice_total_price,
                invoice_total_price_with_old: invoice_total_price_with_old,
                unit_id: unit_id,
                what_paid: what_paid,
                what_remain: what_remain,
                sales_invoice_id: sales_invoice_id,
                invoiceDate: invoiceDate,
                customer_id: customer_id,
                oldRemain: oldRemain,
                item_code: item_code,
                quantity: quantity,
                item_type: item_type,
                unit_price: unit_price,
                chassisWidthValue: chassisWidthValue,
                total_unit_price: total_unit_price,
            },

            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text" or 'json' as you define
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace(.html) or append(.append) the content of the element 'ajax_add_new_item' only
                // [in the 'main view' page] with the content of the "returned_data"
                //  which contains variables and the content of the page 'file.blade.php' in form of text or json
                $("#ajax_add_new_item").append(returned_data);
                //after adding the item to database recalculated the total invoice using ajax
                //and passing function 'recalcInputs' to recalculated input
                ajax_culcTotalInvoiceWithoutOld(recalcInputs);
            },
            error: function () {},
        }); //end if ajax
    }); //end "#addToInvoice" function
    // ======================================== end ajax edit item in bill================================
    //=================================getting data about the chosen item===============================================
    $(document).on("change", "#item_code", function () {
        //get the type of the choosen product[chassis or product]
        var item_type = $("#item_code option:selected").data("type");
        var in_stock_quantity = $("#item_code option:selected").data(
            "quantity"
        );
        $("#stock_quantity").val(in_stock_quantity);
        $("#item_type").val(item_type);
        // 2 is a chassis so show up the input width of chassis to enter
        if (item_type == 2) {
            $("#chassisWidth").show();
        } else {
            $("#chassisWidth").hide();
            $("#chassisWidth").val("");
        }
        //calculate total item price when select item
        calculateTotalForItem();
    });
    //=================================end getting data about the chosen item===============================================

    // ===================events realated to changing of item calcualtions(quantity and size...)============================
    //calculate total item price while changing the chassis size
    $(document).on("input", "#chassisWidthValue", function () {
        calculateTotalForItem();
    });
    //calculate total item price when select item when you change the quantity
    $(document).on("input", "#quantity", function () {
        calculateTotalForItem();
    });
    //when click on the increase button recalculate the total of chosen item
    $(document).on("click", "#addToQuantity", function () {
        calculateTotalForItem();
    });
    //when click on the decrease button recalculate the total of chosen item
    $(document).on("click", "#subFromQuantity", function () {
        calculateTotalForItem();
    });
    // =================end events realated to changing of item calcualtions(quantity and size...)=========================

    // ============================================ ajax add item to invoice===========================================
    $(document).on("click", "#addToInvoice", function (e) {
        e.preventDefault();

        var ajax_add_new_item_url = $("#ajax_add_new_item_url").val();
        var token_search = $("#token_search").val();
        var invoiceDate = $("#invoiceDate").val();
        var customer_id = $("#customer_id").val();
        var oldRemain = $("#oldRemain").val();
        var item_code = $("#item_code").val();
        var item_name = $("#item_code option:selected").text();
        var quantity = $("#quantity").val();
        var item_type = $("#item_code option:selected").data("type");
        var unit_price = $("#item_code option:selected").data("price");
        var chassisWidthValue = $("#chassisWidthValue").val();
        var total_unit_price = $("#totalOneItemPrice").val();
        var sales_invoice_id = $("#sales_invoice_id").val();
        var invoice_total_price = $("#totalInvoice").val();
        var unit_id = $("#item_code option:selected").data("unit");
        var what_paid = $("#what_paid").val();
        var what_remain = $("#what_remain").val();
        var invoice_total_price_with_old = $(
            "#invoice_total_price_with_old"
        ).val();
        //if the user does't chose the customer name alert him
        if (customer_id == "") {
            alert("اختار اسم العميل");
            $("#customer_id").focus();
            return false;
        } else {
            //after the user chosen customer name once click add one item to
            //invoicee prevent the user form changein the customer name
            // $("#customer_id").attr("disabled", "disabled");
            $("#customer_id").attr("style", "pointer-events: none;");
        }

        if (item_code == "") {
            alert("اختار اسم الصنف");
            $("#item_code").focus();
            return false;
        }
        if (what_paid == "") {
            $("#what_paid").val(0);
        }
        //=======this ajax used to store the chosen item to database one by one (once the user click on '#addToInvoice')=========
        jQuery.ajax({
            //url which the function will submit to, and send the request to.
            url: ajax_add_new_item_url,
            // used 'post' method to send the data to url, the default is "get"
            type: "post",
            //if the ajax request success, this function will receive the returned(ex:view file) data as HTML text; included script tags .
            dataType: "html",
            cache: false,
            //Data to be sent to the server (data sent in the request)as{key:value}
            //If the HTTP method have not an entity body, such as GET, the data is appended to the URL.

            data: {
                item_name: item_name,
                _token: token_search,
                invoice_total_price: invoice_total_price,
                invoice_total_price_with_old: invoice_total_price_with_old,
                unit_id: unit_id,
                what_paid: what_paid,
                what_remain: what_remain,
                sales_invoice_id: sales_invoice_id,
                invoiceDate: invoiceDate,
                customer_id: customer_id,
                oldRemain: oldRemain,
                item_code: item_code,
                quantity: quantity,
                item_type: item_type,
                unit_price: unit_price,
                chassisWidthValue: chassisWidthValue,
                total_unit_price: total_unit_price,
            },

            //if the function in the controller succeded ,this function will return the
            // 'file.blade.php' with all data as "html text" or 'json' as you define
            //and we will receive the returned data in a variable ex:returned_data
            success: function (returned_data) {
                //replace(.html) or append(.append) the content of the element 'ajax_add_new_item' only
                // [in the 'main view' page] with the content of the "returned_data"
                //  which contains variables and the content of the page 'file.blade.php' in form of text or json
                $("#ajax_add_new_item").append(returned_data);
                //after adding the item to database recalculated the total invoice using ajax
                //and passing function 'recalcInputs' to recalculated input
                ajax_culcTotalInvoiceWithoutOld(recalcInputs);
            },
            error: function () {},
        }); //end if ajax
    }); //end "#addToInvoice" function
    // ======================================== end ajax edit item in bill================================

    // ======================================== calculateTotalForItem================================
    function calculateTotalForItem() {
        //get the price of the choosen item
        var item_price = $("#item_code option:selected").data("price");
        //get the number of items
        var quantity = $("#quantity").val();
        //check if chassis or product
        var item_type = $("#item_code option:selected").data("type");
        // 2 is a chassis
        if (item_type == 2) {
            var chassisWidthValue = $("#chassisWidthValue").val();
            var totalOneItemPrice =
                quantity * item_price * (chassisWidthValue / 100);
            $("#totalOneItemPrice").val(totalOneItemPrice);
            //1 is a product
        } else if (item_type == 1) {
            $("#chassisWidthValue").val(0);
            var totalOneItemPrice = quantity * item_price;
            $("#totalOneItemPrice").val(totalOneItemPrice);
        } else {
            $("#totalOneItemPrice").val("");
            $("#chassisWidthValue").val(0);
        }
    }
    // ======================================== end calculateTotalForItem================================

    // ======================================== calculateTotalForItem================================
    function calculateTotalinvoice() {
        //get the price of the choosen item
        var item_price = $("#item_code option:selected").data("price");
        //get the number of items
        var quantity = $("#quantity").val();
        //check if chassis or product
        var item_type = $("#item_code option:selected").data("type");
        // 2 is a chassis
        if (item_type == 2) {
            var chassisWidthValue = $("#chassisWidthValue").val();
            var totalOneItemPrice =
                quantity * item_price * (chassisWidthValue / 100);
            $("#totalOneItemPrice").val(totalOneItemPrice);
            //1 is a product
        } else if (item_type == 1) {
            $("#chassisWidthValue").val(0);
            var totalOneItemPrice = quantity * item_price;
            $("#totalOneItemPrice").val(totalOneItemPrice);
        } else {
            $("#totalOneItemPrice").val("");
            $("#chassisWidthValue").val(0);
        }
    }
    // ======================================== end calculateTotalForItem================================

    $(document).on("input", "#what_paid", function () {
        recalcInputs();
    });
    //========================================function of recalculate inputs====================================
    function recalcInputs() {
        //------------------------------------
        var totalInvoice = $("#totalInvoice").val();
        totalInvoice = parseFloat(totalInvoice);
        //------------------------------------
        var oldRemain = $("#oldRemain").val();
        oldRemain = parseFloat(oldRemain);
        //------------------------------------
        var totalWithOld = totalInvoice + oldRemain * -1;
        $("#invoice_total_price_with_old").val(totalWithOld);
        //------------------------------------
        var whatPaid = $("#what_paid").val();
        if (whatPaid == "") {
            whatPaid = 0;
        } else {
            whatPaid = parseFloat(whatPaid);
        }
        //----------------------------------------
        var whatRemain = totalWithOld - whatPaid;
        //----------------------------------------
        $("#what_remain").val(whatRemain);
        //if the user paid more than the value of the current invoice, add the over to 'whatRemain' and show up 'دائن'
        $("#what_remain").val(whatRemain);
        if (whatRemain < 0) {
            $(".debit").show();
        } else {
            $(".debit").hide();
        }
        //----------------------------------------
        var what_old_paid = whatPaid - totalInvoice;
        if (what_old_paid < 0) {
            what_old_paid = 0;
            what_old_paid = $("#what_old_paid").val(what_old_paid);
        } else {
            what_old_paid = $("#what_old_paid").val(what_old_paid);
        }
    }
    //=====================================end function of recalculate inputs====================================

    //==========================removing item form the invoice while creating using ajax =======================================
    $(document).on("click", ".remove", function (e) {
        //delay 500 ms becouse there are two function excute at the same time so you have to wait unit the first on execute
        //and store the data in data base

        var item_serial = $(this).val();
        var ajax_delete_item_url = $("#ajax_delete_item_url").val();
        var token_search = $("#token_search").val();
        jQuery.ajax({
            url: ajax_delete_item_url,
            type: "post",
            dataType: "html",
            cache: false,

            data: {
                item_serial: item_serial,
                _token: token_search,
            },
            success: function (returned_data) {
                //after removing the item from database recalculated the total invoice using ajax
                //and passing function 'recalcInputs' to recalculated input
                ajax_culcTotalInvoiceWithoutOld(recalcInputs);
            },
            error: function () {
                alert();
            },
        }); //end if ajax
        $(this).closest("tr").remove();
        //remove the 'tr' inwhich the this button exist
    });
    //==========================end removing item form the invoice while creating using ajax =======================================

    //===================function of reculculated the total of the invoice_without_old using ajax===================================

    function ajax_culcTotalInvoiceWithoutOld(callbackfunction) {
        var sales_invoice_id = $("#sales_invoice_id").val();
        var ajax_totalInvoice_url = $("#ajax_totalInvoice_url").val();
        var token_search = $("#token_search").val();

        jQuery.ajax({
            url: ajax_totalInvoice_url,
            type: "post",
            dataType: "html",
            cache: false,
            data: {
                sales_invoice_id: sales_invoice_id,
                _token: token_search,
            },
            success: function (returned_data) {
                //set the new value to the input
                $("#ajax_totalInvoice").html(returned_data);
                //any function user can send
                callbackfunction();
            },
            error: function () {
                alert();
            },
        }); //end if ajax
    } //end ajax_culcTotalInvoiceWithoutOld()
    //===================function of reculculated the total of the invoice_without_old using ajax===================================
});
