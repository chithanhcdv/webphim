@extends('layouts.app')

@section('title', 'Top bình luận')

@section('show_aside')
@endsection

@section('content')

<div class="main-content">       
    <section class="movies-list movies-ranking">
        <h2 class="mb-2">Danh sách phim theo top bình luận</h2>
        <x-movie-list-by-ranking :movies="$movies" />
    </section>
</div>

@endsection

