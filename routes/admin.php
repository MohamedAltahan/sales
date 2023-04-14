<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Admin_panel_settingsController;
use App\Http\Controllers\Admin\treasuriesController;
use App\Http\Controllers\Admin\Sales_matrial_typesController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\Inv_unitController;

/*--------------------------------------------------------------------------
|                                   Admin Routes
|--------------------------------------------------------------------------*/

define('PAGINATION_COUNT', 10);

/* 'middleware'=>'auth:admin'
 auth is the middleware and admin is the guard*/

Route::group(['namespace' => 'Admin', 'prefix' => '/admin', 'middleware' => 'auth:admin'], function () {
    //============================== dashboard routed ===============================================================
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('adminpanelsetting/index', [Admin_panel_settingsController::class, 'index'])->name('admin.adminpanelsetting.index');
    Route::get('adminpanelsetting/edit', [Admin_panel_settingsController::class, 'edit'])->name('admin.adminpanelsetting.edit');
    Route::post('adminpanelsetting/update', [Admin_panel_settingsController::class, 'update'])->name('admin.adminpanelsetting.update');

    //============================== dashboard routed end=============================================================

    //================================ treasuries routes =============================================================
    Route::get('treasuries/index', [treasuriesController::class, 'index'])->name('admin.treasuries.index');
    Route::get('treasuries/create', [treasuriesController::class, 'create'])->name('admin.treasuries.create');
    Route::post('treasuries/store', [treasuriesController::class, 'store'])->name('admin.treasuries.store');
    Route::get('treasuries/edit/{id}', [treasuriesController::class, 'edit'])->name('admin.treasuries.edit');
    Route::post('treasuries/update/{id}', [treasuriesController::class, 'update'])->name('admin.treasuries.update');
    Route::post('treasuries/ajax_search', [treasuriesController::class, 'ajax_search'])->name('admin.treasuries.ajax_search');
    Route::get('treasuries/details/{id}', [treasuriesController::class, 'details'])->name('admin.treasuries.details');
    Route::get('treasuries/add_treasuries_delivery/{id}', [treasuriesController::class, 'add_treasuries_delivery'])->name('admin.treasuries.add_treasuries_delivery');
    Route::post('treasuries/store_treasuries_delivery/{id}', [treasuriesController::class, 'store_treasuries_delivery'])->name('admin.treasuries.store_treasuries_delivery');
    Route::get('treasuries/delete_treasuries_delivery/{id}', [treasuriesController::class, 'delete_treasuries_delivery'])->name('admin.treasuries.delete_treasuries_delivery');


    //======================================= treasuries routes end====================================================
    //======================================= sales matrial types======================================================
    Route::get('sales_matrial_types/index',  [sales_matrial_typesController::class, 'index']) ->name('admin.sales_matrial_types.index');
    Route::get('sales_matrial_types/create', [sales_matrial_typesController::class, 'create'])->name('admin.sales_matrial_types.create');
    Route::post('sales_matrial_types/store', [sales_matrial_typesController::class, 'store']) ->name('admin.sales_matrial_types.store');
    Route::get('sales_matrial_types/edit/{id}', [sales_matrial_typesController::class, 'edit'])->name('admin.sales_matrial_types.edit');
    Route::post('sales_matrial_types/update/{id}', [sales_matrial_typesController::class, 'update'])->name('admin.sales_matrial_types.update');
    Route::get('sales_matrial_types/delete/{id}', [sales_matrial_typesController::class, 'delete'])->name('admin.sales_matrial_types.delete');
    //======================================= sales matrial types end==================================================
    //======================================= stores==================================================================
    Route::get('stores/index',  [StoresController::class, 'index']) ->name('admin.stores.index');
    Route::get('stores/create', [StoresController::class, 'create'])->name('admin.stores.create');
    Route::post('stores/store', [StoresController::class, 'store']) ->name('admin.stores.store');
    Route::get('stores/edit/{id}', [StoresController::class, 'edit'])->name('admin.stores.edit');
    Route::post('stores/update/{id}', [StoresController::class, 'update'])->name('admin.stores.update');
    Route::get('stores/delete/{id}', [StoresController::class, 'delete'])->name('admin.stores.delete');
    //======================================= stores end==============================================================

    //======================================= inv_units==================================================================
    Route::get('units/index',  [Inv_unitController::class, 'index']) ->name('admin.units.index');
    Route::get('units/create', [Inv_unitController::class, 'create'])->name('admin.units.create');
    Route::post('units/store', [Inv_unitController::class, 'store']) ->name('admin.units.store');
    Route::get('units/edit/{id}', [Inv_unitController::class, 'edit'])->name('admin.units.edit');
    Route::post('units/update/{id}', [Inv_unitController::class, 'update'])->name('admin.units.update');
    Route::get('units/delete/{id}', [Inv_unitController::class, 'delete'])->name('admin.units.delete');
    Route::post('units/ajax_search', [Inv_unitController::class, 'ajax_search'])->name('admin.units.ajax_search');

    //======================================= end inv_units==============================================================

}); //end group


//===================================================== login routes ==================================================

//group > means obay to some conditions which are between []
Route::group(['namespace' => 'Admin', 'prefix' => '/admin', 'middleware' => 'guest:admin'], function () {
    //you can make a name for your route to use it easily anywhere
    //->name('admin.showlogin') note('.' === '/') in laravel
    Route::get('login', [LoginController::class, 'show_login_view'])->name('admin.showlogin');

    // when you get request to go to login page then go to the controller which name is LoginController
    // and then excute login function
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
});//end group
