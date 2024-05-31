<?php

use App\Http\Controllers\AdminMitraController;
use App\Http\Controllers\AdminTadController;
use App\Http\Middleware\CheckRole;
use App\Mail\TransaksiMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

Auth::routes();

// Route::get('test', function () {
//     $email = new TransaksiMail();
//     Mail::to('agung.dni19@gmail.com')->send($email);
//     return "sukses kirim";
// });

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::resource('/kelola-mitra', AdminMitraController::class);
        Route::resource('/kelola-tad', AdminTadController::class);
        Route::resource('/kelola-pegawai', 'PegawaiController');
        Route::resource('/data-transaksi', 'TransaksiController');
    });

    Route::middleware([CheckRole::class . ':pegawai'])->group(function () {
        Route::get('/upload-transaksi', 'TransaksiController@create')->name('upload-transaksi.create');
        Route::post('/upload-transaksi', 'TransaksiController@store')->name('upload-transaksi.store');

        Route::get('/riwayat-transaksi', 'TransaksiController@riwayatIndex')->name('riwayat-transaksi.index');
    });
});