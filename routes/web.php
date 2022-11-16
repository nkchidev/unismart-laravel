<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MailController;
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

# Guest
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// Page
Route::get('/gioi-thieu/{id}', [PageController::class , 'show'])->name('page.about');
Route::get('/lien-he/{id}', [PageController::class , 'show'])->name('page.contact');

// Post
Route::get('/tin-tuc',[PostController::class, 'show']);
Route::get('/tin-tuc/{category?}/{slug}/{id}', [PostController::class, 'detail'])->name('post.detail');

// Product
Route::get('/danh-muc/{slug}/{cate_id}',[ProductController::class, 'show']);
Route::get('/san-pham/{id}',[ProductController::class, 'detail'])->name('product.detail');
Route::post('/san-pham/tim-kiem/',[ProductController::class, 'search'])->name('product.search');

// Giỏ hàng
Route::get('/gio-hang', [CartController::class, 'show'])->name('cart.show');
Route::get('/cart/add/{id}',[CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/delete/{rowId}',[CartController::class, 'delete'])->name('cart.delete');
Route::get('/cart/destroy',[CartController::class,'destroy'])->name('cart.destroy');
Route::get('/gio-hang/thanh-toan',[CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/store',[CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/gio-hang/thanh-toan/thanh-cong', [CheckoutController::class, 'success'])->name('checkout.success');
// Mail
Route::get('mail/sendmail/{order_id}',[MailController::class, 'sendmail'])->name('sendmail');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show']);
    Route::get('/admin', [DashboardController::class, 'show']);

    # User
    Route::get('admin/user/list',[AdminUserController::class, 'show']);
    Route::get('admin/user/add', [AdminUserController::class, 'add']);
    Route::post('admin/user/store', [AdminUserController::class, 'store']);
    Route::get('admin/user/delete/{id}', [AdminUserController::class, 'delete'])->name('delete_user');
    Route::post('admin/user/action', [AdminUserController::class, 'action']);
    Route::get('admin/user/edit/{id}', [AdminUserController::class, 'edit'])->name('user.edit');
    Route::post('admin/user/update/{id}', [AdminUserController::class, 'update'])->name('user.update');

    # Page
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    Route::get('admin/page/list', [AdminPageController::class, 'show']);
    Route::get('admin/page/add', [AdminPageController::class, 'add']);
    Route::post('admin/page/store', [AdminPageController::class, 'store']);
    Route::get('admin/page/delete/{id}', [AdminPageController::class, 'delete'])->name('page.delete');
    Route::get('admin/page/edit/{id}', [AdminPageController::class, 'edit'])->name('page.edit');
    Route::post('admin/page/update/{id}', [AdminPageController::class, 'update'])->name('page.update');
    Route::post('admin/page/action', [AdminPageController::class, 'action']);

    # Category
    Route::get('admin/post/cat/list',[AdminCategoryController::class, 'show']);
    Route::post('admin/post/cat/add',[AdminCategoryController::class, 'add']);
    Route::get('admin/post/cat/delete/{id}',[AdminCategoryController::class, 'delete'])->name('cat.delete');
    Route::post('admin/post/cat/update/{id}',[AdminCategoryController::class, 'update'])->name('cat.update');
    Route::get('admin/post/cat/edit/{id}',[AdminCategoryController::class, 'edit'])->name('cat.edit');
    Route::get('admin/product/cat/list', [AdminCategoryController::class, 'show']);

    # Post
    Route::get('admin/post/list',[AdminPostController::class, 'show']);
    Route::get('admin/post/add',[AdminPostController::class, 'add']);
    Route::post('admin/post/store',[AdminPostController::class, 'store']);
    Route::get('admin/post/delete/{id}',[AdminPostController::class, 'delete'])->name('post.delete');
    Route::get('admin/post/edit/{id}',[AdminPostController::class, 'edit'])->name('post.edit');
    Route::post('admin/post/update/{id}',[AdminPostController::class, 'update'])->name('post.update');
    Route::post('admin/post/action',[AdminPostController::class, 'action']);

    # Product
    Route::get('admin/product/list',[AdminProductController::class,'show']);
    Route::get('admin/product/add',[AdminProductController::class, 'add']);
    Route::post('admin/product/store',[AdminProductController::class, 'store']);
    Route::get('admin/product/delete/{id}',[AdminProductController::class, 'delete'])->name('product.delete');
    Route::get('admin/product/edit/{id}',[AdminProductController::class, 'edit'])->name('product.edit');
    Route::post('admin/product/update/{id}',[AdminProductController::class, 'update'])->name('product.update');
    Route::post('admin/product/action',[AdminProductController::class, 'action']);

    # Order
    Route::get('admin/order/list', [AdminOrderController::class, 'show'] );
    Route::get('admin/order/detail/{id}', [AdminOrderController::class, 'detail'])->name('order.detail');
    Route::post('admin/order/action', [AdminOrderController::class, 'action']);
    Route::post('admin/order/edit/{id}', [AdminOrderController::class, 'edit'])->name('order.edit');
});
