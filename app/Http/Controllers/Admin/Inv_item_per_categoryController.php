<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inv_items_per_category;
use App\Models\Admin;
use App\Models\Inv_category;
use App\Models\Inv_unit;
use App\Http\Requests\ItemRequest;

class Inv_item_per_categoryController extends Controller
{
    //=======================================index====================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = getColumns_p(new Inv_items_per_category(), ['*'], ['com_code' => $com_code], 'id', 'DESC', PAGINATION_COUNT);
        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                //to get the name of the person who added the data
                $info['added_by_admin'] = getValue(new Admin(), ['id' => $info->added_by], 'name');

                //to get the name of the person who updated the data(maybe no updates)
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info['updated_by_admin'] = getValue(new Admin(), ['id' => $info->updated_by], 'name');
                }
                //info about item
                //to get the primary_item name of this item(ex:فراخ)
                $info['primary_item_name'] = getValue(new Inv_items_per_category(), ['id' => $info->primary_item_id], 'name');
                //info about unit
                //to get the primary unit name of this item(ex:شكارة)
                $info['primary_unit_name'] = getValue(new Inv_unit(), ['id' => $info->primary_unit_id], 'name');
                //to get the retail unit name of this item(ex:KG)
                $info['retail_unit_name'] = getValue(new Inv_unit(), ['id' => $info->retail_unit_id], 'name');
            }
        }
        $inv_category = getColumns(new Inv_category(), ['id', 'name'], ['com_code' => $com_code, 'active' => 1], 'id', 'DESC');
        return view('admin.inv_items_per_category.index', ['data' => $data, 'inv_category' => $inv_category]);
    }
    //============================================end index===========================================================
    //============================================create=============================================================
    public function create()
    {

        $com_code = auth()->user()->com_code;
        $inv_category = getColumns(new Inv_category(), ['id', 'name'], ['com_code' => $com_code, 'active' => 1], 'id', 'DESC');
        $inv_units_primary = getColumns(new Inv_unit(), ['id', 'name'], ['com_code' => $com_code, 'active' => 1, 'is_master' => '1'], 'id', 'DESC');
        $inv_units_secondary = getColumns(new Inv_unit(), ['id', 'name'], ['com_code' => $com_code, 'active' => 1, 'is_master' => '0'], 'id', 'DESC');
        $inv_items_per_category = getColumns(new Inv_items_per_category(), ['id', 'name'], ['com_code' => $com_code, 'active' => 1], 'id', 'DESC');

        return view('admin.inv_items_per_category.create', ['inv_category' => $inv_category, 'inv_items_per_category' => $inv_items_per_category, 'inv_units_primary' => $inv_units_primary, 'inv_units_secondary' => $inv_units_secondary]);
    }
    //============================================end create ===========================================================

    //============================================create=============================================================
    public function create_size()
    {

        $com_code = auth()->user()->com_code;
        $data = getColumns(new Inv_items_per_category(), ['width', 'length', 'primary_retail_price'], ['com_code' => $com_code], 'id', 'DESC');
        $inv_units_primary = getColumns(new Inv_unit(), ['id', 'name'], ['com_code' => $com_code, 'active' => 1, 'is_master' => '1'], 'id', 'DESC');

        return view('admin.inv_items_per_category.create_size', ['data' => $data, 'inv_units_primary' => $inv_units_primary]);
    }
    //============================================end create ===========================================================

    //============================================create=============================================================
    public function edit_size($id)
    {

        $com_code = auth()->user()->com_code;
        $sizeData = getOneRow(new Inv_items_per_category(), ['item_stock_type', 'stock_quantity', 'id', 'width', 'name', 'length', 'primary_retail_price', 'primary_unit_id'], ['id' => $id]);
        $units = getColumns(new Inv_unit(), ['id', 'name'], ['com_code' => $com_code], 'id', 'DESC');
        return view('admin.inv_items_per_category.edit_size', ['sizeData' => $sizeData, 'units' => $units]);
    }
    //============================================end create ===========================================================

    //============================================create=============================================================
    public function update_size($id, Request $request)
    {

        try {
            $com_code = auth()->user()->com_code;


            //check existance of name
            $checkExists_name = Inv_items_per_category::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if (!empty($checkExists_name)) {
                return redirect()
                    ->back()
                    ->with(['error' => ' عفوا اسم الصنف مسجل من قبل'])
                    ->withinput();
            }
            $data_insert['name'] = $request->name;
            $data_insert['length'] = $request->length;
            $data_insert['primary_retail_price'] = $request->primary_retail_price;
            $data_insert['stock_quantity'] = $request->stock_quantity;
            $data_insert['item_stock_type'] = $request->item_stock_type;

            $data_insert['primary_unit_id'] = $request->primary_unit_id;
            $data_insert['com_code'] = $com_code;

            Inv_items_per_category::where(['id' => $id])->update($data_insert);


            return redirect()
                ->route('admin.items.index')
                ->with(['success' => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
        return view('admin.inv_items_per_category.index');
    }
    //============================================end create ===========================================================

    //============================================store =============================================================
    public function store(ItemRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;

            //set 'item code' for items
            //first we get the last item number
            $lastrow = getlastRow(new Inv_items_per_category(), ['item_code'], ['com_code' => $com_code], 'id', 'DESC');
            if (!empty($lastrow)) {
                $data_insert['item_code'] = $lastrow['item_code'] + 1;
            } else {
                $data_insert['item_code'] = 1;
            }

            //check existance of name
            $checkExists_name = Inv_items_per_category::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if (!empty($checkExists_name)) {
                return redirect()
                    ->back()
                    ->with(['error' => ' عفوا اسم الصنف مسجل من قبل'])
                    ->withinput();
            }
            $data_insert['name'] = $request->name;
            //1 is a normal product and not a chassis size
            $data_insert['item_type'] = 1;


            $data_insert['primary_unit_id'] = $request->primary_unit_id;
            $data_insert['primary_retail_price'] = $request->primary_retail_price;
            $data_insert['primary_item_id'] = $request->primary_item_id;
            $data_insert['stock_quantity'] = $request->stock_quantity;
            $data_insert['item_stock_type'] = $request->item_stock_type;


            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['date'] = date('Y-m-d');
            $data_insert['com_code'] = $com_code;
            Inv_items_per_category::create($data_insert);

            return redirect()
                ->back()
                ->with(['success' => "تمت اضافة  $request->name بنجاح"])
                ->withinput();
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //============================================end store ===========================================================
    //============================================store_size=============================================================
    public function store_size(Request $request)
    {
        try {
            $com_code = auth()->user()->com_code;

            //set 'item code' for items
            //first get the last item number
            $lastrow = getlastRow(new Inv_items_per_category(), ['item_code'], ['com_code' => $com_code], 'id', 'DESC');
            if (!empty($lastrow)) {
                $data_insert['item_code'] = $lastrow['item_code'] + 1;
            } else {
                $data_insert['item_code'] = 1;
            }

            //check existance of name
            $checkExists_name = Inv_items_per_category::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if (!empty($checkExists_name)) {
                return redirect()
                    ->back()
                    ->with(['error' => ' عفوا اسم الصنف مسجل من قبل'])
                    ->withinput();
            }
            $data_insert['name'] = $request->name;
            // 2 means chassis size
            $data_insert['item_type'] = 2;
            $data_insert['width'] = $request->width;
            $data_insert['length'] = $request->length;
            $data_insert['primary_retail_price'] = $request->primary_retail_price;
            $data_insert['stock_quantity'] = $request->stock_quantity;
            $data_insert['item_stock_type'] = $request->item_stock_type;

            $data_insert['primary_unit_id'] = $request->primary_unit_id;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['date'] = date('Y-m-d');
            $data_insert['com_code'] = $com_code;
            Inv_items_per_category::create($data_insert);


            return redirect()
                ->route('admin.items.index')
                ->with(['success' => 'تم اضافه البيانات بنجاح']);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //============================================end store_size===========================================================

    //======================================================== edit ===========================================================
    // used to edit the  info
    public function edit($id)
    {

        $com_code = auth()->user()->com_code;
        $itemsData = getOneRow(new Inv_items_per_category(), ['id', 'stock_quantity', 'name', 'primary_unit_id', 'primary_retail_price', 'item_type', 'item_stock_type'], ['id' => $id]);
        $inv_units_primary = getColumns(new Inv_unit(), ['id', 'name'], ['com_code' => $com_code], 'id', 'DESC');

        return view('admin.inv_items_per_category.edit', ['inv_units_primary' => $inv_units_primary, 'itemsData' => $itemsData]);
    }
    //============================================end edit ===========================================================

    //========================================================update ===========================================================

    public function update($id, ItemRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = getOneRow(new Inv_items_per_category(), ['*'], ['id' => $id]);

            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.items.index')
                    ->with(['error' => 'غير قادر على الوصول للبيانات']);
            }



            $checkExists_name = Inv_items_per_category::where(['name' => $request->name, 'com_code' => $com_code])
                ->where('id', '!=', $id)
                ->first();
            if (!empty($checkExists_name)) {
                return redirect()
                    ->back()
                    ->with(['error' => ' عفوا اسم الصنف مسجل من قبل'])
                    ->withinput();
            }

            $data_update['name'] = $request->name;
            $data_update['primary_unit_id'] = $request->primary_unit_id;
            $data_update['primary_retail_price'] = $request->primary_retail_price;
            $data_update['item_stock_type'] = $request->item_stock_type;
            $data_update['stock_quantity'] = $request->stock_quantity;
            $data_update['updated_by'] = auth()->user()->id;


            update(new Inv_items_per_category(), ['id' => $id, 'com_code' => $com_code], $data_update);
            return redirect()
                ->route('admin.items.index')
                ->with(['success' => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //========================================================end update===================================================
    //========================================delete treasuries delivery==================================================

    public function delete($id)
    {
        try {
            $item_row = Inv_items_per_category::find($id);
            if (!empty($item_row)) {
                // delete returns true or false
                $flag = $item_row->delete();
                if ($flag) {
                    return redirect()
                        ->back()
                        ->with(['success' => ' تم حذف ' . $item_row->name . ' بنجاح ']);
                } else {
                    return redirect()
                        ->back()
                        ->with(['error' => 'حدث خطأ ما']);
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

    //========================================end delete treasuries delivery================================================
    //========================================================show ===========================================================
    // used to edit the  info
    public function show($id)
    {
        $data = getOneRow(new Inv_items_per_category(), ['*'], ['id' => $id]);
        $com_code = auth()->user()->com_code;
        //to get the name of the person who added the data
        $data['added_by_admin'] = getValue(new Admin(), ['id' => $data->added_by], 'name');

        //to get the name of the person who updated the data(maybe no updates)
        if ($data->updated_by > 0 and $data->updated_by != null) {
            $data['updated_by_admin'] = getValue(new Admin(), ['id' => $data->updated_by], 'name');
        }
        //info about item
        //to get the category name of this item(ex:مجمدات)
        $data['inv_item_category_name'] = getValue(new Inv_category(), ['id' => $data->inv_category_id], 'name');
        //to get the primary_item name of this item(ex:فراخ)
        $data['primary_item_name'] = getValue(new Inv_items_per_category(), ['id' => $data->primary_item_id], 'name');
        //info about unit
        //to get the primary unit name of this item(ex:شكارة)
        $data['primary_unit_name'] = getValue(new Inv_unit(), ['id' => $data->primary_unit_id], 'name');
        //to get the name of the person who updated the data(maybe no updates)
        if ($data->has_retailunit > 0 and $data->has_retailunit != null) {
            //to get the retail unit name of this item(ex:KG)
            $data['retail_unit_name'] = getValue(new Inv_unit(), ['id' => $data->retail_unit_id], 'name');
        }

        return view('admin.inv_items_per_category.show_more', ['data' => $data]);
    }
    //============================================end show ===========================================================

    //=========================================================AJAX search============================================
    //used to make live search with the help of jquary
    public function ajax_search(Request $request)
    {
        //if the request is ajax
        if ($request->ajax()) {
            // receive the variables which come from the ajax "post"
            $search_by_text = $request->search_by_text;
            $radio_search = $request->radio_search;
            //-----------------------here we do mix search between more than one field-----------------

            //-----------------------------third field-------------------------------------
            // this is a radio input and you have to choose in input only
            //  if the input is anything enter this if
            if ($search_by_text != null) {
                if ($radio_search == 'name') {
                    $field3 = 'name';
                    $operator3 = 'LIKE';
                    $value3 = "%{$search_by_text}%";
                } elseif ($radio_search == 'barcode') {
                    $field3 = 'barcode';
                    $operator3 = '=';
                    $value3 = $search_by_text;
                } elseif ($radio_search == 'item_code') {
                    $field3 = 'item_code';
                    $operator3 = '=';
                    $value3 = $search_by_text;
                }
                //  if the user doesn't enter anything wiew all "always true condtion" '
            } else {
                $field3 = 'id';
                $operator3 = '>';
                $value3 = '0';
            }

            //start to search in database
            $data = Inv_items_per_category::Where($field3, $operator3, $value3)
                ->orderBy('id', 'DESC')
                ->paginate(PAGINATION_COUNT);

            //if you found data in database
            if (!empty($data)) {
                //'data' is an array of objects
                foreach ($data as $info) {
                    //------------------------------get add_by and updated_by------------------------------------------
                    //to get the name of the person who added the data
                    $info['added_by_admin'] = getValue(new Admin(), ['id' => $info->added_by], 'name');
                    //to get the name of the person who updated the data(maybe no updates)
                    if ($info->updated_by > 0 and $info->updated_by != null) {
                        $info['updated_by_admin'] = getValue(new Admin(), ['id' => $info->updated_by], 'name');
                    }
                    // --------------- get info about the item and add this info to every item's object------------------
                    //to get the category name of this item(ex:مجمدات)
                    $info['inv_item_category_name'] = getValue(new Inv_category(), ['id' => $info->inv_category_id], 'name');
                    //to get the primary_item name of this item(ex:فراخ)
                    $info['primary_item_name'] = getValue(new Inv_items_per_category(), ['id' => $info->primary_item_id], 'name');
                    //info about unit
                    //to get the primary unit name of this item(ex:شكارة)
                    $info['primary_unit_name'] = getValue(new Inv_unit(), ['id' => $info->primary_unit_id], 'name');
                    //to get the retail unit name of this item(ex:KG)
                    $info['retail_unit_name'] = getValue(new Inv_unit(), ['id' => $info->retail_unit_id], 'name');
                }
            }
            $com_code = auth()->user()->com_code;
            //"$inv_category" is a collection of objects contains category ids and names
            $inv_category = getColumns(new Inv_category(), ['id', 'name'], ['com_code' => $com_code, 'active' => 1], 'id', 'DESC');
            //this will be returned to ajax funtion (in js file) which sent the the ajax request
            return view('admin.inv_items_per_category.ajax_search', ['data' => $data, 'inv_category' => $inv_category]);
        }
    }
    //================================================== end AJAX search funtion ========================================
} //end of the main class
