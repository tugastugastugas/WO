<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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
    return view('welcome');
});

Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/data', [Controller::class, 'data']);
Route::get('/input_alamat', [Controller::class, 'input_alamat'])->name('input_alamat');
Route::get('/quiz', [Controller::class, 'quiz'])->name('quiz');
Route::post('/input', [Controller::class, 'store'])->name('quiz.store');
Route::post('/input-lokasi', [Controller::class, 'SimpanLokasi'])->name('input.lokasi');
Route::get('/login', [Controller::class, 'login'])->name('login');
Route::post('/aksi_login', [Controller::class, 'aksi_login'])->name('aksi_login');
Route::get('/logout', [Controller::class, 'logout'])->name('logout');
Route::delete('/lokasi/{id}', [Controller::class, 'destroy'])->name('lokasi.destroy');
Route::get('/register', [Controller::class, 'register'])->name('register');
Route::post('/tambah_akun', [Controller::class, 'tambah_akun'])->name('tambah_akun');
Route::get('/user', [Controller::class, 'user'])->name('user');
Route::post('/t_user', [Controller::class, 't_user'])->name('t_user');
Route::post('/t_murid', [Controller::class, 't_murid'])->name('t_murid');
// Route::delete('/user/{id}', [Controller::class, 'user_destroy'])->name('user.destroy');
Route::post('/user/reset-password/{id}', [Controller::class, 'resetPassword'])->name('user.resetPassword');
// Route::get('/user/detail/{id}', [Controller::class, 'detail'])->name('detail');
Route::post('/user/update', [Controller::class, 'updateDetail'])->name('update.user');
Route::get('/restore_e', [Controller::class, 'restore_e'])->name('restore_e');
Route::delete('/lokasi_backup/{id}', [Controller::class, 'lokasi_backup_destroy'])->name('lokasi_backup.destroy');
Route::post('/lokasi_backup/restore/{id}', [Controller::class, 'restore'])->name('lokasi_backup.restore');
Route::post('/user/restoreUser/{id}', [Controller::class, 'restoreUser'])->name('restoreUser');
Route::get('/restore_d', [Controller::class, 'restore_d'])->name('restore_d');


Route::delete('/user/{id}', [Controller::class, 'user_destroy'])->name('user.destroy');
Route::get('/user/detail/{id}', [Controller::class, 'detail'])->name('detail');
