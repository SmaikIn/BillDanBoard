<?php

use App\Http\Controllers\Account\AccountCompanyController;
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
Route::get('/qwerty', function () {
    return response()->json(['message' => 'API is working level2']);
});
Route::get('/abc/qwerty', function () {
    return response()->json(['message' => 'API is working level3']);
});
Route::group(['prefix' => 'auth', 'middleware' => 'auth'], function () {
    Route::post('register', [AccountController::class, 'store'])->withoutMiddleware(['auth'])->name('register');
    Route::patch('updateAccount/{uuid}', [AccountController::class, 'update']);
    Route::delete('deleteAccount/{uuid}', [AccountController::class, 'destroy']);

    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware(['auth'])->name('login');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh'])->withoutMiddleware(['auth']);
    Route::get('me', [AuthController::class, 'me']);

    Route::post('/resetPassword', [AccountController::class, 'resetUserPassword'])->name('auth.reset.password');
    Route::post('/forgetPassword', [AuthController::class, 'forgotPassword'])->name('auth.forgot.password');
});
Route::group(['prefix' => 'account', 'middleware' => 'auth'], function () {
    Route::get('/companies', [AccountCompanyController::class, 'index']);
    Route::post('/companies', [AccountCompanyController::class, 'store']);
    Route::get('/companies/{companyId}', [AccountCompanyController::class, 'show'])->middleware('user-company');
    Route::put('/companies/{companyId}', [AccountCompanyController::class, 'update'])->middleware('user-company');
    Route::patch('/companies/{companyId}', [AccountCompanyController::class, 'update'])->middleware('user-company');
    Route::delete('/companies/{companyId}', [AccountCompanyController::class, 'destroy'])->middleware('user-company');
    Route::group(['prefix' => 'company', 'middleware' => 'user-company'], function () {
        Route::get('{companyId}/roles/{roleId}/permissions',
            [AccountCompanyRoleController::class, 'getRolePermission']);
        Route::apiResource('{companyId}/roles', AccountCompanyRoleController::class);
        Route::apiResource('{companyId}/departments', AccountCompanyDepartmentController::class);
        Route::post('{companyId}/profiles/accept/{code}',
            [AccountCompanyProfileController::class, 'acceptUserToCompany'])->withoutMiddleware('auth');
        Route::post('{companyId}/profiles/invite', [AccountCompanyProfileController::class, 'inviteUserToCompany']);
        Route::post('{companyId}/profiles/ban', [AccountCompanyProfileController::class, 'banProfile']);
        Route::apiResource('{companyId}/profiles', AccountCompanyProfileController::class)->except(['store']);
    });
});