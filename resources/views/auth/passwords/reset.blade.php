@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg auth-form" id="reset-form">
                <div class="text-center text-white">
                    <h3 class="font-weight-light my-4">{{ __('ĐẶT LẠI MẬT KHẨU') }}</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email Field -->
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            <label for="email">{{ __('Email đăng nhập') }}</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Mật khẩu mới">
                            <label for="password">{{ __('Mật khẩu mới') }}</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-floating mb-3">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Xác nhận mật khẩu">
                            <label for="password-confirm">{{ __('Xác nhận mật khẩu') }}</label>
                        </div>

                        <!-- Reset Password Button -->
                        <div class="d-grid auth-button" id="reset-button">
                            <button type="submit" class="btn btn-lg">
                                {{ __('Đặt lại mật khẩu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection