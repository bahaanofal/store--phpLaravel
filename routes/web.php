<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController as FrontProductsController;
use App\Http\Controllers\RatingController;
use App\Models\Order;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::prefix('admin')->middleware(['auth', 'auth.type:admin,super-admin'])->group(function(){


    Route::group([
        'prefix' => '/categories',
        'as' => 'categories.'
    ],function(){
        // standard طريقة استخدام وتسمية الراوت هذه هي المتبعة في أساس لارافيل
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');
        Route::post('', [CategoriesController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoriesController::class, 'show'])->name('show');
        Route::get('/{category_id}/edit', [CategoriesController::class, 'edit'])->name('edit');
        Route::put('/{category_id}', [CategoriesController::class, 'update'])->name('update');
        Route::delete('/{category_id}', [CategoriesController::class, 'destroy'])->name('destroy');
    });
    
    
    Route::get('/products/trash', [ProductsController::class, 'trash'])->name('products.trash');
    Route::put('/products/trash/{id?}', [ProductsController::class, 'restore'])->name('products.restore');
    Route::delete('/products/trash/{id?}', [ProductsController::class, 'forceDelete'])->name('products.force-delete');
    // هادا الراوت بعطيني نفس ال7 أسطر اللي فوق
    Route::resource('/products', ProductsController::class)->middleware(['password.confirm']);
    
    
    Route::resource('/roles', RolesController::class);
    
    Route::get('/get-users-addresses', [HomeController::class, 'getUsersAddresses']);
    
    Route::resource('/countries', CountriesController::class);

    Route::get('/profiles/{profile}', [ProfileController::class, 'show']);

});

Route::get('/products', [FrontProductsController::class, 'index'])->name('products');
Route::get('/products/{slug}', [FrontProductsController::class, 'show'])->name('product.details');

Route::post('/ratings/{type}', [RatingController::class, 'store'])->where('type', 'profile|product');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'store']);

Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store']);

Route::get('/orders', function() {
    return Order::all();
})->name('orders');