<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Treasuries;
use App\Models\Treasuries_admin;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    //=======================================index====================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        //'paginate()' is the number of rows in a single page
        $com_code = auth()->user()->com_code;
        $data = getColumns_p(new Admin(), ['*'], ['com_code' => $com_code], 'id', 'DESC', PAGINATION_COUNT);
        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.admins_accounts.index', ['data' => $data]);
    }
    //================================================end index===========================================================

    //======================================================details=======================================================
    public function details($id)
    {
        try {
            // $com_code = auth()->user()->com_code;
            //get the info of the current Treasuries from the database using "select()" of the the id using "find($id)"
            $com_code = auth()->user()->com_code;
            $data = getOneRow(new Admin(), ['*'], ['id' => $id, 'com_code' => $com_code]);

            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.admins_accounts.index')
                    ->with(['error' => ' غير قادر على الوصول للبيانات']);
            }
            //get the admin's name who added the current treauries($id)
            $data['added_by_admin'] = Admin::where('id', $data->added_by)->value('name');
            //get the admin's name who updated the current treasries
            //first chech if there is someone updated the record
            if (($data->updated_by > 0) && ($data->updated_by != null)) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }
            $treasuries = getColumns(new Treasuries(), ['id', 'name'], ['active' => 1, 'com_code' => $com_code], 'id', 'ASC');

            //get secondry treasuries 'treasuries_id', which follow the current parent '$id'.
            $treasuries_admins = getColumns(new Treasuries_admin(), ['*'], ['admin_id' => $id, 'com_code' => $com_code], 'treasuries_admins_id', 'DESC');

            if (!empty($treasuries_admins)) {
                foreach ($treasuries_admins as $info) {
                    // to get the treasuries name through its id and add a new attribute called 'name' to the object 
                    $info->name = Treasuries::where('id', $info->treasury_id)->value('name');
                    // to get the treasuries name through its id and add a new attribute called 'add_by_admin' to the object 
                    $info->add_by_admin = Admin::where('id', $info->added_by)->value('name');
                }
            }

            return view('admin.admins_accounts.details', ['data' => $data, 'treasuries_admins' => $treasuries_admins, 'treasuries' => $treasuries]);
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

    //===========================================add_treasuries_to_admin=================================================
    public function add_treasuries_to_admin($id, Request $request)
    {
        try {
            $com_code = auth()->user()->com_code;

            //get data about the choosen admin
            $data = getOneRow(new Admin(), ['*'], ['id' => $id, 'com_code' => $com_code]);
            //if we don't find this admin id in admin table
            if (empty($data)) {
                return redirect()
                    ->route('admin.admins_accounts.index')
                    ->with(['error' => ' غير قادر على الوصول للبيانات']);
            }
            //check the admin existance
            $treasuries_admins = getOneRow(new Treasuries_admin(), ['treasuries_admins_id'], ['admin_id' => $id, 'treasury_id' => $request->treasury_id, 'com_code' => $com_code]);

            //if we don't find this id
            if (!empty($treasuries_admins)) {
                return redirect()
                    ->route('admin.admins_accounts.details', $id)
                    ->with(['error' => ' عفو اهذا الخزنة مضافة من قبل لهذا المستخدم  ']);
            }

            //if we don't find this id
            if (empty($request->treasury_id)) {
                return redirect()
                    ->route('admin.admins_accounts.details', $id)
                    ->with(['error' => ' لم يتم اختيار اسم الخزنة !!!!! اختر اسم الخزنة ']);
            }
            $data_insert['admin_id'] = $id;
            $data_insert['active'] = 1;
            $data_insert['treasury_id'] = $request->treasury_id;
            $data_insert['created_at'] = date('Y-m-d H:i:s');
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['com_code'] = $com_code;
            $data_insert['date'] = date('Y-m-d ');

            //write the data in the database in the treasuries table
            $flag = create(new Treasuries_admin(), $data_insert);
            if ($flag) {
                return redirect()
                    ->route('admin.admins_accounts.details', $id)
                    ->with(['success' => 'تم اضافه البيانات بنجاح']);
            } else {
                return redirect()
                    ->route('admin.admins_accounts.details', $id)
                    ->with(['error' => ' عفوا حدث خطأ ما   ']);
            }
        } catch (\Exception $ex) {
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //========================================end add_treasuries_to_admin===============================================
}
