<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

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
    return redirect()->route('patients.index');
});

Route::prefix('patients')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('patients.index');
//    Route::get('/{patient}', [PatientController::class, 'show'])->name('patients.show');

    Route::get('/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/', [PatientController::class, 'store'])->name('patients.store');

//    Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
//    Route::put('/{patient}', [PatientController::class, 'update'])->name('patients.update');

//    Route::delete('/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
});