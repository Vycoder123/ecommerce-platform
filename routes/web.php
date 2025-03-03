<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route cho trang chủ (danh sách sản phẩm cho người dùng)
Route::get('/', [UserController::class, 'index'])->name('user.index');

// Routes cho xác thực (đăng nhập, đăng ký, đăng xuất)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Routes cho người dùng (User) - yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index'); // Danh sách sản phẩm
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // Xem giỏ hàng
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add'); // Thêm vào giỏ
    Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update'); // Cập nhật số lượng
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove'); // Xóa khỏi giỏ

    // Routes cho checkout và thanh toán
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/paywithpaypal', [PaymentController::class, 'payWithPaypal'])->name('paywithpaypal');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});

// Routes cho admin - yêu cầu đăng nhập và vai trò admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index'); // Dashboard admin
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index'); // Danh sách sản phẩm
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create'); // Form thêm sản phẩm
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store'); // Lưu sản phẩm mới
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit'); // Form sửa sản phẩm
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update'); // Cập nhật sản phẩm
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy'); // Xóa sản phẩm
});
