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

//Route::get('/', 'HomeController')->name('home');
//Route::post('prepare', 'DownloaderController@prepare')->name('prepare');
//Route::get('status/{video}', 'DownloaderController@status')->name('status');
//Route::get('download/{video}', 'DownloaderController@download')->name('download');

Route::get('/bot/set_webhook', [TelegramBotController::class, 'index']);

Route::get('/bot/get_webhook_info', [TelegramBotController::class, 'getWebhookInfo']);

Route::post('/'.config('telegram.bots.mybot.webhook_url'), function () {
    $update = Telegram::commandsHandler(true);
    return 'ok';
});
