<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use YouTube\YouTubeDownloader;
use YouTube\Exception\YouTubeException;

class DownloaderController extends Controller
{
    public function prepare(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $youtube = new YouTubeDownloader();

        try {
            $downloadOptions = $youtube->getDownloadLinks($request["url"]);

            if ($downloadOptions->getAllFormats()) {
                return view('status', [
                    "combined" => $downloadOptions->getCombinedFormats(),
                        "audio" => $downloadOptions->getAudioFormats()
                    ]
                );
            } else {
                echo 'No links found';
            }
        } catch (YouTubeException $e) {
            echo 'Something went wrong: ' . $e->getMessage();
        }

        // return redirect()->route('/status/'.$video->id);
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

    public function status(Video $video)
    {
        return view('status', ['video' => $video]);
    }

    public function download(Video $video)
    {
        abort_if($video->status !== 'completed', 404);

        return response()->download($video->info->_filename);
    }
}
