<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserCouponController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserBankController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\AppSettingsController;

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
Route::get('/', function () { return view('home'); });


Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () { 
	return view('pages.forgot-password'); 
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	// dashboard route  
	Route::get('/dashboard', function () { 
		// return view('pages.form-advance');
		return view('dashboard'); 

	})->name('dashboard');

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
		Route::get('/users', [UserController::class,'index']);
		Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);

		// Customer Manager
		Route::get('/customer', [CustomerController::class,'index']);
		Route::get('/customer/get-list', [CustomerController::class,'getCustomerList']);
		Route::get('/customer/create', [CustomerController::class,'create']);
		Route::post('/customer/create', [CustomerController::class,'store'])->name('create-customer');
		Route::get('/customer/{id}', [CustomerController::class,'edit']);
		Route::post('/customer/update', [CustomerController::class,'update']);
		Route::get('/customer/delete/{id}', [CustomerController::class,'delete']);

		// User Withdrawal Manager
		Route::get('/withdrawal', [WithdrawalController::class,'index']);
		Route::get('/withdrawal/get-list', [WithdrawalController::class,'getWithdrawalList']);
		Route::get('/withdrawal/create', [WithdrawalController::class,'create']);
		Route::post('/withdrawal/create', [WithdrawalController::class,'store'])->name('create-withdrawal');
		Route::get('/withdrawal/{id}', [WithdrawalController::class,'edit']);
		Route::get('/withdrawal/view/{id}', [WithdrawalController::class,'show']);
		Route::post('/withdrawal/update', [WithdrawalController::class,'update']);
		Route::get('/withdrawal/delete/{id}', [WithdrawalController::class,'delete']);
		Route::post('/withdrawal/statusupdate', [WithdrawalController::class,'StatusUpdate']);
		
		// Coupon Manager
		Route::get('/coupon', [CouponController::class,'index']);
		Route::get('/coupon/get-list', [CouponController::class,'getCouponList']);
		Route::get('/coupon/create', [CouponController::class,'create']);
		Route::post('/coupon/create', [CouponController::class,'store'])->name('create-coupon');
		Route::get('/coupon/{id}', [CouponController::class,'edit']);
		Route::get('/coupon/view/{id}', [CouponController::class,'show']);
		Route::post('/coupon/update', [CouponController::class,'update']);
		Route::get('/coupon/delete/{id}', [CouponController::class,'delete']);

		// User Coupon Manager
		Route::get('/user_coupon', [UserCouponController::class,'index']);
		Route::get('/user_coupon/get-list', [UserCouponController::class,'getUserCouponList']);
		Route::get('/user_coupon/{id}', [UserCouponController::class,'edit']);
		Route::post('/user_coupon/update', [UserCouponController::class,'update']);
		Route::get('/user_coupon/delete/{id}', [UserCouponController::class,'delete']);

		// Banner Manager
		Route::get('/banners', [BannersController::class,'index']);
		Route::get('/banners/get-list', [BannersController::class,'getBannerList']);
		Route::get('/banners/create', [BannersController::class,'create']);
		Route::post('/banners/create', [BannersController::class,'store'])->name('create-banner');
		Route::get('/banners/{id}', [BannersController::class,'edit']);
		Route::post('/banners/update', [BannersController::class,'update']);
		Route::get('/banners/delete/{id}', [BannersController::class,'delete']);

		// Product Manager
		Route::get('/product', [ProductController::class,'index']);
		Route::get('/product/get-list', [ProductController::class,'getProductList']);
		Route::get('/product/create', [ProductController::class,'create']);
		Route::post('/product/create', [ProductController::class,'store'])->name('create-product');
		Route::get('/product/{id}', [ProductController::class,'edit']);
		Route::post('/product/update', [ProductController::class,'update']);
		Route::get('/product/delete/{id}', [ProductController::class,'delete']);
		
		// User Bank Manager
		Route::get('/user_bank', [UserBankController::class,'index']);
		Route::get('/user_bank/get-list', [UserBankController::class,'getUserBankList']);
		Route::get('/user_bank/{id}', [UserBankController::class,'edit']);
		Route::post('/user_bank/update', [UserBankController::class,'update']);
		Route::get('/user_bank/delete/{id}', [UserBankController::class,'delete']);
		
		// Contact Us Manager
		Route::get('/contact_us', [ContactUsController::class,'index']);
		Route::get('/contact_us/create', [ContactUsController::class,'create']);
		Route::get('/contact_us/{id}', [ContactUsController::class,'edit']);
		Route::post('/contact_us/update', [ContactUsController::class,'update']);
		Route::get('/contact_us/delete/{id}', [ContactUsController::class,'delete']);


		// App Settings
		Route::get('/app_settings', [AppSettingsController::class,'index']);
		Route::get('/app_settings/create', [AppSettingsController::class,'create']);
		Route::get('/app_settings/{id}', [AppSettingsController::class,'edit']);
		Route::post('/app_settings/update', [AppSettingsController::class,'update']);
		Route::get('/app_settings/delete/{id}', [AppSettingsController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


});


// Route::get('/register', function () { return view('pages.register'); });