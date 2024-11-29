@extends('layouts.app')

@section('title', 'Phim mới cập nhật')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">       
    <section class="movies-list">
        <h2 class="mb-3">MỚI CẬP NHẬT</h2>
        <x-movie-list :movies="$movies" />
    </section>
</div>

@endsection

