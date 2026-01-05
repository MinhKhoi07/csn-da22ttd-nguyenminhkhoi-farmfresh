<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Khuyến mãi') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                ← Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Phần Tiêu đề và Nút Thêm mới -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Danh sách khuyến mãi</h3>
                        <a href="{{ route('admin.promotions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Thêm khuyến mãi mới
                        </a>
                    </div>

                    <!-- Hiển thị thông báo -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Bảng Danh sách -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên KM</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Áp dụng</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giảm giá</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thời gian</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($promotions as $promotion)
                                    <tr class="{{ $promotion->isValid() ? 'bg-green-50' : '' }}">
                                        <td class="px-4 py-4">
                                            <div class="font-bold">{{ $promotion->name }}</div>
                                            @if($promotion->description)
                                                <div class="text-xs text-gray-500">{{ Str::limit($promotion->description, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if($promotion->type === 'category')
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">Danh mục</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-800">Sản phẩm</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($promotion->type === 'category' && $promotion->category)
                                                <div class="text-sm font-semibold">{{ $promotion->category->name }}</div>
                                            @elseif($promotion->type === 'product' && $promotion->product)
                                                <div class="text-sm font-semibold">{{ $promotion->product->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $promotion->product->category->name ?? '' }}</div>
                                            @else
                                                <span class="text-red-500 text-sm">Đã xóa</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if($promotion->discount_type === 'percentage')
                                                <span class="font-bold text-green-600">-{{ number_format($promotion->discount_value, 0) }}%</span>
                                            @else
                                                <span class="font-bold text-green-600">-{{ number_format($promotion->discount_value, 0, ',', '.') }}đ</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm">
                                            <div>{{ $promotion->start_date->format('d/m/Y H:i') }}</div>
                                            <div>{{ $promotion->end_date->format('d/m/Y H:i') }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if($promotion->isValid())
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">✓ Đang chạy</span>
                                            @elseif($promotion->is_active && $promotion->start_date > now())
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">⏳ Sắp diễn ra</span>
                                            @elseif($promotion->end_date < now())
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">⏹ Đã kết thúc</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">✕ Tắt</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                                            
                                            <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa khuyến mãi này không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Chưa có khuyến mãi nào. Hãy tạo khuyến mãi mới!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Phân trang -->
                    <div class="mt-4">
                        {{ $promotions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
