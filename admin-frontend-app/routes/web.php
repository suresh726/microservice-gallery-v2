<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

Route::get('/admin/login', [App\Http\Controllers\AdminController::class, 'loginGet'])->name('login');
Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'loginPost'])->name('login');

Route::get('/admin/register', [App\Http\Controllers\AdminController::class, 'registerGet'])->name('register');
Route::post('/admin/register', [App\Http\Controllers\AdminController::class, 'registerPost'])->name('register');

Route::middleware(['custom.auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\CategoryController::class, 'index']);
    Route::get('/admin', [App\Http\Controllers\CategoryController::class, 'index']);
    Route::get('/admin/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('dashboard');
    Route::get('/admin/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category-create');
    Route::post('/admin/categories/create', [App\Http\Controllers\CategoryController::class, 'store'])->name('category-create');
    Route::delete('/admin/categories/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category-delete');
    Route::post('/admin/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
});

// Frontend pages
Route::get('/', [PagesController::class, 'index']);
Route::get('/image-list/{category_id}', [PagesController::class, 'imagesByCategory']);
Route::get('/image-detail/{image_id}', [PagesController::class, 'imageDetail']);
