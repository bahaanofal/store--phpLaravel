<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingController;
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



// standard طريقة استخدام وتسمية الراوت هذه هي المتبعة في أساس لارافيل
Route::get('/admin/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/admin/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
Route::post('/admin/categories', [CategoriesController::class, 'store'])->name('categories.store');
Route::get('/admin/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');
Route::get('/admin/categories/{category_id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
Route::put('/admin/categories/{category_id}', [CategoriesController::class, 'update'])->name('categories.update');
Route::delete('/admin/categories/{category_id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');


Route::get('/admin/products/trash', [ProductsController::class, 'trash'])->name('products.trash');
Route::put('/admin/products/trash/{id?}', [ProductsController::class, 'restore'])->name('products.restore');
Route::delete('/admin/products/trash/{id?}', [ProductsController::class, 'forceDelete'])->name('products.force-delete');
// هادا الراوت بعطيني نفس ال7 أسطر اللي فوق
Route::resource('/admin/products', ProductsController::class)->middleware(['auth', 'password.confirm']);


Route::resource('/admin/roles', RolesController::class)->middleware('auth');

Route::get('admin/get-users-addresses', [HomeController::class, 'getUsersAddresses']);

Route::resource('/admin/countries', CountriesController::class)->middleware('auth');

Route::post('/ratings/{type}', [RatingController::class, 'store'])->where('type', 'profile|product');

Route::get('/admin/profiles/{profile}', [ProfileController::class, 'show']);