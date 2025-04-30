<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\AdminController;

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
    return view('welcome');
});

// HomeController.php

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/penerimaansurat', [HomeController::class, 'penerimaansurat'])->name('admin.surat');
    Route::get('/admin/pengelolaanakun', [HomeController::class, 'pengelolaanakun'])->name('admin.akun');
    Route::patch('/admin/akun/{user}/activate', [LoginController::class, 'activate'])->name('admin.akun.activate');

    // Route untuk surat
    Route::get('/surat', [App\Http\Controllers\Admin\SuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/{id}', [App\Http\Controllers\Admin\SuratController::class, 'show'])->name('surat.show');
    Route::get('/surat/{id}/approve', [App\Http\Controllers\Admin\SuratController::class, 'approve'])->name('surat.approve');
    Route::post('/surat/{id}/reject', [App\Http\Controllers\Admin\SuratController::class, 'reject'])->name('surat.reject');
    Route::get('/surat/{id}/download', [App\Http\Controllers\Admin\SuratController::class, 'download'])->name('surat.download');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/berita', [HomeController::class, 'beritauser'])->name('user.berita');
    Route::get('/user/faq', [HomeController::class, 'userfaq'])->name('user.faq');
    Route::get('/user/pengajuansurat', [HomeController::class, 'userpengajuansurat'])->name('user.pengajuansurat');
    Route::get('/user/profile', [HomeController::class, 'userprofile'])->name('user.profile');
    Route::get('/user/riwayatsurat', [SuratController::class, 'riwayat'])->name('user.riwayatsurat');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login/success', [LoginController::class, 'authenticate'])->name('login.success');
    Route::get('/', [LoginController::class,'halamanutama'])->name('index');
    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/register/success', [LoginController::class, 'registersuccess'])->name('register.success');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/surat/create', [SuratController::class, 'create'])->name('create.surat');
    Route::post('/surat/store', [SuratController::class, 'store'])->name('store.surat');
    Route::get('/surat/download/{id}', [SuratController::class, 'download'])->name('download.surat');
    Route::delete('/surat/delete/{id}', [SuratController::class, 'destroy'])->name('delete.surat');
});

Route::get('/word', [WordController::class, 'index'])->name('word');

Route::post('/createsurat', [SuratController::class, 'store'])->name('create.surat');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Surat
    Route::get('/surat', [AdminController::class, 'surat'])->name('surat');
    Route::get('/surat/{surat}', [App\Http\Controllers\Admin\SuratController::class, 'show'])->name('surat.show');
    Route::post('/surat/{surat}/approve', [App\Http\Controllers\Admin\SuratController::class, 'approve'])->name('surat.approve');
    Route::post('/surat/{surat}/reject', [App\Http\Controllers\Admin\SuratController::class, 'reject'])->name('surat.reject');
    Route::get('/surat/{surat}/print', [App\Http\Controllers\Admin\SuratController::class, 'print'])->name('surat.print');
    
    // Akun
    Route::get('/pengelolaanakun', [HomeController::class, 'pengelolaanakun'])->name('akun');
    Route::patch('/akun/{user}/activate', [LoginController::class, 'activate'])->name('akun.activate');

    // Berita
    Route::resource('berita', App\Http\Controllers\Admin\BeritaController::class);
});

// User Routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/berita', [App\Http\Controllers\User\BeritaController::class, 'index'])->name('berita');
});



