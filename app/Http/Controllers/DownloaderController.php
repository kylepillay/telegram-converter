<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadVideo;
use App\Models\Video;
use Illuminate\Http\Request;

class DownloaderController extends Controller
{
    public function prepare(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $video = Video::create([
            'url' => $request->input('url')
        ]);

        DownloadVideo::dispatch($video);

        return redirect()->route('/status/'.$video->id);
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
