<?php

use App\Http\Controllers\Api\CategoryWorkController;
use App\Http\Controllers\Api\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\StatusController;
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
    Route::get('/user/{username}', [UserController::class, 'getUserInfoByUsername']);//добавить
    Route::put('/user', [UserController::class, 'setUserInfo']);
    Route::delete('/user', [UserController::class, 'deleteUser']);
    Route::post('/user/logout', [LoginController::class, 'logout']);
    Route::post('/user/avatar', [UserController::class, 'changeAvatar']);
    Route::post('/user/type', [UserController::class, 'changeUserType']) ; //добавить

    Route::get('/tasks', [TaskController::class, 'getTasks']);
    Route::post('/task', [TaskController::class, 'createTask']);

    Route::put('/task/{id}', [TaskController::class, 'updateTask']);
    Route::get('/task/{id}', [TaskController::class, 'getTaskInfo']);
    Route::delete('/task/{id}', [TaskController::class, 'deleteTask']);
    Route::post('/task/{id}/executor', [TaskController::class, 'setExecutor']);
    Route::post('/task/{id}/delete-executor', [TaskController::class, 'unsetExecutor']); //Добавить
    Route::post('/task/{id}/views', [TaskController::class, 'incrementViews']);
    Route::post('/task/{id}/status', [TaskController::class, 'setTaskStatus']); //обновить
    Route::get('/task/{id}/chats', [ChatController::class, 'getChatsByTask']);

    Route::get('/customer-tasks', [TaskController::class, 'getCustomerTasks']); //добавить

    Route::get('/tasks/prices', [PriceController::class, 'getPrices']); //добавить
    Route::get('/tasks/statuses', [StatusController::class, 'getTaskStatuses']);//добавить

    Route::get('/chats', [ChatController::class, 'getChats']);
    Route::post('/chat', [ChatController::class, 'createChat']);
    Route::post('/chat/{id}/message', [ChatController::class, 'createMessage']);
    Route::put('/chat/{chatId}/message/{messageId}', [ChatController::class, 'updateMessage']);
    Route::delete('/chat/{chatId}/message/{messageId}', [ChatController::class, 'deleteMessage']);
    Route::get('/chat/{id}', [ChatController::class, 'getChatMessages']);

    Route::get('/reviews', [ReviewController::class, 'getReviews']);
    Route::get('/user-reviews', [ReviewController::class, 'getUserReviews']); //добавить
    Route::post('/review', [ReviewController::class, 'createReview']); //обновить

    Route::get('/score-types', [ReviewController::class, 'getScoreTypes']); //добавить
    Route::get('/employment-types', [StatusController::class, 'getEmploymentTypes']) ; //добавить
    Route::get('/category-works', [CategoryWorkController::class, 'getCategoryWorks']);
});
