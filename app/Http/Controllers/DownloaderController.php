<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadVideo;
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
            $downloadOptions = $youtube->getDownloadLinks("https://www.youtube.com/watch?v=aqz-KE-bpKQ");

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
