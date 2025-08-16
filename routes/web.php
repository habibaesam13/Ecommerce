<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\OTPLogicController;
use App\Http\Middleware\EnsureSingleSession;

Route::get('/', function () {
    return view('Auth.login');
});
Route::get("/login", function () {
    return view("Auth.login");
})->name("Auth.login");
Route::post('/login', [AuthController::class, 'login'])->name("auth.login");

Route::get("/register", function () {
    return view("Auth.signup");
});
Route::post('/register', [AuthController::class, 'register'])->name("auth.register");

/**             Password Reset Routes                   */
Route::get('/forgetPassword',[OTPLogicController::class,'forgotPassword'])->name('password.forget');
Route::post("/sendOtp",[OTPLogicController::class,'sendOtp'])->name('sendOtp');
Route::get('/reset-password', [OTPLogicController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [OTPLogicController::class, 'resetPassword'])->name('password.reset');


/**                   Authenticated Routes                          */
    //user Routes
Route::middleware(['auth', 'single.session'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::get("/home-page", [HomePageController::class, 'index'])->name('home');

    Route::get('/category-products/{categoryId}', [CategoryController::class, 'categoryProducts'])->name('category-products');
});

//Admin Routes
Route::middleware(['auth', 'single.session'])->prefix('/admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.AdminDashboard');
    })->name("AdminDashboard");

});