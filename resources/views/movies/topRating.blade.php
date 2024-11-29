@extends('layouts.app')

@section('title', 'Top đánh giá')

@section('show_aside')
@endsection

@section('content')

<div class="main-content">       
    <section class="movies-list movies-ranking">
        <h2 class="mb-2">Danh sách phim theo top đánh giá</h2>
        <x-movie-list-by-ranking :movies="$movies" />
    </section>
</div>

@endsection
