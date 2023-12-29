<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account_types;

class Account_typesController extends Controller
{
    //=======================================index======================================================================
    // index is the first page you will see when you enter the treasuries page(alkhazna)
    public function index()
    {
        //'paginate()' is the number of rows in a single page

        $data = getAllRows(new Account_types(), ['*'], 'id', 'ASC');
        return view('admin.account_types.index', ['data' => $data]);
    }
    //============================================end index==============================================================
}
