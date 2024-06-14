<?php

use App\Http\Controllers\AcaraController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ReportController;
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

// Route::get('/', function () {
//     return view('landing_page.index');
// });

Route::get('/landing/search',[HomeController::class, 'ajaxSearch'])->name('landing.ajaxSearch');


// Route::get('/tes', function () {
//     return view('auth.login');
// });
Route::get('/', [HomeController::class, 'index'])->name('landing');

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'postLogin'])->name('post.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//CONTCT
Route::get('/hubungi-kami', [HomeController::class, 'contact'])->name('contact');


//KONFIRMASI PESERTA
Route::post('konfirmasi/acara', [HomeController::class, 'konfirmasiPeserta'])->name('konfirmasi.peserta');

//CETAK TIKET
Route::get('peserta/kartu-peserta', [HomeController::class, 'indexKartuPeserta'])->name('get.kartu.peserta');
Route::post('peserta/kartu-peserta/cek', [HomeController::class, 'cekKartuPeserta'])->name('cek.kartu.peserta');
Route::get('peserta/kartu-peserta/unduh/{uuid}', [HomeController::class, 'unduhKartuPeserta'])->name('unduh.kartu.peserta');



Route::group(['middleware' => ['auth', 'checkRole:ADMIN']], function () {
    Route::get('/acara/datatable', [AcaraController::class, 'datatable'])->name('acara.datatable');
    Route::get('/acara', [AcaraController::class, 'index'])->name('acara.index');
    Route::get('/acara/create', [AcaraController::class, 'create'])->name('acara.create');
    Route::post('/acara/store', [AcaraController::class, 'store'])->name('acara.store');
    Route::get('/acara/edit/{id}', [AcaraController::class, 'edit'])->name('acara.edit');
    Route::put('/acara/update/{id}', [AcaraController::class, 'update'])->name('acara.update');
    Route::delete('/acara/destroy/{id}', [AcaraController::class, 'destroy'])->name('acara.destroy');

    //REPORT
    Route::get('/report/acara', [ReportController::class, 'index'])->name('get.halaman.report');
    Route::post('/report/acara/cek', [ReportController::class, 'cekReport'])->name('cek.report');
    Route::get('/report/acara/pdf/{uuid}', [ReportController::class, 'pdfReport'])->name('pdf.report');

    //QRCODE
    Route::get('/scan_qrcode', [QrCodeController::class, 'scan_qr'])->name('scan-qr');
    Route::post('/validasi_qrcode', [QrCodeController::class, 'validasi_qr'])->name('validasi-qr');
});
