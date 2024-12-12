<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterApiController;
use App\Http\Controllers\API\LoginApiController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\SuratMasukController;
use App\Http\Controllers\API\ProfileApiController;
use App\Http\Controllers\Api\DisposisiApiController;

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/dashboard', DashboardController::class);
// Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class, 'index']);

Route::get('/dashboard', [App\Http\Controllers\API\DashboardController::class, 'index']);

// Route::post('register', [RegisterApiController::class, 'store'])->name('register');
// Route::post('login', [LoginApiController::class, 'store']);

Route::post('login', [LoginApiController::class, 'login']);
Route::post('register', [RegisterApiController::class, 'store']);
// Route::get('profiles/me', [ProfileApiController::class, 'me'])->middleware('auth:sanctum');
// Route::middleware('auth:api')->get('/profiles', [ProfileApiController::class, 'show']);


Route::apiResource('surat_masuks', SuratMasukController::class);
Route::get('surat_masuks', [SuratMasukController::class, 'index']);             // Untuk mendapatkan semua surat masuk
Route::get('surat_masuks/{id}', [SuratMasukController::class, 'show']);         // Untuk mendapatkan surat masuk berdasarkan ID
Route::post('surat_masuks', [SuratMasukController::class, 'store']);            // Untuk menambah surat masuk
Route::post('surat_masuks/{id}', [SuratMasukController::class, 'update']);      // Untuk memperbarui surat masuk
Route::delete('surat_masuks/{id}', [SuratMasukController::class, 'destroy']);   // Untuk menghapus surat masuk
Route::patch('/surat_masuks/{id}', [SuratMasukController::class, 'updateStatus']);

// Route::post('/surat_masuks/simpan_status', [SuratMasukController::class, 'simpanStatus']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route untuk profile API
// Route::middleware('auth:sanctum')->group(function () {
Route::get('profiles', [ProfileApiController::class, 'index']);                 // Mendapatkan semua profil
Route::get('profiles/{userId}', [ProfileApiController::class, 'show']);         // Mendapatkan profil berdasarkan user ID
Route::post('profiles', [ProfileApiController::class, 'store']);                // Menambah profil baru
Route::put('profiles/{userId}', [ProfileApiController::class, 'update']);       // Memperbarui profil
Route::delete('profiles/{userId}', [ProfileApiController::class, 'destroy']);   // Menghapus profil
// });


Route::get('disposisis', [DisposisiApiController::class, 'index']);             // Mendapatkan semua disposisi
Route::get('disposisis/{id}', [DisposisiApiController::class, 'show']);         // Mendapatkan disposisi berdasarkan ID
Route::post('disposisis', [DisposisiApiController::class, 'store']);            // Menambahkan disposisi baru
Route::post('disposisis/{id}', [DisposisiApiController::class, 'update']);      // Memperbarui disposisi berdasarkan ID
Route::delete('disposisis/{id}', [DisposisiApiController::class, 'destroy']);   // Menghapus disposisi berdasarkan ID
