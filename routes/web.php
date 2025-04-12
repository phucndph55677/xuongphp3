<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

Route::get('/about', function () {
    return "ABOUT PAGE";
});

//Nhóm tiền tố lại thành 1
Route::prefix('admin')->group(function () {
    Route::get('/posts', function () {
        return "Admin Posts";
    });
    Route::get('/users', function () {
        return "Admin Users";
    });
});

//Khai báo tham số
Route::get('/posts/{id}', function ($id) {
    return "POST ID: " . $id;
});
Route::get('/posts/{id}/comments/{c_id}', function ($id, $c_id) {
    return "POST ID: $id & comment id: $c_id";
})->name('posts.comment');

Route::get('/posts', [PostController::class, 'index']);

Route::get('/test', [ProductController::class, 'index']);
Route::get('/test2', [ProductController::class, 'list']);


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('/products', AdminProductController::class);
    Route::get('/variants/{id}/product', [ProductVariantController::class, 'index'])->name('variants.index');
    Route::get('/variants/{id}/create', [ProductVariantController::class, 'create'])->name('variants.create');
    Route::post('/variants', [ProductVariantController::class, 'store'])->name('variants.store');
    Route::get('/variants/{id}/edit', [ProductVariantController::class, 'edit'])->name('variants.edit');
    Route::put('/variants/{id}', [ProductVariantController::class, 'update'])->name('variants.update');
    Route::delete('/variants/{id}', [ProductVariantController::class, 'destroy'])->name('variants.destroy');
    //Đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

//Website front end
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/detail/{id}', [ProductController::class, 'show'])->name('product.detail');

//API lấy get-variant-price
Route::get('/get-variant-price', [ProductController::class, 'getVariantPrice'])->name('get-variant-price');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Giỏ hàng
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    //Xem giỏ hàng
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    //Hiển thị form checkout
    Route::get('/checkout', [CartController::class, 'showCheckOut'])->name('cart.checkout');
    //Thanh toán đơn hàng
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout.post');
});

require __DIR__ . '/auth.php';