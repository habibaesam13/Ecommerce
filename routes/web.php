<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OTPLogicController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::get("/home-page", function () {
        return view("mainApp");
    })->name('home');








    
    Route::prefix('/admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.AdminDashboard');
        })->name("AdminDashboard");
    });


});