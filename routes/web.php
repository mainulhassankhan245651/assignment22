<?php

use App\Models\Customer;
use App\Mail\PromotionalEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenVerificationMiddleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// API Routes
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);


// After Authentication
Route::get("/user-profile-details",[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/user-update",[UserController::class,'UserUpdate'])->middleware([TokenVerificationMiddleware::class]);
// Logout
Route::get('/logout',[UserController::class,'UserLogout']);

// Page Routes
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);


Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);


// Customer API
Route::post("/create-customer",[CustomerController::class,'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-customer",[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-customer",[CustomerController::class,'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-customer",[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/customer-by-id",[CustomerController::class,'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);



// Category API
Route::post("/create-category",[CategoryController::class,'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-category",[CategoryController::class,'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-category",[CategoryController::class,'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-category",[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);


// Product API
Route::post("/create-product",[ProductController::class,'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-product",[ProductController::class,'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-product",[ProductController::class,'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-product",[ProductController::class,'ProductList'])->middleware([TokenVerificationMiddleware::class]);


// Dashboard API

Route::get("/total-customer",[DashboardController::class,'TotalCustomer'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/total-category",[DashboardController::class,'TotalCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/total-product",[DashboardController::class,'TotalProduct'])->middleware([TokenVerificationMiddleware::class]);

// Route::get('/email-campaigns', 'EmailCampaignController@index')->name('email-campaigns.index');
// Route::get('/email-campaigns/create', 'EmailCampaignController@create')->name('email-campaigns.create');
// Route::post('/email-campaigns', 'EmailCampaignController@store')->name('email-campaigns.store');




Route::get('/send-email', function () {


    // Inside the controller method:
    $customers = Customer::all();
    
    $enrollmentData=[
        'body'=>'You received a new test notification',
        'text'=>'You are allowed to enroll',
        'url'=>url('/'),
        'thankyou'=>'You have 14 days to enroll'


    ];
    foreach ($customers as $customer) {
        Mail::to($customer->email)->send(new PromotionalEmail('$enrollmentData'));
    }
    return redirect()->back();

});
