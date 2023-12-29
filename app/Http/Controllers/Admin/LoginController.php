<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;


class LoginController extends Controller
{
   public function show_login_view()
   {
      return view('admin.auth.login');
   }

   //    LoginRequest is the validation that we created to validate the info inderted in the form
   //    you have to include loginrequest file so that 'validation' excuted automatically
   //    '->'  ==  '.'
   public function login(LoginRequest $request)
   {

      if (auth()->guard('admin')->attempt([
         'username' => $request->input('username'),
         'password' => $request->input('password')
      ])) {
         return redirect()->route('admin.dashboard');
      } else {
         return redirect()->route('admin.showlogin');
      }
   }

   public function logout()
   {
      auth()->logout();
      return redirect()->route('admin.showlogin');
   }
   /*
function make_new_admin(){
$admin = new App\Models\Admin();
$admin->name='a';
$admin->email='mohamed@gmail.com';
$admin->username='a';
$admin->password=bcrypt('a');
$admin->com_code=1;
$admin->save();
}
*/
}
