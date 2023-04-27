<?php

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

Route::get('/', function () {
    return view('pages.app');
});


Route::prefix('form')->group(function () {
    Route::match(['GET', 'POST'], '/', [BaseController::class, 'form']);
});

Route::get('/pembayaran/{participantId}', [BaseController::class, 'pembayaran']);
Route::post('/upload-bukti-pembayaran', [BaseController::class, 'buktiPembayaran']);

Route::get('daftar-peserta', [BaseController::class, 'daftarPeserta']);
