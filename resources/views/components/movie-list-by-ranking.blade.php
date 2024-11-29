<ul class="pb-3 mt-3 animate__animated animate__fadeInLeft">
    @foreach($movies as $movie)
    <li class="position-relative">
        {{-- Tính số thứ tự dựa trên trang hiện tại --}}
        @php
            $ranking = ($movies->currentPage() - 1) * $movies->perPage() + $loop->iteration;
        @endphp

        {{-- Chỉ hiển thị background_image cho item đầu tiên --}}
        @if($loop->first)
        <img src="{{ asset('storage/images/movies/' . $movie->background_image) }}" alt="" width="100%" height="220px" class="object-fit-cover"> 
        <a href="{{ route('movies.show', $movie->slug)}}" class="d-flex position-absolute top-0 start-0 ms-4 mt-4">                  
            <div class="position-relative">
                {{-- Thêm số thứ tự ở góc trái --}}
                <span class="ranking-number position-absolute top-0 start-0 px-2 py-1">#{{ $ranking }}</span>
                <img src="{{ asset('storage/images/movies/' . $movie->image) }}" alt="" width="130px" height="180px" class="rounded-1">     
                <div class="play-icon big-play-icon position-absolute top-50 start-50 translate-middle">
                    <i class="fas fa-play fa"></i>
                </div>
            </div>
            <div class="text-ranking ms-3">
                <p class="fs-4">{{ $movie->name }}</p>
                <span>{{$movie->other_name}}</span>
                @if(request()->routeIs('movies.topView'))
                <p><i class="fa-solid fa-eye mt-3"></i>{{ $movie->views_count }}</p>
                @elseif(request()->routeIs('movies.topRating'))
                <p><i class="fa-solid fa-star mt-3 text-warning fa-xs"></i>{{ number_format($movie->avg_rating, 1) }}</p>
                @elseif(request()->routeIs('movies.topComment'))
                <p><i class="fa-solid fa-comment mt-3"></i>{{ $movie->count_comment }}</p>  
                @endif
            </div>
        </a>
        @else
        <a href="{{ route('movies.show', $movie->slug)}}" class="d-flex ms-4 mt-3">                 
            <div class="position-relative">
                {{-- Thêm số thứ tự ở góc trái --}}
                <span class="ranking-number position-absolute top-0 start-0 ps-1 pe-2 py-1">#{{ $ranking }}</span>
                <img src="{{ asset('storage/images/movies/' . $movie->image) }}" alt="" width="80px" height="110px" class="rounded-1">     
                <div class="play-icon small-play-icon position-absolute top-50 start-50 translate-middle">
                    <i class="fas fa-play fa"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-grow-1">
                <div class="text-ranking ms-3">
                    <p>{{ $movie->name }}</p>
                    <span>{{$movie->other_name}}</span>
                </div>
                <div class="text-ranking me-3">
                    @if(request()->routeIs('movies.topView'))
                    <p><i class="fa-solid fa-eye"></i>{{ $movie->views_count }}</p>
                    @elseif(request()->routeIs('movies.topRating'))
                    <p><i class="fa-solid fa-star text-warning fa-xs"></i>{{ number_format($movie->avg_rating, 1) }}</p>
                    @elseif(request()->routeIs('movies.topComment'))
                    <p><i class="fa-solid fa-comment"></i>{{ $movie->count_comment }}</p>
                    @endif
                </div>
            </div>
        </a>
        @endif         
    </li>
    @endforeach
</ul>

<div class="d-flex justify-content-center mt-3 mb-3">
    {{ $movies->links('pagination::bootstrap-4') }} 
</div>