<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\API\DashboardController;

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

route::get('/', DashboardController::class);


// route::get('register', [RegisterController::class, 'create'])->name('register');
// route::post('register', [RegisterController::class, 'store'])->name('register');

// route::get('login', [LoginController::class, 'create'])->name('login');
// route::post('login', [LoginController::class, 'store'])->name('login');
