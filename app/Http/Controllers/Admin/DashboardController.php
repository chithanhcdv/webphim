<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Movie;
use App\Models\ServiceOrder;
use App\Models\Service;
use App\Models\Comment;
use App\Models\View;
use App\Models\Rating;
use App\Models\WatchList;

class DashboardController extends Controller
{
    public function index()
    {
        // Lấy tổng số lượng thành viên
        $totalUsers = User::count();

        // Lấy tổng số lượng phim
        $totalMovies = Movie::count();

        // Lấy tổng số lượng đơn dịch vụ
        $totalOrders = ServiceOrder::count();

        // Tính tổng thu nhập (dựa trên cột price trong bảng services)
        $totalIncome = ServiceOrder::join('services', 'services.id', '=', 'services_orders.service_id')
            ->sum('services.price');

        $totalComment = Comment::count();

        $totalView = View::sum('views_count');

        $totalRating = Rating::count();

        $totalWatchList = WatchList::count();
        
        $monthlyOrders = ServiceOrder::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->all();

        $currentMonth = date('m');

        $dailyOrders = ServiceOrder::selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->whereRaw('MONTH(created_at) = ?', [$currentMonth])
            ->groupBy('day')
            ->pluck('count', 'day')
            ->all();

        $dailyIncome = ServiceOrder::selectRaw('DAY(services_orders.created_at) as day,
            SUM(services.price) as total_income')
            ->join('services', 'services.id', '=', 'services_orders.service_id')
            ->whereRaw('MONTH(services_orders.created_at) = ?', [$currentMonth])
            ->groupBy('day')
            ->pluck('total_income', 'day')
            ->all();

        return view(backpack_view('dashboard'), compact('totalUsers', 'totalMovies',
        'totalOrders','totalIncome','totalComment', 'totalView', 'totalRating', 'totalWatchList',
        'monthlyOrders', 'currentMonth', 'dailyOrders','dailyIncome'));
    }

    public function getOrdersData(Request $request)
    {
        $month = $request->month;
        $year = date('Y'); // Bạn có thể điều chỉnh nếu muốn cho phép người dùng chọn cả năm

        // Lấy số ngày trong tháng
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Tạo một mảng với tất cả các ngày trong tháng
        $days = range(1, $daysInMonth);

        // Lấy dữ liệu đơn dịch vụ theo ngày trong tháng được chọn
        $dailyOrders = ServiceOrder::selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->whereRaw('MONTH(created_at) = ?', [$month])
            ->whereRaw('YEAR(created_at) = ?', [$year])
            ->groupBy('day')
            ->pluck('count', 'day')
            ->all();

        // Điền dữ liệu cho tất cả các ngày, nếu ngày nào không có đơn thì gán giá trị 0
        $ordersData = [];
        foreach ($days as $day) {
            $ordersData[$day] = $dailyOrders[$day] ?? 0;
        }

        // Chuẩn bị dữ liệu cho biểu đồ
        $labels = array_keys($ordersData);
        $data = array_values($ordersData);

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function getPricesData(Request $request)
    {
        $month = $request->month;
        $year = date('Y'); // Bạn có thể thay đổi logic để chọn năm nếu cần.

        // Lấy số ngày trong tháng
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Tạo mảng với tất cả các ngày trong tháng
        $days = range(1, $daysInMonth);

        // Lấy dữ liệu tổng thu nhập theo ngày trong tháng được chọn
        $dailyIncome = ServiceOrder::selectRaw('DAY(services_orders.created_at) as day, SUM(services.price) as total_income')
            ->join('services', 'services.id', '=', 'services_orders.service_id')
            ->whereRaw('MONTH(services_orders.created_at) = ?', [$month])
            ->whereRaw('YEAR(services_orders.created_at) = ?', [$year])
            ->groupBy('day')
            ->pluck('total_income', 'day')
            ->all();

        // Điền dữ liệu cho tất cả các ngày, nếu ngày nào không có thu nhập thì gán giá trị 0
        $pricesData = [];
        foreach ($days as $day) {
            $pricesData[$day] = $dailyIncome[$day] ?? 0;
        }

        // Chuẩn bị dữ liệu cho biểu đồ
        $labels = array_keys($pricesData);
        $data = array_values($pricesData);

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

}
