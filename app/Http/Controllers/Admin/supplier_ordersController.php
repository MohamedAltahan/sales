<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\supplierOrdersRequest;
use App\Models\Admin;
use App\Models\Inv_items_per_category;
use App\Models\Inv_unit;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\SupplierOrder;
use App\Models\SupplierOrderDetail;
use App\Models\Treasuries;
use App\Models\Treasuries_transaction;
use App\Models\Users_shift;
use Illuminate\Http\Request;

class supplier_ordersController extends Controller
{
    //=======================================index====================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = getColumns_p(new SupplierOrder(), ['*'], ['com_code' => $com_code], 'id', 'DESC', PAGINATION_COUNT);

        // get addBy and updatedBy
        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
                $info['supplier_name'] = Supplier::where('supplier_code', $info['supplier_code'])->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.supplier_orders.index', ['data' => $data]);
    }
    //============================================end index===========================================================

    //============================================create=============================================================
    public function create()
    {


        $com_code = auth()->user()->com_code;
        $Suppliers = getColumns(new Supplier(), ['supplier_code', 'id', 'name'], ['com_code' => $com_code, 'active' => 1], 'id', 'DESC');

        return view('admin.supplier_orders.create', ['Suppliers' => $Suppliers]);
    }
    //============================================end create ===========================================================

    //============================================store=============================================================
    public function store(supplierOrdersRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;

            //set auto serial for a bill
            $lastrow = getlastRow(new SupplierOrder(), ['auto_serial'], ['com_code' => $com_code], 'id', 'DESC');
            if (!empty($lastrow)) {
                $data_insert['auto_serial'] = $lastrow['auto_serial'] + 1;
            } else {
                $data_insert['auto_serial'] = 1;
            }


            $data_insert['item_type'] = $request->doc_no;

            $data_insert['order_type'] = PURCHASE_BILL;
            $data_insert['doc_no'] = $request->doc_no;
            $data_insert['notes'] = $request->notes;
            $data_insert['supplier_code'] = $request->supplier_code;


            $data_insert['order_date'] = $request->order_date;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['com_code'] = $com_code;
            create(new SupplierOrder(), $data_insert);

            $id = getValue(new SupplierOrder(), ['auto_serial' => $data_insert['auto_serial']], 'id');
            return redirect()
                ->route('admin.supplier_orders.details', $id);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //============================================end store ===========================================================

    //=========================================edit ====================================
    // used to edit the info
    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
        $data = getOneRow(new SupplierOrder(), ['*'], ['id' => $id, 'com_code' => $com_code]);
        if (empty($data)) {
            return redirect()
                ->route('admin.supplier_orders.index')
                ->with(['error' => ' غير قادر على الوصول للبيانات']);
        }

        if (($data['is_approved'] == 1)) {
            return redirect()
                ->route('admin.supplier_orders.index')
                ->with(['error' => 'عفوا لا يمكن التعديل على فاتورة معتمدة']);
        }
        $Suppliers = getColumns(new Supplier(), ['supplier_code', 'id', 'name'], ['com_code' => $com_code, 'active' => 1], 'id', 'DESC');


        //return with an array named 'data'
        return view('admin.supplier_orders.edit', ['data' => $data, 'Suppliers' => $Suppliers]);
    }
    //========================================end edit==================================

    //========================================end update==================================
    //store the date in the database after the user edit it
    public function update($id, supplierOrdersRequest $request)
    {
        try {

            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = getOneRow(new SupplierOrder(), ['is_approved'], ['id' => $id, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);
            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.supplier_orders.index')
                    ->with(['error' => 'غير قادر على الوصول للبيانات']);
            }

            //to get account number
            $supplierAccountNumber = getOneRow(new Supplier(), ['account_number'], ['supplier_code' => $request->supplier_code, 'com_code' => $com_code]);
            if (empty($supplierAccountNumber)) {
                return redirect()
                    ->back()
                    ->with(['error' => 'عفوا غير قادر على الوصول لبيانات المورد المحدد'])
                    ->withinput();
            }


            $data_update['order_date'] = $request->order_date;
            $data_update['doc_no'] = $request->doc_no;
            $data_update['payment_type'] = $request->payment_type;
            $data_update['store_id'] = $request->store_id;
            $data_update['supplier_code'] = $request->supplier_code;
            $data_update['account_number'] = $supplierAccountNumber['account_number'];
            $data_insert['notes'] = $request->notes;
            $data_update['updated_at'] = date("Y-m-d");
            $data_update['updated_by'] = auth()->user()->id;


            update(new SupplierOrder(), ['id' => $id, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL], $data_update);
            return redirect()
                ->route('admin.supplier_orders.index')
                ->with(['success' => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //========================================================end update========================

    //======================================================details=====================
    public function details($id)
    {

        try {
            $com_code = auth()->user()->com_code;
            $data = getOneRow(new SupplierOrder(), ['*'], ['id' => $id, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);

            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.supplier_orders.index')
                    ->with(['error' => ' غير قادر على الوصول للبيانات']);
            }
            //get the admin's name who added the current treauries($id)
            $data['added_by_admin'] = Admin::where('id', $data->added_by)->value('name');
            //get the supplier name
            $data['supplier_name'] = Supplier::where('supplier_code', $data['supplier_code'])->value('name');

            //get the admin's name who updated the current treasries
            //first chech if there is someone updated the record
            if (($data->updated_by > 0) && ($data->updated_by != null)) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }

            //when order_type is '1' it means 'purchase bill'
            $details = getColumns(new SupplierOrderDetail(), ['*'], ['supplier_orders_serial' => $data['auto_serial'], 'order_type' => PURCHASE_BILL, 'com_code' => $com_code], 'id', 'DESC');
            if (!empty($details)) {
                foreach ($details as $info) {
                    // to get the item name through its item_code and add a new attribute to the our object and call it 'name'
                    $info->name = Inv_items_per_category::where('item_code', $info->item_code)->value('name');
                    $info->unit_name = Inv_unit::where('id', $info->unit_id)->value('name');
                    $info->add_by_admin = Admin::where('id', $info->added_by)->value('name');

                    if (($data->updated_by > 0) && ($data->updated_by != null)) {
                        $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
                    }
                }
            }


            return view('admin.supplier_orders.details', ['data' => $data, 'details' => $details]);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr,
            //and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //==========================================end details=============================================================


    //==========================================ajax search 'ajax_get_item_units'=============================================================

    public function ajax_get_item_units(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $item_code_add = $request->item_code_add;
            $item_data = getOneRow(new Inv_items_per_category(), ['has_retailunit', 'retail_unit_id', 'primary_unit_id'], ['item_code' => $item_code_add, 'com_code' => $com_code]);
            if (!empty($item_data)) {
                if ($item_data['has_retailunit'] == 1) {
                    $item_data['primary_unit_name'] = getValue(new Inv_unit(), ['id' => $item_data['primary_unit_id']], 'name');
                    $item_data['retail_unit_name'] = getValue(new Inv_unit(), ['id' => $item_data['retail_unit_id']], 'name');
                } else {
                    $item_data['primary_unit_name'] = getValue(new Inv_unit(), ['id' => $item_data['primary_unit_id']], 'name');
                }
            }

            return view('admin.supplier_orders.ajax_get_item_units', ['item_data' => $item_data,]);
        }
    }
    //===================================== end ajax 'ajax_get_item_units'====================================

    //==========================================ajax 'ajax_add_items_details'=============================================================

    public function ajax_add_details(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $SupplierOrderData = getOneRow(new SupplierOrder(), ['discount_value', 'is_approved', 'tax_value', 'order_date'], ['auto_serial' => $request->auto_serial, 'com_code' => $com_code]);
            if (!empty($SupplierOrderData)) {
                //bill sill not approved yet
                if ($SupplierOrderData['is_approved'] == 0) {
                    $data_insert['supplier_orders_serial'] = $request->auto_serial;
                    $data_insert['order_type'] = PURCHASE_BILL;
                    $data_insert['item_code'] = $request->item_code_add;
                    $data_insert['unit_price'] = $request->price_add;
                    $data_insert['unit_id'] = $request->unit_id_add;
                    // if the product has prodution date, if not it will not be sent to database so it would be null
                    if ($request->data_type == HAS_EXPIRE_DATE) {
                        $data_insert['production_date'] = $request->production_date;
                        $data_insert['expire_date'] = $request->expire_date;
                    }
                    $data_insert['is_parent_unit'] = $request->is_parent_unit;
                    $data_insert['received_quantity'] = $request->quantity_add;
                    $data_insert['unit_total_price'] = $request->total_add;
                    // data_type استهلاكي مخزني عهدة
                    $data_insert['item_type'] = $request->data_type;


                    $data_insert['order_date'] = $SupplierOrderData['order_date'];
                    $data_insert['added_by'] = auth()->user()->id;
                    $data_insert['created_at'] = date('Y-m-d H:i:s');
                    $data_insert['com_code'] = $com_code;
                    $flag = SupplierOrderDetail::create($data_insert);
                    if ($flag) {
                        // total price of all items in the bill without tax or discount
                        $all_items_total_price = getSum(
                            new SupplierOrderDetail(),
                            ['supplier_orders_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL],
                            'unit_total_price'
                        );
                        $update_parent['item_total_price'] = $all_items_total_price;
                        //total include tax without discount
                        $update_parent['bill_total_cost_before_discount'] = $all_items_total_price + $SupplierOrderData['tax_value'];
                        //total include tax and discount
                        $update_parent['bill_final_total_cost'] = ($update_parent['bill_total_cost_before_discount']) - ($SupplierOrderData['discount_value']);
                        $update_parent['updated_by'] = auth()->user()->id;
                        $update_parent['updated_at'] = date('Y-m-d H:i:s');
                        update(new SupplierOrder(), ['auto_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL], $update_parent);
                        //update parent bill
                        echo json_encode('done');
                    }
                }
            }
        }
    }
    //===================================== end ajax  'ajax_add_items_details'====================================

    //==========================================ajax  'ajax_reload_items_details'=============================================================

    public function ajax_reload_items_details(Request $request)
    {
        if ($request->ajax()) {
            $auto_serial = $request->auto_serial;
            $com_code = auth()->user()->com_code;
            $data = getOneRow(new SupplierOrder(), ['is_approved', 'id'], ['auto_serial' => $auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);

            if (!empty($data)) {
                //when order_type is '1' it means 'purchase bill'
                $details = getColumns(new SupplierOrderDetail(), ['*'], ['supplier_orders_serial' => $auto_serial, 'order_type' => PURCHASE_BILL, 'com_code' => $com_code], 'id', 'DESC');
                if (!empty($details)) {
                    foreach ($details as $info) {
                        // to get the item name through its item_code and add a new attribute to the our object and call it 'name'
                        $info->name = Inv_items_per_category::where('item_code', $info->item_code)->value('name');
                        $info->unit_name = Inv_unit::where('id', $info->unit_id)->value('name');
                        $info->add_by_admin = Admin::where('id', $info->added_by)->value('name');

                        if (($data->updated_by > 0) && ($data->updated_by != null)) {
                            $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
                        }
                    }
                }
                return view('admin.supplier_orders.ajax_reload_items_details', ['data' => $data, 'details' => $details]);
            }
        }
    }
    //===================================== end ajax 'ajax_reload_items_details'====================================

    //====================================ajax  'ajax_reload_parent_bill_details'===================================
    //after adding a new item to bill ajax will add the item immediatly to the bill without refresh the page
    //==============================================================================================================
    public function ajax_reload_parent_bill(Request $request)
    {

        if ($request->ajax()) {

            $com_code = auth()->user()->com_code;
            $data = getOneRow(new SupplierOrder(), ['*'], ['auto_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);

            //if we don't find this id
            if (!empty($data)) {

                //get the admin's name who added the current treauries($id)
                $data['added_by_admin'] = Admin::where('id', $data->added_by)->value('name');
                //get the supplier name
                $data['supplier_name'] = Supplier::where('supplier_code', $data['supplier_code'])->value('name');
                $data['store_name'] = Store::where('id', $data->store_id)->value('name');

                //get the admin's name who updated the current treasries
                //first chech if there is someone updated the record
                if (($data->updated_by > 0) && ($data->updated_by != null)) {
                    $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
                }
                return view('admin.supplier_orders.ajax_reload_parent_bill', ['data' => $data]);
            } //if !empty
        } //if ajax
    } //end function ajax_reload_parent_bill
    //=================================== end ajax 'ajax_reload_parent_bill_details'==================================


    //==========================================ajax  'ajax_reload_edit_item'=============================================================
    public function ajax_reload_edit_item(Request $request)
    {
        if ($request->ajax()) {

            $com_code = auth()->user()->com_code;
            $is_approved = getOneRow(new SupplierOrder(), ['is_approved'], ['auto_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);

            //if don't find data
            if (!empty($is_approved)) {
                //if found data and editable
                if (($is_approved->is_approved) == 0) {
                    //'id' is the item "id"
                    $item_details = getOneRow(new SupplierOrderDetail(), ['*'], ['id' => $request->id, 'com_code' => $com_code]);
                    $items = getColumns(new Inv_items_per_category(), ['item_type', 'name', 'item_code'], ['active' => 1, 'com_code' => $com_code], 'id', 'DESC');
                    $item_data = getOneRow(new Inv_items_per_category(), ['has_retailunit', 'retail_unit_id', 'primary_unit_id'], ['item_code' => $item_details->item_code, 'com_code' => $com_code]);
                    if (!empty($item_data)) {
                        if ($item_data['has_retailunit'] == 1) {
                            $item_data['primary_unit_name'] = getValue(new Inv_unit(), ['id' => $item_data['primary_unit_id']], 'name');
                            $item_data['retail_unit_name'] = getValue(new Inv_unit(), ['id' => $item_data['retail_unit_id']], 'name');
                        } else {
                            $item_data['primary_unit_name'] = getValue(new Inv_unit(), ['id' => $item_data['primary_unit_id']], 'name');
                        }
                    }
                    return view('admin.supplier_orders.ajax_reload_edit_item', ['item_details' => $item_details, 'items' => $items, 'item_type' => $request->data_type, 'item_data' => $item_data]);
                } else {
                    return redirect()
                        ->route('admin.supplier_orders.index')
                        ->with(['error' => 'عفوا لا يمكن التعديل على فاتورة معتمدة']);
                }
            } else {
                return redirect()
                    ->route('admin.supplier_orders.index')
                    ->with(['error' => ' غير قادر على الوصول للبيانات']);
            }
        } //if ajax

    } //end function ajax_reload_parent_bill
    //===================================== end ajax 'ajax_reload_edit_item'====================================


    function ajax_add_new_item(Request $request)
    {
        if ($request->ajax()) {

            $com_code = auth()->user()->com_code;
            $is_approved = getOneRow(new SupplierOrder(), ['is_approved'], ['auto_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);

            //if don't find data
            if (!empty($is_approved)) {
                //if found data and editable
                if (($is_approved->is_approved) == 0) {
                    //'id' is the item "id"
                    $item_details = getOneRow(new SupplierOrderDetail(), ['*'], ['id' => $request->id, 'com_code' => $com_code]);
                    //if the bill still open and not approved
                    if ($is_approved['is_approved'] == 0) {
                        //get all active items
                        $items = getColumns(new Inv_items_per_category(), ['item_type', 'name', 'item_code'], ['com_code' => $com_code], 'id', 'DESC');

                        return view('admin.supplier_orders.ajax_add_new_item', ['item_details' => $item_details, 'items' => $items, 'item_type' => $request->data_type]);
                    } else {
                        return redirect()
                            ->route('admin.supplier_orders.index')
                            ->with(['error' => 'عفوا لا يمكن التعديل على فاتورة معتمدة']);
                    }
                } else {
                    return redirect()
                        ->route('admin.supplier_orders.index')
                        ->with(['error' => ' غير قادر على الوصول للبيانات']);
                }
            } //if ajax

        }
    }


    //==========================================ajax  'ajax_reload_edit_item'=============================================================
    public function edit_item_details(Request $request)
    {
        if ($request->ajax()) {

            $com_code = auth()->user()->com_code;
            $parent_bill = getOneRow(new SupplierOrder(), ['is_approved', 'order_date', 'tax_value', 'discount_value'], ['auto_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);

            //if don't find data
            if (!empty($parent_bill)) {
                //if found data and editable
                if (($parent_bill->is_approved) == 0) {

                    $data_update['item_code'] = $request->item_code_add;
                    $data_update['unit_price'] = $request->price_add;
                    $data_update['unit_id'] = $request->unit_id_add;
                    // if the product has prodution date, if not it will not be sent to database so it would be null
                    if ($request->data_type == HAS_EXPIRE_DATE) {
                        $data_update['production_date'] = $request->production_date;
                        $data_update['expire_date'] = $request->expire_date;
                    }
                    $data_update['is_parent_unit'] = $request->is_parent_unit;
                    $data_update['received_quantity'] = $request->quantity_add;
                    $data_update['unit_total_price'] = $request->total_add;
                    // data_type استهلاكي مخزني عهدة
                    $data_update['item_type'] = $request->data_type;


                    $data_update['order_date'] = $parent_bill['order_date'];
                    $data_update['updated_by'] = auth()->user()->id;
                    $data_update['updated_at'] = date('Y-m-d H:i:s');
                    $data_update['com_code'] = $com_code;
                    $flag =  update(new SupplierOrderDetail(), ['id' => $request->id, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL, 'supplier_orders_serial' => $request->auto_serial], $data_update);
                    if ($flag) {
                        // total price of all items in the bill without tax or discount
                        $all_items_total_price = getSum(
                            new SupplierOrderDetail(),
                            ['supplier_orders_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL],
                            'unit_total_price'
                        );
                        $update_parent['item_total_price'] = $all_items_total_price;
                        //total include tax without discount
                        $update_parent['bill_total_cost_before_discount'] = $all_items_total_price + $parent_bill['tax_value'];
                        //total include tax and discount
                        $update_parent['bill_final_total_cost'] = ($update_parent['bill_total_cost_before_discount']) - ($parent_bill['discount_value']);
                        $update_parent['updated_by'] = auth()->user()->id;
                        $update_parent['updated_at'] = date('Y-m-d H:i:s');
                        update(new SupplierOrder(), ['auto_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL], $update_parent);
                        //update parent bill
                        echo json_encode('done');
                    }
                } else {
                    return redirect()
                        ->route('admin.supplier_orders.index')
                        ->with(['error' => 'عفوا لا يمكن التعديل على فاتورة معتمدة']);
                }
            } else {
                return redirect()
                    ->route('admin.supplier_orders.index')
                    ->with(['error' => ' غير قادر على الوصول للبيانات']);
            }
        } //if ajax

    } //end function ajax_reload_parent_bill
    //===================================== end ajax 'ajax_reload_edit_item'====================================

    //========================================delete item from details=======================================
    public function delete_item_details($id, $parent_id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $parent_bill = getOneRow(new SupplierOrder(), ['is_approved', 'auto_serial'], ['id' => $parent_id, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);
            if (!empty($parent_bill)) {
                if ($parent_bill['is_approved'] == 0) {
                    $item_row = SupplierOrderDetail::find($id);
                    if (!empty($item_row)) {
                        $flag = $item_row->delete();
                        if ($flag) {

                            $all_items_total_price = getSum(
                                new SupplierOrderDetail(),
                                ['supplier_orders_serial' => $parent_bill->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL],
                                'unit_total_price'
                            );
                            $update_parent['item_total_price'] = $all_items_total_price;
                            //total include tax without discount
                            $update_parent['bill_total_cost_before_discount'] = $all_items_total_price + $parent_bill['tax_value'];
                            //total include tax and discount
                            $update_parent['bill_final_total_cost'] = ($update_parent['bill_total_cost_before_discount']) - ($parent_bill['discount_value']);
                            $update_parent['updated_by'] = auth()->user()->id;
                            $update_parent['updated_at'] = date('Y-m-d H:i:s');
                            update(new SupplierOrder(), ['id' => $parent_id, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL], $update_parent);
                            //update parent bill


                            return redirect()
                                ->back()
                                ->with(['success' => 'تم الحذف بنجاح']);
                        } else {
                            return redirect()
                                ->back()
                                ->with(['error' => 'حدث خطأ ما']);
                        }
                    }
                }
            } else {
                return redirect()
                    ->back()
                    ->with(['error' => 'غير قادر على الوصول الى البيانات']);
            }
        } catch (\Exception $ex) {
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()]);
        }
    }
    //======================================= end delete item from details===========================================


    //========================================delete delete_supplier_order=======================================
    public function delete_supplier_order($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $parent_bill = getOneRow(new SupplierOrder(), ['is_approved', 'auto_serial'], ['id' => $id, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);
            if (empty($parent_bill)) {

                return redirect()
                    ->back()
                    ->with(['error' => 'غير قادر على الوصول الى البيانات']);
            }
            if ($parent_bill['is_approved'] == 1) {
                return redirect()
                    ->back()
                    ->with(['error' => 'عفوا لايمكن مسح فاتورة معتمده ']);
            }

            $flag = SupplierOrder::where(['id' => $id, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL])->delete();
            if ($flag) {

                SupplierOrderDetail::where(['supplier_orders_serial' => $parent_bill->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL])->delete();
                return redirect()
                    ->route('admin.supplier_orders.index')
                    ->with(['success' => ' تم الحذف بنجاح']);
            }
        } catch (\Exception $ex) {
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()]);
        }
    } //end function
    //======================================= end delete_supplier_order============================================


    //====================================ajax  'ajax_approve_invoice'=============================================
    //after adding a new item to bill ajax will add the item immediatly to the bill without refresh the page
    //==============================================================================================================
    public function ajax_approve_invoice(Request $request)
    {
        if ($request->ajax()) {

            $com_code = auth()->user()->com_code;
            $data = getOneRow(new SupplierOrder(), ['*'], ['auto_serial' => $request->auto_serial, 'com_code' => $com_code, 'order_type' => PURCHASE_BILL]);
            //Users_shift() to get data about the current shift
            //Treasuries_transaction() to get the current balance of the current treasury
            //Treasuries() to get the name of the curruent treasury
            $userShift = getUserShift(new Users_shift(), new Treasuries_transaction(), new Treasuries());
            return view('admin.supplier_orders.ajax_approve_invoice', ['data' => $data, 'userShift' => $userShift]);
        } //if ajax end
    } //end function ajax_approve_invoice
    //=================================== end ajax 'ajax_approve_invoice'=========================================
    //======================================= end delete_supplier_order===========================================

    public function do_approve($auto_serial)
    {
        SupplierOrder::where(['auto_serial' => $auto_serial])->update(['is_approved' => 1]);
        $received_quantity = getColumns(new SupplierOrderDetail(), ['item_code', 'received_quantity'], ['supplier_orders_serial' => $auto_serial], 'id', 'DESC');
        foreach ($received_quantity as $info) {
            Inv_items_per_category::where(['item_code' => $info->item_code])->increment('stock_quantity', $info->received_quantity);
        }

        return redirect()->back()->with(['success' => ' تم الاعتماد بنجاح']);
    }
}//end main class
