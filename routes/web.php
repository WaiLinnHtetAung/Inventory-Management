<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DailyPurchaseReportController;
use App\Http\Controllers\Admin\DailySaleReportController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SaleController;
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
    Route::get('/recent-purchase-datatable', [PurchaseController::class, 'recentData']);
    Route::resource('purchases', PurchaseController::class);

    //Daily Purchase Report
    Route::get('/daily-purchase-report', [DailyPurchaseReportController::class, 'index'])->name('daily-purchase-report.index');
    Route::post('/get-purchase-report', [DailyPurchaseReportController::class, 'getReport'])->name('purchase.report');

    //sale
    Route::get('/sale-datatable', [SaleController::class, 'dataTable']);
    Route::get('/recent-sale-datatable', [SaleController::class, 'recentData']);
    Route::post('/product-stock', [SaleController::class, 'getProductStock'])->name('product.stock');
    Route::post('/stock-compare', [SaleController::class, 'compareStock'])->name('compare.stock');
    Route::resource('sales', SaleController::class);

    //Daily Sale Report
    Route::get('/daily-sale-report', [DailySaleReportController::class, 'index'])->name('daily-sale-report.index');
    Route::post('/get-sale-report', [DailySaleReportController::class, 'getReport'])->name('sale.report');

    //pdf
    Route::get('pdf-download', [PdfController::class, 'pdfDownload'])->name('pdf.download');

});

require __DIR__ . '/auth.php';
