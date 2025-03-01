<?php

use App\Http\Controllers\Backend\AdminAuthenticationController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\LanguageController;
use Illuminate\Support\Facades\Route;

// Route::get('/dashboard', function () {
//   return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('login', [AdminAuthenticationController::class, 'login'])->name('login');
Route::post('login', [AdminAuthenticationController::class, 'handleLogin'])->name('handle-login');
Route::post('logout', [AdminAuthenticationController::class, 'adminLogout'])->name('logout');
Route::get('forgot-password', [AdminAuthenticationController::class, 'forgotPassword'])->name('forgot-password');
Route::post('forgot-password', [AdminAuthenticationController::class, 'sendResetLink'])->name('forgot-password.send-link');
Route::get('reset-password/{token}', [AdminAuthenticationController::class, 'resetPassword'])->name('reset-password');
Route::post('reset-password/send', [AdminAuthenticationController::class, 'handelRequestPassword'])->name('reset-password-send');

// Admin All Routes
Route::group(['middleware' => ['admin']], function () {
  Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
  Route::get('profile', [DashboardController::class, 'index'])->name('dashboard.profile.index');
  Route::post('profile/update/{id}', [DashboardController::class, 'profileUpdate'])->name('dashboard.profile.update');
  Route::post('password/update/{id}', [DashboardController::class, 'passwordUpdate'])->name('dashboard.password.update');
  // Languages
  Route::resource('languages', LanguageController::class);

  // Category 
  Route::resource('category', CategoryController::class);
});

// Profile Page
