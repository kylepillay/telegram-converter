<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Telegram;

class TelegramBotController extends Controller
{
    public function index(): JsonResponse
    {
        $response = Telegram::setWebhook(['url' => config('telegram.bots.mybot.webhook_url')]);
        return response()->json($response);
    }

    public function getWebhookInfo(): JsonResponse
    {
        $response = Telegram::getWebhookInfo();

        return response()->json($response);
    }
}
