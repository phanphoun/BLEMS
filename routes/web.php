
<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredBooks = Book::with('categories')
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();
        
    $categories = Category::withCount('books')
        ->orderBy('books_count', 'desc')
        ->take(6)
        ->get();
    return view('welcome', compact('featuredBooks', 'categories'));
})->name('home');
Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
Auth::routes();
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// In web.php, inside the auth middleware group
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Book import/export routes
    Route::get('/books/import', [App\Http\Controllers\BookController::class, 'showImportForm'])->name('books.import.form');
    Route::post('/books/import', [App\Http\Controllers\BookController::class, 'import'])->name('books.import');
    Route::get('/books/export', [App\Http\Controllers\BookController::class, 'export'])->name('books.export');
    
    // Other protected routes
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
});