<?php

use App\Http\Controllers\Agency\AgencyApiController;
use App\Http\Controllers\Closet\ClosetApiController;
use App\Http\Controllers\Company\CompanyApiController;
use App\Http\Controllers\Product\ProductApiController;
use App\Http\Controllers\Role\RoleApiController;
use App\Http\Controllers\StockMove\StockMoveApiController;
use App\Http\Controllers\User\UserApiController;
use App\Http\Controllers\Variant\VariantApiController;
use App\Http\Controllers\Warehouse\WarehouseApiController;
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
        'prefix' => 'companies',
        'as' => 'companies.'
    ], static function () {
        Route::get('{company}/users', [CompanyApiController::class, 'users'])->name('users');
        Route::post('{company}/add-user/{user}', [CompanyApiController::class, 'addUser'])->name('add-user');
        Route::delete('{company}/remove-user/{user}', [CompanyApiController::class, 'removeUser'])->name('remove-user');
        Route::delete('delete', [CompanyApiController::class, 'delete'])->name('delete');
        Route::delete('delete/multiple', [CompanyApiController::class, 'deleteMultiple'])->name('delete-multiple');
    });

    Route::group([
        'prefix' => 'users',
        'as' => 'users.'
    ], static function () {
        Route::get('{user}/roles', [UserApiController::class, 'roles'])->name('roles');
        Route::post('{user}/assign-role/{role}', [UserApiController::class, 'assignRole'])->name('assign-role');
        Route::delete('{user}/remove-role/{role}', [UserApiController::class, 'removeRole'])->name('remove-role');
        Route::post('{user}/give-permission/{permission}', [UserApiController::class, 'givePermission'])->name('give-permission');
        Route::delete('{user}/remove-permission/{permission}', [UserApiController::class, 'removePermission'])->name('remove-permission');
        Route::delete('delete', [UserApiController::class, 'delete'])->name('delete');
        Route::delete('delete/multiple', [UserApiController::class, 'deleteMultiple'])->name('delete-multiple');
    });

    Route::group([
        'prefix' => 'roles',
        'as' => 'roles.'
    ], static function () {
        Route::get('{role}/permissions', [RoleApiController::class, 'permissions'])->name('permissions');
        Route::post('{role}/give-permission/{permission}', [RoleApiController::class, 'givePermission'])->name('give-permission');
        Route::delete('{role}/remove-permission/{permission}', [RoleApiController::class, 'removePermission'])->name('remove-permission');
    });

    Route::group([
        'prefix' => 'warehouses',
        'as' => 'warehouses.'
    ], static function () {
        Route::get('{warehouse}/countries', [WarehouseApiController::class, 'countries'])->name('countries');
        Route::post('{warehouse}/add-country/{country}', [WarehouseApiController::class, 'addCountry'])->name('add-country');
        Route::delete('{warehouse}/remove-country/{country}', [WarehouseApiController::class, 'removeCountry'])->name('remove-country');
        Route::delete('delete', [WarehouseApiController::class, 'delete'])->name('delete');
        Route::delete('delete/multiple', [WarehouseApiController::class, 'deleteMultiple'])->name('delete-multiple');
    });

    Route::group([
        'prefix' => 'closets',
        'as' => 'closets.'
    ], static function () {
        Route::get('{closet}/users', [ClosetApiController::class, 'users'])->name('users');
        Route::post('{closet}/add-user/{user}', [ClosetApiController::class, 'addUser'])->name('add-user');
        Route::delete('{closet}/remove-user/{user}', [ClosetApiController::class, 'removeUser'])->name('remove-user');
        Route::delete('delete', [ClosetApiController::class, 'delete'])->name('delete');
        Route::delete('delete/multiple', [ClosetApiController::class, 'deleteMultiple'])->name('delete-multiple');
    });

    Route::group([
        'prefix' => 'products',
        'as' => 'products.'
    ], static function () {
        Route::delete('delete', [ProductApiController::class, 'delete'])->name('delete');
        Route::delete('delete/multiple', [ProductApiController::class, 'deleteMultiple'])->name('delete-multiple');
    });

    Route::group([
        'prefix' => 'variants',
        'as' => 'variants.'
    ], static function () {
        Route::delete('delete', [VariantApiController::class, 'delete'])->name('delete');
        Route::delete('delete/multiple', [VariantApiController::class, 'deleteMultiple'])->name('delete-multiple');
    });

    Route::group([
        'prefix' => 'stock_moves',
        'as' => 'stock_moves.'
    ], static function () {
        Route::delete('delete', [StockMoveApiController::class, 'delete'])->name('delete');
        Route::delete('delete/multiple', [StockMoveApiController::class, 'deleteMultiple'])->name('delete-multiple');
        Route::post('process/{stock_move}/{action}', [StockMoveApiController::class, 'process'])->name('process');
    });
});
