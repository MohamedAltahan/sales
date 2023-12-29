<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserShiftsRequest;
use App\Models\Admin;
use App\Models\Treasuries;
use App\Models\Treasuries_admin;
use App\Models\Users_shift;
use Illuminate\Http\Request;

class Users_shiftsController extends Controller
{
    // ================================================index===================================================
    public function index()
    {
        //we need to get all the shifts in 'Users_shift' table to view them 
        $com_code = auth()->user()->com_code;
        //first get all shifts belongs to this company
        $data = getColumns_p(new Users_shift(), ['*'], ['com_code' => $com_code], 'users_shiftsID', 'DESC', PAGINATION_COUNT);
        // check if there is data comes form this query
        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                //get the name of the user who added this shift
                $info['current_user_name'] = Admin::where('id', $info->user_id)->value('name');
                //get the name of the treasury in this shift
                $info['treasury_name'] = Treasuries::where('id', $info->treasury_id)->value('name');
            }
        }
        $current_user_id = auth()->user()->id;
        $current_shift_state = getValue(new Users_shift(), ['com_code' => $com_code, 'user_id' => $current_user_id, 'is_shift_finished' => 0], 'is_shift_finished');
        return view('admin.users_shifts.index', ['data' => $data, 'current_shift_state' => $current_shift_state]);
    }
    // ================================================end index================================================

    //============================================create=============================================================
    public function create()
    {

        //we need to get the treasuries that user can access them
        $com_code = auth()->user()->com_code;
        $current_user_id = auth()->user()->id;
        //first get ids of all treasuries that belongs to current user
        $current_user_treasuries = getColumns(new Treasuries_admin(), ['treasury_id'], ['admin_id' => $current_user_id, 'com_code' => $com_code, 'active' => 1], 'treasuries_admins_id', 'DESC');
        if (!empty($current_user_treasuries)) {
            //'Treasuries_admin' is an array of objects
            foreach ($current_user_treasuries as $info) {
                //second get the name of all treasuries that belongs to current user
                $info['treasury_name'] = Treasuries::where('id', $info->treasury_id)->value('name');
                //chect if the current shift is finished or not (true or false)
                $check_shift_finish = getOneRow(new Users_shift(), ['is_shift_finished'], ['treasury_id' => $info->treasury_id, 'com_code' => $com_code, 'is_shift_finished' => 0]);
                if (!empty($check_shift_finish) and ($check_shift_finish != null)) {
                    //if the current shift is finshed yet
                    $info['available'] = 0;
                } else {
                    //if the current shift finshed 
                    $info['available'] = 1;
                }
            } //foreach end
        } //end if
        return view('admin.users_shifts.create', ['current_user_treasuries' => $current_user_treasuries]);
    }
    //============================================end create ===========================================================

    //===========================================store==================================================================
    // store the entered data in the 'creat form' in the database
    public function store(UserShiftsRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $current_user_id = auth()->user()->id;
            //chect if the current shift is still open or finished before you start new shift
            $check_shift_finish = getOneRow(new Users_shift(), ['is_shift_finished'], ['user_id' => $current_user_id, 'com_code' => $com_code, 'is_shift_finished' => 0]);
            if ($check_shift_finish != null and !empty($check_shift_finish)) {
                return redirect()
                    ->route('admin.users_shifts.index')
                    ->with(['error' => 'لايمكن فتح شيف جديد, يجب انهاء الشيفت الحالي اولاً']);
            }
            //check if the selected treasury is stil in use or free
            $check_treasury_finish = getOneRow(new Users_shift(), ['is_shift_finished'], ['com_code' => $com_code, 'is_shift_finished' => 0]);
            if ($check_treasury_finish != null and !empty($check_treasury_finish)) {
                return redirect()
                    ->route('admin.users_shifts.index')
                    ->with(['error' => 'لايمكن فتح شيفت جديد, لان الخزنة مستخدمة مع شيفت اخر يجب انهاء الشيفت اولا.']);
            }
            //set 'shift_code' for each shift
            //first get the last shift number 
            $lastrow = getlastRow(new Users_shift(), ['shift_code'], ['com_code' => $com_code], 'id', 'DESC');
            if (!empty($lastrow)) {
                //after getting the last account number you add 1 to it
                $data_insert['shift_code'] = $lastrow['shift_code'] + 1;
            } else {
                // for the first time
                $data_insert['shift_code'] = 1;
            }
            $data_insert['user_id'] = $current_user_id;
            $data_insert['treasury_id'] = $request->treasury_id;
            $data_insert['start_date'] = date('Y-m-d H:i:s');
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['com_code'] = $com_code;
            $data_insert['date'] = date('Y-m-d ');

            $flag = create(new Users_shift(), $data_insert);
            if ($flag) {
                return redirect()
                    ->route('admin.users_shifts.index')
                    ->with(['success' => 'تم اضافه البيانات بنجاح']);
            } else {
                return redirect()
                    ->route('admin.users_shifts.index')
                    ->with(['error' => 'عفوا حدث خطأ ما']);
            }
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //========================================================end store=======================================================
}
