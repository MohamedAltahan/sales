<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales_matrial_types;
use App\Models\Admin;
use App\Http\Requests\SalesMatrialTypesRequest;

class Sales_matrial_typesController extends Controller
{
    //=======================================index======================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        //'paginate()' is the number of rows in a single page
        $data = Sales_matrial_types::select()
            ->orderby('id', 'DESC')
            ->paginate(PAGINATION_COUNT);
        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.sales_matrial_types.index', ['data' => $data]);
    }
    //============================================end index=================================================================
    //============================================create=====================================================================
    //used to creat new treasuries go to this page
    public function create()
    {
        return view('admin.sales_matrial_types.create');
    }
    //===========================================end create==================================================================
    //===========================================store======================================================================
    // store the entered data in the 'creat form' in the database
    public function store(SalesMatrialTypesRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //check if  entered name not exist
            //search by [com_code and the entered name] you have to use array brackets[]
            $checkExists = Sales_matrial_types::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {


                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['added_by'] = auth()->user()->id;
                $data['com_code'] = $com_code;
                $data['date'] = date('Y-m-d ');

                //write the data in the database in the treasuries table
                Sales_matrial_types::create($data);
                return redirect()
                    ->route('admin.sales_matrial_types.index')
                    ->with(['success' => 'تم اضافه البيانات بنجاح']);
            }
            //end main if
            //do this if the name is exist before
            else {
                return redirect()
                    ->back()
                    ->with(['error' => 'عفوا اسم الفئة موجود'])
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
        $data = sales_matrial_types::select()->find($id);
        //return with an array named 'data'
        return view('admin.sales_matrial_types.edit', ['data' => $data]);
    }
    //=======================================================end edit=========================================================

    //===========================================update======================================================================

    //store the date in the database after the user edit it
    public function update($id, SalesMatrialTypesRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = sales_matrial_types::select()->find($id);
            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.sales_matrial_typess.index')
                    ->with(['error' => 'غير قادر على الوصول للبيانات']);
            }
            //check name existance
            $checkExists = sales_matrial_types::where(['name' => $request->name, 'com_code' => $com_code])
                // if there is anothr item with the same name and the same id it means it's repeated
                ->where('id', '!=', $id)
                ->first();
            if ($checkExists != null) {
                return redirect()
                    ->back()
                    ->with(['error' => 'اسم الفئة مسجل من قبل'])
                    ->withInput();
            }

            $data_to_update['name'] = $request->name;
            $data_to_update['active'] = $request->active;
            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['updated_at'] = date('Y-m-d H:i:s');
            sales_matrial_types::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            return redirect()
                ->route('admin.sales_matrial_types.index')
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
            $sales_matrial_types_row = sales_matrial_types::find($id);
            if (!empty($sales_matrial_types_row)) {
                // delete returns true or false
                $flag = $sales_matrial_types_row->delete();
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

    //========================================end delete treasuries delivery==================================================
} //class end
