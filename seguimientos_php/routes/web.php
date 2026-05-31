<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TipCalculatorController;
use App\Http\Controllers\PasswordGeneratorController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('layouts.app');
});

Route::prefix('tareas')->name('tasks.')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::patch('/{task}/toggle', 'toggle')->name('toggle');
    Route::delete('/{task}', 'destroy')->name('destroy');
});

Route::prefix('propinas')->name('tips.')->controller(TipCalculatorController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/calcular', 'calculate')->name('calculate');
});

Route::prefix('contraseñas')->name('passwords.')->controller(PasswordGeneratorController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/generar', 'generate')->name('generate');
});

Route::prefix('gastos')->name('expenses.')->controller(ExpenseController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/registrar', 'store')->name('store');
    Route::delete('/{expense}', 'destroy')->name('destroy');
});

Route::prefix('reservas')->name('reservations.')->controller(ReservationController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/crear', 'store')->name('store');
    Route::delete('/{reservation}', 'destroy')->name('destroy');
});
