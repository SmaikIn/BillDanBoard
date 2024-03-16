<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'auth', 'middleware' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh'])->withoutMiddleware(['auth']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group(['prefix' => 'account', 'middleware' => 'auth'], function () {
});
Route::get('/test', function () {
    return "<img src='".asset('avatar.svg')."' alt='Avatar'>";

    return 'Даня говно API моё работает';
});
Route::get('yandex/callback', function () {
    return 'Даня говно API моё работает';
});

