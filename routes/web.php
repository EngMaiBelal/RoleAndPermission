<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOldController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['prefix'=>'products', 'as'=>'products.', 'middleware'=>'verified'],function(){

//     Route::get('/all-products',[ProductOldController::class,'index'])->name('index');
//     Route::get('/create-product',[ProductOldController::class,'create'])->name('create');
//     Route::post('/store-product',[ProductOldController::class,'store'])->name('store');
//     Route::get('/edit-product/{id}',[ProductOldController::class,'edit'])->name('edit');
//     Route::put('/update-product',[ProductOldController::class,'update'])->name('update');
//     Route::delete('/destroy-product/{product_id}',[ProductOldController::class,'destroy'])->name('destroy');
// });

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('permissions', PermissionController::class);
});

