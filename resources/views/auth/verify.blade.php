@extends('layouts.app')

@section('title', 'Xác thực Email')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg auth-form" id="verify-form">
                <div class="text-center text-white">
                    <h3 class="font-weight-light my-4">{{ __('XÁC THỰC EMAIL') }}</h3>
                </div>
                <div class="card-body p-4">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Một liên kết xác thực mới đã được gửi đến email của bạn.') }}
                        </div>
                    @endif

                    <p class="text-white">{{ __('Trước khi tiếp tục, vui lòng kiểm tra email của bạn để nhận liên kết xác thực.') }}</p>
                    <p class="text-white">{{ __('Nếu bạn không nhận được email') }},</p>
                    
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="d-grid auth-button" id="resend-button">
                            <button type="submit" class="btn btn-lg">
                                {{ __('Nhấn vào đây để yêu cầu liên kết mới') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection