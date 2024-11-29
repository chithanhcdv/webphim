@extends('layouts.app')

@section('title', 'Thanh toán thành công')

@section('show_aside')
@endsection

@section('content')
<div class="container mt-5">
    @if (session('status'))
        <x-toast message="{{ session('status') }}" />
    @endif 
    <div class="alert alert-success text-center m-3 animate__animated animate__zoomIn">
        <img src="/storage/images/logo/fail.png" alt="" width="100px">
        <h1>Lỗi thanh toán!</h1>
        <a href="{{ route('index') }}" class="btn btn-primary mt-3">Về trang chủ</a>
    </div>
</div>
@endsection
