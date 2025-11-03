<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Routing\Router;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/create', [ProductController::class, 'create'])->name("product-create");
Route::post('/product', [ProductController::class, 'store'])->name("product-store");
require __DIR__.'/auth.php';


//index
Route::get('/product', [ProductController::class, 'index'])->name('product-index');
Route::get('/product/create', [ProductController::class, 'create'])->name("product-create");
Route::post('/product', [ProductController::class, 'store'])->name("product-store");
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name("product-edit");
Route::put('/product/{id}', [ProductController::class, 'update'])->name("product-update");
// Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name("product-delete");
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name("product-deleted");

Route::get('/product/{id}', [ProductController::class, 'sho'])->name("product-detail");

//rute baru
Route::get('/product/export/excel', [ProductController::class, 'exportExcel'])->name('product-export-excel');

//rute export pdf dan jpg
Route::get('product/export/pdf', [ProductController::class, 'exportPDF'])->name('product.export.pdf');
Route::get('product/export/jpg', [ProductController::class, 'exportJPG'])->name('product.export.jpg');


