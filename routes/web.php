<?php

use App\Http\Controllers\Address\AddressViewController;
use App\Http\Controllers\Agency\AgencyViewController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Company\CompanyViewController;
use App\Http\Controllers\Role\RoleViewController;
use App\Http\Controllers\User\UserViewController;
use App\Http\Controllers\Warehouse\WarehouseViewController;
use App\Mail\ContactSubmitted;
use Illuminate\Http\Request;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Mail;
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

Route::post('/contact', static function (Request $request) {

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|',
        'message' => 'required|min:10|max:1000|',
        'send_me' => 'required|bool|',
    ]);

    Mail::to(config('mail.from.address'))
        ->when($validated['send_me'], fn(PendingMail $mail) => $mail->cc($validated['email']))
        ->send(new ContactSubmitted($validated));

    return back();

})->name('contact');

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
        'prefix' => 'companies',
        'as' => 'companies.'
    ], static function () {
        Route::get('/', [CompanyViewController::class, 'index'])->name('index');
        Route::get('/create', [CompanyViewController::class, 'create'])->name('create');
        Route::post('/', [CompanyViewController::class, 'store'])->name('store');
        Route::get('/{company?}', [CompanyViewController::class, 'details'])->name('details');
        Route::put('/{company}', [CompanyViewController::class, 'update'])->name('update');
        Route::delete('/{company}', [CompanyViewController::class, 'destroy'])->name('destroy');
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
        Route::get('/switch/closet/{id}', [UserViewController::class, 'switchCloset'])->name('switch_closet');
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

    Route::group([
        'prefix' => 'address',
        'as' => 'address.',
    ], static function () {
        Route::post('/', [AddressViewController::class, 'store'])->name('store');
        Route::put('/{address}', [AddressViewController::class, 'update'])->name('update');
    });

    Route::group([
        'prefix' => 'warehouses',
        'as' => 'warehouses.'
    ], static function () {
        Route::get('/', [WarehouseViewController::class, 'index'])->name('index');
        Route::get('/create', [WarehouseViewController::class, 'create'])->name('create');
        Route::post('/', [WarehouseViewController::class, 'store'])->name('store');
        Route::get('/{warehouse?}', [WarehouseViewController::class, 'details'])->name('details');
        Route::put('/{warehouse}', [WarehouseViewController::class, 'update'])->name('update');
        Route::delete('/{warehouse}', [WarehouseViewController::class, 'destroy'])->name('destroy');
    });

});

require __DIR__ . '/auth.php';
