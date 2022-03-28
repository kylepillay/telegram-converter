<?php

use App\Http\Controllers\DownloaderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TelegramBotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('prepare', [DownloaderController::class, 'prepare'])->name('prepare');
Route::get('status/{video}', [DownloaderController::class, 'status'])->name('status');
Route::get('download/{video}', [DownloaderController::class, 'download'])->name('download');

Route::get('/bot/set_webhook', [TelegramBotController::class, 'setWebHook']);
Route::get('/bot/get_webhook_info', [TelegramBotController::class, 'getWebhookInfo']);

Route::post('/'.explode(':', config('telegram.bots.mybot.token'))[1].'/webhook', [TelegramBotController::class, 'handleRequest']);
