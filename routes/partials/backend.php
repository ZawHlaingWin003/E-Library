
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\BookController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Dashboard\GenreController;
use App\Http\Controllers\Dashboard\AuthorController;
use App\Http\Controllers\Dashboard\AdminUserController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\SubscribedUserController;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register backend routes (Dashboard Side) for your application.
|
*/

Route::prefix('admin')->group(function () {

    Route::controller(AdminLoginController::class)
        ->group(function () {
            Route::get('/login', 'showLoginForm')->name('admin.login-form');
            Route::post('/login', 'login')->name('admin.login');
            Route::post('/logout', 'logout')->name('admin.logout');
        });

    Route::middleware('auth:admin_user')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::controller(AdminUserController::class)
            ->prefix('admin-users')
            ->name('admin-users.')
            ->group(function () {
                Route::get('/export', 'export')->name('export');
                Route::get('/upload', 'uploadExcel')->name('upload');
                Route::post('/import', 'import')->name('import');
            });

        Route::controller(BookController::class)
            ->prefix('books')
            ->name('books.')
            ->group(function () {
                Route::get('/check-slug', 'checkSlug')->name('checkSlug');
                Route::get('/list', 'list')->name('list');
            });

        Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

        Route::get('/authors/list', [AuthorController::class, 'list'])->name('authors.list');

        Route::get('/genres/list', [GenreController::class, 'list'])->name('genres.list');

        Route::get('/subscribed-users/list', [SubscribedUserController::class, 'list'])->name('subscribed-user.list');

        Route::resource('/admin-users', AdminUserController::class);
        Route::resource('/users', UserController::class)->only('index');
        Route::resource('/books', BookController::class)->except('index', 'show');
        Route::resource('/authors', AuthorController::class)->except('index', 'show');
        Route::resource('/genres', GenreController::class)->except('index', 'show');
    });
});
