@extends('layouts.app')

@section('title', 'Phim thể loại ' . $genre->name)

@section('show_aside')
@endsection

@section('content')

<div class="main-content">       
    <section class="movies-list">
        <div class="d-flex justify-content-between gap-3">
            <h2 class="mb-2">Danh sách phim thuộc thể loại {{ $genre->name }}</h2>
            <button class="btn movies-filter h-100"><i class="fa-solid fa-filter"></i>Lọc phim</button>
        </div>        
        <h3>{{ $genre->description }}</h3>
        <x-filter-form />
        <x-movie-list :movies="$movies" />
    </section>
</div>

@endsection

