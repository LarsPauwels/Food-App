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
	Route::post('login', 'UserController@login')->name('login');
	Route::post('register', 'UserController@register');

	Route::get('test',  function() {
	    $user = Order::with('bases.toppings')->get();
		return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'message' => $user
            ], 
        200);
	});

	Route::group(['middleware' => 'auth:api'], function() {
		Route::get('logout', 'UserController@logout');
		Route::get('users', 'UserController@getUsers');
		Route::get('users/{id}', 'UserController@getUserById');
		Route::put('users/{id}', 'UserController@updateUserById');
		Route::Delete('users/{id}', 'UserController@deleteUserById');

		// Admins end-points
		Route::get('admins', 'AdminController@getAdmins');
		Route::get('admins/{id}', 'AdminController@getAdminById');
		Route::delete('admins/{id}', 'AdminController@deleteAdminById');

		// Employee end-points
		Route::get('employees', 'EmployeeController@getEmployees');
		Route::get('employees/{id}', 'EmployeeController@getEmployeeById');
		Route::delete('employees/{id}', 'EmployeeController@deleteEmployeeById');

		// Company end-points
		Route::get('companies', 'CompanyController@getCompanies');
		Route::get('companies/{id}', 'CompanyController@getCompanyById');
		Route::get('companies/{id}/employees', 'CompanyController@getEmployeesByCompany');
		Route::delete('companies/{id}', 'CompanyController@deleteCompanyById');

		// Supplier end-points
		Route::get('suppliers', 'SupplierController@getSuppliers');
		Route::get('suppliers/{id}', 'SupplierController@getSupplierById');
		Route::get('suppliers/{id}/orders', 'SupplierController@getOrdersBySupplier');
		Route::delete('suppliers/{id}', 'SupplierController@deleteSupplierById');

		// Order end-points
		Route::get('orders', 'OrderController@getOrders');
		Route::post('orders', 'OrderController@setOrder');
		Route::put('orders/{id}/delivered', 'OrderController@deliverdOrder');
		Route::get('orders/{id}', 'OrderController@getOrderById');
		Route::get('orders/{role}/{id}', 'OrderController@getOrdersByUser');
		Route::delete('orders/{id}', 'OrderController@deleteOrderById');
	});
});