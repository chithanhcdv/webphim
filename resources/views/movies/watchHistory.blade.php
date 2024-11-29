@extends('layouts.app')

@section('title', 'Lịch sử xem phim')

@section('show_aside')
@endsection

@section('content')

<div class="main-content">    
    <section class="movies-list">
        <h2 class="mb-3">Lịch sử xem phim</h2>
        <x-movie-list :movies="$movies" />
    </section>
</div>

@endsection

