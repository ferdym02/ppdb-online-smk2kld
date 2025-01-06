<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AptitudeTestController;
use App\Http\Controllers\SchoolProfileController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PeriodeJurusanController;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'userLoginForm'])->name('user.login');
Route::post('/login', [AuthController::class, 'userLogin']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password-act', [AuthController::class, 'sendResetLink'])->name('forgot.password.act');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/admin/login', [AuthController::class, 'adminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
        Route::post('/admin/profile', [AdminController::class, 'adminUpdate'])->name('admin.profile.update');
        Route::resource('/admin/users', UserController::class);
        // middleware superadmin
        Route::middleware(['superadmin'])->group(function () {
            Route::resource('/admin/admins', AdminController::class);
            Route::get('/admins-data', [DataTableController::class, 'getAdminsData'])->name('admins.data');
        });
        Route::get('/users-data', [DataTableController::class, 'getUsersData'])->name('users.data');
        Route::resource('/admin/jurusan', JurusanController::class);
        Route::get('/jurusan-data', [DataTableController::class, 'getJurusanData'])->name('jurusan.data');
        Route::get('/admin/pendaftar', [PendaftaranController::class, 'index'])->name('admin.pendaftar.index');
        Route::get('/admin/pendaftar/status/{status}/data', [DataTableController::class, 'getPendaftarByStatus'])->name('pendaftar.status.data');
        Route::get('/admin/pendaftar/status/{status}', [PendaftaranController::class, 'indexByStatus'])->name('pendaftar.status');
        Route::get('/admin/pendaftar/{id}', [PendaftaranController::class, 'show'])->name('admin.pendaftar.show');
        Route::get('/admin/pendaftar/{id}/edit', [PendaftaranController::class, 'edit'])->name('pendaftar.edit');
        Route::put('/admin/pendaftar/{id}', [PendaftaranController::class, 'update'])->name('pendaftar.update');
        Route::delete('/admin/pendaftar/{id}', [PendaftaranController::class, 'destroy'])->name('pendaftar.destroy');
        Route::post('/admin/pendaftar/{id}/verifikasi', [PendaftaranController::class, 'verifikasi'])->name('pendaftar.verifikasi');
        Route::post('/pendaftar/{id}/update-daftar-ulang', [PendaftaranController::class, 'updateDaftarUlang'])->name('pendaftar.updateDaftarUlang');
        Route::post('/pendaftar/{id}/update-status', [PendaftaranController::class, 'updateStatus'])->name('pendaftar.updateStatus');
        Route::resource('/admin/periodes', PeriodeController::class);
        Route::resource('/admin/jadwals', JadwalController::class);
        Route::get('/periodes-data', [PeriodeController::class, 'getPeriodeData'])->name('periodes.data');
        Route::resource('/admin/aptitudes', AptitudeTestController::class);
        Route::get('/aptitude-data', [AptitudeTestController::class, 'getAptitudeTestsData'])->name('aptitude_tests.data');
        Route::post('/admin/pendaftar/{id}/update-nilai-tes', [PendaftaranController::class, 'updateNilaiTes'])->name('pendaftar.updateNilaiTes');
        Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/admin/laporan/getData', [LaporanController::class, 'getData'])->name('laporan.getData');
        Route::get('/admin/laporan/pdf', [LaporanController::class, 'generatePDF'])->name('laporan.pdf');
        Route::get('/admin/laporan/word', [LaporanController::class, 'generateWord'])->name('laporan.word');
        Route::get('/admin/laporan/excel', [LaporanController::class, 'generateExcel'])->name('laporan.excel');
        Route::get('/admin/laporan/word-diterima', [LaporanController::class, 'generateWordDiterima'])->name('laporan.wordDiterima');
        Route::get('/admin/laporan/pdf-diterima', [LaporanController::class, 'generatePdfDiterima'])->name('laporan.pdfDiterima');
        Route::get('/admin/laporan/excel-diterima', [LaporanController::class, 'generateExcelDiterima'])->name('laporan.excelDiterima');
        Route::resource('/admin/pengumuman', PengumumanController::class);
        Route::get('/pengumuman-data', [PengumumanController::class, 'getPengumumanData'])->name('pengumuman.data');
        Route::get('/admin/school-profile', [SchoolProfileController::class, 'create'])->name('school-profile.create');
        Route::post('/admin/school-profile', [SchoolProfileController::class, 'store'])->name('school-profile.store');
        Route::get('/admin/pendaftar/{id}/cetak-bukti', [PendaftaranController::class, 'cetakBukti'])->name('admin.cetakBukti');
        Route::resource('/admin/periode-jurusan', PeriodeJurusanController::class);
    });

    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
        Route::put('/user/update-password',[UserController::class, 'updatePassword'])->name('user.update.password');
        Route::get('/user/pendaftaran', [PendaftaranController::class, 'create'])->name('user.pendaftaran');
        Route::get('/user/pendaftaran/{id}/edit', [PendaftaranController::class, 'editPendaftaran'])->name('pendaftaran.edit');
        Route::put('/user/pendaftaran/{id}', [PendaftaranController::class, 'updatePendaftaran'])->name('pendaftaran.update');
        Route::get('/user/pengumuman', [PengumumanController::class, 'pengumumanUser'])->name('pengumuman');
        Route::get('/user/status', function () {
            return view('/user/status');
        })->name('status');
        Route::post('/user/pendaftaran', [PendaftaranController::class, 'store']);
        Route::get('/user/pendaftaran/{id}/cetak-bukti', [PendaftaranController::class, 'cetakBukti'])->name('pendaftar.cetakBukti');
    });
});
