<?php

use App\Models\Report;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ComparisonController;

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

Route::get('/', [ReportController::class, 'index'])->name('index');

Route::get('/reports/test', function () {
    return view('test_graph');
});

Route::get('/ataskaitos/{report}/3d', [ReportController::class, 'show3D']);

Route::get('/ataskaitos/palyginti', [ComparisonController::class, 'compare']);

Route::post('/ataskaitos/palyginti', [ComparisonController::class, 'show']);

Route::get('/ataskaitos/sukurti', [ReportController::class, 'create'])->middleware('auth');

Route::post('/ataskaitos/issaugoti', [ReportController::class, 'store']);

Route::get('/ataskaitos/tvarkymas', [ReportController::class, 'manage'])->middleware('auth');

Route::get('/ataskaitos/test', [ReportController::class, 'test']);

Route::get('/ataskaitos/lentele', [AdminController::class, 'showReportTable'])->middleware('admin');

Route::get('ataskaitos/{report}/eksportuoti', [ReportController::class, 'export']);


Route::get('/ataskaitos/{report}/redaguoti', [AdminController::class, 'edit'])->middleware('admin');

Route::delete('/ataskaitos/{report}', [AdminController::class, 'destroy'])->middleware('admin');

Route::put('/ataskaitos/{report}', [AdminController::class, 'update'])->middleware('admin');

Route::get('/ataskaitos/{report}', [ReportController::class, 'show'])->name('ataskaitos');

Route::get('/registracija', [UserController::class, 'register']);

Route::get('/prisijungti', [UserController::class, 'login'])->name('login');

Route::post('/vartotojai/autentifikuoti', [UserController::class, 'authenticate']);

Route::post('/vartotojai', [UserController::class, 'store']);

Route::post('/atsijungti', [UserController::class, 'logout']);





