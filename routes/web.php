<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('admin.login');
Route::get('/login/sales', 'Auth\LoginController@showSalesLoginForm')->name('sales.login');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('/register/sales', 'Auth\RegisterController@showSalesRegisterForm');

Route::get('/logout', 'Auth\LoginController@logout');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/sales', 'Auth\LoginController@salesLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/sales', 'Auth\RegisterController@createSales');

Route::group(['prefix'=>'admin',['middleware' => 'auth:admin']], function () {
    Auth::routes();

    Route::get('change-password', 'ChangePasswordController@index')->name('AdminChangePassword');;
    Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/fetch_data', 'HomeController@fetch_data');
    Route::post('/fetch_data_sales', 'HomeController@fetch_data_sales');
    Route::post('/fetch_data_segmen', 'HomeController@fetch_data_segmen');
    Route::post('/fetch_potency_month', 'HomeController@fetch_potency_month');
    Route::post('/fetch_potency_month_sales', 'HomeController@fetch_potency_month_sales');
    Route::post('/fetch_potency_month_segmen', 'HomeController@fetch_potency_month_segmen');
    Route::post('/fetch_closing', 'HomeController@fetch_closing');
    Route::post('/fetch_closing_sales', 'HomeController@fetch_closing_sales');
    Route::post('/fetch_closing_segmen', 'HomeController@fetch_closing_segmen');


    Route::get('potensi', 'PotencyController@index')->name('potensi');
    Route::get('potensi/json','PotencyController@json');
    Route::get('potensi/{id}/detail','PotencyController@detail');
    Route::get('potensi/{id}/edit','PotencyController@edit');
    Route::post('potensi/update', 'PotencyController@update')->name('potensi_update');

    Route::get('potensi/create-step-one', 'PotencyController@createStepOne')->name('create.step.one');
    Route::get('potensi/create-step-two', 'PotencyController@createStepTwo')->name('create.step.two');
    Route::get('potensi/create-step-three', 'PotencyController@createStepThree')->name('create.step.three');
    Route::get('potensi/create-step-four', 'PotencyController@createStepFour')->name('create.step.four');
    Route::get('potensi/create-step-five', 'PotencyController@createStepFive')->name('create.step.five');

    Route::post('potensi/create-step-one','PotencyController@postCreateStepOne')->name('create.step.one.post');
    Route::post('potensi/create-step-two','PotencyController@postCreateStepTwo')->name('create.step.two.post');
    Route::post('potensi/create-step-three','PotencyController@postCreateStepThree')->name('create.step.three.post');
    Route::post('potensi/create-step-four','PotencyController@postCreateStepFour')->name('create.step.four.post');
    Route::post('potensi/create-step-five','PotencyController@postCreateStepFive')->name('create.step.five.post');

    Route::get('potensi/excel', 'PotencyController@excel')->name('excel');
    Route::post('potensi/import', 'PotencyController@import')->name('import');
    Route::get('potensi/format', 'PotencyController@format_potensi')->name('format_potensi');


    Route::get('service','ServiceController@index')->name('service');
    Route::get('service/json','ServiceController@json');
    Route::get('service/delete/{id}','ServiceController@delete');
    Route::get('service/{id}/edit', 'ServiceController@edit');
    Route::post('service/update', 'ServiceController@update');
    Route::get('service/add','ServiceController@create');
    Route::post('service/store','ServiceController@store');

    Route::get('customer','CustomerController@index')->name('customer');
    Route::get('customer/json','CustomerController@json');
    Route::get('customer/delete/{id}','CustomerController@delete');
    Route::get('customer/{id}/edit', 'CustomerController@edit');
    Route::post('customer/update', 'CustomerController@update');
    Route::get('customer/add','CustomerController@create')->name('admin.customer_add');
    Route::post('customer/store','CustomerController@store');
    Route::post('customer/import_excel', 'CustomerController@import_excel')->name('import_excel');
    Route::get('customer/format', 'CustomerController@format_customer')->name('format_customer');


    Route::get('office','OfficeController@index')->name('office');
    Route::get('office/json','OfficeController@json');
    Route::get('office/delete/{id}','OfficeController@delete');
    Route::get('office/{id}/edit', 'OfficeController@edit');
    Route::post('office/update', 'OfficeController@update');
    Route::get('office/add','OfficeController@create');
    Route::post('office/store','OfficeController@store');


    Route::get('sbu','SbuNamesController@index')->name('sbu');
    Route::get('sbu/json','SbuNamesController@json');
    Route::get('sbu/delete/{id}','SbuNamesController@delete');
    Route::get('sbu/{id}/edit', 'SbuNamesController@edit');
    Route::post('sbu/update', 'SbuNamesController@update');
    Route::get('sbu/add','SbuNamesController@create');
    Route::post('sbu/store','SbuNamesController@store');

    Route::get('sales','SalesController@index')->name('sales');
    Route::get('sales/json','SalesController@json');
    Route::get('sales/delete/{id}','SalesController@delete');
    Route::get('sales/{id}/edit', 'SalesController@edit');
    Route::post('sales/update', 'SalesController@update')->name('sales.update');
    Route::get('sales/add','SalesController@create');
    Route::post('sales/store','SalesController@store')->name('sales.add');


    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});



