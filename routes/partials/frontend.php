

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BookController;
use App\Http\Controllers\Frontend\GenreController;
use App\Http\Controllers\Frontend\AuthorController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\SubscribedUserController;
use App\Http\Controllers\Frontend\TwoFactorCodeController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register frontend routes (Client Side) for your application.
|
*/

Auth::routes();

Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::controller(TwoFactorCodeController::class)
        ->prefix('two-factor-authentication')
        ->name('2fa.')
        ->group(function () {
            Route::get('/', 'index')->name('form');
            Route::post('/', 'store')->name('store');
            Route::get('/resend', 'resend')->name('resend');
        });

    Route::post('newsletter/subscribe', [SubscribedUserController::class, 'subscribe'])
        ->name('newsletter.subscribe');

    Route::get('/authors/get-authors', [AuthorController::class, 'getAuthors'])->name('authors.getAuthors');
    Route::get('/books/get-books', [BookController::class, 'getBooks'])->name('books.getBooks');

    Route::resource('books', BookController::class)->only(['index', 'show']);
    Route::resource('authors', AuthorController::class)->only(['index', 'show']);
    Route::resource('genres', GenreController::class)->only(['index', 'show']);
    Route::apiResource('reviews', ReviewController::class);
});
