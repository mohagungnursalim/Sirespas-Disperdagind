<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PasarController;
use App\Http\Controllers\RetribusiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// _________________Login Views_______________
Route::redirect('/', '/login');



// ________________Dashboard admin & Operator__________________
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/dashboard/profile', [ProfileController::class, 'index']);
    Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/dashboard/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/dashboard/retribusi', RetribusiController::class)->middleware('auth');
Route::get('/export-retribusi',[RetribusiController::class , 'export'])->middleware('auth')->name('export.retribusi');

Route::resource('/dashboard/pasar', PasarController::class)->middleware('auth');
Route::resource('/dashboard/buat-akun', UserController::class)->middleware('admin','auth');

// settings app resource
Route::resource('/dashboard/setting-app', SettingController::class)->middleware('auth');

Route::put('/dashboard/setting-app/updatetext/{setting:id}' ,[SettingController::class, 'updatetext'])->middleware('auth')->name('update-text');
Route::put('/dashboard/setting-app/updatecopyright/{setting:id}' ,[SettingController::class, 'updatecopyright'])->middleware('auth')->name('update-copyright');

require __DIR__.'/auth.php';
