<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Treasuries_transaction;
use Illuminate\Http\Request;

class employeesController extends Controller
{
    public function index()
    {
        //'paginate()' is the number of rows in a single page
        $com_code = auth()->user()->com_code;
        $data = getColumns_p(new Employee(), ['*'], ['com_code' => $com_code], 'employeeId', 'DESC', PAGINATION_COUNT);

        return view('admin.employees.index', ['data' => $data]);
    }
    // ================================================end index================================================

    // ================================================create================================================
    public function create()
    {
        //$com_code = auth()->user()->com_code;
        // $supplier_type_id = getColumns(new Supplier_type(), ['id', 'name'], ['com_code' => $com_code], 'id', 'DESC');
        return view('admin.employees.create');
    }
    // ================================================end create================================================

    //============================================store=============================================================
    public function store(Request $request)
    {
        try {
            $com_code = auth()->user()->com_code;

            //check existance of name
            $checkExists_name = getOneRow(new Employee(), ['employeeId'], ['name' => $request->name, 'com_code' => $com_code]);
            if (!empty($checkExists_name)) {
                return redirect()
                    ->back()
                    ->with(['error' => ' عفوا اسم العميل مسجل من قبل'])
                    ->withinput();
            }


            $data_insert['name'] = $request->name;
            // 2 is له 
            if ($request->start_balance_status == 1) {
                $data_insert['current_balance'] = $request->current_balance;
                //1 is عليه
            } elseif ($request->start_balance_status == 2) {
                $data_insert['current_balance'] = -1 * $request->current_balance;
            } else {
                $data_insert['current_balance'] = 0;
            }

            $data_insert['start_balance_status'] = $request->start_balance_status;
            $data_insert['notes'] = $request->notes;
            $data_insert['address'] = $request->address;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['date'] = date('Y-m-d');
            $data_insert['com_code'] = $com_code;
            $flag = Employee::create($data_insert);

            return redirect()
                ->route('admin.employees.index')
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
    public function edit($employeeId)
    {
        $com_code = auth()->user()->com_code;
        //get the data of an if
        $employeeData = getOneRow(new Employee(), ['*'], ['employeeId' => $employeeId, 'com_code' => $com_code]);
        //return with an object named 'employeeData'
        return view('admin.employees.edit', ['employeeData' => $employeeData]);
    }
    //========================================end edit==========================================

    //=========================================details ============================================
    // used to edit the treasuries info
    public function details($employeeId)
    {
        $com_code = auth()->user()->com_code;
        //get the data of an if
        $employeeDetails = getColumns_p(new Treasuries_transaction(), ['*'], ['account_number' => $employeeId, 'com_code' => $com_code], 'created_at', 'DESC', PAGINATION_COUNT);
        foreach ($employeeDetails as $info) {
            //get the user name and add it to $data collection 
            $info['user_name'] = Admin::where('id', $info->added_by)->value('name');
            $info['employee_name'] = Employee::where('employeeId', $info->account_number)->value('name');
        }
        //return with an object named 'employeeData'
        return view('admin.employees.details', ['employeeDetails' => $employeeDetails]);
    }
    //========================================end details==========================================

    //========================================end update===========================================
    //store the date in the database after the user edit it
    public function update($employeeId, Request $request)
    {

        try {
            $com_code = auth()->user()->com_code;

            //check existance of name
            $checkExists_name = Employee::where(['name' => $request->name])->where('employeeId', '!=', $employeeId)->first();
            if (!empty($checkExists_name)) {
                return redirect()
                    ->back()
                    ->with(['error' => ' عفوا اسم العميل مسجل من قبل'])
                    ->withinput();
            }


            $data_insert['name'] = $request->name;
            // 2 is له 
            if ($request->start_balance_status == 1) {
                $data_insert['current_balance'] = $request->current_balance;
                //1 is عليه
            } elseif ($request->start_balance_status == 2) {
                $data_insert['current_balance'] = -1 * $request->current_balance;
            } else {
                $data_insert['current_balance'] = 0;
            }

            $data_insert['start_balance_status'] = $request->start_balance_status;
            $data_insert['notes'] = $request->notes;
            $data_insert['address'] = $request->address;
            $data_insert['updated_at'] = date('Y-m-d H:i:s');

            $data_insert['com_code'] = $com_code;
            Employee::where(['employeeId' => $employeeId])->update($data_insert);

            return redirect()
                ->route('admin.employees.index')
                ->with(['success' => "تمت اضافة  $request->name بنجاح"]);
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
    public function delete($employeeId)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            //check if there is data in the table
            $data = getOneRow(new Employee(), ['employeeId'], ['employeeId' => $employeeId]);

            if (!empty($data)) {
                // delete returns true or false (0 or 1)
                $flag = Employee::where(['employeeId' => $employeeId])->delete();
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


}
