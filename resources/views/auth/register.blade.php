@extends('layouts.app')

@section('title', 'Đăng ký')

@section('show_aside')
@endsection 

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg auth-form">
                <div class="text-center text-white">
                    <h3 class="font-weight-light my-4">{{ __('ĐĂNG KÝ TÀI KHOẢN') }}</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf                
                        <!-- Name Field -->
                        <div class="form-floating mb-3">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="John Doe">
                            <label for="name">{{ __('Tên tài khoản') }}</label>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                            <label for="email">{{ __('Địa chỉ email') }}</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                            <label for="password">{{ __('Mật khẩu') }}</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-floating mb-3">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            <label for="password-confirm">{{ __('Xác nhận mật khảu') }}</label>
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid auth-button mt-4" id="register-button">
                            <button type="submit" class="btn btn-lg">
                                {{ __('Đăng ký') }}
                            </button>
                        </div>

                        <div class="text-center mt-3 link" id="login-link">
                            <a href="{{ route('login') }}">{{ __('Đã có tài khoản? Đăng nhập!') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
