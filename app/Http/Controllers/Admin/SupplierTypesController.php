<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier_type;
use App\Models\Admin;
use App\Http\Requests\SupplierTypesRequest;


class SupplierTypesController extends Controller
{
    //=======================================index======================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        //'paginate()' is the number of rows in a single page
        $com_code = auth()->user()->com_code;
        $data = getColumns_p(new Supplier_type(), ['*'], ['com_code' => $com_code], 'id', 'DESC', PAGINATION_COUNT);
        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.supplier_types.index', ['data' => $data]);
    }
    //============================================end index==============================================================

    //============================================create=====================================================================
    //used to creat new treasuries go to this page
    public function create()
    {
        return view('admin.supplier_types.create');
    }
    //===========================================end create==================================================================
    //===========================================store======================================================================
    // store the entered data in the 'creat form' in the database
    public function store(SupplierTypesRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //check if  entered name not exist
            //search by [com_code and the entered name] you have to use array brackets[]
            $checkExists = Supplier_type::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {

                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['added_by'] = auth()->user()->id;
                $data['com_code'] = $com_code;
                $data['date'] = date('Y-m-d ');

                //write the data in the database in the treasuries table
                Supplier_type::create($data);
                return redirect()
                    ->route('admin.supplier_types.index')
                    ->with(['success' => 'تم اضافه البيانات بنجاح']);
            }
            //end main if
            //do this if the name is exist before
            else {
                return redirect()
                    ->back()
                    ->with(['error' => 'عفوا اسم المورد موجود'])
                    ->withinput();
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

    //========================================================edit ===========================================================
    // used to edit the treasuries info
    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
        $data = getOneRow(new Supplier_type(), ['*'], ['id' => $id, 'com_code' => $com_code]);

        //return with an array named 'data'
        return view('admin.supplier_types.edit', ['data' => $data]);
    }
    //=======================================================end edit=========================================================

    //===========================================update======================================================================

    //store the date in the database after the user edit it
    public function update($id, SupplierTypesRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = getOneRow(new Supplier_type(), ['id'], ['id' => $id, 'com_code' => $com_code]);
            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.supplier_types.index')
                    ->with(['error' => 'غير قادر على الوصول للبيانات']);
            }
            //check name existance
            $checkExists = Supplier_type::where(['name' => $request->name, 'com_code' => $com_code])
                // if there is anothr item with the same name and the same id it means it's repeated
                ->where('id', '!=', $id)
                ->first();
            if ($checkExists != null) {
                return redirect()
                    ->back()
                    ->with(['error' => 'اسم المورد مسجل من قبل'])
                    ->withInput();
            }

            $data_to_update['name'] = $request->name;
            $data_to_update['active'] = $request->active;
            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['updated_at'] = date('Y-m-d H:i:s');
            Supplier_type::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            return redirect()
                ->route('admin.supplier_types.index')
                ->with(['success' => 'تم اضافه البيانات بنجاح']);
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
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = getOneRow(new Supplier_type(), ['id'], ['id' => $id, 'com_code' => $com_code]);

            if (!empty($data)) {
                // delete returns true or false
                $flag = Supplier_type::where(['id' => $id, 'com_code' => $com_code])->delete();
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

    //========================================end delete treasuries delivery==========================================

}
