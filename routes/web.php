<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peminjam\BookController;
use App\Http\Controllers\Peminjam\BorrowingController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect(auth()->user()->role === 'admin' ? '/admin/books' : '/books');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('categories', AdminCategoryController::class)->except(['create', 'edit', 'show']);
        Route::resource('books', AdminBookController::class)->except(['create', 'edit', 'show']);
        Route::get('borrowings', [AdminBorrowingController::class, 'index'])->name('borrowings.index');
    });

    Route::middleware('role:peminjam')->group(function () {
        Route::get('books', [BookController::class, 'index'])->name('books.index');
        Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
        Route::post('books/{book}/borrow', [BorrowingController::class, 'store'])->name('borrowings.store');
        Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
        Route::patch('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
    });
});
