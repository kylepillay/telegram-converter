<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bot/set_webhook', [TelegramBotController::class, 'index']);

Route::get('/bot/get_webhook_info', [TelegramBotController::class, 'getWebhookInfo']);

Route::post('/bot/webhook', function () {
    $updates = Telegram::getWebhookUpdates();
    $update = Telegram::commandsHandler(true);

    return 'ok';
});
