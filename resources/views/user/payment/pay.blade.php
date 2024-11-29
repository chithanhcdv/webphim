@extends('layouts.app')

@section('title', 'Thông tin tài khoản')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    @if (session('status'))
        <x-toast message="{{ session('status') }}" />
    @endif 
    <div class="row animate__animated animate__lightSpeedInLeft">
        <div class="col-lg-6 col-md-12 col-12">
            <div class="card shadow-lg border-0 rounded-lg">
                @if($service->id == 1)
                <div class="d-flex justify-content-center">
                    <img src="/storage/images/logo/30.jpg" alt="" width="140px" height="140px">
                </div>                
                @else
                <div class="d-flex justify-content-center">
                    <img src="/storage/images/logo/365.png" alt="" width="180px" height="140px">
                </div>   
                @endif          
                <div class="card-header bg-white text-center fs-3 fw-bold">Gói {{ $service->name }}</div>
                <div class="p-3">
                    <ul style="list-style:disc" class="ms-4 fs-5">
                        {!! $service->description !!}
                    </ul>
                </div>
                <div class="card-footer fs-4 p-3 text-center">
                    {{ number_format($service->price, 0, ',', '.') }}đ/{{ $service->duration }} ngày
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-12">
            <p class="text-center fs-4">Chọn phương thức thanh toán</p>
            <div class="d-flex justify-content-center">
                <form action="{{ route('payment.momo') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="hidden" name="price" value="{{ $service->price }}">
                    <input type="hidden" name="payment_method" value="MoMo">
                    <button class="btn">
                        <img src="/storage/images/logo/momo.png" alt="" width="60px" class="rounded-2">
                    </button>
                </form>
                <form action="{{ route('payment.paypal') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="hidden" name="price" value="{{ $service->price }}">
                    <input type="hidden" name="payment_method" value="PayPal">
                    <button class="btn">
                        <img src="/storage/images/logo/paypal.png" alt="" width="60px" class="rounded-2">
                    </button>
                </form>
                <form action="{{ route('payment.vnpay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="hidden" name="price" value="{{ $service->price }}">
                    <input type="hidden" name="payment_method" value="VNPay">
                    <button class="btn">
                        <img src="/storage/images/logo/vnpay.png" alt="" width="60px" class="rounded-2">
                    </button>
                </form>
            </div>   
        </div>
    </div>
</div>
@endsection
