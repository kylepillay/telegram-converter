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

        return response()->json([
            'Bot ID' => $botId,
            'First Name' => $firstName,
            'Username' => $username
        ]);
    }
}
