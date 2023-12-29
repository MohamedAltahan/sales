<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Admin_panel_settingsController;
use App\Http\Controllers\Admin\treasuriesController;
use App\Http\Controllers\Admin\Sales_matrial_typesController;
use App\Http\Controllers\Admin\SupplierTypesController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\Inv_unitController;
use App\Http\Controllers\Admin\Inv_categories;
use App\Http\Controllers\Admin\Inv_item_per_categoryController;
use App\Http\Controllers\Admin\Account_typesController;
use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\collectController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\employeesController;
use App\Http\Controllers\Admin\exchangeController;
use App\Http\Controllers\Admin\SalesInvoiceController;
use App\Http\Controllers\Admin\supplier_ordersController;
use App\Http\Controllers\Admin\suppliersController;
use App\Http\Controllers\Admin\Users_shiftsController;

/*--------------------------------------------------------------------------
|                                   Admin Routes
|--------------------------------------------------------------------------*/
//FOR PAGINATION
define('PAGINATION_COUNT', 20);
//FOR BILL TYPE
define('PURCHASE_BILL', 1);
define('SALES_BILL', 2);
define('RETURN_BILL', 3);
//FOR ITEM TYPE
define('STORABLE', 1);
define('HAS_EXPIRE_DATE', 2);
define('', 3);

/* 'middleware'=>'auth:admin'
 auth is the middleware and admin is the guard*/

