@extends('layouts.app')

@section('title', 'Lọc Phim')

@section('show_aside')
@endsection

@section('content')

<div class="main-content">       
    <section class="movies-list">
        <div class="d-flex justify-content-between gap-3">
            <h2>Kết quả lọc phim</h2>
            <button class="btn bg-white movies-filter h-100"><i class="fa-solid fa-filter"></i>Lọc phim</button>
        </div> 

         <!-- Hiển thị các tiêu chí lọc đã chọn -->
        <div class="filter-info mt-2">
            <h5>Tiêu chí lọc:</h5>
            <ul>
                @if($selectedGenres)
                    <li>Thể loại: 
                        @foreach($selectedGenres as $genre)
                            <span class="badge bg-primary">{{ \App\Models\Genre::find($genre)->name }}</span>
                        @endforeach
                    </li>
                @endif
                @if($selectedCountry)
                    <li>Quốc gia: <span class="badge bg-secondary">{{ \App\Models\Country::find($selectedCountry)->name }}</span></li>
                @endif
                @if($selectedCategory)
                    <li>Danh mục: <span class="badge bg-info">{{ \App\Models\Category::find($selectedCategory)->name }}</span></li>
                @endif
                @if($selectedReleaseYear)
                    <li>Năm phát hành: <span class="badge bg-warning">{{ \App\Models\ReleaseYear::find($selectedReleaseYear)->year }}</span></li>
                @endif
            </ul>
        </div>
        
        <x-filter-form /> 

        @if($movies->isEmpty()) 
        <p>Không tìm thấy kết quả nào.</p>
        @else
        <ul class="row animate__animated animate__lightSpeedInLeft">
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

        <div class="d-flex justify-content-center mb-3">
            {{ $movies->appends(request()->input())->links('pagination::bootstrap-4') }} 
        </div>
        @endif
    </section>  
</div>

@endsection
