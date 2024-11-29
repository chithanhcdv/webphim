<aside>
   @if(Auth::check())
   @if(isset($watchHistories) && $watchHistories->isNotEmpty())
   <section class="movies-list rounded-1 p-3 mb-3">
      <div class="d-flex justify-content-between">
         <h3><i class="fa-solid fa-lightbulb"></i>Gợi ý cho bạn</h3>
         <a href="{{ route('movies.recommended')}}" class="see-all">
            Xem thêm <i class="fa-solid fa-caret-right"></i>
         </a>
      </div>
      
      <hr>
      <ul class="d-flex gap-3">
         @foreach($recommendedMovies as $recommendedMovie)
         <li>
            <a href="{{ route('movies.show', $recommendedMovie->slug)}}">
               <div class="position-relative">
                  <img src="{{ asset('storage/images/movies/' . $recommendedMovie->image) }}" alt="" class="rounded-1" width="80px">
                  <div class="play-icon position-absolute top-50 start-50 translate-middle">
                        <i class="fas fa-play fa"></i>
                  </div>
                  
               </div>            
            </a>
         </li>
         @endforeach
      </ul>
   </section>

   <section class="movies-list rounded-1 p-3 mb-3">
      <div class="d-flex justify-content-between">
         <h3><i class="fa-solid fa-clock-rotate-left"></i>Lịch Sử Xem Phim</h3>
         <a href="{{ route('movies.watchHistory')}}" class="see-all">
            Xem tất cả <i class="fa-solid fa-caret-right"></i>
         </a>
      </div>
      
      <hr>
      <ul class="d-flex gap-3">
         @foreach($watchHistories as $watchHistory)
         <li>
            <a href="{{ route('movies.show', $watchHistory->slug)}}">
               <div class="position-relative">
                  <img src="{{ asset('storage/images/movies/' . $watchHistory->image) }}" alt="" class="rounded-1" width="80px">
                  <div class="play-icon position-absolute top-50 start-50 translate-middle">
                        <i class="fas fa-play fa"></i>
                  </div>
               </div>            
            </a>
         </li>
         @endforeach
      </ul>
   </section>
   @endif
   @endif

   <section class="movies-list rounded-1 p-3" id="aside-new-update">
      <div class="d-flex justify-content-between">
         <h3><i class="fa-solid fa-clock"></i>Phim Mới Cập Nhật</h3>
         <a href="{{ route('movies.newUpdate')}}" class="see-all">
            Xem tất cả <i class="fa-solid fa-caret-right"></i>
         </a>
      </div>
      <hr>
      <ul>
         @foreach($movies as $movie)
         <li class="mt-3">
            <a href="{{ route('movies.show', $movie->slug)}}" class="d-flex">
               <div class="position-relative">
                  <img src="{{ asset('storage/images/movies/' . $movie->image) }}" alt="" class="rounded-1" width="80px">
                  <div class="play-icon position-absolute top-50 start-50 translate-middle">
                        <i class="fas fa-play fa"></i>
                  </div>
               </div>
               <div class="ms-3 lh-1 mt-1">
                  <p>{{ $movie->name }}</p>
                  <span class="opacity-75">{{ $movie->other_name }}</span>
               </div> 
            </a>
         </li>
         @endforeach
      </ul>
   </section>

   <section class="movies-list rounded-1 p-3 mt-3" id="aside-ranking">
      <h3><i class="fas fa-crown fa"></i>Bảng Xếp Hạng</h3>
      <div class="tab-detail mt-3">
         <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#aside-home"><i class="fa-regular fa-eye"></i>Lượt xem</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#aside-menu1"><i class="fa-regular fa-star"></i>Đánh giá</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#aside-menu2"><i class="fa-regular fa-comment"></i>Bình luận</a>
            </li>
         </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Tab lượt xem -->
            <div id="aside-home" class="container tab-pane active">
               <br>
               <ul>
                  @foreach($moviesByView as $movieByView)
                  <li class="mt-3">
                     <a href="{{ route('movies.show', $movieByView->slug)}}" class="d-flex">
                        <div class="position-relative">
                           <span class="ranking-number position-absolute top-0 start-0 ps-1 pe-2 py-1">#{{ $loop->iteration }}</span>
                           <img src="{{ asset('storage/images/movies/' . $movieByView->image) }}" alt="" class="rounded-1" width="80px">
                           <div class="play-icon position-absolute top-50 start-50 translate-middle">
                                 <i class="fas fa-play fa"></i>
                           </div>
                        </div>
                        <div class="text-ranking ms-3 lh-1 mt-1">
                           <p>{{ $movieByView->name }}</p>
                           <span class="opacity-75"><i class="fa-solid fa-eye"></i>{{ $movieByView->views_count }}</sp>
                        </div> 
                     </a>
                  </li>
                  @endforeach
               </ul>  
               
               <div class="see-more-button text-center mt-4">
                  <a class="btn" href="{{ route('movies.topView') }}">Xem tất cả</a>
               </div>
            </div>

            <!-- Tab lượt đánh giá -->
            <div id="aside-menu1" class="container tab-pane fade">
               <br>
               <ul>
                  @foreach($moviesByRating as $movieByRating)
                  <li class="mt-3">
                     <a href="{{ route('movies.show', $movieByRating->slug)}}" class="d-flex">
                        <div class="position-relative">
                           <span class="ranking-number position-absolute top-0 start-0 ps-1 pe-2 py-1">#{{ $loop->iteration }}</span>
                           <img src="{{ asset('storage/images/movies/' . $movieByRating->image) }}" alt="" class="rounded-1" width="80px">
                           <div class="play-icon position-absolute top-50 start-50 translate-middle">
                                 <i class="fas fa-play fa"></i>
                           </div>
                        </div>
                        <div class="text-ranking ms-3 lh-1 mt-1">
                           <p>{{ $movieByRating->name }}</p>
                           <span class="opacity-75"><i class="fa-solid fa-star text-warning fa-xs"></i>{{ number_format($movieByRating->avg_rating, 1) }}</span>
                        </div>                      
                     </a>
                  </li>
                  @endforeach
               </ul>

               <div class="see-more-button text-center mt-4">
                  <a class="btn" href="{{ route('movies.topRating') }}">Xem tất cả</a>
               </div>
            </div>

            <!-- Tab lượt bình luận -->
            <div id="aside-menu2" class="container tab-pane fade">
               <br>
               <ul>
                  @foreach($moviesByComment as $movieByComment)
                  <li class="mt-3">
                     <a href="{{ route('movies.show', $movieByComment->slug)}}" class="d-flex">
                        <div class="position-relative">
                           <span class="ranking-number position-absolute top-0 start-0 ps-1 pe-2 py-1">#{{ $loop->iteration }}</span>
                           <img src="{{ asset('storage/images/movies/' . $movieByComment->image) }}" alt="" class="rounded-1" width="80px">
                           <div class="play-icon position-absolute top-50 start-50 translate-middle">
                                 <i class="fas fa-play fa"></i>
                           </div>
                        </div>
                        <div class="text-ranking ms-3 lh-1 mt-1">
                           <p>{{ $movieByComment->name }}</p>
                           <span class="opacity-75"><i class="fa-solid fa-comment"></i>{{ $movieByComment->count_comment }}</span>
                        </div> 
                     </a>
                  </li>
                  @endforeach
               </ul>  
               
               <div class="see-more-button text-center mt-4">
                  <a class="btn" href="{{ route('movies.topComment') }}">Xem tất cả</a>
               </div>
            </div>
        </div>        
    </div>
   </section>
</aside>