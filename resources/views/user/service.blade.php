@extends('layouts.app')

@section('title', 'Gói dịch vụ')

@section('show_aside')
@endsection

@section('content')
<div class="main-content">
    @if (session('status'))
        <x-toast message="{{ session('status') }}" />
    @endif 

    <!-- Modal Xác nhận Hủy -->
    <div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
        <div class="modal-dialog text-dark">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmCancelModalLabel">Xác nhận hủy gói dịch vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn hủy gói dịch vụ này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                <a href="{{ route('service.remove', Auth::user()->id) }}" class="btn btn-danger">Xác nhận Hủy</a>
            </div>
            </div>
        </div>
    </div>

    <div class="row animate__animated animate__lightSpeedInLeft">
        @if($currentService)
            <div class="col-lg-6 col-md-12 col-12 mb-3">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="d-flex justify-content-center">
                        <img src="{{ $currentService->id == 1 ? '/storage/images/logo/30.jpg' : '/storage/images/logo/365.png' }}" alt="" width="180px" height="140px">
                    </div>
                    <div class="card-header bg-white text-center fs-3 fw-bold">Gói {{ $currentService->name }}</div>
                    <div class="p-3">
                        <ul style="list-style:disc" class="ms-4 fs-5">
                            {!! $currentService->description !!}
                        </ul>
                    </div>
                    <div class="card-footer fs-4 p-3 text-center">
                        {{ number_format($currentService->price, 0, ',', '.') }}đ/{{ $currentService->duration }} ngày
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12 mb-3">
                <p class="fs-4">Bạn đang sử dụng gói dịch vụ {{ $currentService->name }}</p>
                <ul class="fs-5 px-4" style="list-style:disc;">
                    <li>Ngày bắt đầu gói: {{ \Carbon\Carbon::parse($currentService->service_start_at)->format('d/m/Y H:i:s') }}</li>
                    <li>Ngày kết thúc gói: {{ \Carbon\Carbon::parse($currentService->service_end_at)->format('d/m/Y H:i:s') }}</li>
                </ul>
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#confirmCancelModal">
                        Hủy gói
                    </button>
                </div>
            </div>
        @else
            @foreach ($services as $service)
            <div class="col-lg-6 col-md-12 col-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="d-flex justify-content-center">
                        <img src="{{ $service->id == 1 ? '/storage/images/logo/30.jpg' : '/storage/images/logo/365.png' }}" alt="" width="180px" height="140px">
                    </div>
                    <div class="card-header bg-white text-center fs-3 fw-bold">Gói {{ $service->name }}</div>
                    <div class="p-3">
                        <ul style="list-style:disc" class="ms-4 fs-5">
                            {!! $service->description !!}
                        </ul>
                    </div>
                    <div class="card-footer fs-4 p-3 text-center">
                        {{ number_format($service->price, 0, ',', '.') }}đ/{{ $service->duration }} ngày
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('user.payment', $service->id) }}" class="btn btn-primary">Chọn gói</a>
                </div>
            </div>
            @endforeach
        @endif

        @if($servicesHistory->isNotEmpty())
        <div class="mt-3">
            <p class="fs-3">Lịch sử dịch vụ</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Gói</th>
                        <th scope="col">Mã dịch vụ</th>
                        <th scope="col">Thanh toán</th>
                        <th scope="col">Ngày bắt đầu</th>
                        <th scope="col">Ngày kết thúc</th>
                        <th scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicesHistory as $index => $serviceHistory)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $serviceHistory->name }}</td>
                        <td>{{ $serviceHistory->order_code }}</td>
                        <td>{{ $serviceHistory->payment_method }}</td>
                        <td>{{ \Carbon\Carbon::parse($serviceHistory->service_start_at)->format('d/m/Y H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($serviceHistory->service_end_at)->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $serviceHistory->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
