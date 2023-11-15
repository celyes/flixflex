<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Movies\MoviesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/v1')->group(function () {

    // Authentication route group
    Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
        Route::post('/register', RegistrationController::class)->name('register');
        Route::post('/login', AuthenticationController::class)->name('login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', LogoutController::class)->name('login');
        });
    });

    // Movies route group
    Route::group(['prefix' => 'movies', 'as' => 'movies.', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [MoviesController::class, 'index'])->name('index');
        Route::get('/favourites', [MoviesController::class, 'favourites']);
        Route::get('/search', [MoviesController::class, 'search']);Route::get('/{movie}', [MoviesController::class, 'show'])->name('show');
        Route::get('/{movie}/trailer', [MoviesController::class, 'showTrailer'])->name('show');
        Route::post('/favourites/{movieId}', [MoviesController::class, 'favourize'])->name('favourites.add');
        Route::delete('/favourites/{movieId}', [MoviesController::class, 'unfavourize'])->name('favourites.remove');
    });
});
