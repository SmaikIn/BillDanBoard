<?php

use App\Http\Controllers\Account\AccountCompanyDepartmentController;
use App\Http\Controllers\Account\AccountCompanyProfileController;
use App\Http\Controllers\Account\AccountCompanyRoleController;
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
Route::group(['prefix' => 'account', 'middleware' => 'auth'], function () {
    Route::apiResource('companies', \App\Http\Controllers\Account\AccountCompanyController::class);
    Route::group(['prefix' => 'company'], function () {
        Route::apiResource('{companyId}/roles', AccountCompanyRoleController::class);
        Route::apiResource('{companyId}/departments', AccountCompanyDepartmentController::class);
        Route::apiResource('{companyId}/profiles', AccountCompanyProfileController::class)->except(['create']);
        Route::post('{companyId}/profiles/invite/{profile}', [AccountCompanyProfileController::class, 'inviteUserToCompany']);
        Route::post('{companyId}/profiles/ban', [AccountCompanyProfileController::class, 'banUser']);
    });
});

Route::get('test', function () {
    return view('emails.create-company');
});