@extends(backpack_view('blank'))

@section('content')

<div class="row mb-3">
        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="card border-start-0">
                <div class="ribbon ribbon-top bg-success"><i class="la la-user fs-3"></i></div>
                <div class="card-status-start bg-success"></div>
                <div class="card-body">
                    <h3>Số lượng thành viên</h3>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="card border-start-0">
                <div class="ribbon ribbon-top bg-danger"><i class="la la-film fs-3"></i></div>
                <div class="card-status-start bg-danger"></div>
                <div class="card-body">
                    <h3>Số lượng phim</h3>
                    <h2>{{ $totalMovies }}</h2>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="card border-start-0">
                <div class="ribbon ribbon-top bg-primary"><i class="la la-file fs-3"></i></div>
                <div class="card-status-start bg-primary"></div>
                <div class="card-body">
                    <h3>Số lượng đơn dịch vụ</h3>
                    <h2>{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="card border-start-0">
                <div class="ribbon ribbon-top bg-warning"><i class="la la-coins fs-3"></i></div>
                <div class="card-status-start bg-warning"></div>
                <div class="card-body">
                    <h3>Tổng thu nhập</h3>
                    <h2>{{ number_format($totalIncome, 0, ',', '.') }} VND</h2>
                </div>
            </div>
        </div>  

        <div class="col-sm-6 col-lg-3">
            <div class="card border-start-0">
                <div class="ribbon ribbon-top bg-info"><i class="la la-eye fs-3"></i></div>
                <div class="card-status-start bg-info"></div>
                <div class="card-body">
                    <h3>Lượt xem phim</h3>
                    <h2>{{ $totalView }}</h2>
                </div>
            </div>
        </div> 

        <div class="col-sm-6 col-lg-3">
            <div class="card border-start-0">
                <div class="ribbon ribbon-top bg-info"><i class="la la-comment fs-3"></i></div>
                <div class="card-status-start bg-info"></div>            
                <div class="card-body">
                    <h3>Lượt bình luận phim</h3>
                    <h2>{{ $totalComment  }}</h2>
                </div>
            </div>
        </div> 

        <div class="col-sm-6 col-lg-3">
            <div class="card border-start-0">
                <div class="ribbon ribbon-top bg-info"><i class="la la-star fs-3"></i></div>
                <div class="card-status-start bg-info"></div>
                <div class="card-body">
                    <h3>Lượt đánh giá phim</h3>
                    <h2>{{ $totalRating }}</h2>
                </div>
            </div>
        </div> 

        <div class="col-sm-6 col-lg-3">
            <div class="card border-start-0">
                <div class="ribbon ribbon-top bg-info"><i class="la la-heart fs-3"></i></div>
                <div class="card-status-start bg-info"></div>
                <div class="card-body">
                    <h3>Lượt theo dõi phim</h3>
                    <h2>{{ $totalWatchList }}</h2>
                </div>
            </div>
        </div> 
    </div>

    <div class="row mb-3">
        <div class="col-12 col-lg-6">
            <label for="monthSelector">Chọn tháng:</label>
            <select id="monthSelector" class="form-control mt-1">
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ $month == $currentMonth ? 'selected' : '' }}>
                        Tháng {{ $month }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Line Chart & Bar Chart -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Đơn dịch vụ trong tháng</div>
                <div class="card-body">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Tổng thu nhập trong tháng</div>
                <div class="card-body">
                    <canvas id="pricesChart"></canvas>
                </div>
            </div>
        </div>        
    </div>


@endsection

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Function to load chart data for the selected month
    function loadOrdersChart(month) {
        $.ajax({
            url: '{{ url("admin/dashboard/orders-data") }}', // Route to fetch data
            type: 'GET',
            data: { month: month },
            success: function(response) {
                // Update chart with new data (response contains all days of the month)
                ordersChart.data.labels = response.labels;
                ordersChart.data.datasets[0].data = response.data;
                ordersChart.update();
            }
        });
    }

    // Initialize chart
    var ordersChartCtx = document.getElementById('ordersChart').getContext('2d');
    var ordersChart = new Chart(ordersChartCtx, {
        type: 'bar', // Thay đổi sang biểu đồ cột
        data: {
            labels: {!! json_encode(array_keys($dailyOrders)) !!}, // Các ngày trong tháng hiện tại
            datasets: [{
                label: 'Số đơn',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                data: {!! json_encode(array_values($dailyOrders)) !!}, // Số lượng đơn theo ngày
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function loadPricesChart(month) {
        $.ajax({
            url: '{{ url("admin/dashboard/prices-data") }}', // Route to fetch data
            type: 'GET',
            data: { month: month },
            success: function(response) {
                // Update prices chart with new data
                pricesChart.data.labels = response.labels;
                pricesChart.data.datasets[0].data = response.data;
                pricesChart.update();
            }
        });
    }

    // Initialize the prices chart
    var pricesChartCtx = document.getElementById('pricesChart').getContext('2d');
    var pricesChart = new Chart(pricesChartCtx, {
        type: 'bar', // Biểu đồ dạng cột (bar chart)
        data: {
            labels: {!! json_encode(array_keys($dailyIncome)) !!}, // Các ngày trong tháng hiện tại
            datasets: [{
                label: 'Tổng thu nhập (VND)',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                data: {!! json_encode(array_values($dailyIncome)) !!}, // Tổng thu nhập theo ngày
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Handle month selection change
    $('#monthSelector').on('change', function() {
        var selectedMonth = $(this).val();
        loadOrdersChart(selectedMonth);
        loadPricesChart(selectedMonth);
    });
</script>
@endsection