<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chi tiết Đánh giá #') }}{{ $review->id }}
            </h2>
            <a href="{{ route('admin.reviews.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                ← Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Thông tin sản phẩm -->
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="text-lg font-bold mb-4">Sản phẩm được đánh giá</h3>
                        <div class="flex items-start gap-4">
                            @if($review->product->image)
                                <img src="{{ Storage::url($review->product->image) }}" alt="{{ $review->product->name }}" class="w-20 h-20 object-cover rounded">
                            @endif
                            <div>
                                <div class="font-bold text-lg">{{ $review->product->name }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $review->product->id }}</div>
                                <div class="text-sm text-gray-500">Giá: {{ number_format($review->product->price) }}đ</div>
                                <a href="{{ route('products.show', $review->product->id) }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                    Xem sản phẩm →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin người đánh giá -->
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="text-lg font-bold mb-4">Người đánh giá</h3>
                        <div class="space-y-2">
                            <div><strong>Tên:</strong> {{ $review->user->name }}</div>
                            <div><strong>Email:</strong> {{ $review->user->email }}</div>
                            <div><strong>Ngày đánh giá:</strong> {{ $review->created_at->format('d/m/Y H:i:s') }}</div>
                        </div>
                    </div>

                    <!-- Đánh giá -->
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="text-lg font-bold mb-4">Đánh giá</h3>
                        <div class="flex items-center mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-2xl text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400">★</span>
                            @endfor
                            <span class="ml-3 text-xl font-bold">{{ $review->rating }}/5</span>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <strong class="block mb-2">Nội dung:</strong>
                            <p class="text-gray-700">{{ $review->comment ?: 'Không có nội dung' }}</p>
                        </div>
                    </div>

                    <!-- Thao tác -->
                    <div class="flex gap-3">
                        <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Quay lại
                        </a>
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Xóa đánh giá
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
