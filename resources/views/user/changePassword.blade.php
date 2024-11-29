@extends('layouts.app')

@section('title', 'Đổi Mật Khẩu')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg auth-form" id="change-password-form">
                <div class="text-center">
                    <h3 class="font-weight-light my-4">{{ __('Đổi Mật Khẩu') }}</h3>
                </div>
                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <!-- Current Password -->
                        <div class="form-floating mb-3">
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" placeholder="Mật khẩu hiện tại" required>
                            <label for="current_password">{{ __('Mật khẩu hiện tại') }}</label>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Mật khẩu mới" required>
                            <label for="password">{{ __('Mật khẩu mới') }}</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="form-floating mb-3">
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu mới" required>
                            <label for="password_confirmation">{{ __('Xác nhận mật khẩu mới') }}</label>
                        </div>

                        <!-- Change Password Button -->
                        <div class="d-grid auth-button" id="change-password-button">
                            <button type="submit" class="btn btn-lg btn-primary">
                                {{ __('Đổi Mật Khẩu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
