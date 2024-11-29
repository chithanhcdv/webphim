<ul class="row animate__animated animate__fadeInLeft">
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
    {{ $movies->links('pagination::bootstrap-4') }} 
</div>