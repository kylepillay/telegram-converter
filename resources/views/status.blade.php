@extends('layouts.base')

@section('content')

   @foreach($combined as $video)
       <a href="{{ $video->url }}">{{ $video->quality }}</a><br>
   @endforeach

@endsection
