<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Auth\AuthController;
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
    Route::post('register', [AccountController::class, 'store'])->withoutMiddleware(['auth']);
    Route::patch('updateAccount/{uuid}', [AccountController::class, 'update']);
    Route::delete('deleteAccount/{uuid}', [AccountController::class, 'destroy']);

    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh'])->withoutMiddleware(['auth']);
    Route::get('me', [AuthController::class, 'me']);
});
Route::apiResource('account/company', \App\Http\Controllers\Account\AccountCompanyController::class);
Route::get('test', function () {
    return view('emails.create-company');
});