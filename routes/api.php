<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;

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
Route::post('/user/login', [LoginController::class, 'doLogin']);
Route::post('/user/register', [RegisterController::class, 'doRegister']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [UserController::class, 'getUserInfo']);
    Route::put('/user', [UserController::class, 'setUserInfo']);
    Route::delete('/user', [UserController::class, 'deleteUser']);
    Route::post('/user/logout', [LoginController::class, 'logout']);
    Route::post('/user/avatar', [UserController::class, 'changeAvatar']);

    Route::post('/task', [TaskController::class, 'createTask']);
    Route::put('/task/{id}', [TaskController::class, 'updateTask']);
    Route::get('/task/{id}', [TaskController::class, 'getTaskInfo']);
    Route::delete('/task/{id}', [TaskController::class, 'deleteTask']);
    Route::post('/task/{id}/executor', [TaskController::class, 'setExecutor']);
    Route::post('/task/{id}/views', [TaskController::class, 'incrementViews']);
});
