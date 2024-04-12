<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/task/list', [TaskController::class, 'list']);
Route::post('/task/create', [TaskController::class, 'create']);
Route::post('/task/update', [TaskController::class, 'update']);
Route::post('/task/complete', [TaskController::class, 'complete']);
Route::post('/task/delete', [TaskController::class, 'delete']);