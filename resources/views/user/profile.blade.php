@extends('layouts.app')

@section('title', 'Thông tin tài khoản')

@section('show_aside')
@endsection

@section('content')
<div class="main-content" id="user-profile">
    @if (session('status'))
        <x-toast message="{{ session('status') }}" />
    @endif 
    <div class="row">
        <div class="col-lg-5 col-md-12 col-12">
            <div class="mb-3 d-flex justify-content-center">              
                @if(Str::startsWith(Auth::user()->avatar, 'https://lh3.googleusercontent.com')
                || Str::startsWith(Auth::user()->avatar, 'https://graph.facebook.com'))
                <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="rounded-circle">
                @elseif(!isset(Auth::user()->avatar))
                <img src="/storage/images/avatar/default-avatar.jpg" alt="User Avatar" class="rounded-circle">
                @else
                <img src="{{ asset('storage/images/avatar/' . Auth::user()->avatar) }}" alt="User Avatar" class="rounded-circle">
                @endif
            </div>
        </div>
        <div class="col-lg-7 col-md-10 col-12">
            <div class="card shadow-lg border-0 rounded-lg">             
                <div class="p-3 ps-4 fs-4">
                    Thông tin tài khoản
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-2">
                        <p><i class="fa-regular fa-user"></i>Tên</p>
                        <p class="text-break">{{ Auth::user()->name}}</p>
                    </div>
                    
                    <div class="d-flex justify-content-between gap-2">
                        <p><i class="fa-regular fa-envelope"></i>Email</p>
                        <p class="text-break">{{ Auth::user()->email}}</p>
                    </div>
                    
                    @if(Auth::user()->password)
                    <div class="d-flex justify-content-between gap-2">
                        <p><i class="fa-solid fa-key"></i>Mật khẩu</p>
                        <p class="text-break">**********</p> 
                    </div>
                    @endif
                </div>

                <div id="profile-update-button" class="text-center">
                    <a href="{{ route('user.profileEdit') }}" class="btn p-3 m-2 mb-3 text-white">
                        Cập nhật thông tin
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
