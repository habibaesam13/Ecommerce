<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Auth.login');
});
Route::get("/login", function () {
    return view("Auth.login");
});
Route::post('/login', [AuthController::class, 'login'])->name("auth.login");

Route::get("/register", function () {
    return view("Auth.signup");
});
Route::post('/register', [AuthController::class, 'register'])->name("auth.register");

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