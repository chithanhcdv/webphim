@extends('layouts.app')

@section('title', session('status'))
@section('show_aside')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>        
        </div>
    </div>
</div>
@endsection
