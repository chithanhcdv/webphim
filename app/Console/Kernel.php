<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Đăng ký các command của ứng dụng.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

    /**
     * Định nghĩa lịch trình chạy các command.
     */
    protected function schedule(Schedule $schedule)
    {
        // Lên lịch chạy command hàng ngày
        $schedule->command('service_order:update-status')->daily();
    }
}
