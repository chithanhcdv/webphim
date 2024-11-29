@extends('layouts.app')

@section('title', 'Phim sản xuất năm ' . $release_year->year)

@section('show_aside')
@endsection

@section('content')

<div class="main-content">     
    <section class="movies-list">
        <div class="d-flex justify-content-between gap-3">
            <h2>Danh sách phim thuộc năm {{ $release_year->year }}</h2>
            <button class="btn movies-filter h-100"><i class="fa-solid fa-filter"></i>Lọc phim</button>
        </div>
        <x-filter-form /> 
        <x-movie-list :movies="$movies" />
    </section>
</div>

@endsection

