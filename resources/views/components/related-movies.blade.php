<div class="related-movies rounded-1 p-3 my-3">
    <p class="fs-5">Phim liên quan</p>
    <hr>
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach($relatedMovies as $relatedMovie)
            <div class="swiper-slide">
                <a href="{{ route('movies.show', $relatedMovie->slug) }}">
                    <div class="image-wrapper">
                        <img src="{{ asset('storage/images/movies/' . $relatedMovie->image) }}" alt="">
                        <div class="play-icon position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-2x fa-play"></i>
                        </div>
                        <div class="movie-title position-absolute bottom-0 text-center p-2">
                            <p class="m-0">{{ $relatedMovie->name }}</p>
                        </div>
                    </div>
                    
                </a>
            </div>
            @endforeach
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
