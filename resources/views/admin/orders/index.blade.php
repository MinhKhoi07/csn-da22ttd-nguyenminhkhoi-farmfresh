<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Quản lý đơn hàng</h1>
                <p class="text-sm text-gray-500 mt-1">Theo dõi và xử lý đơn hàng từ khách hàng</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Quay lại Dashboard
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
            <div class="bg-white rounded-xl border p-4">
                <div class="text-xs text-gray-500 uppercase font-semibold">Tổng đơn</div>
                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-yellow-50 rounded-xl border border-yellow-200 p-4">
                <div class="text-xs text-yellow-700 uppercase font-semibold">Chờ xử lý</div>
                <div class="mt-1 text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
                <div class="text-xs text-blue-700 uppercase font-semibold">Đã xác nhận</div>
                <div class="mt-1 text-2xl font-bold text-blue-700">{{ $stats['confirmed'] }}</div>
            </div>
            <div class="bg-purple-50 rounded-xl border border-purple-200 p-4">
                <div class="text-xs text-purple-700 uppercase font-semibold">Đang giao</div>
                <div class="mt-1 text-2xl font-bold text-purple-700">{{ $stats['shipping'] }}</div>
            </div>
            <div class="bg-green-50 rounded-xl border border-green-200 p-4">
                <div class="text-xs text-green-700 uppercase font-semibold">Hoàn thành</div>
                <div class="mt-1 text-2xl font-bold text-green-700">{{ $stats['completed'] }}</div>
            </div>
            <div class="bg-red-50 rounded-xl border border-red-200 p-4">
                <div class="text-xs text-red-700 uppercase font-semibold">Đã hủy</div>
                <div class="mt-1 text-2xl font-bold text-red-700">{{ $stats['cancelled'] }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl border shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm mã đơn hoặc tên khách..." 
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div class="min-w-[160px]">
                    <select name="status" class="w-full rounded-lg border-gray-300 text-sm">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="shipping" {{ request('status') === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                    Lọc
                </button>
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">
                    Xóa lọc
                </a>
            </form>
        </div>

        <!-- Orders table -->
        <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mã đơn</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Khách hàng</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Ngày đặt</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Trạng thái</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">SP</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Tổng tiền</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-bold text-gray-900">#{{ $order->id }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                            'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'shipping' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            'completed' => 'bg-green-50 text-green-700 border-green-200',
                                            'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Chờ xử lý',
                                            'confirmed' => 'Đã xác nhận',
                                            'shipping' => 'Đang giao hàng',
                                            'completed' => 'Hoàn thành',
                                            'cancelled' => 'Đã hủy',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$order->status] ?? 'bg-gray-50 text-gray-700' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right text-sm">{{ $order->details_count }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-900">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                        class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 text-sm font-medium">
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                    Không tìm thấy đơn hàng nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</body>
</html>
