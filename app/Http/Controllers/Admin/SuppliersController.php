<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuppliersRequest;
use App\Http\Requests\SupplierUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Supplier;
use App\Models\Account;
use App\Models\Supplier_type;
use App\Models\Admin_panel_setting;


class SuppliersController extends Controller
{
    // ================================================index===================================================

    public function index()
    {
        //'paginate()' is the number of rows in a single page
        $com_code = auth()->user()->com_code;
        $data = getColumns_p(new Supplier(), ['*'], ['com_code' => $com_code], 'id', 'DESC', PAGINATION_COUNT);
        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                $info['supplier_type_name'] = Supplier_type::where('id', $info->added_by)->value('name');
                $info['added_by_admin'] = Supplier::where('id', $info->supplier_type_id)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }

        return view('admin.suppliers.index', ['data' => $data]);
    }
    // ================================================end index================================================

    // ================================================create================================================
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $supplier_type_id = getColumns(new Supplier_type(), ['id', 'name'], ['com_code' => $com_code], 'id', 'DESC');
        return view('admin.suppliers.create', ['supplier_type_id' => $supplier_type_id]);
    }
    // ================================================end create================================================

    //============================================store=============================================================
    public function store(SuppliersRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;

            //check existance of name
            $checkExists_name = getOneRow(new Supplier(), ['id'], ['name' => $request->name, 'com_code' => $com_code]);
            if (!empty($checkExists_name)) {
                return redirect()
                    ->back()
                    ->with(['error' => ' عفوا اسم العميل مسجل من قبل'])
                    ->withinput();
            }

            //set 'supplier_code' for each account
            //first get the last account number 
            $lastrow = getlastRow(new Supplier(), ['supplier_code'], ['com_code' => $com_code], 'id', 'DESC');
            if (!empty($lastrow)) {
                //after getting the last account number you add 1 to it
                $data_insert['supplier_code'] = $lastrow['supplier_code'] + 1;
            } else {
                // for the first time
                $data_insert['supplier_code'] = 1;
            }


            $data_insert['name'] = $request->name;
            $data_insert['supplier_type_id'] = $request->supplier_type_id;
            $data_insert['address'] = $request->address;

            $data_insert['active'] = $request->active;

            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['date'] = date('Y-m-d');
            $data_insert['com_code'] = $com_code;
            $flag = Supplier::create($data_insert);

            return redirect()
                ->route('admin.suppliers.index')
                ->with(['success' => "تمت اضافة  $request->name بنجاح"]);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //=====================================end store ===========================================


    //=========================================edit ============================================
    // used to edit the treasuries info
    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
        //get the data of an if
        $supplier_type_id = getColumns(new Supplier_type(), ['id', 'name'], ['com_code' => $com_code], 'id', 'DESC');
        $data = getOneRow(new Supplier(), ['*'], ['id' => $id, 'com_code' => $com_code]);
        //return with an object named 'data'
        return view('admin.suppliers.edit', ['data' => $data, 'supplier_type_id' => $supplier_type_id]);
    }
    //========================================end edit==========================================

    //========================================end update===========================================
    //store the date in the database after the user edit it
    public function update(SupplierUpdateRequest $request, $id)
    {

        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = getOneRow(new supplier(), ['id', 'account_number'], ['id' => $id, 'com_code' => $com_code]);
            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.suppliers.index')
                    ->with(['error' => 'غير قادر على الوصول للبيانات']);
            }
            //check name existance
            $checkExists = supplier::where(['name' => $request->name, 'com_code' => $com_code])
                // if there is anothr item with the same name and the same id it means it's repeated
                ->where('id', '!=', $id)
                ->first();
            if ($checkExists != null) {
                return redirect()
                    ->back()
                    ->with(['error' => 'اسم الحساب مسجل من قبل'])
                    ->withInput();
            }
            $data_to_update['supplier_type_id'] = $request->supplier_type_id;
            $data_to_update['name'] = $request->name;
            $data_to_update['address'] = $request->address;
            $data_to_update['notes'] = $request->notes;
            $data_to_update['active'] = $request->active;

            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['updated_at'] = date('Y-m-d H:i:s');
            // vip notes
            //update and delete function in laravel returns 0 or 1 
            //create function in laravel returns the created object 
            $flag = supplier::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            //also update in the accounts table 

            return redirect()
                ->route('admin.suppliers.index')
                ->with(['success' => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //========================================end update==============================================

    //========================================delete==================================================
    public function delete($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = getOneRow(new supplier(), ['id'], ['id' => $id, 'com_code' => $com_code]);


            if (!empty($data)) {
                // delete returns true or false (0 or 1)
                $flag = supplier::where(['id' => $id, 'com_code' => $com_code])->delete();
                if ($flag) {
                    return redirect()
                        ->back()
                        ->with(['success' => 'تم الحذف بنجاح']);
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
    //==================================end delete ========================================



    //===============================AJAX search============================================
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
            // this is a radio input and you have to choose one input only
            //  if the input is anything enter this if
            if ($search_by_text != null) {
                if ($radio_search == 'name') {
                    $field1 = 'name';
                    $operator1 = 'LIKE';
                    $value1 = "%{$search_by_text}%";
                } elseif ($radio_search == 'supplier_code') {
                    $field1 = 'supplier_code';
                    $operator1 = '=';
                    $value1 = $search_by_text;
                } elseif ($radio_search == 'account_number') {
                    $field1 = 'account_number';
                    $operator1 = '=';
                    $value1 = $search_by_text;
                }
                //  if the user doesn't enter anything wiew all "always true condtion" '
            } else {
                $field1 = 'id';
                $operator1 = '>';
                $value1 = '0';
            }
            $com_code = auth()->user()->com_code;
            //start to search in database
            $data = supplier::where($field1, $operator1, $value1)->where('com_code', $com_code)
                ->orderBy('id', 'DESC')
                ->paginate(PAGINATION_COUNT);

            //if you found data in database

            //'data' is an array of objects
            if (!empty($data)) {
                //'data' is an array of objects
                foreach ($data as $info) {
                    $info['supplier_type_name'] = Supplier_type::where('id', $info->added_by)->value('name');
                    $info['added_by_admin'] = Supplier::where('id', $info->supplier_type_id)->value('name');
                    if ($info->updated_by > 0 and $info->updated_by != null) {
                        $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                    }
                }
            }
            //this will be returned to ajax funtion (in js file) which sent the the ajax request
            return view('admin.suppliers.ajax_search', ['data' => $data]);
        }
    }
    //========================================= end AJAX search funtion ==================================

}
