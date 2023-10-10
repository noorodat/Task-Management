<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

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

Route::get('/', [TaskController::class, 'index']);

Route::resource('task', TaskController::class);
Route::resource('project', ProjectController::class);

// Update priority coming from Ajax request
Route::post('/update-priority', [TaskController::class, 'updatePriority'])->name('update-priority');

