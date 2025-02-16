<?php

use App\Http\Controllers\Backend\AdminAuthenticationController;
use App\Http\Controllers\Backend\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/dashboard', function () {
//   return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('login', [AdminAuthenticationController::class, 'login'])->name('login');
Route::post('login', [AdminAuthenticationController::class, 'handleLogin'])->name('handle-login');
Route::post('logout', [AdminAuthenticationController::class, 'adminLogout'])->name('logout');
Route::get('forgot-password', [AdminAuthenticationController::class, 'forgotPassword'])->name('forgot-password');

Route::group(['middleware' => ['admin']], function () {
  Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});
