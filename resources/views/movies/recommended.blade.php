@extends('layouts.app')

@section('title', 'Gợi ý phim')

@section('show_aside')
@endsection

@section('content')

<div class="main-content">    
    <section class="movies-list">    
        <h2 class="mb-2">Gợi ý cho bạn</h2>
        <h3 class="mb-3">
            Gợi ý phim nhằm mục đích gợi ý các bộ phim mà người dùng chưa xem, các bộ phim mà người dùng có thể sẽ thích, được tính 
            toán bằng cách tìm các bộ phim có cùng thể loại với các bộ phim trong lịch sử xem phim 
            của ngươi dùng, sắp xếp theo thứ tự phim có đánh giá và lượt xem cao nhất.
        </h3>
        <x-movie-list :movies="$recommendedMovies" />
    </section>
</div>

@endsection

