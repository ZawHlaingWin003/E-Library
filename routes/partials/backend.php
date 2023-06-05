
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Backend\BookController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\GenreController;
use App\Http\Controllers\Backend\AuthorController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SubscribedUserController;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register backend routes (Dashboard Side) for your application.
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::controller(AdminLoginController::class)
            ->group(function () {
                Route::get('/login', 'showLoginForm')->name('loginForm');
                Route::post('/login', 'login')->name('login');
                Route::post('/logout', 'logout')->name('logout');
            });

        Route::middleware('auth:admin_user')->group(function () {
            Route::get('/', DashboardController::class)->name('dashboard');

            Route::controller(AdminUserController::class)
                ->prefix('admin-users')
                ->name('admin-users.')
                ->group(function () {
                    Route::get('/ssr', 'ssr')->name('ssr');
                    Route::get('/export', 'export')->name('export');
                    Route::get('/upload', 'uploadExcel')->name('upload');
                    Route::post('/import', 'import')->name('import');
                });

            Route::controller(BookController::class)
                ->prefix('books')
                ->name('books.')
                ->group(function () {
                    Route::get('/check-slug', 'checkSlug')->name('checkSlug');
                });

            Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

            Route::resource('/admin-users', AdminUserController::class);
            Route::resource('/subscribed-users', SubscribedUserController::class);
            Route::resource('/users', UserController::class);
            Route::resource('/books', BookController::class);
            Route::resource('/authors', AuthorController::class);
            Route::resource('/genres', GenreController::class);
        });
    });
