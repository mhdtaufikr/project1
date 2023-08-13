<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthCustomerController;

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

Route::get('/admin/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'postLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/', [CustomerController::class, 'index']);



Route::get('/customer/login', [AuthCustomerController::class, 'login']);
Route::get('/customer/register', [AuthCustomerController::class, 'register']);
Route::post('/customer/register/store', [AuthCustomerController::class, 'store']);
Route::post('/customer/auth/login', [AuthCustomerController::class, 'postLogin']);
Route::get('/customer/logout', [AuthCustomerController::class, 'logout']);


Route::middleware(['auth'])->group(function () {
    //Home Controller
    Route::get('/home', [HomeController::class, 'index']);

    //masterProductContoller
    Route::get('/product', [ProductController::class, 'index']);
    Route::post('/product/store', [ProductController::class, 'storeProduct']);
    Route::post('/product/update', [ProductController::class, 'updateProduct']);
    Route::delete('/product/delete', [ProductController::class, 'deleteProduct']);
});

Route::middleware(['customer.auth'])->group(function () {
    Route::post('/customer/update-profile', [AuthCustomerController::class, 'updateProfile']);
    Route::get('/customer/detail/{id}', [CustomerController::class, 'detailProduct']);
    Route::post('/customer/order', [CustomerController::class, 'orderProduct']);
    Route::get('/customer/cart/{id}', [CustomerController::class, 'cartProduct']);
    Route::post('/customer/cancel-order', [CustomerController::class, 'cancelProduct']);
    Route::post('/customer/pay', [CustomerController::class, 'payProduct']);
   
});

