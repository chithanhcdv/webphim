<!-- resources/views/movies/index.blade.php -->

@extends('layouts.app')

@section('title', 'Trang chủ')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    @if (session('status'))
        <x-toast message="{{ session('status') }}" />
    @endif

    <div id="carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">  
            @foreach($carouselMovies as $index => $carouselMovie)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <a href="{{ route('movies.show', $carouselMovie->slug) }}">
                    <img src="{{ asset('storage/images/movies/' . $carouselMovie->background_image) }}" class="d-block w-100" alt="{{ $carouselMovie->name }}">
                    <div class="play-icon position-absolute top-50 start-50 translate-middle">
                        <i class="fas fa-play fa-3x"></i>
                    </div>
                    <div class="carousel-caption d-none d-md-block mb-4 p-3">
                        <h4>{{ $carouselMovie->name }}</h4>
                        <p class="">{{ $carouselMovie->description }}</p>
                        <div class="d-flex mt-1">
                            <p class="me-3"><i class="fa-solid fa-eye"></i>{{ $carouselMovie->views_count}}</p>
                            <p class="me-3"><i class="fa-solid fa-sm fa-star"></i>{{ number_format($carouselMovie->avg_rating, 1) }}</p>
                            <p><i class="fa-solid fa-comment"></i>{{ $carouselMovie->count_comment}}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>  
    
    <section class="mt-4 movies-list" id="new-update">
        <h3>MỚI CẬP NHẬT</h3>
        <ul class="row animate__animated animate__backInLeft">
            @foreach($movies as $movie)
            <li class="col-md-3 col-6 item mb-4">
                <a href="{{ route('movies.show', $movie->slug) }}">
                    <div class="position-relative">
                        <img src="{{ asset('storage/images/movies/' . $movie->image) }}" alt="" class="w-100 rounded-1">
                        <div class="play-icon position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-play fa-2x"></i>
                        </div>
                        @if($movie->total_episode == 1 || $movie->total_episode == $movie->episode_count)
                        <div class="episode-number episode-full text-center">                  
                            Tập<span>Full</span>
                        </div>
                        @elseif($movie->episode_count < 10)
                        <div class="episode-number text-center">                  
                            Tập<span>0{{$movie->episode_count}}</span>
                        </div>
                        @else  
                        <div class="episode-number text-center">                  
                            Tập<span>{{$movie->episode_count}}</span> 
                        </div>         
                        @endif
                    </div>
                    <div class="movies-list-text text-center mt-2">
                        <p class="text-truncate mb-0">{{ $movie->name }}</p>
                        <span class="text-truncate">{{ $movie->other_name }}</span>
                    </div>    
                </a>
            </li>
            @endforeach
        </ul>

        <div class="see-more-button text-center">
            <a class="btn w-25" href="{{ route('movies.newUpdate') }}">Xem tất cả</a>
        </div>
    </section>

    <section class="movies-list mt-5" id="ranking">
        <div class="tab-detail mt-3">
            <div class="d-flex justify-content-start">
                <h3>Bảng Xếp Hạng <i class="fa-solid fa-caret-right"></i></h3>
                <ul class="nav nav-tabs ms-3" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#topView">Lượt xem phim</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#topRating">Luợt đánh giá</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#topComment">Lượt bình luận</a>
                    </li>
                </ul>
            </div>
            
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Tab lượt xem -->
                <div id="topView" class="tab-pane active row animate__animated animate__fadeInLeft">
                    <ul class="row mt-3">
                        @foreach($moviesByTopView as $movieByTopView)
                        <li class="col-md-3 col-6 item mb-4">
                            <a href="{{ route('movies.show', $movieByTopView->slug) }}">
                                <div class="position-relative">
                                    <span class="ranking-number position-absolute px-2 py-1">#{{ $loop->iteration }}</span>
                                    <img src="{{ asset('storage/images/movies/' . $movieByTopView->image) }}" alt="" class="w-100 rounded-1">
                                    <div class="play-icon position-absolute top-50 start-50 translate-middle">
                                        <i class="fas fa-play fa-2x"></i>
                                    </div>
                                    @if($movieByTopView->total_episode == 1 || $movieByTopView->total_episode == $movieByTopView->episode_count)
                                    <div class="episode-number episode-full text-center">                  
                                        Tập<span>Full</span>
                                    </div>
                                    @elseif($movieByTopView->episode_count < 10)
                                    <div class="episode-number text-center">                  
                                        Tập<span>0{{$movieByTopView->episode_count}}</span>
                                    </div>
                                    @else  
                                    <div class="episode-number text-center">                  
                                        Tập<span>{{$movieByTopView->episode_count}}</span> 
                                    </div>         
                                    @endif
                                </div>
                                <div class="movies-list-text text-center mt-2">
                                    <p class="text-truncate mb-0">{{ $movieByTopView->name }}</p>
                                    <span class="text-truncate">Lượt xem: {{ $movieByTopView->views_count }}</span>
                                </div>    
                            </a>
                        </li>
                        @endforeach
                    </ul>   
                
                    <div class="see-more-button text-center">
                        <a class="btn w-25" href="{{ route('movies.topView') }}">Xem tất cả</a>
                    </div>
                </div>

                <!-- Tab lượt đánh giá -->
                <div id="topRating" class="tab-pane fade row animate__animated animate__fadeInLeft">
                    <ul class="row mt-3">
                        @foreach($moviesByTopRating as $movieByTopRating)
                        <li class="col-md-3 col-6 item mb-4">
                            <a href="{{ route('movies.show', $movieByTopRating->slug) }}">
                                <div class="position-relative">
                                    <span class="ranking-number position-absolute px-2 py-1">#{{ $loop->iteration }}</span>
                                    <img src="{{ asset('storage/images/movies/' . $movieByTopRating->image) }}" alt="" class="w-100 rounded-1">
                                    <div class="play-icon position-absolute top-50 start-50 translate-middle">
                                        <i class="fas fa-play fa-2x"></i>
                                    </div>
                                    @if($movieByTopRating->total_episode == 1 || $movieByTopRating->total_episode == $movieByTopRating->episode_count)
                                    <div class="episode-number episode-full text-center">                  
                                        Tập<span>Full</span>
                                    </div>
                                    @elseif($movieByTopRating->episode_count < 10)
                                    <div class="episode-number text-center">                  
                                        Tập<span>0{{$movieByTopRating->episode_count}}</span>
                                    </div>
                                    @else  
                                    <div class="episode-number text-center">                  
                                        Tập<span>{{$movieByTopRating->episode_count}}</span> 
                                    </div>         
                                    @endif
                                </div>
                                <div class="movies-list-text text-center mt-2">
                                    <p class="text-truncate mb-0">{{ $movieByTopRating->name }}</p>
                                    <span class="text-truncate">Điểm trung bình: {{ number_format($movieByTopRating->avg_rating, 1) }}</span>
                                </div>    
                            </a>
                        </li>
                        @endforeach
                    </ul>   
                
                    <div class="see-more-button text-center">
                        <a class="btn w-25" href="{{ route('movies.topRating') }}">Xem tất cả</a>
                    </div>
                </div>

                <!-- Tab lượt bình luận -->
                <div id="topComment" class="tab-pane fade animate__animated animate__fadeInLeft">
                    <ul class="row mt-3">
                        @foreach($moviesByTopComment as $movieByTopComment)
                        <li class="col-md-3 col-6 item mb-4">
                            <a href="{{ route('movies.show', $movieByTopComment->slug) }}">
                                <div class="position-relative">
                                    <span class="ranking-number position-absolute px-2 py-1">#{{ $loop->iteration }}</span>
                                    <img src="{{ asset('storage/images/movies/' . $movieByTopComment->image) }}" alt="" class="w-100 rounded-1">
                                    <div class="play-icon position-absolute top-50 start-50 translate-middle">
                                        <i class="fas fa-play fa-2x"></i>
                                    </div>
                                    @if($movieByTopComment->total_episode == 1 || $movieByTopComment->total_episode == $movieByTopComment->episode_count)
                                    <div class="episode-number episode-full text-center">                  
                                        Tập<span>Full</span>
                                    </div>
                                    @elseif($movieByTopComment->episode_count < 10)
                                    <div class="episode-number text-center">                  
                                        Tập<span>0{{$movieByTopComment->episode_count}}</span>
                                    </div>
                                    @else  
                                    <div class="episode-number text-center">                  
                                        Tập<span>{{$movieByTopComment->episode_count}}</span> 
                                    </div>         
                                    @endif
                                </div>
                                <div class="movies-list-text text-center mt-2">
                                    <p class="text-truncate mb-0">{{ $movieByTopComment->name }}</p>
                                    <span class="text-truncate">Lượt bình luận: {{ $movieByTopComment->count_comment }}</span>
                                </div>    
                            </a>
                        </li>
                        @endforeach
                    </ul>   
                
                    <div class="see-more-button text-center">
                        <a class="btn w-25" href="{{ route('movies.topComment') }}">Xem tất cả</a>
                    </div>
                </div>
            </div>        
        </div>
   </section>

   <section id="news" class="movies-list my-5">
        <h3 class="mb-3">TIN PHIM MỚI CẬP NHẬT</h3>
        <ul class="row">
            @foreach($news as $new)
            <li class="col-md-4 col-6 mb-4">
                <a href="{{ route('news.show', $new->slug) }}">
                    <div class="position-relative">
                        <img src="{{ asset('storage/images/news/' . $new->title_image) }}" alt="" class="w-100 rounded-1" height="200px">                        
                    </div>
                    <div class="movies-list-text text-center mt-2">
                        <p class="mb-0">{{ $new->title }}</p>
                    </div>    
                </a>
            </li>
            @endforeach
        </ul>

        <div class="see-more-button text-center">
            <a class="btn w-25" href="{{ route('news.newUpdate') }}">Xem tất cả</a>
        </div>
   </section>
</div>
@endsection