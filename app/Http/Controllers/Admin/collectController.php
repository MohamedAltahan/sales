<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collect_trasactionRequset;
use App\Models\Account;
use App\Models\Account_types;
use App\Models\Admin;
use App\Models\Transaction_type;
use App\Models\Treasuries;
use App\Models\Treasuries_transaction;
use App\Models\Users_shift;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class collectController extends Controller
{

    // ================================================index===================================================
    public function index()
    {
        //get the company code
        $com_code = auth()->user()->com_code;
        //get all transaction's data in the table which is positive only (collect)
        $data = Treasuries_transaction::select('*')->where('com_code', $com_code)->where("transaction_money_value", '>', 0)->orderby('treasuries_transactionsID', 'DESC')->paginate(PAGINATION_COUNT);
        //if table not empty add some info like 'user_name','treasury_name'
        if (!empty($data)) {
            //'data' is a collection of objects
            foreach ($data as $info) {
                //get the user name and add it to $data collection 
                $info['user_name'] = Admin::where('id', $info->added_by)->value('name');
                //get treasury name and add it to $data collection 
                $info['treasury_name'] = Treasuries::where('id', $info->treasury_id)->value('name');
                $info['transaction_type_name'] = Transaction_type::where('transaction_typesID', $info->transaction_type)->value('transaction_name');
            }
        }
        $current_user_id = auth()->user()->id;
        //get some info about the current user's shift like 'is_shift_finished', 'user_id', 'users_shiftsID '.
        $current_shift_state = getOneRow(new Users_shift(), ['user_id', 'shift_code', 'is_shift_finished', 'treasury_id'], ['com_code' => $com_code, 'user_id' => $current_user_id, 'is_shift_finished' => 0]);
        // if there is an open shift get the treasury name of this shift and add new field 'treasury_name'
        if (!empty($current_shift_state)) {
            $current_shift_state['treasury_name'] = Treasuries::where('id', $current_shift_state->treasury_id)->value('name');
            //get current treasury balance and add new field called 'treasury_balance'
            $current_shift_state['treasury_balance'] = Treasuries_transaction::where(['com_code' => $com_code, 'shift_code' => $current_shift_state->shift_code])->sum('transaction_money_value');
        }
        //'in_screen' => 2 means collect, 'is_private_internal'=>0 means view general only
        $transaction_type = getColumns(new Transaction_type(), ['transaction_name', 'transaction_typesID'], ['active' => 1, 'in_screen' => 2, 'is_private_internal' => 0], 'transaction_typesID', 'ASC');
        //get all accounts names and account_number and account_type_id
        //is_primary must be 0 becouse you can't collect for parent account
        //don't get the primary account but secondary only
        $accounts = getColumns(new Account(), ['id', 'name', 'account_number', 'account_type_id'], ['com_code' => $com_code, 'active' => 1, 'is_primary' => 0], 'id', 'DESC');

        if (!empty($accounts)) {
            foreach ($accounts as $info) {
                //get the account_type of each account to preview beside of the account name( محمد>>عميل)
                $info['account_type_name'] = Account_types::where(['id' => $info->account_type_id])->value('name');
            }
        }
        return view('admin.collect_transactions.index', ['data' => $data, 'current_shift_state' => $current_shift_state, 'accounts' => $accounts, 'transaction_type' => $transaction_type]);
    }
    // ================================================end index================================================

    //============================================store=============================================================
    public function store(Collect_trasactionRequset $request)
    {
        try {
            //get the current user id 
            $current_user_id = auth()->user()->id;
            $com_code = auth()->user()->com_code;
            //check if the user has open shift
            //get some info about the current user's shift like 'user_id', 'users_shiftsID ', 'is_shift_finished'
            $current_shift_state = getOneRow(new Users_shift(), ['user_id', 'shift_code', 'is_shift_finished', 'treasury_id'], ['com_code' => $com_code, 'user_id' => $current_user_id, 'is_shift_finished' => 0, 'treasury_id' => $request->treasury_id]);
            //check if there is an open shift 
            if (empty($current_shift_state)) {
                return redirect()->back()->with(['error' => ' عفوا لا يوجد شفت مفتوح حاليا'])->withInput();
            }
            //get last bill number with treasury
            $treasuty_data = getOneRow(new Treasuries(), ['last_bill_collect'], ['com_code' => $com_code, 'id' => $request->treasury_id]);
            //check if the treasuty is exist
            if (empty($treasuty_data)) {
                return redirect()->back()->with(['error' => 'بيانات الخزنة غير موجودة'])->withInput();
            }
            //get last auto_serial
            $last_record_in_treasuries_transactions = getLastRow(new Treasuries_transaction(), ['auto_serial'], ['com_code' => $com_code], 'auto_serial', 'DESC');
            //if empty means that the table is sill empty and no recods yet
            if (empty($last_record_in_treasuries_transactions)) {
                $data_insert['auto_serial'] = 1;
            } else {
                //if there is a record, increase it by one
                $data_insert['auto_serial'] = $last_record_in_treasuries_transactions->auto_serial + 1;
            }
            $data_insert['bill_number'] = $treasuty_data['last_bill_collect'] + 1;
            $data_insert['shift_code'] = $current_shift_state['shift_code'];
            //debit(increase the balance of this treasuty)
            $data_insert['transaction_money_value'] = $request['transaction_money_value'];
            //current account balance (creadit)(reduce the balace of the account who paid to the treasury)
            $data_insert['current_account_balance'] = $request['transaction_money_value'] * (-1);
            $data_insert['treasury_id'] = $request['treasury_id'];
            $data_insert['transaction_type'] = $request['transaction_type'];;
            $data_insert['transaction_date'] = $request['transaction_date'];
            $data_insert['account_or_treasury'] = 1;
            $data_insert['transaction_date'] = $request['transaction_date'];
            $data_insert['note'] = $request['note'];

            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['com_code'] = $com_code;
            $flag = create(new Treasuries_transaction(), $data_insert);
            if ($flag) {
                $dateUpdateTreasury['last_bill_collect'] = $data_insert['bill_number'];
                update(new Treasuries(), ['com_code' => $com_code, 'id' => $request->treasury_id], $dateUpdateTreasury);
                return redirect()->route('admin.collect_transactions.index')->with(['success' => ' تم اضافة البيانات بنجاح '])->withInput();
            } else {
                return redirect()->back()->with(['error' => ' عفوا حدث خطأ ما حاول مرة اخري'])->withInput();
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأ ما' . $ex->getMessage()])->withInput();
        }
    }
}
