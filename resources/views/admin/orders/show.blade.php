<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn #{{ $order->id }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Đơn hàng #{{ $order->id }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Danh sách đơn hàng
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Thông tin khách hàng -->
                <div class="bg-white rounded-xl border shadow-sm">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-900">Thông tin khách hàng</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-500">Họ tên</div>
                                <div class="mt-1 font-semibold text-gray-900">{{ $order->user->name }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Email</div>
                                <div class="mt-1 font-semibold text-gray-900">{{ $order->user->email }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Số điện thoại</div>
                            <div class="mt-1 font-semibold text-gray-900">{{ $order->phone }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Địa chỉ giao hàng</div>
                            <div class="mt-1 font-semibold text-gray-900">{{ $order->shipping_address }}</div>
                        </div>
                        @if($order->note)
                        <div>
                            <div class="text-sm text-gray-500">Ghi chú</div>
                            <div class="mt-1 text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $order->note }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sản phẩm -->
                <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-900">Sản phẩm đã đặt</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Sản phẩm</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Đơn giá</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">SL</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($order->details as $detail)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($detail->product && $detail->product->image)
                                                    <img src="{{ Storage::url($detail->product->image) }}" alt="{{ $detail->product->name }}" class="w-12 h-12 rounded object-cover">
                                                @else
                                                    <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center text-gray-400">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="font-medium text-gray-900">{{ $detail->product->name ?? 'Sản phẩm #'.$detail->product_id }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right text-gray-600">{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                                        <td class="px-6 py-4 text-right font-medium">x{{ $detail->quantity }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-gray-900">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-900">Tổng cộng:</td>
                                    <td class="px-6 py-4 text-right text-xl font-bold text-green-700">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Trạng thái -->
                <div class="bg-white rounded-xl border shadow-sm">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-900">Trạng thái đơn hàng</h3>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                            @csrf
                            @php
                                // Định nghĩa thứ tự trạng thái
                                $statusOrder = [
                                    'pending' => 1,
                                    'confirmed' => 2,
                                    'shipping' => 3,
                                    'completed' => 4,
                                    'cancelled' => 5,
                                ];
                                $currentOrder = $statusOrder[$order->status] ?? 0;
                                
                                // Không cho phép thay đổi nếu đã hoàn thành hoặc đã hủy
                                $isLocked = in_array($order->status, ['completed', 'cancelled']);
                            @endphp
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer {{ $order->status === 'pending' ? 'bg-yellow-50 border-yellow-300' : ($isLocked || $currentOrder > 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50') }}">
                                    <input type="radio" name="status" value="pending" 
                                        {{ $order->status === 'pending' ? 'checked' : '' }} 
                                        {{ $isLocked || $currentOrder > 1 ? 'disabled' : '' }}
                                        class="text-yellow-600">
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900">Chờ xử lý</div>
                                        <div class="text-xs text-gray-500">Đơn hàng mới, chưa xử lý</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer {{ $order->status === 'confirmed' ? 'bg-blue-50 border-blue-300' : ($isLocked || $currentOrder > 2 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50') }}">
                                    <input type="radio" name="status" value="confirmed" 
                                        {{ $order->status === 'confirmed' ? 'checked' : '' }}
                                        {{ $isLocked || $currentOrder > 2 ? 'disabled' : '' }}
                                        class="text-blue-600">
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900">Đã xác nhận</div>
                                        <div class="text-xs text-gray-500">Đã xác nhận đơn hàng</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer {{ $order->status === 'shipping' ? 'bg-purple-50 border-purple-300' : ($isLocked || $currentOrder > 3 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50') }}">
                                    <input type="radio" name="status" value="shipping" 
                                        {{ $order->status === 'shipping' ? 'checked' : '' }}
                                        {{ $isLocked || $currentOrder > 3 ? 'disabled' : '' }}
                                        class="text-purple-600">
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900">Đang giao hàng</div>
                                        <div class="text-xs text-gray-500">Đang trên đường giao</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer {{ $order->status === 'completed' ? 'bg-green-50 border-green-300' : ($isLocked ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50') }}">
                                    <input type="radio" name="status" value="completed" 
                                        {{ $order->status === 'completed' ? 'checked' : '' }}
                                        {{ $isLocked ? 'disabled' : '' }}
                                        class="text-green-600">
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900">Hoàn thành</div>
                                        <div class="text-xs text-gray-500">Đã giao hàng thành công</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer {{ $order->status === 'cancelled' ? 'bg-red-50 border-red-300' : ($isLocked ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50') }}">
                                    <input type="radio" name="status" value="cancelled" 
                                        {{ $order->status === 'cancelled' ? 'checked' : '' }}
                                        {{ $isLocked ? 'disabled' : '' }}
                                        class="text-red-600">
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900">Đã hủy</div>
                                        <div class="text-xs text-gray-500">Hủy đơn hàng</div>
                                    </div>
                                </label>
                            </div>
                            @if(!$isLocked)
                            <button type="submit" class="w-full mt-4 px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                                Cập nhật trạng thái
                            </button>
                            @else
                            <div class="mt-4 p-3 bg-gray-100 text-gray-600 rounded-lg text-center text-sm">
                                Không thể thay đổi trạng thái đơn hàng này
                            </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Thông tin tổng quan -->
                <div class="bg-white rounded-xl border shadow-sm">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-900">Thông tin đơn hàng</h3>
                    </div>
                    <div class="p-6 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Mã đơn:</span>
                            <span class="font-semibold">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ngày tạo:</span>
                            <span class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Số sản phẩm:</span>
                            <span class="font-semibold">{{ $order->details->count() }}</span>
                        </div>
                        <div class="flex justify-between pt-3 border-t">
                            <span class="text-gray-500">Tổng tiền:</span>
                            <span class="font-bold text-green-700">{{ number_format($order->total_price, 0, ',', '.') }} đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
