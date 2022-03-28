@extends('layouts.base')
@section('title', 'Video Downloader')

@section('content')
    <form method="post" action="{{ route('prepare') }}">
        @csrf

        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        <div class="form-group">
            <input name="url" type="text" required class="form-control @error('url')  is-invalid @enderror" id="url"
                   aria-describedby="url" value="{{ old('url') }}"
                   autocomplete="off" autofocus>

            @error('url')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button class="btn btn-lg btn-primary">Download</button>
        </div>
    </form>
@endsection
