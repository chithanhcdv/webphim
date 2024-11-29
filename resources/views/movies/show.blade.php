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
    
    <!-- Thông tin của phim gồm background, hình ảnh, tên phim,... -->
    <x-movie-detail :movie="$movie" :existingWatchList="$existingWatchList" :averageRating="$averageRating" :memberRating="$memberRating" />

    <div class="tab-detail mt-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#home"><i class="la la-play"></i><i class="fa-solid fa-film"></i>Thông tin phim</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#menu1"><i class="fa-solid fa-video"></i>Trailer</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#menu2"><i class="fa-solid fa-image"></i>Hình ảnh</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" id="movie-information-tab">
            <!-- Tab thông tin phim -->
            <div id="home" class="container tab-pane active"><br>
                <div class="row" id="information-tab">
                    <div class="col-md-6 col-12">                     
                        <p class="">Tập mới:                      
                            @foreach($episodeLists as $episodeList)
                            <a href="{{ route('movies.watch', ['slug' => $movie->slug, 'episode' => $episodeList->episode_number]) }}" class="btn btn-dark text-white">{{ $episodeList->episode_number }}</a>
                            @endforeach
                        </p>
                        <p>Thể loại:                         
                            @foreach ($genres as $genre)
                                <a href="{{ route('movies.genre', $genre->slug) }}">{{ $genre->name }}</a>
                                @if (!$loop->last), @endif
                            @endforeach
                        </p>

                        <p>Quốc gia:<a href="{{ route('movies.country', $movie->country_slug) }}">{{ $movie->country_name}}</a></p>
                        <p>Năm sản xuất:<a href="{{ route('movies.release_year', $movie->release_year_year) }}">{{ $movie->release_year_year}}</a></p>
                        <p>Danh mục:<a href="{{ route('movies.category', $movie->category_slug) }}">{{ $movie->category_name}}</a></p>
                        <p>Studio:<span>{{ $movie->studio }}</span></p>
                        <p>Đạo diễn:<span>{{ $movie->director }}</span></p>
                    </div>

                    <div class="col-md-6 col-12">
                        <p>Diễn viên:<span>{{$movie->actor}}</span></p>
                        <p>Tổng số tập:<span>{{ $movie->total_episode }}</span></p>
                        <p>Thời lượng mỗi tập:<span>{{ $duration }} phút</span></p>
                        <p>Số lượt bình luận:<span>{{ $commentCount}}</span></p>
                        <p>Số lượt xem:<span>{{ $views }}</span></p>
                        <p>Đánh giá trung bình:<span>{{ number_format($averageRating, 1) }}</span></p>
                        <p>Ngày cập nhật mới nhất:<span>{{ \Carbon\Carbon::parse($latestUpdate)->format('d/m/Y H:i:s') }}</span></p>
                        
                    </div>           
                </div>                   
            </div>

            <!-- Tab trailer -->
            <div id="menu1" class="container tab-pane fade">
                <br>
                <div id="trailer-tab">
                    @if ($trailer && $trailer->url)
                        <iframe width="100%" height="450" src="{{ $trailer->url }}" frameborder="0" title="Trailer"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    @else
                        <p>Không có trailer cho phim này.</p>
                    @endif
                </div>
            </div>

            <!-- Tab hình ảnh -->
            <div id="menu2" class="container tab-pane fade">
                <br>
                <div id="image-tab">
                    <img src="{{ asset('storage/images/movies/' . $movie->background_image) }}" alt="" width="100%">
                </div>         
            </div>
        </div>        
    </div>

    <!-- Bình luận phim -->
    <x-comment :comments="$comments" :movie="$movie" :commentCount="$commentCount" />

    <!-- Phim liên quan (phim cùng thể loại) -->
    <x-related-movies :relatedMovies="$relatedMovies" />
</div>
@endsection

