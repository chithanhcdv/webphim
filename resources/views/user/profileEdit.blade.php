@extends('layouts.app')

@section('title', 'Cập nhật thông tin')

@section('show_aside')
@endsection

@section('content')
<div class="main-content card" id="user-profile-update">  
    <div class="row justify-content-center">
        <div class="col-lg-5" id="user-profile-image">
            <div class="d-flex flex-column justify-content-center align-items-center">
                @if(Str::startsWith(Auth::user()->avatar, 'https://lh3.googleusercontent.com')
                || Str::startsWith(Auth::user()->avatar, 'https://graph.facebook.com'))
                <img id="avatar-preview" src="{{ Auth::user()->avatar }}" alt="User Avatar" class="rounded-circle" >
                @elseif(!isset(Auth::user()->avatar))
                <img id="avatar-preview" src="/storage/images/avatar/default-avatar.jpg" alt="User Avatar" class="rounded-circle" >
                @else
                <img id="avatar-preview" src="{{ asset('storage/images/avatar/' . Auth::user()->avatar) }}" alt="User Avatar" class="rounded-circle">
                @endif
                <div class="text-center mt-2">
                    <p class="mb-1">{{ Auth::user()->name }}</p>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-10">
            <div class="">
                <form class="card-body" method="POST" action="{{ route('user.profileUpdate') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3 justify-content-between gap-4">
                        <label class="mt-2">Tên</label>
                        <input type="text" class="form-control rounded-1" name="name" value="{{ Auth::user()->name }}" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    
                    <div class="input-group mb-3 gap-3">
                        <label class="mt-1">Avatar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="avatar" onchange="previewImage(event)">
                        </div>
                    </div>

                    <div id="avatar-thumbnail-preview" class="text-center mt-3"></div>

                    <div id="profile-update-button" class="text-center">
                        <button type="submit" class="btn btn-primary p-2 m-2 mb-2">
                            Cập nhật thông tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

