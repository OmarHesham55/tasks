<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('todos',\App\Http\Controllers\TodoController::class);
Route::patch('/todos/{todo}/toggle-completed',[\App\Http\Controllers\TodoController::class,'toggleCompleted'])->name('todos.toggle-completed');
