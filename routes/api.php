<?php

use App\Http\Controllers\Agency\AgencyApiController;
use App\Http\Controllers\Role\RoleApiController;
use App\Http\Controllers\User\UserApiController;
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

Route::middleware('auth:sanctum')->group(static function () {

    Route::get('/user', static function (Request $request) {
        return $request->user();
    });


    Route::group([
        'prefix' => 'agencies',
        'as' => 'agencies.'
    ], static function () {
        Route::get('{agency}/users', [AgencyApiController::class, 'users'])->name('users');
        Route::post('{agency}/add-user/{user}', [AgencyApiController::class, 'addUser'])->name('add-user');
        Route::delete('{agency}/remove-user/{user}', [AgencyApiController::class, 'removeUser'])->name('remove-user');
        Route::delete('delete', [AgencyApiController::class, 'delete'])->name('delete');
        Route::delete('delete/multiple', [AgencyApiController::class, 'deleteMultiple'])->name('delete-multiple');
    });

    Route::group([
        'prefix' => 'users',
        'as' => 'users.'
    ], static function () {
        Route::get('{user}/roles', [UserApiController::class, 'roles'])->name('roles');
        Route::post('{user}/add-role/{role}', [UserApiController::class, 'addRole'])->name('add-role');
        Route::delete('{user}/remove-role/{role}', [UserApiController::class, 'removeRole'])->name('remove-role');
        Route::post('{user}/add-permission/{permission}', [UserApiController::class, 'addPermission'])->name('add-permission');
        Route::delete('{user}/remove-permission/{permission}', [UserApiController::class, 'removePermission'])->name('remove-permission');
    });

    Route::group([
        'prefix' => 'roles',
        'as' => 'roles.'
    ], static function () {
        Route::get('{role}/permissions', [RoleApiController::class, 'permissions'])->name('permissions');
        Route::post('{role}/add-permission/{permission}', [RoleApiController::class, 'addPermission'])->name('add-permission');
        Route::delete('{role}/remove-permission/{permission}', [RoleApiController::class, 'removePermission'])->name('remove-permission');
    });
});
