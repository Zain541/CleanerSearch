<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

	Route::get('/', function () {
    	return view('welcome');
	});


	Route::group(['middleware' => ['guest']], function () {
		Route::get('/customer/register','Customer\CustomerRegisterController@showCustomerRegisterForm')->name('customer.register');

		Route::post('/customer/register', 'Customer\CustomerRegisterController@createCustomer')->name('customer.store');


		Route::get('/customer/login','Customer\CustomerLoginController@showCustomerLoginForm')->name('customer.login');

		Route::post('/customer/login','Customer\CustomerLoginController@customerLogin')->name('customer.post.login');
		
	});


Route::group(['middleware' => ['customer']], function () {
		Route::get('/customer/','Customer\CustomerHomeController@index')->name('customer.index');
		Route::resource('/customer/order','Customer\PostOrderController');
		
	});


	Auth::routes();

	Route::group(['middleware' => ['admin']], function () {
		Route::get('/admin/index', 'HomeController@index')->name('admin.index');

		Route::resource('admin/propertytypes', 'Admin\PropertyTypeController');
		Route::resource('admin/contracttypes', 'Admin\ContractTypeController');
		
		Route::resource('admin/customers', 'Admin\CustomerController');
	});