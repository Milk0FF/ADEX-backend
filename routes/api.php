<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
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
    Route::post('/user/logout', [LoginController::class, 'logout']);
});
