<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inv_category;
use App\Models\Admin;
use App\Http\Requests\Inv_categoriesRequest;
class Inv_categories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //'paginate()' is the number of rows in a single page
        $data = Inv_category::select()
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
        return view('admin.inv_categories.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inv_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Inv_categoriesRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //check if  entered name not exist
            //search by [com_code and the entered name] you have to use array brackets[]
            $checkExists = Inv_category::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['added_by'] = auth()->user()->id;
                $data['com_code'] = $com_code;
                $data['date'] = date('Y-m-d ');

                //write the data in the database in the treasuries table
                Inv_category::create($data);
                return redirect()
                    ->route('inv_categories.index')
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $categoty_row = Inv_category::find($id);
            if (!empty($categoty_row)) {
                // delete returns true or false
                $flag = $categoty_row->delete();
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

//========================================================edit ===========================================================
// used to edit the treasuries info
public function edit($id)
{
    $data = Inv_category::select()->find($id);
    //return with an array named 'data'
    return view('admin.inv_categories.edit', ['data' => $data]);
}
//=======================================================end update=========================================================

  //store the date in the database after the user edit it
  public function update($id, Inv_categoriesRequest $request)
  {
      try {
          $com_code = auth()->user()->com_code;
          //get the data from the table using "select()" of the the id using "find()"
          $data = Inv_category::select()->find($id);
          //if we don't find this id
          if (empty($data)) {
              return redirect()
                  ->route('inv_categories.index')
                  ->with(['error' => 'غير قادر على الوصول للبيانات']);
          }
          //check name existance
          $checkExists = Inv_category::where(['name' => $request->name, 'com_code' => $com_code])
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
          Inv_category::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
          return redirect()
              ->route('inv_categories.index')
              ->with(['success' => 'تم تعديل البيانات بنجاح']);
      } catch (\Exception $ex) {
          //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
          return redirect()
              ->back()
              ->with(['error' => 'خطأ' . $ex->getMessage()])
              ->withinput();
      }
  }
  //========================================================end update===================================================

}






