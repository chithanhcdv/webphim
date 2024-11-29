@extends('layouts.app')

@section('title', $news->title)

@section('show_aside')
@endsection

@section('content')

<div class="main-content">    
    <section class="" id="news-show">
        <h1 class="mb-4 fs-3"><strong>{{ $news->title }}</strong></h1>        
        <p class="mt-4 fs-5" style="white-space: pre-wrap;">{!! $news->content !!}</p>
        <img src="{{ asset('storage/images/news/' . $news->content_image) }}" alt="" class="w-100">
        <p class="mt-4 fs-5" style="white-space: pre-wrap;">{!! $news->other_content !!}</p>
        <img src="{{ asset('storage/images/news/' . $news->other_image) }}" alt="" class="w-100">
        <hr>
        <p class="fs-4">Các tin khác</p>
        <ul class="mt-3">
            @foreach($other_news as $other_new)
            <li class="mb-2 ms-3" style="list-style:disc;"><a href="{{ route('news.show', $other_new->slug) }}">{{ $other_new->title }}</a></li>
            @endforeach
        </ul>
    </section>
</div>

@endsection
