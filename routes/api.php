<?php

use App\Http\Controllers\api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RegistrationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/registration', [RegistrationController::class, 'registration']);
Route::middleware('auth:api')->group(function () {
    Route::resource('/v1/tasks', TaskController::class)->only(['index', 'store']);
});
