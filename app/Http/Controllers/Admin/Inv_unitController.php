<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inv_unit;
use App\Models\Admin;
use App\Http\Requests\InvUnitsRequest;

class Inv_unitController extends Controller
{
    //=======================================index====================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        //'paginate()' is the number of rows in a single page
        $data = Inv_unit::select()
            ->orderby('id', 'DESC')
            ->paginate(PAGINATION_COUNT);
        // get addBy and updatedBy
        if (!empty($data)) {
            //'data' is an array of objects
            foreach ($data as $info) {
                $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                }
            }
        }
        return view('admin.inv_units.index', ['data' => $data]);
    }
    //============================================end index===========================================================
    //============================================create=====================================================================
    //used to creat new treasuries go to this page
    public function create()
    {
        return view('admin.inv_units.create');
    }
    //===========================================end create==================================================================
    //========================================================edit ===========================================================
    // used to edit the treasuries info
    //===========================================store======================================================================
    // store the entered data in the 'creat form' in the database
    public function store(InvUnitsRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //check if  entered name not exist
            //search by [com_code and the entered name] you have to use array brackets[]
            $checkExists = Inv_unit::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['is_master'] = $request->is_master;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['added_by'] = auth()->user()->id;
                $data['com_code'] = $com_code;
                $data['date'] = date('Y-m-d ');

                //write the data in the database in the treasuries table
                Inv_unit::create($data);
                return redirect()
                    ->route('admin.units.index')
                    ->with(['success' => 'تم اضافه البيانات بنجاح']);
            }
            //end main if
            //do this if the name is exist before
            else {
                return redirect()
                    ->back()
                    ->with(['error' => 'عفوا اسم الوحدة موجود'])
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
        $data = Inv_unit::select()->find($id);
        //return with an array named 'data'
        return view('admin.inv_units.edit', ['data' => $data]);
    }
    //=======================================================end edit=========================================================

    //======================================================= update =========================================================

    //store the date in the database after the user edit it
    public function update($id, InvUnitsRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = Inv_unit::select()->find($id);
            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.units.index')
                    ->with(['error' => 'غير قادر على الوصول للبيانات']);
            }
            //check name existance
            $checkExists = Inv_unit::where(['name' => $request->name, 'com_code' => $com_code])
                // if there is anothr item with the same name and the same id it means it's repeated
                ->where('id', '!=', $id)
                ->first();
            if ($checkExists != null) {
                return redirect()
                    ->back()
                    ->with(['error' => 'اسم المخزن مسجل من قبل'])
                    ->withInput();
            }

            $data_to_update['name'] = $request->name;
            $data_to_update['is_master'] = $request->is_master;
            $data_to_update['active'] = $request->active;
            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['updated_at'] = date('Y-m-d H:i:s');
            Inv_unit::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            return redirect()
                ->route('admin.units.index')
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
            $item_row = Inv_unit::find($id);
            if (!empty($item_row)) {
                // delete returns true or false
                $flag = $item_row->delete();
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
    //=========================================================AJAX search=================================================
    //used to make live search with the help of jquary
    public function ajax_search(Request $request)
    {
        dd($request->search_by_text);
        if ($request->ajax()) {
            // receive the variables which come from the post
            $search_by_text = $request->search_by_text;
            $is_master_search = $request->is_master_search;

            //start to search
            $data = Inv_units::where('name', 'like', "%{$search_by_text}%")
                ->where('is_master', '=', $is_master_search)
                ->orderBy('id', 'DESC')
                ->paginate(PAGINATION_COUNT);
            // get addBy and updatedBy
            if (!empty($data)) {
                //'data' is an array of objects
                foreach ($data as $info) {
                    $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
                    if ($info->updated_by > 0 and $info->updated_by != null) {
                        $info['updated_by_admin'] = Admin::where('id', $info['updated_by'])->value('name');
                    }
                }
            }

            return view('admin.inv_units.ajax_search')->with('data', $data);
        }
    }
    //==================================================end AJAX search===================================================
}
