<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\BookController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Dashboard\GenreController;
use App\Http\Controllers\Dashboard\AuthorController;
use App\Http\Controllers\Dashboard\AdminUserController;
use App\Http\Controllers\UserCodeController;

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

Route::get('/', HomeController::class)->name('home');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/search', [AuthorController::class, 'search']);
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

Auth::routes();

Route::get('/2fa', [UserCodeController::class, 'index'])->name('2fa.index');
Route::post('/2fa', [UserCodeController::class, 'store'])->name('2fa.store');
Route::get('/2fa/resend', [UserCodeController::class, 'resend'])->name('2fa.resend');

Route::prefix('admin')->group(function(){

    Route::get('/login', [AdminLoginController::class, 'showLoginForm']);
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin_user')->group(function() {
        Route::view('/', 'dashboard.home')->name('dashboard');

        Route::get('/admin_users/export', [AdminUserController::class, 'export'])->name('admin_users.export');
        Route::get('/admin_users/upload', [AdminUserController::class, 'uploadExcel'])->name('upload.admin_users');
        Route::post('/admin_users/import', [AdminUserController::class, 'import'])->name('admin_users.import');
        Route::resource('/admin_users', AdminUserController::class);

        Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
        Route::resource('/users', UserController::class);

        Route::get('books/check_slug', [BookController::class, 'checkSlug'])->name('books.checkSlug');
        Route::get('/book_list', [BookController::class, 'list'])->name('books.list');
        Route::resource('/books', BookController::class)->except('index', 'show');

        Route::get('/author_list', [AuthorController::class, 'list'])->name('authors.list');
        Route::resource('/authors', AuthorController::class)->except('index', 'show');

        Route::resource('/genres', GenreController::class);

    });

});


