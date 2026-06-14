<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Toko Inventari Cokomi & Wowo
|--------------------------------------------------------------------------
|
| Semua route yang memerlukan autentikasi dilindungi oleh middleware 'auth'.
| Route publik hanya menampilkan halaman selamat datang.
|
*/

// Halaman utama redirect ke dashboard jika sudah login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Dashboard — setelah login
Route::get('/dashboard', function () {
    $stats = [
        'total'        => \App\Models\Product::count(),
        'active'       => \App\Models\Product::where('is_active', true)->count(),
        'low_stock'    => \App\Models\Product::where('stock', '<=', 10)->where('is_active', true)->count(),
        'out_of_stock' => \App\Models\Product::where('stock', 0)->count(),
    ];
    $recentProducts = \App\Models\Product::latest()->take(5)->get();
    return view('dashboard', compact('stats', 'recentProducts'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Profile (dari Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Resource CRUD Produk — hanya untuk user yang sudah login
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
