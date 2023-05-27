<?php

use App\Http\Controllers\Agency\AgencyViewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', static function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
    ], static function() {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::group([
        'prefix' => 'agencies',
        'as' => 'agencies.'
    ], static function() {
        Route::get('/', [AgencyViewController::class, 'index'])->name('index');
        Route::get('/create', [AgencyViewController::class, 'create'])->name('create');
        Route::post('/', [AgencyViewController::class, 'store'])->name('store');
        Route::get('/{agency}', [AgencyViewController::class, 'show'])->name('show');
        Route::get('/{agency}/edit', [AgencyViewController::class, 'edit'])->name('edit');
        Route::put('/{agency}', [AgencyViewController::class, 'update'])->name('update');
        Route::delete('/{agency}', [AgencyViewController::class, 'destroy'])->name('destroy');
    });

});

require __DIR__.'/auth.php';
