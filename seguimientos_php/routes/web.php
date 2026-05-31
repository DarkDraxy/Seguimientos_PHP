<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('layouts.app');
});

Route::prefix('tareas')->name('tasks.')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::patch('/{task}/toggle', 'toggle')->name('toggle');
    Route::delete('/{task}', 'destroy')->name('destroy');
});
