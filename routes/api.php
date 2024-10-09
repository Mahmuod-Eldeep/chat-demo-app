<?php

use \App\Http\Controllers\Api\UserMessagesController;
use App\Events\MessageRead;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\api\MessageController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("users/register", [RegisterController::class, 'register']);
Route::post("users/login", [LoginController::class, 'login']);


Route::middleware('auth:sanctum')->get('/messages', [UserMessagesController::class, 'index']);
Route::middleware('auth:sanctum')->post('/messages', [MessageController::class, 'sendMessage']);
Route::post('messages/seen', [MessageController::class, 'markAllAsSeen'])->middleware('auth:sanctum');
