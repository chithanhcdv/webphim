<div class="position-relative movie-information">
    <!-- Background image -->
    <div class="position-absolute w-100 h-100 movie-background">
        <img class="w-100 h-100 object-fit-cover opacity-25 rounded-1" src="{{ asset('storage/images/movies/' . $movie->background_image) }}" alt="{{ $movie->name }}">
    </div>

    <!-- Foreground content -->
    <div class="container py-5 position-relative">
        <div class="row justify-content-center">
            <!-- Movie Poster -->
            <div class="col-lg-4 col-md-4 col-10 mb-3">
                <div class="position-relative movie-image">
                    @if(request()->routeIs('movies.show'))
                    <a href="{{ route('movies.watch', ['slug' => $movie->slug, 'episode' => 1]) }}">
                        <img class="w-100 h-100 p-2" src="{{ asset('storage/images/movies/' . $movie->image) }}" alt="{{ $movie->name }}">
                        <div class="play-icon position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-play fa-2x"></i>
                        </div>
                        @if($existingWatchList)
                        <div class="watchList-button">
                            <form action="{{ route('watchList.store', $movie->id) }}" method="POST">
                                @csrf
                                <button class="btn "><i class="fa-solid fa-heart"></i>Bỏ theo dõi</button>
                            </form>
                        </div>
                        @else
                        <div class="watchList-button">
                            <form action="{{ route('watchList.store', $movie->id) }}" method="POST">
                                @csrf
                                <button class="btn"><i class="fa-regular fa-heart"></i>Theo dõi</button>                          
                            </form>
                        </div>
                        @endif
                    </a>
                    @else
                    <img height="380px" class="movie-poster w-100 rounded-1 p-2" src="{{ asset('storage/images/movies/' . $movie->image) }}" alt="{{ $movie->name }}">
                    @if($existingWatchList)
                    <div class="watchList-button">
                        <form action="{{ route('watchList.store', $movie->id) }}" method="POST">
                            @csrf
                            <button class="btn "><i class="fa-solid fa-heart"></i>Bỏ theo dõi</button>
                        </form>
                    </div>
                    @else
                    <div class="watchList-button">
                        <form action="{{ route('watchList.store', $movie->id) }}" method="POST">
                            @csrf
                            <button class="btn"><i class="fa-regular fa-heart"></i>Theo dõi</button>
                            
                        </form>
                    </div>
                    @endif
                    @endif
                </div>                 
            </div>

            <!-- Movie Text Details -->
            <div class="col-lg-8 col-md-8 col-12 mt-3">
                <div class="movie-text">
                    <h3 class="movie-title">{{$movie->name}}</h3>
                    <h4 class="movie-other-name mt-2">{{$movie->other_name}}</h4>
                    <h5 class="movie-description fs-6 mt-3">{{$movie->description}}</h5>
                </div>

                <div class="movie-stars">
                    <!-- Display average rating -->
                    <div class="fs-4">
                        @for ($i = 1; $i <= 10; $i++)
                            <span class="rating-star {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}" data-value="{{ $i }}">★</span>
                        @endfor
                    </div>           
                </div>
                
                <!-- Hiển thị điểm đánh giá trung bình -->
                <div class="rating-text">
                    <p class="mb-0">Điểm trung bình: {{ number_format($averageRating, 1) }} / 10</p>
                    <span class="opacity-75">(từ {{$memberRating}} thành viên)</span>
                </div>
                
                <form id="rating-form" action="{{ route('rating.store', $movie->id) }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="rating" id="rating-input" value=""> 
                </form>

            </div>
        </div>
    </div>
</div>