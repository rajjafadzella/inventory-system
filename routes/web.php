<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified', 'role:Admin,Staff,Manager'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Admin,Staff'])->group(function () {
    Route::resource('products', ProductController::class);

    Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::put('borrowings/{borrowing}/return', [BorrowingController::class, 'returnAsset'])->name('borrowings.return');
});

Route::middleware(['auth', 'role:Admin,Manager'])->group(function () {
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
});

Route::get('/storage/{path}', function ($path) {
    $path = str_replace('../', '', $path);
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
})->where('path', '.*');

// ==================== REST API ====================
Route::prefix('api')->group(function () {
    // 1. Endpoint untuk list semua barang
    Route::get('/products', function () {
        $products = \App\Models\Product::with('category')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Daftar barang inventaris',
            'data' => $products
        ], 200);
    });

    // 2. Endpoint untuk detail satu barang berdasarkan ID
    Route::get('/products/{product}', function (\App\Models\Product $product) {
        return response()->json([
            'status' => 'success',
            'message' => 'Detail barang inventaris',
            'data' => $product->load('category')
        ], 200);
    });
});


require __DIR__.'/auth.php';
