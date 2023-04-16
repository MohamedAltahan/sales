<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin_panel_setting_Request;
use App\Models\Admin_panel_setting;
use App\Models\Admin;
use App\Http\Controllers\Controller;



class Admin_panel_settingsController extends Controller
{

    public function index()
    { 
        //get the com_code of the user that is logged in now using this quiry "(auth()->user()->com_code)"
        //after getting the com_code (EX=1) then go to "Admin_panel_setting" table and search by this com_code that you get
        //and return the first record found "first()"
        $data = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
        if (!empty($data)) {
            if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
                //get the data stored in 'updated_by' using " $data['updated_by'] " in "Admin" table
                //search in the "Admin" table using the "id" which stord in 'updated_by'
                //note that 'updated_by' contains an "id"
                //after getting the person info using the 'id' then return its name only.
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }
        }
        return view('admin.admin_panel_settings.index', ['data' => $data]);
    }

    public function edit()
    {
        $data = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
        return view('admin.admin_panel_settings.edit', ['data' => $data]);
    }


    public function update(Admin_panel_setting_Request $request)
    {
        try {

            $admin_panel_setting = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
            $admin_panel_setting->system_name = $request->system_name;
            $admin_panel_setting->address = $request->address;
            $admin_panel_setting->phone = $request->phone;
            $admin_panel_setting->general_alert = $request->general_alert;
            $admin_panel_setting->updated_by = auth()->user()->id;
            $admin_panel_setting->updated_at = date("Y-m-d H:i:s");
            //we need the old name  of the photo in order to delete this photo after upload the new photo
            $oldPhotoPath = $admin_panel_setting->photo;
            if ($request->has('photo')) {
                $request->validate(['photo' => 'required|mimes:png,jpg|max:2000']);
                //customized helper function
                //upload photo function and return the new name of the photo
                //it take the path where we need to store the uploaded photo, and the photo name
                $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
                $admin_panel_setting->photo = $the_file_path;
                //check if the old file is exist and not 'null'  before delete it
                if (file_exists('assets/admin/uploads/' . $oldPhotoPath) && $oldPhotoPath != null) {
                    unlink('assets/admin/uploads/' . $oldPhotoPath);
                }
            }
            $admin_panel_setting->save();
            // with is method returns key(any name) and its value to the route

            return redirect()->route('admin.adminpanelsetting.index')->with(['success' => 'تم بنجاح']);
        } catch (\Exception $ex) {
            //$ex is variable which contians the erorr, and 'getMessage()' is a method to return the message error only without more details
            return redirect()->route('admin.adminpanelsetting.index')->with(['error' => 'خطأ' . $ex->getMessage()]);
        }
    }
}