Route::group(['prefix'=>'sales',['middleware' => 'auth:sales']], function () {
    Auth::routes();

    Route::get('change-password', 'Sales\ChangePasswordController@index')->name('SalesChangePassword');;
    Route::post('change-password', 'Sales\ChangePasswordController@store')->name('sales.change.password');

    Route::get('/home', 'Sales\HomeSalesController@index')->name('sales.home');
    Route::get('/', 'Sales\HomeSalesController@index')->name('sales.home');
    Route::post('/fetch_data', 'Sales\HomeSalesController@fetch_data');
    Route::post('/fetch_data_sales', 'Sales\HomeSalesController@fetch_data_sales');
    Route::post('/fetch_data_segmen', 'Sales\HomeSalesController@fetch_data_segmen');
    Route::post('/fetch_potency_month', 'Sales\HomeSalesController@fetch_potency_month');
    Route::post('/fetch_potency_month_sales', 'Sales\HomeSalesController@fetch_potency_month_sales');
    Route::post('/fetch_potency_month_segmen', 'Sales\HomeSalesController@fetch_potency_month_segmen');
    Route::post('/fetch_closing', 'Sales\HomeSalesController@fetch_closing');
    Route::post('/fetch_closing_sales', 'Sales\HomeSalesController@fetch_closing_sales');
    Route::post('/fetch_closing_segmen', 'Sales\HomeSalesController@fetch_closing_segmen');


    Route::get('potensi', 'Sales\PotencySalesController@index')->name('sales.potensi');
    Route::get('potensi/json','Sales\PotencySalesController@json');
    Route::get('potensi/{id}/detail','Sales\PotencySalesController@detail');
    Route::get('potensi/{id}/edit','Sales\PotencySalesController@edit');
    Route::post('potensi/update', 'Sales\PotencySalesController@update')->name('sales.potensi_edit');

    Route::get('potensi/create-step-one', 'Sales\PotencySalesController@createStepOne')->name('sales.create.step.one');
    Route::get('potensi/create-step-two', 'Sales\PotencySalesController@createStepTwo')->name('sales.create.step.two');
    Route::get('potensi/create-step-three', 'Sales\PotencySalesController@createStepThree')->name('sales.create.step.three');
    Route::get('potensi/create-step-four', 'Sales\PotencySalesController@createStepFour')->name('sales.create.step.four');
    Route::get('potensi/create-step-five', 'Sales\PotencySalesController@createStepFive')->name('sales.create.step.five');

    Route::post('potensi/create-step-one','Sales\PotencySalesController@postCreateStepOne')->name('sales.create.step.one.post');
    Route::post('potensi/create-step-two','Sales\PotencySalesController@postCreateStepTwo')->name('sales.create.step.two.post');
    Route::post('potensi/create-step-three','Sales\PotencySalesController@postCreateStepThree')->name('sales.create.step.three.post');
    Route::post('potensi/create-step-four','Sales\PotencySalesController@postCreateStepFour')->name('sales.create.step.four.post');
    Route::post('potensi/create-step-five','Sales\PotencySalesController@postCreateStepFive')->name('sales.create.step.five.post');

    Route::get('potensi/excel', 'Sales\PotencySalesController@excel')->name('sales.excel');
    Route::post('potensi/import', 'Sales\PotencySalesController@import')->name('sales.import');

    Route::get('customer','Sales\CustomerSalesController@index')->name('sales.customer');
    Route::get('customer/json','Sales\CustomerSalesController@json')->name('sales.customerjson');
    Route::get('customer/delete/{id}','Sales\CustomerSalesController@delete');
    Route::get('customer/{id}/edit', 'Sales\CustomerSalesController@edit');
    Route::post('customer/update', 'Sales\CustomerSalesController@update')->name('sales.customer_edit');
    Route::get('customer/add','Sales\CustomerSalesController@create')->name('sales.customer_tambah');
    Route::post('customer/store','Sales\CustomerSalesController@store')->name('sales.customer_add');
    Route::post('customer/import_excel', 'Sales\CustomerSalesController@import_excel')->name('sales.import_excel');
    Route::get('customer/format', 'Sales\CustomerSalesController@format_customer')->name('sales.format_customer');

    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'Sales/ProfileSalesController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'Sales/ProfileSalesController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'Sales/ProfileSalesController@password']);
});

// For Clear cache
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// 404 for undefined routes
Route::any('/{page?}',function(){
    return View::make('pages.error-pages.error-404');
})->where('page','.*');
