<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Api;
use YouTube\Exception\YouTubeException;
use YouTube\YouTubeDownloader;

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

        if ($this->isYoutubeUrl($this->text)) {
            $youtube = new YouTubeDownloader();

            try {
                $downloadOptions = $youtube->getDownloadLinks($this->text);
                $combined = $downloadOptions->getCombinedFormats();
                if ($combined) {
                    $this->telegram->sendVideo([
                        'chat_id' => $this->chat_id,
                        'video' => $combined[sizeof($combined) - 1]->url
                    ]);
                } else {
                    $this->sendMessage('No links found');
                }
            } catch (YouTubeException $e) {
                $this->sendMessage($e->getMessage());
            }
        }
    }

    protected function isYoutubeUrl (string $url) {
        $rx = '~
                  ^(?:https?://)?                           # Optional protocol
                   (?:www[.])?                              # Optional sub-domain
                   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
                   ([^&]{11})                               # Video id of 11 characters as capture group 1
                    ~x';

        return preg_match($rx, $url);
    }

    protected function buildYoutubeLinksList (array $linksList) {
        $text = '';

        foreach ($linksList as $link) {
            $text .= "<a href='".$link->url."'>".$link->quality."</a>\n";
        }

        return $text;
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
