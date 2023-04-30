<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BaseController;
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

Route::get('/', [BaseController::class, 'index']);
Route::get('/peraturan', [BaseController::class, 'peraturan']);
Route::get('/hasil-lomba', [BaseController::class, 'hasilLomba']);

Route::prefix('form')->group(function () {
    Route::match(['GET', 'POST'], '/', [BaseController::class, 'form']);
});

Route::get('/pembayaran/{participantId}', [BaseController::class, 'pembayaran']);
Route::post('/upload-bukti-pembayaran', [BaseController::class, 'buktiPembayaran']);

Route::get('daftar-peserta', [BaseController::class, 'daftarPeserta']);

Route::post('post-login', [AdminController::class, 'postLogin']);




Route::prefix('/')->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->middleware('admin.auth');
        Route::get('login', function () {
            return view('admin.login');
        });
        Route::get('logout', [AdminController::class, 'logout']);
    });

    Route::post('upload-pengumuman', [AdminController::class, 'uploadPengumuman']);
    Route::post('upload-pemenang', [AdminController::class, 'uploadPemenang']);
    Route::get('table', [AdminController::class, 'table']);
    Route::get('load-table', [AdminController::class, 'loadTable']);

    Route::post('detail', [AdminController::class, 'getDetail'])->name('participant.detail');
    Route::post('konfirmasi-pembayaran', [AdminController::class, 'konfirmasiPembayaran']);
    Route::get('konfirmasi-pembayaran-get/{participantId}', [AdminController::class, 'konfirmasiPembayaranGet']);
    Route::delete('/delete-participant/{participantId}', [AdminController::class, 'deleteParticipant']);
    Route::get('announcement', function () {
        return view('admin.pengumuman', [
            'active' => 'pengumuman'
        ]);
    });
    Route::get('champion', function () {
        return view('admin.juara', [
            'active' => 'juara'
        ]);
    });
});
