<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('/registration', RegistrationController::class)
    ->only(['store'])
    ->names(['registration.store' => 'store']);

Route::middleware('auth:api')->prefix('/v1')->group(function () {
    Route::resource('/tasks', TaskController::class)
        ->only(['index', 'store'])
        ->names([
            'tasks.index' => 'index',
            'tasks.store' => 'store',
        ]);
});
