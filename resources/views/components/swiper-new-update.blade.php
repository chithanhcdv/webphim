<div class="movies-list rounded-1" id="swiper-newUpdate">
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach($swiperMovies as $swiperMovie)
            <div class="swiper-slide">
                <a href="{{ route('movies.show', $swiperMovie->slug) }}">
                    <div class="image-wrapper">
                        <img src="{{ asset('storage/images/movies/' . $swiperMovie->image) }}" alt="">
                        <div class="play-icon position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="movie-title position-absolute bottom-0 text-center p-2">
                            <p class="m-0">{{ $swiperMovie->name }}</p>
                        </div>
                        @if($swiperMovie->total_episode == 1 || $swiperMovie->total_episode == $swiperMovie->episode_count)
                        <div class="episode-number episode-full text-center">                  
                            Tập<span>Full</span>
                        </div>
                        @elseif($swiperMovie->episode_count < 10)
                        <div class="episode-number text-center">                  
                            Tập<span>0{{$swiperMovie->episode_count}}</span>
                        </div>
                        @else  
                        <div class="episode-number text-center">                  
                            Tập<span>{{$swiperMovie->episode_count}}</span> 
                        </div>         
                        @endif 
                    </div>         
                </a>
            </div>
            @endforeach
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>