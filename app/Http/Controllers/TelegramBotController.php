<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Api;

class TelegramBotController extends Controller
{
    protected Api $telegram;
    protected string $chat_id;
    protected string $username;
    protected string $text;

    /**
     * @throws TelegramSDKException
     */
    public function __construct()
    {
        $this->telegram = new Api(config('telegram.bots.mybot.token'));
    }

    /**
     * @throws TelegramSDKException
     */
    public function getMe()
    {
        return $this->telegram->getMe();
    }

    /**
     * @throws TelegramSDKException
     */
    public function setWebHook(): JsonResponse
    {
        $response = $this->telegram->setWebhook(['url' => config('telegram.bots.mybot.webhook_url')]);
        return response()->json($response);
    }

    /**
     * @throws TelegramSDKException
     */
    public function getWebhookInfo(): JsonResponse
    {
        $response = $this->telegram->getWebhookInfo();

        return response()->json($response);
    }

    /**
     * @throws TelegramSDKException
     */
    public function handleRequest(Request $request)
    {
        $this->chat_id = $request['message']['chat']['id'];
        $this->username = $request['message']['from']['username'];
        $this->text = $request['message']['text'];

        $this->telegram->commandsHandler(true);

        $this->sendMessage($this->text);
    }

    /**
     * @throws TelegramSDKException
     */
    protected function sendMessage($message, $parse_html = false)
    {
        $data = [
            'chat_id' => $this->chat_id,
            'text' => $message,
        ];

        if ($parse_html) $data['parse_mode'] = 'HTML';

        $this->telegram->sendMessage($data);
    }
}
