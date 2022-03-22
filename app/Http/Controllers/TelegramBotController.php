<?php

namespace App\Http\Controllers;

use Telegram;

class TelegramBotController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $response = Telegram::setWebhook(['url' => config('telegram.bots.mybot.webhook_url')]);
        return response()->json($response);
    }

    public function getWebhookInfo() {
        $response = Telegram::getWebhookInfo();

        return response()->json($response);
    }
}
