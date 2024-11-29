<div class="position-fixed bottom-0 end-0 p-3">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto text-danger">Thông báo</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ $message }}
        </div>
    </div>
</div>

<style>
.position-fixed {
    z-index: 1050; 
}

.toast {
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    background-color: #f8f9fa; 
    animation: slide-in 0.5s ease-out, fade-in 0.5s ease-out;
}

.toast-header {
    background-color: #ffc107; 
    color: #212529; 
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.toast-body {
    background-color: #fff;
    color: #212529;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

.btn-close:hover {
    background-color: #ff6b6b; 
    border-radius: 50%;
}

@keyframes slide-in {
    from {
        transform: translateX(100%); 
    }
    to {
        transform: translateX(0); 
    }
}

@keyframes fade-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>