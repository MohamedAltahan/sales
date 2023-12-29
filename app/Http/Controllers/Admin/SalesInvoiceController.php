<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Admin_panel_setting;
use App\Models\Customer;
use App\Models\Inv_items_per_category;
use App\Models\Sales_matrial_types;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceDetail;
use Illuminate\Http\Request;

class SalesInvoiceController extends Controller
{
    //====================================================index============================================================
    public function index()
    {
        $com_code = auth()->user()->com_code;

        $data = getColumns_p(new SalesInvoice(), ['*'], ['com_code' => $com_code], 'id', 'DESC', PAGINATION_COUNT);
        $customers = getColumns(new Customer(), ['current_balance', 'name', 'customer_code', 'id'], ['com_code' => $com_code], 'name', 'ASC');

        $sales_invoice = getLastRow(new SalesInvoice(), ['sales_invoice_id', 'is_approved'], ['com_code' => $com_code],  'id', 'DESC');
        if (!isset($sales_invoice)) {
            $is_approved = 1;
            $sales_invoice_id = 1;
        } else {
            $is_approved = $sales_invoice->is_approved;
            if (empty($sales_invoice->sales_invoice_id)) {
                //set the invoice number to 1 if that's the first invoice in the program
                $sales_invoice_id = 1;
                //check if the last bill is approved in order to increase the invoice number
            } else if ($sales_invoice->is_approved == 1) {
                //increase the invoice number
                $sales_invoice_id = (++$sales_invoice->sales_invoice_id);
            } else {
                $sales_invoice_id  = $sales_invoice->sales_invoice_id;
            }
        }

        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
                $info['customer_name'] =  getValue(new Customer(), ['id' => $info->customer_id], 'name');
            } //foreach end
        } //if end
        $items  = getColumns(new Inv_items_per_category(), ['stock_quantity', 'item_code', 'item_type', 'name', 'primary_retail_price', 'primary_unit_id'], ['com_code' => $com_code], 'name', 'ASC');
        return view('admin.salesInvoice.index', [
            'data' => $data, 'items' => $items,
            'sales_invoice_id' => $sales_invoice_id,
            'is_approved' => $is_approved,
            'customers' => $customers
        ]);
    } //index function end
    //================================================== end index============================================================

    //============================================store=============================================================
    // public function store(Request $request)
    // {
    //     try {

    //         $com_code = auth()->user()->com_code;

    //         $data_insert['invoice_date'] = $request->invoice_date;
    //         $data_insert['customer_id'] = $request->customer_id;
    //         $data_insert['old_remain'] = $request->oldRemain;
    //         $data_insert['item_code'] = $request->item_code;
    //         $data_insert['quantity'] = $request->quantity;


    //         if ($request->item_type == 2) {
    //             $data_insert['chassisWidthValue'] = $request->chassisWidthValue;
    //         } else {
    //             $data_insert['chassisWidthValue'] = 0;
    //         }

    //         //price of one item only
    //         $data_insert['unit_price'] = $request->primary_retail_price;
    //         //price of all items of the same type
    //         $data_insert['total_unit_price'] = $request->totalOneItemPrice;
    //         // price of all items in the invoice without old
    //         $data_insert['invoice_total_price'] = $request->totalInvoice;
    //         // price of all items in the invoice + the old balance *-1 to make the old remain positive 
    //         $data_insert['invoice_total_price_with_old'] = ($request->totalInvoice) * (-1 * $request->oldRemain);


    //         $data_insert['unit_id'] = $request->primary_unit_id;
    //         //$data_insert['order_date'] = $request->order_date;
    //         $data_insert['added_by'] = auth()->user()->id;
    //         $data_insert['created_at'] = date('Y-m-d H:i:s');
    //         $data_insert['com_code'] = $com_code;
    //         $data_insert['sales_invoice_id'] = $request->sales_invoice_id;

    //         $data_insert['what_paid'] = $request->what_paid;
    //         $data_insert['what_remain'] = $request->what_remain;
    //         $data_insert['date'] = date('Y-m-d');

    //         $flag = create(new SalesInvoiceDetail(), $data_insert);


    //         //update the user balance
    //         // if ($flag2) {
    //         //     $newBalance = ($request->oldRemain) - ($request->what_remain);

    //         //     Customer::where(['id' => $request['customer_id']])->update(["current_balance" => $newBalance]);
    //         // }
    //     } catch (\Exception $ex) {
    //         //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
    //         return redirect()
    //             ->back()
    //             ->with(['error' => 'خطأ' . $ex->getMessage()])
    //             ->withinput();
    //     }
    // }
    //============================================end store ===========================================================

    //==========================================ajax 'ajax_add_items_details'=============================================================

    public function ajax_add_new_item(Request $request)
    {
        if ($request->ajax()) {

            $com_code = auth()->user()->com_code;
            //get item name using js (sent from js file using ajax)
            $item_name = $request->item_name;

            $data_insert['invoice_date'] = $request->invoiceDate;
            $data_insert['item_serial'] = time();
            $data_insert['customer_id'] = $request->customer_id;
            $data_insert['item_code'] = $request->item_code;
            //1 is a normal item, 2 is a chassis
            $data_insert['item_type'] = $request->item_type;
            $data_insert['quantity'] = $request->quantity;


            if ($request->item_type == 2) {
                $data_insert['chassisWidthValue'] = $request->chassisWidthValue;
            } else {
                $data_insert['chassisWidthValue'] = 0;
            }

            //price of one item only
            $data_insert['unit_price'] = $request->unit_price;
            //price of all items of the same type
            $data_insert['total_unit_price'] = 1 * $request->total_unit_price;
            // price of all items in the invoice without old
            $data_insert['invoice_total_price'] = $request->invoice_total_price;

            $data_insert['unit_id'] = $request->unit_id;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['com_code'] = $com_code;
            $data_insert['sales_invoice_id'] = $request->sales_invoice_id;


            $data_insert['what_paid'] = $request->what_paid;
            $data_insert['what_remain'] = $request->what_remain;
            $data_insert['date'] = date('Y-m-d');

            $flag = create(new SalesInvoiceDetail(), $data_insert);
            // //add the invoice to invoice list
            if ($flag) {
                $last_invoice_id = getLastRow(new SalesInvoice(), ['is_approved'], ['com_code' => $com_code], 'id', 'DESC');
                if (!isset($last_invoice_id)) {
                    $is_approved = 1;
                } else {
                    $is_approved = $last_invoice_id->is_approved;
                }
                if ($is_approved == 1) {

                    $data_insert_invoce['sales_invoice_id'] = $request->sales_invoice_id;
                    $data_insert_invoce['invoice_date'] = $request->invoiceDate;
                    $data_insert_invoce['customer_id'] = $request->customer_id;
                    $data_insert_invoce['com_code'] = $com_code;
                    $data_insert_invoce['added_by'] = $com_code = auth()->user()->id;;
                    $data_insert_invoce['date'] = date('Y-m-d');
                    create(new SalesInvoice(), $data_insert_invoce);
                }
            }

            return view('admin.salesInvoice.ajax_add_new_item', ['data' => $data_insert, 'item_name' => $item_name]);
        } //if ajax end
    } //function end
    //===================================== end ajax  'ajax_add_items_details'====================================

    public function ajax_totalInvoice(Request $request)
    {

        if ($request->ajax()) {
            $sum = SalesInvoiceDetail::where('sales_invoice_id', $request->sales_invoice_id)->sum('total_unit_price');
            return view('admin.salesInvoice.ajax_totalInvoice', ['sum' => $sum * 1]);
        }
    }

    //============================================ approve ===========================================================
    function do_approve($invoiceId)
    {
        SalesInvoice::where(['sales_invoice_id' => $invoiceId])->update(['is_approved' => 1]);
        return redirect()->route("admin.salesInvoice.index");
    }
    //============================================end approve ===========================================================

    //========================================ajax delete ==================================================
    public function ajax_delete_item(Request $request)
    {
        if ($request->ajax()) {
            // delete returns true or false (0 or 1)
            SalesInvoiceDetail::where(['item_serial' => $request->item_serial])->delete();
        } //end ajax if
    }
    //==================================end ajax delete ========================================
    //========================================delete==================================================
    public function delete($sales_invoice_id)
    {

        SalesInvoice::where(['sales_invoice_id' => $sales_invoice_id])->delete();
        SalesInvoiceDetail::where(['sales_invoice_id' => $sales_invoice_id])->delete();
        return redirect()->route("admin.salesInvoice.index");
    }
    //========================================end delete==================================================

    public function get_form_values(Request $request)
    {
        $lastRow = getLastRow(new SalesInvoiceDetail(), ['sales_invoice_id'], ['sales_invoice_id' => $request->sales_invoice_id], 'id', 'DESC');
        if (!empty($lastRow)) {
            $data_insert_invoce['old_remain'] = $request->oldRemain;
            $data_insert_invoce['what_old_paid'] = $request->what_old_paid;
            $data_insert_invoce['what_paid'] = $request->what_paid;
            $data_insert_invoce['what_remain'] = $request->what_remain;
            // price of all items in the invoice without old
            $data_insert_invoce['final_total_cost'] = $request->totalInvoice;
            //total price with old
            $data_insert_invoce['invoice_total_price_with_old'] = $request->invoice_total_price_with_old;
            $data_insert_invoce['is_approved'] = 1;
            SalesInvoice::where(['sales_invoice_id' => $request->sales_invoice_id])->update($data_insert_invoce);
            //update customer balance
            $new_balance = -$request->what_remain;
            Customer::where(['id' => $request->customer_id])->update(['current_balance' => $new_balance]);
            $itemsQuantity = getColumns(new SalesInvoiceDetail(), ['quantity', 'item_code'], ['sales_invoice_id' => $request->sales_invoice_id], 'id', 'DESC');

            foreach ($itemsQuantity as $info) {

                Inv_items_per_category::where(['item_code' => $info->item_code])->decrement('stock_quantity', $info->quantity);
            }
        } else {
            return redirect()
                ->back()
                ->with(['error' => ' لم يتم اضافه اصناف للفاتوره'])
                ->withinput();
        }


        return redirect()->route("admin.salesInvoice.index");
    }
    //========================================end delete==================================================
    // public function updated_customer_balance($customer_id)
    // {
    //     SalesInvoice::where(['sales_invoice_id' => $request->sales_invoice_id])->update($data_insert_invoce);

    //     Customer::where(['id' => $customer_id])->update(['current_balance' => $current_balance]);
    // }

    //==================================end details ========================================

    public function details($sales_invoice_id, $customer_id)
    {
        $com_code = auth()->user()->com_code;
        $SalesInvoice =  getOneRow(new SalesInvoice(), ['old_remain', 'final_total_cost', 'sales_invoice_id', 'created_at', 'invoice_total_price_with_old', 'what_paid', 'what_remain', 'is_approved'], ['sales_invoice_id' => $sales_invoice_id]);
        $details = getColumns_p(new SalesInvoiceDetail(), ['*'], ['sales_invoice_id' => $sales_invoice_id], 'id', 'DESC', PAGINATION_COUNT);
        $customer_data = getOneRow(new Customer(), ['current_balance', 'name', 'customer_code', 'id'], ['id' => $customer_id]);
        if (!empty($details)) {
            //'data' is an array of objects
            foreach ($details as $info) {
                $info['item_name'] = getValue(new inv_items_per_category(), ['item_code' => $info->item_code], 'name');
            } //foreach end
        } //if end
        $footerDetails = getOneRow(new Admin_panel_setting(), ['*'], ['com_code' => $com_code]);
        return view("admin.salesInvoice.details", ['footerDetails' => $footerDetails, 'sales_invoice_id' => $sales_invoice_id, 'data' => $details, 'customer_data' => $customer_data, 'SalesInvoice' => $SalesInvoice]);
    }
    //==================================end details ========================================


}//class end
