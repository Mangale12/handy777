<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatController;
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
// Route::post('/stripe/webhook', 'WebhookController@handle');
Route::get('users', [HomeController::class,'apiUsers']);
Route::post('users/store',[HomeController::class, 'apiStore']);
Route::get('user-details/{id}',[App\Http\Controllers\NewHomeController::class,'userDetailsApi'])->name('api.userDetails');
Route::post('api/messenger-id',[App\Http\Controllers\NewHomeController::class,'messengerId'])->name('api.messenger-id');

// Laravel replacement for the legacy api/chat.php switchboard.
Route::match(['get', 'post'], 'chat', [ChatController::class, 'handle'])->name('api.chat');

// Route::middleware('auth:sanctum')->get('user-details/{id}', [App\Http\Controllers\NewHomeController::class, 'userDetailsApi']);
