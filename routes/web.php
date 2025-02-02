<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;

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

// Main Page Route

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
  Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

  // locale
  Route::get('lang/{locale}', [LanguageController::class, 'swap']);

  // pages
  Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

  // authentication
  Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
  Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

  Route::get('/', [HomePage::class, 'index'])->name('pages-home');

  Route::get('/dashboard', function () {
    return view('dashboard.index');
  })->name('dashboard');

  //roles & permissions routes sections
  Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions.index');
  Route::get('roles-permissions/{id}/edit', [RolePermissionController::class, 'edit'])->name('roles-permissions.edit');
  Route::put('roles-permissions/{id}', [RolePermissionController::class, 'update'])->name('roles-permissions.update');
  //user Management system

  Route::resource('users', UserController::class);
});

// Fallback route
Route::fallback(function () {
  return redirect()->route('pages-misc-error');
});
