@extends('layouts.app')

@section('title', 'Phim theo dõi')

@section('show_aside')
@endsection

@section('content')

<div class="main-content">    
    <section class="movies-list">
        <h2 class="mb-3">Danh sách phim theo dõi</h2>
        <x-movie-list :movies="$movies" />
    </section>
</div>

@endsection

