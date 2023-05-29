<?php

use App\Http\Controllers\Agency\AgencyApiController;
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

        Route::post('{agency}/add-user/{user}', [AgencyApiController::class, 'addUser'])->name('add-user');
        Route::delete('{agency}/remove-user/{user}', [AgencyApiController::class, 'removeUser'])->name('remove-user');
    });
});
