@extends('layouts.app')

@section('title', 'Thanh toán thành công')

@section('show_aside')
@endsection

@section('content')
<div class="container mt-3">
    @if (session('status'))
        <x-toast message="{{ session('status') }}" />
    @endif 
    <div class="alert alert-success text-center animate__animated animate__zoomIn">
        <img src="/storage/images/logo/check.svg" alt="" width="100px">
        <h1>Thanh toán thành công!</h1>
        <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
        <p>Thông tin thanh toán của bạn đã được ghi nhận thành công.</p>
        <a href="{{ route('index') }}" class="btn btn-primary mt-3">Về trang chủ</a>
    </div>
</div>
@endsection
