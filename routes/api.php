<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Order;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
	Route::post('login', 'AuthController@login')->name('login');
	Route::post('register', 'AuthController@register');

	Route::group(['middleware' => 'auth:api'], function() {
		Route::get('logout', 'AuthController@logout');

		// User end-points
		Route::get('user/list', 'UserController@getUsers');
		Route::get('user/{id}', 'UserController@getUserById');
		Route::post('user', 'UserController@createUser');
		Route::post('user/company', 'UserController@createUserCompany');
		Route::post('user/supplier', 'UserController@createUserSupplier');
		Route::put('user/{id}', 'UserController@updateUserById');
		Route::delete('user/{id}', 'UserController@deleteUserById');
		Route::patch('user/{id}', 'UserController@restoreUserById');

		// Admins end-points
		Route::get('admin/list', 'AdminController@getAdmins');
		Route::get('admin/{id}', 'AdminController@getAdminById');
		Route::post('admin', 'AdminController@createAdmin');
		Route::put('admin/{id}', 'AdminController@updateAdminById');
		Route::delete('admin/{id}', 'AdminController@deleteAdminById');

		// Employee end-points
		Route::get('employee/list', 'EmployeeController@getEmployees');
		Route::get('company/{companyId}/employee/list', 'EmployeeController@getEmployeesByCompany');
		Route::get('employee/{id}', 'EmployeeController@getEmployeeById');
		Route::post('company/{companyId}/employee/', 'EmployeeController@createEmployee');
		Route::put('employee/{id}', 'EmployeeController@updateEmployeeById');
		Route::delete('employee/{id}', 'EmployeeController@deleteEmployeeById');

		// Company end-points
		Route::get('company/list', 'CompanyController@getCompanies');
		Route::get('company/{id}', 'CompanyController@getCompanyById');
		Route::post('company', 'CompanyController@createCompany');
		Route::put('company/{id}', 'CompanyController@updateCompanyById');
		Route::delete('company/{id}', 'CompanyController@deleteCompanyById');

		// Supplier end-points
		Route::get('supplier/list', 'SupplierController@getSuppliers');
		Route::get('supplier/{id}', 'SupplierController@getSupplierById');
		Route::get('supplier/{id}/revenue', 'SupplierController@getSupplierRevenue');
		Route::post('supplier', 'SupplierController@createSupplier');
		Route::put('supplier/{id}', 'SupplierController@updateSupplierById');
		Route::delete('supplier/{id}', 'SupplierController@deleteSupplierById');

		// Suplier and Company Connection end-points
		Route::get('supplier/company/{companyId}', 'ConnectionController@getSuppliers');
		Route::get('company/supplier/{supplierId}', 'ConnectionController@getCompanies');
		Route::post('supplier/{id}/add', 'ConnectionController@createConnection');
		Route::put('supplier/{id}/company/{companyId}/accept', 'ConnectionController@updateConnection');
		Route::delete('supplier/{id}/company/{companyId}/remove', 'ConnectionController@deleteConnection');

		// Base end-points
		Route::get('supplier/{supplierId}/base/list', 'BaseController@getAllBasesBySupplier');
		Route::post('supplier/{supplierId}/base', 'BaseController@createBase');
		Route::put('base/{id}', 'BaseController@updateBaseById');
		Route::delete('base/{id}', 'BaseController@deleteBaseById');

		// Topping end-points
		Route::get('base/{baseId}/topping/list', 'ToppingController@getAllToppingsByBase');
		Route::post('base/{baseId}/topping', 'ToppingController@createTopping');
		Route::delete('base/{baseId}/topping', 'ToppingController@deleteToppingByBase');

		// Order end-points
		Route::get('order/list', 'OrderController@getOrders');
		Route::get('supplier/{supplierId}/order/list', 'OrderController@getOrdersBySupplier');
		Route::get('employee/{employeeId}/order/list', 'OrderController@getOrdersByEmployee');
		Route::get('company/{companyId}/order/list', 'OrderController@getOrdersByCompany');
		Route::get('order/{id}', 'OrderController@getOrderById');
		Route::get('supplier/{id}/order/list', 'OrderController@getSupplierOrder');
		Route::post('order', 'OrderController@createOrder');
		Route::put('order/{id}/delivered', 'OrderController@deliverdOrder');
		Route::delete('order/{id}', 'OrderController@deleteOrderById');

		// Detail end-points
		Route::post('detail', 'DetailController@createDetail');
		Route::put('detail/{id}', 'DetailController@updateDetailById');

		// Address end-points
		Route::post('address', 'AddressController@createAddress');
		Route::put('address/{id}', 'AddressController@updateAddressById');

		// Timesheet end-points
		Route::post('timesheet', 'TimesheetController@createTimesheet');
		Route::put('timesheet/{id}', 'TimesheetController@updateTimesheetById');
		Route::put('timesheets', 'TimesheetController@updateTimesheets');
		Route::delete('timesheet/{id}', 'TimesheetController@deleteTimesheetById');
		Route::delete('timesheets', 'TimesheetController@deleteTimesheets');
	});
});