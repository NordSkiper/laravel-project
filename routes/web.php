<?php

use App\Mail\MyDemoMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

//Route::prefix('test')->name('test')->group( function (){
//    Route::get('/', function () {
//        \App\Jobs\TestJob::dispatch('Test Job');
//    });
//
//    Route::get('mail',function () {
//        $myEmail = 'brutalvarenyk@gmail.com';
//
//        $admin = User::where('role_id', '=', 1)->first();
//        Mail::to($myEmail)->send(new \App\Mail\Orders\Created\Admin(4, $admin->full_name));
//
//        dd("Mail Send Successfully");
//    });
//
////    Route::get('mail', [\App\Observers\OrderObserver::class, 'created']);
//});


Route::get('/', function () {
    return redirect('/en/');
});

Route::prefix(\App\Services\Localization\LocalizationService::localize())
    ->name('lang.')->group(function(){
    Auth::routes();

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('products', [\App\Http\Controllers\ProductsController::class, 'index'])
        ->name('products');
    Route::get('products/{product}', [\App\Http\Controllers\ProductsController::class, 'show'])
        ->name('products.show');

    Route::get('categories', [\App\Http\Controllers\CategoriesController::class, 'index'])
        ->name('categories');
    Route::get('categories/{category}', [\App\Http\Controllers\CategoriesController::class, 'show'])
        ->name('categories.show');

// account/orders/5
    Route::namespace('Account')->prefix('account')->name('account.')->middleware('auth')
        ->group(function (){

        Route::get('/', [\App\Http\Controllers\Account\UserController::class, 'index'])
            ->name('main'); // lang.account.home
        Route::get('/edit', [\App\Http\Controllers\Account\UserController::class, 'edit'])
            ->name('edit'); // lang.account.edit
        Route::put('/update', [\App\Http\Controllers\Account\UserController::class, 'update'])
            ->name('update'); // lang.account.update
        Route::get('/wishlist', [\App\Http\Controllers\Account\WishListController::class, 'index'])
            ->name('wishlist');
    });

    Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth', 'admin')
        ->group(function (){

            Route::get('/', '\App\Http\Controllers\Admin\BoardController')
                ->name('home'); // lang.admin.home

            Route::name('orders')->group(function (){
                Route::get('orders', [\App\Http\Controllers\Admin\OrdersController::class, 'index']); // lang.admin.orders
                Route::get('orders/{order}/edit', [\App\Http\Controllers\Admin\OrdersController::class, 'edit'])
                    ->name('.edit'); // lang.admin.orders.edit
                Route::get('orders/{order}/show', [\App\Http\Controllers\Admin\OrdersController::class, 'show'])
                    ->name('.show'); // lang.admin.orders.show
            });

            Route::name('products')->group(function (){
                Route::get('products', [\App\Http\Controllers\Admin\ProductsController::class, 'index']); //admin.products
                Route::get('products/{product}/edit', [\App\Http\Controllers\Admin\ProductsController::class, 'edit'])
                    ->name('.edit'); // lang.admin.products.edit
                Route::put('products/{product}/update', [\App\Http\Controllers\Admin\ProductsController::class, 'update'])
                    ->name('.update'); // lang.admin.products.edit
                Route::delete('products/{product}/delete', [\App\Http\Controllers\Admin\ProductsController::class, 'destroy'])
                    ->name('.delete'); // lang.admin.products.edit
                Route::get('products/new', [\App\Http\Controllers\Admin\ProductsController::class, 'create'])
                    ->name('.create'); // lang.admin.products.create
                Route::post('products', [\App\Http\Controllers\Admin\ProductsController::class, 'store'])
                    ->name('.store'); // lang.admin.products.store
                });

            Route::name('categories')->group(function (){
                Route::get('categories/{category}/edit', [\App\Http\Controllers\Admin\CategoriesController::class, 'edit'])
                    ->name('.edit'); // lang.admin.products.edit
                Route::put('categories/{category}/update', [\App\Http\Controllers\Admin\CategoriesController::class, 'update'])
                    ->name('.update'); // lang.admin.products.edit
                Route::delete('categories/{category}/delete', [\App\Http\Controllers\Admin\CategoriesController::class, 'destroy'])
                    ->name('.delete'); // lang.admin.products.edit
                Route::get('categories/new', [\App\Http\Controllers\Admin\CategoriesController::class, 'create'])
                    ->name('.create'); // lang.admin.products.create
                Route::post('categories', [\App\Http\Controllers\Admin\CategoriesController::class, 'store'])
                    ->name('.store'); // lang.admin.products.store

            });

    });

    Route::middleware('auth')->group(function () {
        Route::get('cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart');
        Route::post('cart/{product}/add', [\App\Http\Controllers\CartController::class, 'add'])
            ->name('cart.add');
        Route::post('cart/{product}/delete', [\App\Http\Controllers\CartController::class, 'delete'])
            ->name('cart.delete');
        Route::post('cart/{product}/count/update', [\App\Http\Controllers\CartController::class, 'countUpdate'])
            ->name('cart.count.update');

        Route::get('checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])
            ->name('checkout');

        Route::post('order', [\App\Http\Controllers\OrdersController::class, 'store'])
            ->name('order.create');

        Route::get('wishlist/{product}/add', [\App\Http\Controllers\WishListController::class, 'add'])
            ->name('wishlist.add');

        Route::delete('wishlist/{product}/delete', [\App\Http\Controllers\WishListController::class, 'delete'])
            ->name('wishlist.delete');

        Route::post('rating/{product}/add', [\App\Http\Controllers\RatingController::class, 'add'])->name('rating.add');
    });
});

Route::delete('ajax/productImage/{image_id}', [\App\Http\Controllers\ProductImageController::class, 'destroy'])
    ->name('ajax.products.images.delete');

