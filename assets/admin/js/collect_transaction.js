$(document).ready(function () {
    //===========================================================================================================
    //=======we need to change (transaction_type) automatically as soon as user choose the (account_number)======
    //===========================================================================================================

    $(document).on("change", "#account_number", function () {
        //first get the account value
        //if user chooses an empty field clear the next field(transaction_type)
        var account_number = $(this).val();
        if (account_number == "") {
            $("#transaction_type").val("");
        } else {
            //get the value of account_type_id
            var account_type_id = $("#account_number option:selected").data(
                "type"
            );
            //in collect case
            //in case of the user chosses(مورد)
            //this happens when our company return something to the supplier so we collect money form our supplier
            if (account_type_id == 2) {
                //so choose automaticaly transaction_type value '10' which means( تحصيل نظير مرتجع مشتريات الي مورد)
                $("#transaction_type").val(10);
            }
            //in case of the user chosses(عميل)
            else if (account_type_id == 3) {
                //so choose automaticaly transaction_type value '5' which means(  تحصيل ايراد مبيعات )
                $("#transaction_type").val(5);
            }
            //in case of the user chosses(بنكي )
            else if (account_type_id == 6) {
                //so choose automaticaly transaction_type value '25' which means( سحب من البنك)
                $("#transaction_type").val(25);
            }
            //in case of the user chosses(عام )
            else {
                //so choose automaticaly transaction_type value '4' which means( تحصيل نقدية من حساب مالي  )
                $("#transaction_type").val(4);
            }
        } //end big else
    }); //end function

    //==============================================================================================================
    //================we need to disable changing (transaction_type)  after choosing the account====================
    //==============================================================================================================
    //if you are tring to choose another value for transaction_type js will choose mandatory the value according to
    //the choosen value at account_number
    //==============================================================================================================
    $(document).on("change", "#transaction_type", function () {
        //first get the account value
        var account_number = $("#account_number").val();
        //if the user tries to select transaction_type before choosing account type
        if (account_number == "") {
            alert("اختار الحساب المالي اولا");
            $("#transaction_type").val("");
            return false;
        }

        //get the value of account_type_id
        var account_type_id = $("#account_number option:selected").data("type");
        //in collect case
        //in case of the user chosses(مورد)
        //this happens when our company return something to the supplier so we collect money form our supplier
        if (account_type_id == 2) {
            //so choose automaticaly transaction_type value '10' which means( تحصيل نظير مرتجع مشتريات الي مورد)
            $("#transaction_type").val(10);
        }
        //in case of the user chosses(عميل)
        else if (account_type_id == 3) {
            //so choose automaticaly transaction_type value '5' which means(  تحصيل ايراد مبيعات )
            $("#transaction_type").val(5);
        }
        //in case of the user chosses(بنكي )
        else if (account_type_id == 6) {
            //so choose automaticaly transaction_type value '25' which means( سحب من البنك)
            $("#transaction_type").val(25);
        }
        //in case of the user chosses(عام )
        else {
            //so choose automaticaly transaction_type value '4' which means( تحصيل نقدية من حساب مالي  )
            $("#transaction_type").val(4);
        }
    });
});
