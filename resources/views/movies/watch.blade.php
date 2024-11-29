@extends('layouts.app')

@section('title', $movie->name)

@section('show_aside')
@endsection

@section('content')

<div class="main-content">
    <!-- Hộp thoại toast thông báo -->
    @if (session('status'))
        <x-toast message="{{ session('status') }}" />
    @endif

    <!-- Xem phim -->
    @if(!$episode)
    <div>
        <h2 id="not-movie">Bộ phim này hiện vẫn chưa được cập nhật, xin vui lòng quay lại sau!</h2>
    </div>
    @else
    <div id="movie-watch">
        <iframe id="movie-iframe" width="100%" height="500" src="{{ $episode->server1 }}" frameborder="0" title=""
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <!-- Chọn server phim -->
    <div class="mt-3 text-center" id="server-select">
        <h5 class="mb-3">Chọn server:</h5>
        <button id="server1-btn" class="btn btn-primary me-2" data-server="{{ $episode->server1 }}">Server 1</button>
        <button id="server2-btn" class="btn btn-secondary" data-server="{{ $episode->server2 }}">Server 2</button>
    </div>
 
    <!-- Chọn tập phim -->
    <div class="mb-4 mt-4" id="episode-select">
        <h6>Chọn tập phim:</h6>
        @foreach ($episodeLists as $episodeList)
        <a class="btn btn-secondary {{ $episode->episode_number == $episodeList->episode_number ? 'active' : '' }}" 
        href="{{ route('movies.watch', ['slug' => $movie->slug, 'episode' => $episodeList->episode_number]) }}">
         {{ $episodeList->episode_number }}</a>
        @endforeach
    </div>
    @endif
    
    <!-- Thông tin của phim -->
    <x-movie-detail :movie="$movie" :existingWatchList="$existingWatchList" :averageRating="$averageRating" :memberRating="$memberRating"/>

    <!-- Bình luận phim -->
    <x-comment :comments="$comments" :movie="$movie" :commentCount="$commentCount" />

    <!-- Phim liên quan (phim cùng thể loại) -->
    <x-related-movies :relatedMovies="$relatedMovies" />
</div>
@endsection
