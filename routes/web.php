<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
Route::get('/', function () {return redirect()->route('admin.home');});

Route::group(['middleware' => ['auth', 'prevent-back-history'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [ProfileController::class, 'dashboard'])->name('home');

    //permission
    Route::get('/permission-datatable', [PermissionController::class, 'dataTable']);
    Route::resource('permissions', PermissionController::class);

    //roles
    Route::get('/roles-datatable', [RolesController::class, 'dataTable']);
    Route::resource('roles', RolesController::class);

    //users
    Route::get('/users-datatable', [UserController::class, 'dataTable']);
    Route::resource('users', UserController::class);

    //category
    Route::get('/category-datatable', [CategoryController::class, 'dataTable']);
    Route::resource('categories', CategoryController::class);

    //product
    Route::get('/product-datatable', [ProductController::class, 'dataTable']);
    Route::resource('products', ProductController::class);

    //customer
    Route::get('/customer-datatable', [CustomerController::class, 'dataTable']);
    Route::resource('customers', CustomerController::class);

    //supplier
    Route::get('/supplier-datatable', [SupplierController::class, 'dataTable']);
    Route::resource('suppliers', SupplierController::class);

    //purchase
    Route::get('/purchase-datatable', [PurchaseController::class, 'dataTable']);
    Route::resource('purchases', PurchaseController::class);

});

require __DIR__ . '/auth.php';
