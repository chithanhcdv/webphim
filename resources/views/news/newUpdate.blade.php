@extends('layouts.app')

@section('title', 'Tin phim mới cập nhật')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">       
    <section class="news-list movies-list">
        <h2 class="mb-3">TIN PHIM MỚI CẬP NHẬT</h2>
        <ul class="row">
            @foreach($news as $new)
            <li class="col-md-4 col-6 mb-4">
                <a href="{{ route('news.show', $new->slug)}}">  
                    <div class="position-relative">
                        <img src="{{ asset('storage/images/news/' . $new->title_image) }}" alt="" class="w-100 rounded-1" height="200px">                        
                    </div>                 
                    <div class="text-center mt-2">
                        <p class="mb-0">{{ $new->title }}</p>
                    </div>    
                </a>
            </li>
            @endforeach
        </ul>

        <div class="d-flex justify-content-center mb-3">
            {{ $news->links('pagination::bootstrap-4') }} 
        </div>
    </section>
</div>

@endsection
