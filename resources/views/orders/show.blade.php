<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn #{{ $order->id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Đơn hàng #{{ $order->id }}</h1>
            <a href="{{ route('orders.index') }}" class="text-green-600 hover:text-green-700">← Danh sách đơn</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl border p-4">
                <div class="text-sm text-gray-500">Trạng thái</div>
                <div class="mt-1 font-semibold">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : 'bg-green-50 text-green-700' }}">{{ $order->status }}</span>
                </div>
            </div>
            <div class="bg-white rounded-xl border p-4">
                <div class="text-sm text-gray-500">Ngày tạo</div>
                <div class="mt-1 font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="bg-white rounded-xl border p-4">
                <div class="text-sm text-gray-500">Tổng tiền</div>
                <div class="mt-1 font-semibold">{{ number_format($order->total_price, 0, ',', '.') }} đ</div>
            </div>
            <div class="bg-white rounded-xl border p-4 md:col-span-2">
                <div class="text-sm text-gray-500">Địa chỉ giao hàng</div>
                <div class="mt-1 font-semibold">{{ $order->shipping_address }}</div>
            </div>
            <div class="bg-white rounded-xl border p-4">
                <div class="text-sm text-gray-500">Số điện thoại</div>
                <div class="mt-1 font-semibold">{{ $order->phone }}</div>
            </div>
            @if($order->note)
            <div class="bg-white rounded-xl border p-4 md:col-span-3">
                <div class="text-sm text-gray-500">Ghi chú</div>
                <div class="mt-1">{{ $order->note }}</div>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden mb-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sản phẩm</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Đơn giá</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->details as $detail)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $detail->product->name ?? ('#'.$detail->product_id) }}</div>
                            </td>
                            <td class="px-4 py-3 text-right">{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                            <td class="px-4 py-3 text-right">x{{ $detail->quantity }}</td>
                            <td class="px-4 py-3 text-right font-semibold">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Review Section (only for completed orders) -->
        @if($order->status === 'completed')
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-2xl font-bold mb-6">💬 Đánh giá từ khách hàng</h2>
            <p class="text-sm text-gray-600 mb-6">Hãy cho chúng tôi biết trải nghiệm của bạn về sản phẩm</p>

            @foreach($order->details as $detail)
            <div class="mb-8 p-6 bg-gray-50 rounded-xl border @if(isset($userReviews[$detail->product_id])) border-green-200 @endif">
                <div class="flex items-center gap-4 mb-4">
                    @if($detail->product->image)
                        <img src="{{ Storage::url($detail->product->image) }}" alt="{{ $detail->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                    @endif
                    <div class="flex-1">
                        <h3 class="font-bold text-lg">{{ $detail->product->name }}</h3>
                        <p class="text-sm text-gray-600">{{ number_format($detail->price, 0, ',', '.') }} ₫</p>
                    </div>
                </div>

                @php
                    $existingReview = $userReviews[$detail->product_id] ?? null;
                @endphp

                @if($existingReview)
                    <!-- Show existing review -->
                    <div class="bg-white rounded-lg p-4 border border-green-200">
                        <p class="text-sm text-green-700 font-medium mb-2">✓ Bạn đã đánh giá sản phẩm này</p>
                        <div class="flex gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        @if($existingReview->comment)
                            <p class="text-gray-700">{{ $existingReview->comment }}</p>
                        @endif
                    </div>
                @else
                    <!-- Review Form -->
                    <form method="POST" action="{{ route('orders.review', ['order' => $order->id, 'product' => $detail->product_id]) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Đánh giá</label>
                            <div class="flex gap-2" data-rating-group>
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer rating-star" data-value="{{ $i }}">
                                        <input type="radio" name="rating" value="{{ $i }}" required class="sr-only">
                                        <svg class="w-8 h-8 text-gray-300 transition" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Nhận xét (tùy chọn)</label>
                            <textarea name="comment" maxlength="500" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm" placeholder="Chia sẻ trải nghiệm của bạn..."></textarea>
                            <p class="text-xs text-gray-500 mt-1">Tối đa 500 ký tự</p>
                        </div>

                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">
                            Gửi đánh giá
                        </button>
                    </form>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const groups = document.querySelectorAll('[data-rating-group]');

    groups.forEach(group => {
        const stars = group.querySelectorAll('.rating-star');

        const applyHighlight = value => {
            stars.forEach(star => {
                const starValue = Number(star.dataset.value);
                const icon = star.querySelector('svg');
                icon.classList.toggle('text-yellow-400', starValue <= value);
                icon.classList.toggle('text-gray-300', starValue > value);
            });
        };

        stars.forEach(star => {
            const value = Number(star.dataset.value);
            const input = star.querySelector('input[type="radio"]');

            star.addEventListener('mouseenter', () => applyHighlight(value));
            star.addEventListener('click', () => {
                input.checked = true;
                applyHighlight(value);
            });
        });

        group.addEventListener('mouseleave', () => {
            const checked = group.querySelector('input[type="radio"]:checked');
            applyHighlight(checked ? Number(checked.value) : 0);
        });

        const checked = group.querySelector('input[type="radio"]:checked');
        applyHighlight(checked ? Number(checked.value) : 0);
    });
});
</script>
</html>
