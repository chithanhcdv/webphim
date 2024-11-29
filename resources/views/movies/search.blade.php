@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm: ' . $searchTerm)

@section('show_aside')
@endsection

@section('content')

<div class="main-content">       
    <section class="movies-list">
        <div class="d-flex justify-content-between gap-3">
            <h2>Kết quả tìm kiếm cho: "{{ $searchTerm }}"</h2>
            <button class="btn movies-filter h-100"><i class="fa-solid fa-filter"></i>Lọc phim</button>
        </div> 

        <x-filter-form /> 

        @if($movies->isEmpty()) 
        <p>Không tìm thấy kết quả nào.</p>
        @else
        <x-movie-list :movies="$movies" />
        @endif
    </section>
    
</div>

@endsection