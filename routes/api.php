<?php

use App\Http\Controllers\PublishController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;

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

// Subscribe to topic
Route::post('/subscribe/{topic}', [SubscribeController::class, 'index'])->name('subscribe');

// Publish message to topic
Route::post('/publish/{topic}', [PublishController::class, 'index'])->name('publish');
