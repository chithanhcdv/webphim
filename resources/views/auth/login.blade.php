@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg auth-form" id="login-form">
                <div class="text-center">
                    <h3 class="font-weight-light my-4 text-white">{{ __('ĐĂNG NHẬP') }}</h3>
                </div>
                <div class="card-body p-4">
                    <!-- Hiển thị thông báo thành công nếu có -->
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email Field -->
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror " name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            <label for="email">{{ __('Email đăng nhập') }}</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <!-- Password Field -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror " name="password" required autocomplete="current-password" placeholder="Password">
                            <label for="password">{{ __('Mật khẩu') }}</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Remember Me and Register Link -->
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-white" for="remember">
                                    {{ __('Ghi nhớ tôi') }}
                                </label>
                            </div>
                            <!-- Forgot Password Link -->
                            <div class="link" id="forgot-password-link">
                                @if (Route::has('password.request'))
                                <a class="small" href="{{ route('password.request') }}">
                                    {{ __('Quên mật khẩu?') }}
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid auth-button" id="login-button">
                            <button type="submit" class="btn btn-lg">
                                {{ __('Đăng nhập') }}
                            </button>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center mt-3 link" id="register-link">
                            <a href="{{ route('register') }}">{{ __('Chưa có tài khoản? Đăng ký') }}</a>
                        </div>
                        
                        <div class="text-white text-center mt-3 mb-2">
                            Hoặc đăng nhập bằng
                        </div>

                        <div class="d-flex justify-content-center gap-2" id="provider-login-button">
                            <a href="{{ route('auth.google') }}" class="btn btn-danger">
                                <i class="fa-brands fa-1x fa-google"></i>
                            </a>

                            <a href="{{ route('auth.facebook') }}" class="btn btn-primary">
                                <i class="fa-brands fa-1x fa-facebook"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection