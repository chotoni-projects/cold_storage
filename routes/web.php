<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;

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

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/report', function () {
    return view('report');
})->middleware(['auth'])->name('report');


Route::get('setting', [SettingController::class, 'index'])->middleware(['auth'])->name('setting');
Route::post('store-setting/{id}', [SettingController::class, 'store']);


require __DIR__.'/auth.php';
