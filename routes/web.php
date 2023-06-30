<?php

use App\Http\Controllers\Agency\AgencyViewController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Role\RoleViewController;
use App\Http\Controllers\User\UserViewController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', static function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', static function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::group([
        'prefix' => 'agencies',
        'as' => 'agencies.'
    ], static function () {
        Route::get('/', [AgencyViewController::class, 'index'])->name('index');
        Route::get('/create', [AgencyViewController::class, 'create'])->name('create');
        Route::post('/', [AgencyViewController::class, 'store'])->name('store');
        Route::get('/{agency?}', [AgencyViewController::class, 'details'])->name('details');
        Route::put('/{agency}', [AgencyViewController::class, 'update'])->name('update');
        Route::delete('/{agency}', [AgencyViewController::class, 'destroy'])->name('destroy');
    });

    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
    ], static function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::group([
        'prefix' => 'users',
        'as' => 'users.',
    ], static function () {
        Route::get('/', [UserViewController::class, 'index'])->name('index');
        Route::get('/create', [UserViewController::class, 'create'])->name('create');
        Route::post('/', [UserViewController::class, 'store'])->name('store');
        Route::get('/{user?}', [UserViewController::class, 'details'])->name('details');
        Route::put('/{user}', [UserViewController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserViewController::class, 'destroy'])->name('destroy');
    });

    Route::group([
        'prefix' => 'roles',
        'as' => 'roles.',
    ], static function () {
        Route::get('/', [RoleViewController::class, 'index'])->name('index');
        Route::get('/create', [RoleViewController::class, 'create'])->name('create');
        Route::post('/', [RoleViewController::class, 'store'])->name('store');
        Route::get('/{role?}', [RoleViewController::class, 'details'])->name('details');
        Route::put('/{role}', [RoleViewController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleViewController::class, 'destroy'])->name('destroy');
    });

});

require __DIR__ . '/auth.php';
