<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\SenderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\DashboardKaryawanController;

// Route untuk menghubungkan ke storage public
Route::get('/storage-link', function () { 
    $targetFolder = base_path().'/storage/app/public'; 
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage'; 
    symlink($targetFolder, $linkFolder); 
});

// Route untuk membersihkan cache
Route::get('/clear-cache', function () {
    Artisan::call('route:cache');
});

// Route utama, untuk login
Route::get('/', [LoginController::class, 'index']);

// Autentikasi
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('karyawan')
    ->middleware(['auth', 'role:karyawan']) // hanya bisa diakses oleh karyawan
    ->group(function() {
        Route::get('/dashboard', [DashboardKaryawanController::class, 'index'])->name('karyawan-dashboard');
    });

// Grup Route untuk Admin
Route::prefix('admin')
    ->middleware(['auth', 'role:admin']) // Pastikan hanya admin yang bisa mengakses
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');
        
        // Route Department
        Route::resource('/department', DepartmentController::class);

        // Route Sender
        Route::resource('/sender', SenderController::class);

        // Route untuk Surat (Letter)
        Route::resource('/letter', LetterController::class, [
            'except' => ['show'] // Menghindari resource 'show' di letter
        ]);

        // Route untuk Surat Masuk dan Surat Keluar
        Route::get('letter/surat-masuk', [LetterController::class, 'incoming_mail'])->name('surat-masuk');
        Route::get('letter/surat-keluar', [LetterController::class, 'outgoing_mail'])->name('surat-keluar');

        // Route untuk Detail Surat
        Route::get('letter/surat/{id}', [LetterController::class, 'show'])->name('detail-surat');
        
        // Route untuk Download Surat
        Route::get('letter/download/{id}', [LetterController::class, 'download_letter'])->name('download-surat');

        // Route Print untuk Surat Masuk dan Surat Keluar
        Route::get('print/surat-masuk', [PrintController::class, 'index'])->name('print-surat-masuk');
        Route::get('print/surat-keluar', [PrintController::class, 'outgoing'])->name('print-surat-keluar');

        // Route User Management
        Route::resource('user', UserController::class);

        // Route Setting
        Route::resource('setting', SettingController::class, [
            'except' => ['show'] // Menghindari resource 'show' di setting
        ]);

        // Route untuk Mengubah Password
        Route::get('setting/password', [SettingController::class, 'change_password'])->name('change-password');
        Route::post('setting/upload-profile', [SettingController::class, 'upload_profile'])->name('profile-upload');
        Route::post('change-password', [SettingController::class, 'update_password'])->name('update.password');
    });
