<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📈 Thống Kê Hệ Thống
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">← Quay lại Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Overview cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-4">
                    <p class="text-xs text-gray-500">Tổng doanh thu</p>
                    <p class="text-2xl font-bold text-blue-700 mt-1">{{ number_format($overview['total_revenue']) }}đ</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-indigo-100 p-4">
                    <p class="text-xs text-gray-500">Đơn hàng</p>
                    <p class="text-2xl font-bold text-indigo-700 mt-1">{{ $overview['total_orders'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-amber-100 p-4">
                    <p class="text-xs text-gray-500">Đơn hôm nay</p>
                    <p class="text-2xl font-bold text-amber-700 mt-1">{{ $overview['orders_today'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <p class="text-xs text-gray-500">Khách hàng</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $overview['total_customers'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-rose-100 p-4">
                    <p class="text-xs text-gray-500">Huỷ</p>
                    <p class="text-2xl font-bold text-rose-700 mt-1">{{ $overview['cancelled'] }}</p>
                </div>
            </div>

            <!-- Status breakdown & revenue by month -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Trạng thái đơn hàng</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Chờ xử lý</span>
                            <span class="text-base font-semibold text-amber-600">{{ $overview['pending'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Đã xác nhận</span>
                            <span class="text-base font-semibold text-blue-600">{{ $overview['confirmed'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Hoàn thành</span>
                            <span class="text-base font-semibold text-emerald-600">{{ $overview['completed'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Đã hủy</span>
                            <span class="text-base font-semibold text-rose-600">{{ $overview['cancelled'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Doanh thu 6 tháng gần nhất</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($revenueByMonth as $row)
                            <div class="p-4 bg-gray-50 rounded-lg border">
                                <p class="text-sm font-semibold text-gray-800">{{ $row->month }}</p>
                                <p class="text-lg font-bold text-emerald-700 mt-1">{{ number_format($row->revenue) }}đ</p>
                                <p class="text-xs text-gray-500">{{ $row->orders }} đơn</p>
                            </div>
                        @empty
                            <p class="text-gray-500">Chưa có dữ liệu</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Biểu đồ -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Biểu đồ doanh thu</h3>
                        <span class="text-xs text-gray-500">6 tháng gần nhất</span>
                    </div>
                    <canvas id="revenueChart" class="w-full h-64"></canvas>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Cơ cấu trạng thái đơn</h3>
                        <span class="text-xs text-gray-500">Tổng: {{ $overview['total_orders'] }}</span>
                    </div>
                    <canvas id="statusChart" class="w-full h-64"></canvas>
                </div>
            </div>

            <!-- Top products / categories / recent orders -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Top Sản phẩm</h3>
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 font-semibold hover:text-blue-700">Xem tất cả →</a>
                    </div>
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 uppercase text-xs">
                                <th class="py-2 text-left">Sản phẩm</th>
                                <th class="py-2 text-right">Số lượng</th>
                                <th class="py-2 text-right">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topProducts as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 font-semibold text-gray-900">{{ $item->name }}</td>
                                    <td class="py-2 text-right font-semibold text-gray-700">{{ $item->qty }}</td>
                                    <td class="py-2 text-right text-emerald-700 font-semibold">{{ number_format($item->revenue) }}đ</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-3 text-gray-500">Chưa có dữ liệu</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Top Danh mục</h3>
                        <a href="{{ route('admin.categories.index') }}" class="text-sm text-blue-600 font-semibold hover:text-blue-700">Xem tất cả →</a>
                    </div>
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 uppercase text-xs">
                                <th class="py-2 text-left">Danh mục</th>
                                <th class="py-2 text-right">Số lượng</th>
                                <th class="py-2 text-right">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topCategories as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 font-semibold text-gray-900">{{ $item->category_name }}</td>
                                    <td class="py-2 text-right font-semibold text-gray-700">{{ $item->qty }}</td>
                                    <td class="py-2 text-right text-emerald-700 font-semibold">{{ number_format($item->revenue) }}đ</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-3 text-gray-500">Chưa có dữ liệu</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Đơn hàng gần đây</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 font-semibold hover:text-blue-700">Xem tất cả →</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">#{{ $order->id }} · {{ $order->user->name ?? 'Khách' }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-700">{{ number_format($order->total_price ?? 0) }}đ</p>
                                <p class="text-xs text-gray-500">{{ $order->status ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 py-3">Chưa có đơn hàng</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @php
        $revenueLabelsJson = $revenueByMonth->pluck('month')->reverse()->values()->toJson();
        $revenueDataJson   = $revenueByMonth->pluck('revenue')->reverse()->values()->toJson();
        $statusDataJson    = json_encode([
            $overview['pending'],
            $overview['confirmed'],
            $overview['completed'],
            $overview['cancelled'],
        ]);
    @endphp

    <!-- Data blob for charts -->
    <script id="stats-data" type="application/json">
        {
            "revenueLabels": {!! $revenueLabelsJson !!},
            "revenueData": {!! $revenueDataJson !!},
            "statusLabels": ["Chờ xử lý", "Đã xác nhận", "Hoàn thành", "Đã hủy"],
            "statusData": {!! $statusDataJson !!}
        }
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const statsDataEl = document.getElementById('stats-data');
        const statsData = statsDataEl ? JSON.parse(statsDataEl.textContent || '{}') : {};
        const revenueLabels = statsData.revenueLabels || [];
        const revenueData   = statsData.revenueData || [];

        const ctxRevenue = document.getElementById('revenueChart');
        if (ctxRevenue && revenueLabels.length) {
            new Chart(ctxRevenue, {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Doanh thu',
                        data: revenueData,
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14,165,233,0.15)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: '#0ea5e9',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => `${Number(ctx.parsed.y).toLocaleString('vi-VN')} đ` } }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: (value) => `${Number(value).toLocaleString('vi-VN')} đ`
                            }
                        }
                    }
                }
            });
        }

        const statusLabels = statsData.statusLabels || ['Chờ xử lý', 'Đã xác nhận', 'Hoàn thành', 'Đã hủy'];
        const statusData = statsData.statusData || [];

        const ctxStatus = document.getElementById('statusChart');
        if (ctxStatus) {
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#f43f5e'],
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.parsed} đơn` } }
                    }
                }
            });
        }
    </script>
</x-app-layout>