Route::group(['prefix' => '/admin', 'middleware' => 'auth:admin'], function () {
    //============================== dashboard routed ===============================================================
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/adminpanelsetting/index', [Admin_panel_settingsController::class, 'index'])->name('admin.adminpanelsetting.index');
    Route::get('/adminpanelsetting/edit', [Admin_panel_settingsController::class, 'edit'])->name('admin.adminpanelsetting.edit');
    Route::post('/adminpanelsetting/update', [Admin_panel_settingsController::class, 'update'])->name('admin.adminpanelsetting.update');

    //============================== dashboard routed end=============================================================

    //================================ treasuries routes =============================================================
    Route::get('/treasuries/index', [treasuriesController::class, 'index'])->name('admin.treasuries.index');
    Route::get('/treasuries/create', [treasuriesController::class, 'create'])->name('admin.treasuries.create');
    Route::post('/treasuries/store', [treasuriesController::class, 'store'])->name('admin.treasuries.store');
    Route::get('/treasuries/edit/{id}', [treasuriesController::class, 'edit'])->name('admin.treasuries.edit');
    Route::post('/treasuries/update/{id}', [treasuriesController::class, 'update'])->name('admin.treasuries.update');
    Route::post('/treasuries/ajax_search', [treasuriesController::class, 'ajax_search'])->name('admin.treasuries.ajax_search');
    Route::get('/treasuries/details/{id}', [treasuriesController::class, 'details'])->name('admin.treasuries.details');
    Route::get('/treasuries/add_treasuries_delivery/{id}', [treasuriesController::class, 'add_treasuries_delivery'])->name('admin.treasuries.add_treasuries_delivery');
    Route::post('/treasuries/store_treasuries_delivery/{id}', [treasuriesController::class, 'store_treasuries_delivery'])->name('admin.treasuries.store_treasuries_delivery');
    Route::get('/treasuries/delete_treasuries_delivery/{id}', [treasuriesController::class, 'delete_treasuries_delivery'])->name('admin.treasuries.delete_treasuries_delivery');
    //======================================= treasuries routes end====================================================
    //======================================= sales matrial types======================================================
    Route::get('/sales_matrial_types/index',  [sales_matrial_typesController::class, 'index'])->name('admin.sales_matrial_types.index');
    Route::get('/sales_matrial_types/create', [sales_matrial_typesController::class, 'create'])->name('admin.sales_matrial_types.create');
    Route::post('/sales_matrial_types/store', [sales_matrial_typesController::class, 'store'])->name('admin.sales_matrial_types.store');
    Route::get('/sales_matrial_types/edit/{id}', [sales_matrial_typesController::class, 'edit'])->name('admin.sales_matrial_types.edit');
    Route::post('/sales_matrial_types/update/{id}', [sales_matrial_typesController::class, 'update'])->name('admin.sales_matrial_types.update');
    Route::get('/sales_matrial_types/delete/{id}', [sales_matrial_typesController::class, 'delete'])->name('admin.sales_matrial_types.delete');
    //======================================= sales matrial types end==================================================

    //======================================= stores==================================================================
    Route::get('/stores/index',  [StoresController::class, 'index'])->name('admin.stores.index');
    Route::get('/stores/create', [StoresController::class, 'create'])->name('admin.stores.create');
    Route::post('/stores/store', [StoresController::class, 'store'])->name('admin.stores.store');
    Route::get('/stores/edit/{id}', [StoresController::class, 'edit'])->name('admin.stores.edit');
    Route::post('/stores/update/{id}', [StoresController::class, 'update'])->name('admin.stores.update');
    Route::get('/stores/delete/{id}', [StoresController::class, 'delete'])->name('admin.stores.delete');
    //======================================= stores end==============================================================

    //======================================= inv_units==================================================================
    Route::get('/units/index',  [Inv_unitController::class, 'index'])->name('admin.units.index');
    Route::get('/units/create', [Inv_unitController::class, 'create'])->name('admin.units.create');
    Route::post('/units/store', [Inv_unitController::class, 'store'])->name('admin.units.store');
    Route::get('/units/edit/{id}', [Inv_unitController::class, 'edit'])->name('admin.units.edit');
    Route::post('/units/update/{id}', [Inv_unitController::class, 'update'])->name('admin.units.update');
    Route::get('/units/delete/{id}', [Inv_unitController::class, 'delete'])->name('admin.units.delete');
    Route::post('/units/ajax_search', [Inv_unitController::class, 'ajax_search'])->name('admin.units.ajax_search');

    //======================================= end inv_units==============================================================

    //======================================= inv_categories ============================================================
    // custom route
    Route::get('/inv_categories/delete/{id}', [Inv_categories::class, 'delete'])->name('inv_categories.delete');
    // route resource
    Route::resource('/inv_categories', Inv_categories::class);
    //======================================= end categories ============================================================

    //======================================= inv_items_per_category==================================================================
    Route::get('/items/index',  [Inv_item_per_categoryController::class, 'index'])->name('admin.items.index');
    Route::get('/items/create', [Inv_item_per_categoryController::class, 'create'])->name('admin.items.create');
    Route::get('/items/create_size', [Inv_item_per_categoryController::class, 'create_size'])->name('admin.items.create_size');
    Route::post('/items/store_size', [Inv_item_per_categoryController::class, 'store_size'])->name('admin.items.store_size');
    Route::get('/items/edit_size/{id}', [Inv_item_per_categoryController::class, 'edit_size'])->name('admin.items.edit_size');
    Route::post('/items/update_size/{id}', [Inv_item_per_categoryController::class, 'update_size'])->name('admin.items.update_size');
    Route::post('/items/store', [Inv_item_per_categoryController::class, 'store'])->name('admin.items.store');
    Route::get('/items/edit/{id}', [Inv_item_per_categoryController::class, 'edit'])->name('admin.items.edit');
    Route::post('/items/update/{id}', [Inv_item_per_categoryController::class, 'update'])->name('admin.items.update');
    Route::get('/items/delete/{id}', [Inv_item_per_categoryController::class, 'delete'])->name('admin.items.delete');
    Route::get('/items/show/{id}', [Inv_item_per_categoryController::class, 'show'])->name('admin.items.show');
    Route::post('/items/ajax_search', [Inv_item_per_categoryController::class, 'ajax_search'])->name('admin.items.ajax_search');

    //======================================= end inv_items_per_category==============================================================

    //======================================= Account_types==================================================================
    Route::get('/account_types/index',  [Account_typesController::class, 'index'])->name('admin.account_types.index');
    //======================================= end Account_types==============================================================

    //======================================= accounts==================================================================
    Route::get('/accounts/index',  [AccountsController::class, 'index'])->name('admin.accounts.index');
    Route::get('/accounts/create', [AccountsController::class, 'create'])->name('admin.accounts.create');
    Route::post('/accounts/store', [AccountsController::class, 'store'])->name('admin.accounts.store');
    Route::get('/accounts/edit/{id}', [AccountsController::class, 'edit'])->name('admin.accounts.edit');
    Route::post('/accounts/update/{id}', [AccountsController::class, 'update'])->name('admin.accounts.update');
    Route::get('/accounts/delete/{id}', [AccountsController::class, 'delete'])->name('admin.accounts.delete');
    Route::get('/accounts/show/{id}', [AccountsController::class, 'show'])->name('admin.accounts.show');
    Route::post('/accounts/ajax_search', [AccountsController::class, 'ajax_search'])->name('admin.accounts.ajax_search');

    //======================================= end accounts==============================================================

    //======================================= cstomers==================================================================
    Route::get('/customers/index',  [CustomersController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/create', [CustomersController::class, 'create'])->name('admin.customers.create');
    Route::post('/customers/store', [CustomersController::class, 'store'])->name('admin.customers.store');
    Route::get('/customers/edit/{id}', [CustomersController::class, 'edit'])->name('admin.customers.edit');
    Route::get('/customers/collect/{id}', [CustomersController::class, 'collect'])->name('admin.customers.collect');
    Route::post('/customers/update/{id}', [CustomersController::class, 'update'])->name('admin.customers.update');
    Route::post('/customers/update_balance/{id}', [CustomersController::class, 'update_balance'])->name('admin.customers.update_balance');
    Route::get('/customers/delete/{id}', [CustomersController::class, 'delete'])->name('admin.customers.delete');
    Route::get('/customers/show/{id}', [CustomersController::class, 'show'])->name('admin.customers.show');
    Route::post('/customers/ajax_search', [CustomersController::class, 'ajax_search'])->name('admin.customers.ajax_search');
    Route::get('/customers/one_customer_invoices/{id}', [CustomersController::class, 'one_customer_invoices'])->name('admin.customers.one_customer_invoices');
    Route::get('/customers/all_transactions/{id}', [CustomersController::class, 'all_transactions'])->name('admin.customers.all_transactions');

    //======================================= end customers======================================================

    //======================================= supplier_types======================================================
    Route::get('/supplier_types/index',  [SupplierTypesController::class, 'index'])->name('admin.supplier_types.index');
    Route::get('/supplier_types/create', [SupplierTypesController::class, 'create'])->name('admin.supplier_types.create');
    Route::post('/supplier_types/store', [SupplierTypesController::class, 'store'])->name('admin.supplier_types.store');
    Route::get('/supplier_types/edit/{id}', [SupplierTypesController::class, 'edit'])->name('admin.supplier_types.edit');
    Route::post('/supplier_types/update/{id}', [SupplierTypesController::class, 'update'])->name('admin.supplier_types.update');
    Route::get('/supplier_types/delete/{id}', [SupplierTypesController::class, 'delete'])->name('admin.supplier_types.delete');
    //=======================================end supplier_types==================================================

    //======================================= suppliers==================================================================
    Route::get('/suppliers/index',  [SuppliersController::class, 'index'])->name('admin.suppliers.index');
    Route::get('/suppliers/create', [SuppliersController::class, 'create'])->name('admin.suppliers.create');
    Route::post('/suppliers/store', [SuppliersController::class, 'store'])->name('admin.suppliers.store');
    Route::get('/suppliers/edit/{id}', [SuppliersController::class, 'edit'])->name('admin.suppliers.edit');
    Route::post('/suppliers/update/{id}', [SuppliersController::class, 'update'])->name('admin.suppliers.update');
    Route::get('/suppliers/delete/{id}', [SuppliersController::class, 'delete'])->name('admin.suppliers.delete');
    Route::get('/suppliers/show/{id}', [SuppliersController::class, 'show'])->name('admin.suppliers.show');
    Route::post('/suppliers/ajax_search', [SuppliersController::class, 'ajax_search'])->name('admin.suppliers.ajax_search');

    //======================================= end suppliers======================================================

    //======================================= employees==================================================================
    Route::get('/employees/index',  [employeesController::class, 'index'])->name('admin.employees.index');
    Route::get('/employees/create', [employeesController::class, 'create'])->name('admin.employees.create');
    Route::post('/employees/store', [employeesController::class, 'store'])->name('admin.employees.store');
    Route::get('/employees/edit/{id}', [employeesController::class, 'edit'])->name('admin.employees.edit');
    Route::get('/employees/details/{id}', [employeesController::class, 'details'])->name('admin.employees.details');
    Route::post('/employees/update/{id}', [employeesController::class, 'update'])->name('admin.employees.update');
    Route::get('/employees/delete/{id}', [employeesController::class, 'delete'])->name('admin.employees.delete');
    Route::get('/employees/show/{id}', [employeesController::class, 'show'])->name('admin.employees.show');
    Route::post('/employees/ajax_search', [employeesController::class, 'ajax_search'])->name('admin.employees.ajax_search');

    //======================================= end employees======================================================

    //======================================= supplier_orders==================================================================
    Route::get('/supplier_orders/index',  [supplier_ordersController::class, 'index'])->name('admin.supplier_orders.index');
    Route::get('/supplier_orders/create', [supplier_ordersController::class, 'create'])->name('admin.supplier_orders.create');
    Route::post('/supplier_orders/store', [supplier_ordersController::class, 'store'])->name('admin.supplier_orders.store');
    Route::get('/supplier_orders/edit/{id}', [supplier_ordersController::class, 'edit'])->name('admin.supplier_orders.edit');
    Route::post('/supplier_orders/update/{id}', [supplier_ordersController::class, 'update'])->name('admin.supplier_orders.update');
    Route::get('/supplier_orders/delete/{id}', [supplier_ordersController::class, 'delete'])->name('admin.supplier_orders.delete');
    Route::get('/supplier_orders/details/{id}', [supplier_ordersController::class, 'details'])->name('admin.supplier_orders.details');
    Route::post('/supplier_orders/ajax_search', [supplier_ordersController::class, 'ajax_search'])->name('admin.supplier_orders.ajax_search');
    Route::post('/supplier_orders/ajax_get_item_units', [supplier_ordersController::class, 'ajax_get_item_units'])->name('admin.supplier_orders.ajax_get_item_units');
    Route::post('/supplier_orders/ajax_add_details', [supplier_ordersController::class, 'ajax_add_details'])->name('admin.supplier_orders.ajax_add_details');
    Route::post('/supplier_orders/ajax_reload_items_details', [supplier_ordersController::class, 'ajax_reload_items_details'])->name('admin.supplier_orders.ajax_reload_items_details');
    Route::post('/supplier_orders/ajax_reload_parent_bill', [supplier_ordersController::class, 'ajax_reload_parent_bill'])->name('admin.supplier_orders.ajax_reload_parent_bill');
    Route::post('/supplier_orders/ajax_reload_edit_item', [supplier_ordersController::class, 'ajax_reload_edit_item'])->name('admin.supplier_orders.ajax_reload_edit_item');
    Route::post('/supplier_orders/ajax_add_new_item', [supplier_ordersController::class, 'ajax_add_new_item'])->name('admin.supplier_orders.ajax_add_new_item');
    Route::post('/supplier_orders/edit_item_details', [supplier_ordersController::class, 'edit_item_details'])->name('admin.supplier_orders.edit_item_details');
    Route::get('/supplier_orders/delete_item_details/{id}/{id_parent}', [supplier_ordersController::class, 'delete_item_details'])->name('admin.supplier_orders.delete_item_details');
    Route::get('/supplier_orders/delete_supplier_order/{id}', [supplier_ordersController::class, 'delete_supplier_order'])->name('admin.supplier_orders.delete_supplier_order');
    Route::get('/supplier_orders/do_approve/{id}', [supplier_ordersController::class, 'do_approve'])->name('admin.supplier_orders.do_approve');
    Route::post('/supplier_orders/ajax_approve_invoice', [supplier_ordersController::class, 'ajax_approve_invoice'])->name('admin.supplier_orders.ajax_approve_invoice');


    //======================================= end supplier_orders==============================================


    //======================================= salesInvoice==================================================================
    Route::get('/salesInvoice/index',  [SalesInvoiceController::class, 'index'])->name('admin.salesInvoice.index');
    Route::get('/salesInvoice/create', [SalesInvoiceController::class, 'create'])->name('admin.salesInvoice.create');
    Route::post('/salesInvoice/store', [SalesInvoiceController::class, 'store'])->name('admin.salesInvoice.store');
    Route::get('/salesInvoice/edit/{id}', [SalesInvoiceController::class, 'edit'])->name('admin.salesInvoice.edit');
    Route::post('/salesInvoice/update/{id}', [SalesInvoiceController::class, 'update'])->name('admin.salesInvoice.update');
    Route::get('/salesInvoice/delete/{id}', [SalesInvoiceController::class, 'delete'])->name('admin.salesInvoice.delete');
    Route::get('/salesInvoice/details/{id}/{ids}', [SalesInvoiceController::class, 'details'])->name('admin.salesInvoice.details');
    Route::post('/salesInvoice/ajax_search', [SalesInvoiceController::class, 'ajax_search'])->name('admin.salesInvoice.ajax_search');
    Route::post('/salesInvoice/ajax_add_details', [SalesInvoiceController::class, 'ajax_add_details'])->name('admin.salesInvoice.ajax_add_details');
    Route::post('/salesInvoice/ajax_delete_item', [SalesInvoiceController::class, 'ajax_delete_item'])->name('admin.salesInvoice.ajax_delete_item');

    Route::post('/salesInvoice/ajax_totalInvoice', [SalesInvoiceController::class, 'ajax_totalInvoice'])->name('admin.salesInvoice.ajax_totalInvoice');
    Route::post('/salesInvoice/ajax_print/{id}/{ids}', [SalesInvoiceController::class, 'ajax_print'])->name('admin.salesInvoice.ajax_print');

    Route::post('/salesInvoice/get_form_values', [SalesInvoiceController::class, 'get_form_values'])->name('admin.salesInvoice.get_form_values');


    Route::post('/salesInvoice/ajax_add_new_item', [SalesInvoiceController::class, 'ajax_add_new_item'])->name('admin.salesInvoice.ajax_add_new_item');

    Route::post('/salesInvoice/edit_item_details', [SalesInvoiceController::class, 'edit_item_details'])->name('admin.salesInvoice.edit_item_details');
    Route::get('/salesInvoice/do_approve/{id}', [SalesInvoiceController::class, 'do_approve'])->name('admin.salesInvoice.do_approve');
    //======================================= end salesInvoice==============================================

    //================================ admins_accounts routes =============================================================
    Route::get('/admins_accounts/index', [AdminsController::class, 'index'])->name('admin.admins_accounts.index');
    Route::get('/admins_accounts/create', [AdminsController::class, 'create'])->name('admin.admins_accounts.create');
    Route::post('/admins_accounts/store', [AdminsController::class, 'store'])->name('admin.admins_accounts.store');
    Route::get('/admins_accounts/edit/{id}', [AdminsController::class, 'edit'])->name('admin.admins_accounts.edit');
    Route::post('/admins_accounts/update/{id}', [AdminsController::class, 'update'])->name('admin.admins_accounts.update');
    Route::post('/admins_accounts/ajax_search', [AdminsController::class, 'ajax_search'])->name('admin.admins_accounts.ajax_search');
    Route::get('/admins_accounts/details/{id}', [AdminsController::class, 'details'])->name('admin.admins_accounts.details');
    Route::get('/admins_accounts/add_treasuries_delivery/{id}', [AdminsController::class, 'add_treasuries_delivery'])->name('admin.admins_accounts.add_treasuries_delivery');
    Route::post('/admins_accounts/add_treasuries_to_admin/{id}', [AdminsController::class, 'add_treasuries_to_admin'])->name('admin.admins_accounts.add_treasuries_to_admin');
    Route::get('/admins_accounts/delete_treasuries_delivery/{id}', [AdminsController::class, 'delete_treasuries_delivery'])->name('admin.admins_accounts.delete_treasuries_delivery');
    //======================================= admins_accounts routes end=============================================

    //================================ users_shifts routes =============================================================
    Route::get('/users_shifts/index', [Users_shiftsController::class, 'index'])->name('admin.users_shifts.index');
    Route::get('/users_shifts/create', [Users_shiftsController::class, 'create'])->name('admin.users_shifts.create');
    Route::post('/users_shifts/store', [Users_shiftsController::class, 'store'])->name('admin.users_shifts.store');
    //======================================= admins_accounts routes end=============================================

    //================================ collect routes =============================================================
    Route::get('/collect_transactions/index', [collectController::class, 'index'])->name('admin.collect_transactions.index');
    Route::get('/collect_transactions/create', [collectController::class, 'create'])->name('admin.collect_transactions.create');
    Route::post('/collect_transactions/store', [collectController::class, 'store'])->name('admin.collect_transactions.store');
    //======================================= collect routes end=============================================

    //================================ exchange routes =============================================================
    Route::get('/exchange_transactions/index', [exchangeController::class, 'index'])->name('admin.exchange_transactions.index');
    Route::get('/exchange_transactions/create', [exchangeController::class, 'create'])->name('admin.exchange_transactions.create');
    Route::post('/exchange_transactions/store', [exchangeController::class, 'store'])->name('admin.exchange_transactions.store');
    //======================================= exchange routes end=============================================
}); //end group

//===================================================== users_shifts routes ==================================================

//group > means obay to some conditions which are between []
Route::group(['namespace' => 'Admin', 'prefix' => '/admin', 'middleware' => 'guest:admin'], function () {
    //you can make a name for your route to use it easily anywhere
    //->name('admin.showlogin') note('.' === '/') in laravel
    Route::get('/login', [LoginController::class, 'show_login_view'])->name('admin.showlogin');

    // when you get request to go to login page then go to the controller which name is LoginController
    // and then excute login function
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
});//end group
