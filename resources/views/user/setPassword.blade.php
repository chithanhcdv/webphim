@extends('layouts.app')

@section('title', 'Đặt Mật Khẩu')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg auth-form" id="change-password-form">
                <div class="text-center">
                    <h3 class="font-weight-light my-4">{{ __('Đặt mật khẩu') }}</h3>
                </div>
                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.setUp') }}">
                        @csrf

                        <!-- Password -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Mật khẩu" required>
                            <label for="password">{{ __('Mật khẩu') }}</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-floating mb-3">
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                            <label for="password_confirmation">{{ __('Xác nhận mật khẩu') }}</label>
                        </div>

                        <!-- Change Password Button -->
                        <div class="d-grid auth-button" id="change-password-button">
                            <button type="submit" class="btn btn-lg btn-primary">
                                {{ __('Đặt Mật Khẩu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
