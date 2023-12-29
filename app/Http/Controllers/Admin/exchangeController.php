<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exchange_transactionRequest;
use App\Models\Account;
use App\Models\Account_types;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Transaction_type;
use App\Models\Treasuries;
use Illuminate\Http\Request;
use App\Models\Treasuries_transaction;
use App\Models\Users_shift;

class exchangeController extends Controller
{
    // ================================================index======================================================

    function index()
    {
        $com_code = auth()->user()->com_code;
        //get all transaction's data in the table which is negative only (exchange)
        $data = Treasuries_transaction::select('*')->where(['com_code' => $com_code])->orderby('treasuries_transactionsID', 'DESC')->paginate(PAGINATION_COUNT);
        //if table not empty add some info like 'user_name','treasury_name'
        if (!empty($data)) {
            //'data' is a collection of objects
            foreach ($data as $info) {
                //get the user name and add it to $data collection 
                $info['user_name'] = Admin::where('id', $info->added_by)->value('name');
                $info['employee_name'] = Employee::where('employeeId', $info->account_number)->value('name');
            }
        }
        //get all accounts names and account_number
        //is_primary must be 0 becouse you can't collect for parent account
        $accounts = getColumns(new Employee(), ['*'], ['com_code' => $com_code], 'name', 'ASC');

        return view('admin.exchange_transactions.index', ['data' => $data, 'accounts' => $accounts]);
    }
    // ================================================end index===================================================

    //============================================store=============================================================
    public function store(Exchange_transactionRequest $request)
    {

        try {
            //get company code and user id
            $com_code = auth()->user()->com_code;
            //check if the user has open shift
            //get some info about the current user's shift like 'user_id', 'users_shiftsID ', 'is_shift_finished'

            //get last auto_serial
            $last_record_in_treasuries_transactions = getLastRow(new Treasuries_transaction(), ['auto_serial'], ['com_code' => $com_code], 'auto_serial', 'DESC');
            //if empty means that the table is sill empty and no recods yet
            if (empty($last_record_in_treasuries_transactions)) {
                $data_insert['auto_serial'] = 1;
            } else {
                //if there is a record, increase it by one
                $data_insert['auto_serial'] = $last_record_in_treasuries_transactions->auto_serial + 1;
            }

            //current account balance (creadit)(reduce the balance of this treasury)
            $data_insert['transaction_money_value'] = $request['transaction_money_value'];
            $data_insert['transaction_date'] = $request['transaction_date'];
            $data_insert['note'] = $request['note'];
            $data_insert['account_number'] = $request['account_number'];

            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['com_code'] = $com_code;
            $flag = create(new Treasuries_transaction(), $data_insert);
            if ($flag) {
                Employee::where('employeeId', $request['account_number'])->decrement('current_balance', $request['transaction_money_value']);
            }
            return redirect()->route('admin.exchange_transactions.index')->with(['success' => ' تم اضافة البيانات بنجاح ']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأ ما' . $ex->getMessage()])->withInput();
        }
    }
    //========================================end store=============================================================

}//end class
