<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\MainController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FullTestController;
use Inertia\Inertia;


Route::get('/fetch/{count?}', function ($count = null) {
    Artisan::call('records:fetch-comments', [
        'count' => $count, 
    ]);

    return response(nl2br(e(Artisan::output())));
});

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

// Route::get('/', function () {
//     return Inertia::render('Admin/home');
// })->name('index');


Route::middleware('auth')->group(function () {
});


Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('adminLoginShow');
    Route::post('/login', [AdminAuthController::class, 'adminLoginForm'])->name('adminLoginForm');
});
Route::get('/', [MainController::class, 'index'])->name('main');
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
Route::get('/user', [AdminAuthController::class, 'getUser'])->name('user');
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/records', function () {
        return Inertia::render('Admin/Records/Index');
    })->name('admin.records.index');
});
