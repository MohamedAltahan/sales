<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoresRequest;
use App\Models\Inv_items_per_category;

class StoresController extends Controller
{
    //=======================================index====================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        $com_code = auth()->user()->com_code;
        //'paginate()' is the number of rows in a single page
        $storesData = getColumns_p(
            new Inv_items_per_category(),
            ['item_type', 'name', 'created_at', 'updated_at', 'stock_quantity', 'id', 'primary_retail_price'],
            ['com_code' => $com_code],
            'id',
            'DESC',
            PAGINATION_COUNT
        );

        return view('admin.stores.index', ['storesData' => $storesData]);
    }
    //============================================end index===========================================================

    //============================================create=====================================================================
    //used to creat new treasuries go to this page
    public function create()
    {
        return view('admin.stores.create');
    }
    //===========================================end create==================================================================

    //===========================================store======================================================================
    // store the entered data in the 'creat form' in the database
    public function store(StoresRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //check if  entered name not exist
            //search by [com_code and the entered name] you have to use array brackets[]
            $checkExists = Store::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {


                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['phone'] = $request->phone;
                $data['address'] = $request->address;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['added_by'] = auth()->user()->id;
                $data['com_code'] = $com_code;
                $data['date'] = date('Y-m-d ');

                //write the data in the database in the treasuries table
                Store::create($data);
                return redirect()
                    ->route('admin.stores.index')
                    ->with(['success' => 'تم اضافه البيانات بنجاح']);
            }
            //end main if
            //do this if the name is exist before
            else {
                return redirect()
                    ->back()
                    ->with(['error' => 'عفوا اسم المخزن موجود'])
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
    //=======================================end store==================================

    //=========================================edit ====================================
    // used to edit the treasuries info
    public function edit($id)
    {
        $data = Store::select()->find($id);
        //return with an array named 'data'
        return view('admin.stores.edit', ['data' => $data]);
    }
    //========================================end edit==================================

    //========================================end update==================================
    //store the date in the database after the user edit it
    public function update($id, StoresRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = Store::select()->find($id);
            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.stores.index')
                    ->with(['error' => 'غير قادر على الوصول للبيانات']);
            }
            //check name existance
            $checkExists = Store::where(['name' => $request->name, 'com_code' => $com_code])
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
            $data_to_update['active'] = $request->active;
            $data_to_update['phone'] = $request->phone;
            $data_to_update['address'] = $request->address;
            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['updated_at'] = date('Y-m-d H:i:s');
            Store::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            return redirect()
                ->route('admin.stores.index')
                ->with(['success' => 'تم اضافه البيانات بنجاح']);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //========================================================end update===================

    //========================================delete=======================================
    public function delete($id)
    {
        try {
            $item_row = Store::find($id);
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

    //==================================end delete ========================================
} //class end
