

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\BookController;
use App\Http\Controllers\Dashboard\GenreController;
use App\Http\Controllers\Dashboard\AuthorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscribedUserController;
use App\Http\Controllers\TwoFactorCodeController;
use App\Http\Controllers\UserCodeController;

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

    Route::controller(ReviewController::class)
        ->prefix('reviews')
        ->name('review.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

    Route::post('newsletter/subscribe', [SubscribedUserController::class, 'subscribe'])
        ->name('newsletter.subscribe');

    Route::get('/authors/get-authors', [AuthorController::class, 'getAuthors'])->name('authors.getAuthors');

    Route::resource('/books', BookController::class)->only('index', 'show');
    Route::resource('/authors', AuthorController::class)->only('index', 'show');
    Route::resource('/genres', GenreController::class)->only('index', 'show');
});
