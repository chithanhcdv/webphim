<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceOrder;
use App\Models\User;
use Carbon\Carbon;

class UpdateServiceOrderStatus extends Command
{
    // Định nghĩa tên của command
    protected $signature = 'service_order:update-status';

    // Mô tả của command
    protected $description = 'Cập nhật trạng thái của service_order khi service_end_at bằng với ngày hiện tại';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy ngày hiện tại
        $today = Carbon::now()->toDateString();

        // Cập nhật các service_order có service_end_at bằng với ngày hiện tại
        ServiceOrder::whereDate('service_end_at', $today)
            ->where('status', '!=', 'đã hết hạn') 
            ->where('status', '!=', 'đã hủy')
            ->update(['status' => 'đã hết hạn']);

        // Hiển thị thông báo khi hoàn thành
        $this->info('Cập nhật trạng thái thành công!');
    }
}