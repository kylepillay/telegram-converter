<?php

namespace App\Http\Controllers;

use Telegram;

class TelegramBotController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $response = Telegram::getMe();

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        $response = Telegram::setWebhook(['url' => config('telegram.bots.mybot.webhook_url')]);

        return response()->json($response);
    }
}
