<?php

namespace App\Http\Controllers\Admin;

use App\Models\Treasuries;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use App\Http\Requests\TreasuriesRequest;
use App\Http\Requests\Add_treasuries_deliveryRequest;
use App\Models\Treasuries_delivery;

class treasuriesController extends Controller
{
    //=======================================index======================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        //'paginate()' is the number of rows in a single page
        $data = Treasuries::select()
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
        return view('admin.treasuries.index', ['data' => $data]);
    }
    //============================================end index=================================================================

    //============================================creat=====================================================================
    //used to creat new treasuries go to this page
    public function create()
    {
        return view('admin.treasuries.create');
    }
    //===========================================end creat==================================================================

    //===========================================store======================================================================
    // store the entered data in the 'creat form' in the database
    public function store(TreasuriesRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //check if  entered name not exist
            //search by [com_code and the entered name] you have to use array brackets[]
            $checkExists = Treasuries::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                if ($request->is_master == 1) {
                    $checkExists_isMaster = Treasuries::where(['is_master' => 1, 'com_code' => $com_code])->first();
                    if ($checkExists_isMaster != null) {
                        return redirect()
                            ->back()
                            ->with(['error' => ' عفوا يوجد خزنة رئيسية اخرى '])
                            ->withinput();
                    } //end inner if
                }
                $data['name'] = $request->name;
                $data['is_master'] = $request->is_master;
                $data['last_bill_exchange'] = $request->last_bill_exchange;
                $data['last_bill_collect'] = $request->last_bill_collect;
                $data['active'] = $request->active;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['added_by'] = auth()->user()->id;
                $data['com_code'] = $com_code;
                $data['date'] = date('Y-m-d ');

                //write the data in the database in the treasuries table
                Treasuries::create($data);
                return redirect()
                    ->route('admin.treasuries.index')
                    ->with(['success' => 'تم اضافه البيانات بنجاح']);
            }
            //end main if
            //do this if the name is exist before
            else {
                return redirect()
                    ->back()
                    ->with(['error' => 'عفوا اسم الخزنة موجود'])
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
        $data = Treasuries::select()->find($id);
        //return with an array named 'data'
        return view('admin.treasuries.edit', ['data' => $data]);
    }
    //=======================================================end edit=========================================================

    //=======================================================update===========================================================
    //store the date in the database after the user edit it
    public function update($id, TreasuriesRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get the data from the table using "select()" of the the id using "find()"
            $data = Treasuries::select()->find($id);
            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.treasuries.index')
                    ->with(['error' => ' غير قادر على الوصول للبيانات']);
            }
            //check name existance
            $checkExists = Treasuries::where(['name' => $request->name, 'com_code' => $com_code])
                ->where('id', '!=', $id)
                ->first();
            if ($checkExists != null) {
                return redirect()
                    ->back()
                    ->with(['error' => 'اسم الخزنه مسجل من قبل'])
                    ->withInput();
            }
            if ($request->is_master == 1) {
                $checkExists_isMaster = Treasuries::where(['is_master' => 1, 'com_code' => $com_code])
                    ->where('id', '!=', $id)
                    ->first();
                if ($checkExists_isMaster != null) {
                    return redirect()
                        ->back()
                        ->with(['error' => ' عفوا يوجد خزنة رئيسية اخرى '])
                        ->withinput();
                } //end inner if
            }
            $data_to_update['name'] = $request->name;
            $data_to_update['active'] = $request->active;
            $data_to_update['is_master'] = $request->is_master;
            $data_to_update['last_bill_exchange'] = $request->last_bill_exchange;
            $data_to_update['last_bill_collect'] = $request->last_bill_collect;
            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['updated_at'] = date('Y-m-d H:i:s');
            Treasuries::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            return redirect()
                ->route('admin.treasuries.index')
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

    //=========================================================AJAX search=================================================
    //used to make live search with the help of jquary
    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $search_by_text = $request->search_by_text;
            //start to search
            $data = Treasuries::where('name', 'like', "%{$search_by_text}%")
                ->orderBy('id', 'DESC')
                ->paginate(PAGINATION_COUNT);
            return view('admin.treasuries.ajax_search')->with('data', $data);
        }
    }
    //==================================================end AJAX search===================================================

    //======================================================details=======================================================
    public function details($id)
    {
        try {
            // $com_code = auth()->user()->com_code;
            //get the info of the current Treasuries from the database using "select()" of the the id using "find($id)"
            $data = Treasuries::select()->find($id);

            //if we don't find this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.treasuries.index')
                    ->with(['error' => ' غير قادر على الوصول للبيانات']);
            }
            //get the admin's name who added the current treauries($id)
            $data['added_by_admin'] = Admin::where('id', $data->added_by)->value('name');
            //get the admin's name who updated the current treasries
            //first chech if there is someone updated the record
            if (($data->updated_by > 0 ) && ($data->updated_by != null)) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }
             //get secondry treasuries 'treasuries_id', which follow the current parent '$id'.
            $treasuries_delivery = Treasuries_delivery::where(['treasuries_id' => $id])
                ->orderby('id', 'DESC')
                ->get();
            if (!empty($treasuries_delivery)) {
                foreach ($treasuries_delivery as $info) {
                    // to get the treasuries name through its id and add a new attribute to the object called 'name'
                    $info->name = Treasuries::where('id', $info->treasuries_tobe_delivered_id)->value('name');
                    // to get the treasuries name through its id and add a new attribute to the object called 'add_by_admin'
                    $info->add_by_admin = Admin::where('id', $info->added_by)->value('name');
                }
            }
            return view('admin.treasuries.details', ['data' => $data, 'treasuries_delivery' => $treasuries_delivery]);
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

    //===========================================add_treasuries_delivery=================================================
    public function add_treasuries_delivery($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            //get data about the current treasury using its id '$id'
            $data = Treasuries::select('name', 'id')->find($id);
            //check if there is no date belong to this id
            if (empty($data)) {
                return redirect()
                    ->route('admin.treasuries.index')
                    ->with(['error' => 'البيانات غير موجوده']);
            }
            //get data of all active treasuries in the databse
            $treasuries = Treasuries::select('id', 'name')
                ->where(['com_code' => $com_code, 'active' => '1'])
                ->get();

            return view('admin.treasuries.add_treasuries_delivery', ['data' => $data, 'treasuries' => $treasuries]);
        } catch (\Exception $ex) {
            return redirect()
                ->back()
                ->with(['error' => 'خطأ' . $ex->getMessage()])
                ->withinput();
        }
    }
    //========================================end add_treasuries_delivery===============================================
    //========================================store treasuries delivery=======================================================
    public function store_treasuries_delivery($id, Add_treasuries_deliveryRequest $request)
    {
        //dd( $request->treasuries_tobe_delivered_id );
        try {

            $com_code = auth()->user()->com_code;
           // $Treasuries = new Treasuries();
            $data = Treasuries::select('id', 'name')->find($id);
            if (empty($data)) {
                return redirect()
                    ->route('admin.treasuries.index')
                    ->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }
            //you can add the same secondary treasury to many primary treasury
            //so check if the secodary treasury was add the 'current main treasury($id)'
            $checkExists = Treasuries_delivery::where(['treasuries_id' => $id, 'treasuries_tobe_delivered_id' => $request->treasuries_tobe_delivered_id, 'com_code' => $com_code])->first();

            if ($checkExists != null) {
                return redirect()
                    ->back()
                    ->with(['error' => 'عفوا هذه الخزنة مسجلة من قبل !'])
                    ->withInput();
            }

            $data_insert_details['treasuries_id'] = $id;
            $data_insert_details['treasuries_tobe_delivered_id'] = $request->treasuries_tobe_delivered_id;
            $data_insert_details['added_by'] = auth()->user()->id;
            $data_insert_details['com_code'] = $com_code;

            Treasuries_delivery::create($data_insert_details);
            return redirect()
                ->route('admin.treasuries.details', $id)
                ->with(['success' => 'لقد تم اضافة البيانات بنجاح']);

        } catch (\Exception $ex) {
            return redirect()
                ->back()
                ->with(['error' => 'ااااعفوا حدث خطأ ما' . $ex->getMessage()]);
        }
    }
    //========================================end store treasuries delivery==================================================
    //========================================delete treasuries delivery==================================================

    public function delete_treasuries_delivery($id)
    {
        try {
            $treasuries_delivery = Treasuries_delivery::find($id);
            if (!empty($treasuries_delivery)) {
                // delete returns true or false
                $flag = $treasuries_delivery->delete();
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
