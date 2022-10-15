<?php

use App\Http\Controllers\AdminAuth\LoginController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/admin')->group(function () {
    Route::get('login', [LoginController::class, 'getLogin']);
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryProductController::class, ['names' => 'category_product'])->parameters(['categories' => 'categoryProduct']);
        Route::resource('brands', BrandProductController::class, ['names' => 'brand'])->parameters(['brands' => 'brand']);
        Route::resource('products', ProductController::class, ['names' => 'product'])->parameters(['products' => 'product']);
        Route::resource('posts', PostController::class, ['names' => 'post'])->parameters(['posts' => 'post']);
        Route::resource('category-posts', CategoryPostController::class, ['names' => 'category_post'])->parameters(['category-posts' => 'categoryPost']);
        Route::resource('customers', CustomerController::class, ['names' => 'customer'])->parameters(['customers' => 'customer']);
        Route::resource('coupons', CouponController::class, ['names' => 'coupon'])->parameters(['coupons' => 'coupon']);
        Route::resource('users', UserController::class, ['names' => 'user'])->parameters(['users' => 'user']);
        Route::resource('orders', OrderController::class, ['names' => 'order'])->parameters(['orders' => 'order']);
        Route::resource('comments', CommentController::class, ['names' => 'comment'])->parameters(['comments' => 'comment']);
        Route::get('admin/fee', [ShippingController::class, 'fee'])->name('shipping.fee');
        Route::resource('shippings', ShippingController::class, ['names' => 'shipping'])->parameters(['shippings' => 'shipping']);
    });
});

Route::post('ckeditor/upload', [CkeditorController::class,'upload'])->name('ckeditor.upload');

Route::post('select_gallery',[ProductImageController::class, 'select_gallery'])->name('select_gallery');
Route::post('insert_gallery/{project}',[ProductImageController::class, 'insert_gallery'])->name('insert_gallery');
Route::post('update_name',[ProductImageController::class, 'update_name'])->name('update_name');
Route::post('delete_image',[ProductImageController::class, 'delete_image'])->name('delete_image');
Route::post('update_gallery',[ProductImageController::class, 'update_gallery'])->name('update_gallery');
// Route::resource('cart', CartController::class);