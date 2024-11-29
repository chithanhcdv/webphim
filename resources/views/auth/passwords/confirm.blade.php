@extends('layouts.app')

@section('title', 'Xác Nhận Mật Khẩu')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg auth-form" id="confirm-password-form">
                <div class="text-center text-white">
                    <h3 class="font-weight-light my-4">{{ __('XÁC NHẬN MẬT KHẨU') }}</h3>
                </div>
                <div class="card-body p-4">
                    <p class="text-white">{{ __('Vui lòng xác nhận mật khẩu của bạn trước khi tiếp tục.') }}</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password Field -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Nhập mật khẩu của bạn">
                            <label for="password">{{ __('Mật Khẩu') }}</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password Button -->
                        <div class="d-grid auth-button" id="confirm-password-button">
                            <button type="submit" class="btn btn-lg">
                                {{ __('Xác Nhận Mật Khẩu') }}
                            </button>
                        </div>

                        <!-- Forgot Password Link -->
                        @if (Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Quên mật khẩu?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection