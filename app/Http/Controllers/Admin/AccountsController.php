<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Account;
use App\Models\Customer;

         use App\Models\Account_types;
use App\Http\Requests\AccountsRequest;

class AccountsController extends Controller
{
    public function index()
    {
        // ================================================index===================================================
        //'paginate()' is the number of rows in a single page
        $com_code = auth()->user()->com_code;
        $data = getColumns_p(new Account(), ['*'], ['com_code' => $com_code], 'id', 'DESC', PAGINATION_COUNT);
        if (!empty($data)) {
            //'data' is an array of objects
                foreach ($data as $info) { 

                $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }

                $info['account_type_name'] = Account_types::where('id', $info['account_type_id'])->value('name');

                 if ($info->is_primary == 0) {
                    $info['primary_account_name'] = Account::where('id', $info['primary_account_number'])->value('name');
                } else {
                    $info['primary_account_name'] = 'لايوجد';
                 }
            }
        }
        $account_types = getColumns(new Account_types(), ['id', 'name'], ['active' => 1], 'id', 'ASC');

        return view('admin.accounts.index', ['data' => $data, 'account_types' => $account_types]);
    }
    // ================================================end index================================================

    // ======================================================create=============================================
     public function create()
    {

        $com_code = auth()->user()->com_code;
        $account_types = getColumns(new Account_types(), ['id', 'name'], ['active' => 1, 'related_internal_accounts' => 0], 'id', 'ASC');
        $primary_accounts = getColumns(new Account(), ['id', 'account_number', 'name'], ['is_primary' => 1, 'com_code' => $com_code], 'id', 'ASC');
        return view('admin.accounts.create', ['account_types' => $account_types, 'primary_accounts' => $primary_accounts]);
    }
    // ======================================================end create==============================================


    //============================================store=============================================================
    public function store(AccountsRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;

            //check existance of name
            $checkExists_name = getOneRow(new Account(), ['id'], ['name' => $request->name, 'com_code' => $com_code]);
            if (!empty($checkExists_name)) {
                return redirect()
                    ->back()
                    ->with(['error' => ' عفوا اسم الحساب مسجل من قبل'])
                    ->withinput();
            }

            //set 'account number' for each account
            //first get the last account number 
            $lastrow = getlastRow(new Account(), ['account_number'], ['com_code' => $com_code], 'id', 'DESC');
            if (!empty($lastrow)) {
                //after getting the last account number you add 1 to it
                $data_insert['account_number'] = $lastrow['account_number'] + 1;
            } else {
                // for the first time
                $data_insert['account_number'] = 1;
            }


            $data_insert['name'] = $request->name;


            $data_insert['account_type_id'] = $request->account_type_id;
            $data_insert['is_primary'] = $request->is_primary;
            $data_insert['start_balance_status'] = $request->start_balance_status;

            if ($data_insert['is_primary'] == 0) {

                $data_insert['primary_account_number'] = $request->primary_accounts;
            } else {
                $data_insert['primary_account_number'] = null;
            }
            // balanced account
            if ($data_insert['start_balance_status'] == 0) {
                $data_insert['start_balance'] = 0;
            }
            // creadit account
            elseif ($data_insert['start_balance_status'] == 1) {
                $data_insert['start_balance'] = $request->start_balance;
            }
            //debit account
            elseif ($data_insert['start_balance_status'] == 2) {
                $data_insert['start_balance'] = ($request->start_balance) * (-1);
            }


            $data_insert['notes'] = $request->notes;
            $data_insert['active'] = $request->active;


            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['date'] = date('Y-m-d');
            $data_insert['com_code'] = $com_code;
            Account::create($data_insert);

            return redirect()
                ->route('admin.accounts.index')
                ->with(['success' => "تمت اضافة  $request->name بنجاح"]);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //=====================================end store ===================================

    //=========================================edit ============================================
    // used to edit the treasuries info
    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
        //get the data of an if
        $data = getOneRow(new Account(), ['*'], ['id' => $id, 'com_code' => $com_code]);
        $account_types = getColumns(new Account_types(), ['id', 'name'], ['active' => 1], 'id', 'ASC');
        $primary_accounts = getColumns(new Account(), ['id', 'name'], ['is_primary' => 1, 'com_code' => $com_code], 'id', 'ASC');

        //return with an object named 'data'
        return view('admin.accounts.edit', ['data' => $data, 'account_types' => $account_types, 'primary_accounts' => $primary_accounts]);
    }
    //========================================end edit============================================

    //========================================end update===========================================
    //store the date in the database after the user edit it
    public function update(AccountsRequest $request, $id)
    {

        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = getOneRow(new Account(), ['id', 'account_number', 'account_type_id'], ['id' => $id, 'com_code' => $com_code]);
            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.accounts.index')
                    ->with(['error' => 'غير قادر على الوصول للبيانات']);
            }
            //check name existance
            $checkExists = Account::where(['name' => $request->name, 'com_code' => $com_code])
                // if there is anothr item with the same name and the same id it means it's repeated
                ->where('id', '!=', $id)
                ->first();
            if ($checkExists != null) {
                return redirect()
                    ->back()
                    ->with(['error' => 'اسم الحساب مسجل من قبل'])
                    ->withInput();
            }

            $data_to_update['name'] = $request->name;
            $data_to_update['account_type_id'] = $request->account_type_id;
            $data_to_update['is_primary'] = $request->is_primary;
            $data_to_update['start_balance_status'] = $request->start_balance_status;

            if ($data_to_update['is_primary'] == 0) {

                $data_to_update['primary_account_number'] = $request->primary_accounts;
            } else {
                $data_to_update['primary_account_number'] = null;
            }
            // balanced account
            if ($data_to_update['start_balance_status'] == 0) {
                $data_to_update['start_balance'] = 0;
            }
            // creadit account
            elseif ($data_to_update['start_balance_status'] == 1) {
                $data_insert['start_balance'] = $request->start_balance;
            }
            //debit account
            elseif ($data_to_update['start_balance_status'] == 2) {
                $data_to_update['start_balance'] = ($request->start_balance) * (-1);
            }

            $data_to_update['notes'] = $request->notes;
            $data_to_update['active'] = $request->active;

            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['updated_at'] = date('Y-m-d H:i:s');
            $flag = Account::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            if ($flag) {
                if ($data['account_type_id'] == 3) {
                    //update in customer table also
                    $data_to_update_customer['name'] = $request->name;
                    $data_to_update_customer['address'] = $request->address;
                    $data_to_update_customer['notes'] = $request->notes;
                    $data_to_update_customer['active'] = $request->active;
                    $data_to_update_customer['updated_by'] = auth()->user()->id;
                    $data_to_update_customer['updated_at'] = date('Y-m-d H:i:s');
                    // vip notes
                    //update and delete function in laravel returns 0 or 1 
                    //create function in laravel returns the created object 
                    Customer::where(['account_number' => $data['account_number'], 'com_code' => $com_code])->update($data_to_update_customer);
                }
            }
            return redirect()
                ->route('admin.accounts.index')
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

    //========================================delete==================================================
    public function delete($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = getOneRow(new Account(), ['id'], ['id' => $id, 'com_code' => $com_code]);


            if (!empty($data)) {
                // delete returns true or false (0 or 1)
                $flag = Account::where(['id' => $id, 'com_code' => $com_code])->delete();
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
            $account_type_id_search = $request->account_type_id_search;
            $is_primary_search = $request->is_primary_search;

            //-----------------------here we do mix search between more than one field-----------------
            //-------------------------------------first field---------------------------
            //if the input is null 'user didn't enter anything,default value is "all"'
            //you will view all the items in the database
            //this condition will display everything in the database(always ture condition ^-^)
            if ($is_primary_search == 'all') {
                $field2 = 'id';
                $operator2 = '>';
                $value2 = '0';
            }
            //  if the user enters anything'
            // find in the database what user chooses
            else {
                $field2 = 'is_primary';
                $operator2 = '=';
                $value2 = $is_primary_search;
            }
            //----------------------------------second field------------------------------
            //if the input is null 'user didn't enter anything, default value is "all" '
            //you will view all the items in the database
            //this condition will display everything in the database
            if ($account_type_id_search == 'all') {
                $field1 = 'id';
                $operator1 = '>';
                $value1 = '0';
            }
            //  if the user enters anything'
            // find in the database what user chooses
            else {
                $field1 = 'account_type_id';
                $operator1 = '=';
                $value1 = $account_type_id_search;
            }
            //-----------------------------third field-------------------------------------
            // this is a radio input and you have to choose one input only
            //  if the input is anything enter this if
            if ($search_by_text != null) {
                if ($radio_search == 'name') {
                    $field3 = 'name';
                    $operator3 = 'LIKE';
                    $value3 = "%{$search_by_text}%";
                } elseif ($radio_search == 'account_number') {
                    $field3 = 'account_number';
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
            $data = Account::where($field2, $operator2, $value2)
                ->where($field1, $operator1, $value1)
                ->Where($field3, $operator3, $value3)
                ->orderBy('id', 'DESC')
                ->paginate(PAGINATION_COUNT);

            //if you found data in database
            if (!empty($data)) {
                //'data' is an array of objects
                foreach ($data as $info) {

                    $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');

                    if ($info->updated_by > 0 and $info->updated_by != null) {
                        $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                    }

                    $info['account_type_name'] = Account_types::where('id', $info['account_type_id'])->value('name');

                    if ($info->is_primary == 0) {
                        $info['primary_account_name'] = Account::where('id', $info['primary_account_number'])->value('name');
                    } else {
                        $info['primary_account_name'] = 'لايوجد';
                    }
                }
                //this will be returned to ajax funtion (in js file) which sent the the ajax request
                return view('admin.accounts.ajax_search', ['data' => $data]);
            }
        }
        //========================================= end AJAX search funtion ==================================
    }
}
