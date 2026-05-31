<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TipCalculatorController;
use App\Http\Controllers\PasswordGeneratorController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\MemoryGameController;
use App\Http\Controllers\SurveyController;

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

Route::prefix('notas')->name('notes.')->controller(App\Http\Controllers\NoteController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/crear', 'store')->name('store');
    Route::delete('/{note}', 'destroy')->name('destroy');
});

Route::prefix('eventos')->name('events.')->controller(App\Http\Controllers\EventController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/crear', 'store')->name('store');
    Route::patch('/{event}', 'update')->name('update');
    Route::delete('/{event}', 'destroy')->name('destroy');
});

Route::prefix('recetas')->name('recipes.')->controller(App\Http\Controllers\RecipeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/crear', 'store')->name('store');
    Route::delete('/{recipe}', 'destroy')->name('destroy');
});
Route::prefix('memoria')->name('memory.')->controller(MemoryGameController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::prefix('encuestas')->name('surveys.')->controller(SurveyController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/{survey}/resultados', 'results')->name('results');
    Route::post('/{survey}/votar', 'vote')->name('vote');
    Route::get('/{survey}', 'show')->name('show');
    Route::delete('/{survey}', 'destroy')->name('destroy');
});
