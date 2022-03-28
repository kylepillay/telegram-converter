@extends('layouts.base')

@section('content')

    @if ($video->status == 'completed')
        <h3>{{ $video->info->title }}</h3>
        <img src="{{ $video->info->thumbnail }}">
        <h3>Click <a href="{{ route('download', ['download' => $video]) }}">here</a> to download it</h3>
    @endif

    @if($video->status == 'in_progress')
        <h3>Download in progress..</h3>
        <p>Please <a href="javascript:;" onclick="window.reload()">refresh</a> this page in a few seconds.</p>
    @endif

    @if ($video->status == 'failed')
        <h3>Download failed!</h3>
        <p>Please try again, if the problem persist, then please contact us.</p>
    @endif

@endsection
