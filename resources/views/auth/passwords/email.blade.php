@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg auth-form" id="password-email-form">
                <div class="text-center text-white">
                    <h3 class="font-weight-light my-4">{{ __('ĐẶT LẠI MẬT KHẨU') }}</h3>
                </div>
                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            <label for="email">{{ __('Địa chỉ Email') }}</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Send Password Reset Link Button -->
                        <div class="d-grid auth-button" id="send-password-reset-button">
                            <button type="submit" class="btn btn-lg">
                                {{ __('Gửi liên kết đặt lại mật khẩu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

