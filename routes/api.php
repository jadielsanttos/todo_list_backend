<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::get('/ping', function(){
    return response()->json(['pong' => true], 200);
});

Route::get('/auth/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/auth/validate', [AuthController::class, 'validateToken'])->middleware('auth:sanctum');
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/task/new', [TaskController::class, 'store']);
    Route::get('/tasks', [TaskController::class, 'getAll']);
    Route::get('/task/{id}', [TaskController::class, 'get']);
    Route::put('/task/update/{id}', [TaskController::class, 'update']);
    Route::delete('/task/delete/{id}', [TaskController::class, 'destroy']);
});
