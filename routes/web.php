<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\TagsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/login/google', [UserLoginController::class,'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [UserLoginController::class,'handleGoogleCallback']);

Route::get('user-login', [UserLoginController::class, 'showUserLoginForm'])->name('user_login');
Route::post('user-login', [UserLoginController::class, 'userLogin'])->name('user_login_handle');
Route::post('user-logout', [UserLoginController::class, 'userLogout'])->name('user_logout');
Route::get('forget-password', [UserLoginController::class, 'forgetPassword'])->name('forget_password');
Route::post('forget-password', [UserLoginController::class, 'forgetPasswordHandle'])->name('forget_password_handle');
Route::get('change-password', [UserLoginController::class, 'changePassword'])->name('change_password');
Route::post('change-password', [UserLoginController::class, 'changePasswordHandle'])->name('change_password_handle');
Route::get('user-register', [UserLoginController::class, 'showUserRegisterForm'])->name('user_register');
Route::post('user-register', [UserLoginController::class, 'userRegister'])->name('user_register_handle');

Route::get('/category-product/{slug}', [HomeController::class, 'getProductByCategory'])->name('category_product');
Route::get('/brand/{slug}', [HomeController::class, 'getProductByBrand'])->name('brand');
Route::get('/products/{slug}', [HomeController::class, 'getProductDetail'])->name('product_detail');
Route::get('/category-news', [HomeController::class, 'getNews'])->name('show_list_news');
Route::get('/news/{slug}', [HomeController::class, 'getNewsDetail'])->name('news_detail');
Route::get('/search-product', [HomeController::class, 'search'])->name('search_product');
Route::post('/rating', [HomeController::class, 'rating'])->name('rating');
Route::post('/comment', [HomeController::class, 'comment'])->name('comment');

Route::get('/carts', [CheckoutController::class, 'showCart'])->name('cart.index');
Route::post('/add-product-to-cart', [CheckoutController::class, 'addProductToCard'])->name('add_product_to_cart');
Route::post('/delete-product-in-cart', [CheckoutController::class, 'deleteProductInCart'])->name('delete_product_in_cart');
Route::post('/update-quantity', [CheckoutController::class, 'updateQuantity'])->name('update_quantity');
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply_coupon');

Route::middleware('auth:user')->group(function () {
    Route::get('/checkouts', [CheckoutController::class, 'checkoutForm'])->name('cart.checkout');
    Route::post('/checkouts', [CheckoutController::class, 'checkoutStore'])->name('checkout.store');
    Route::post('/apply-feeship', [CheckoutController::class, 'applyFeeship'])->name('apply_feeship');

    Route::get('/manager-account/{user}', [HomeController::class, 'managerAccount'])->name('manager_account');
    Route::get('/manager-order/{user}', [HomeController::class, 'managerOrder'])->name('manager_order');
    Route::get('/update-account/{user}', [UserController::class, 'updateUserInfo'])->name('update_info_account');
    Route::put('update-account/{user}', [UserController::class, 'updateAccount'])->name('update_account');
});

Route::prefix('/admin')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin_login');
    Route::post('login', [LoginController::class, 'Login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('update-fee', [ShippingController::class, 'updateFee'])->name('shipping.update_fee');

        Route::resource('categories', CategoryProductController::class, ['names' => 'category_product'])->parameters(['categories' => 'categoryProduct']);
        Route::resource('brands', BrandProductController::class, ['names' => 'brand'])->parameters(['brands' => 'brand']);
        Route::resource('products', ProductController::class, ['names' => 'product'])->parameters(['products' => 'product']);
        Route::resource('posts', PostController::class, ['names' => 'post'])->parameters(['posts' => 'post']);
        Route::resource('category-posts', CategoryPostController::class, ['names' => 'category_post'])->parameters(['category-posts' => 'categoryPost']);
        Route::resource('users', UserController::class, ['names' => 'user'])->parameters(['users' => 'user']);
        Route::resource('coupons', CouponController::class, ['names' => 'coupon'])->parameters(['coupons' => 'coupon']);
        Route::resource('admins', AdminController::class, ['names' => 'admin'])->parameters(['admins' => 'admin']);
        Route::resource('orders', OrderController::class, ['names' => 'order'])->parameters(['orders' => 'order']);
        Route::resource('comments', CommentController::class, ['names' => 'comment'])->parameters(['comments' => 'comment']);
        Route::resource('tags', TagsController::class, ['names' => 'tag'])->parameters(['tags' => 'tag']);
        Route::resource('shippings', ShippingController::class, ['names' => 'shipping'])->parameters(['shippings' => 'shipping']);
        Route::resource('slides', SlideController::class, ['names' => 'slide'])->parameters(['slides' => 'slide']);
    });
});

Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');

Route::post('select_gallery', [ProductImageController::class, 'select_gallery'])->name('select_gallery');
Route::post('insert_gallery/{project}', [ProductImageController::class, 'insert_gallery'])->name('insert_gallery');
Route::post('update_name', [ProductImageController::class, 'update_name'])->name('update_name');
Route::post('delete_image', [ProductImageController::class, 'delete_image'])->name('delete_image');
Route::post('update_gallery', [ProductImageController::class, 'update_gallery'])->name('update_gallery');
// Route::resource('cart', CartController::class);
