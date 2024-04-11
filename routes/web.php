<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/task/list', [TaskController::class, 'list']);
Route::post('/task/create', [TaskController::class, 'create']);
Route::post('/task/update', [TaskController::class, 'update']);
Route::post('/task/complete', [TaskController::class, 'complete']);
Route::post('/task/delete', [TaskController::class, 'delete']);
