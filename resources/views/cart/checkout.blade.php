<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận thanh toán</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Xác nhận thanh toán</h1>
            <a href="{{ route('cart.index') }}" class="text-green-600 hover:text-green-700">← Quay lại giỏ hàng</a>
        </div>

        <form method="POST" action="{{ isset($buyNow) && $buyNow ? route('cart.buy_now.confirm') : route('cart.checkout.confirm') }}" class="bg-white rounded-2xl border shadow-sm overflow-hidden">
            @csrf
            <div class="divide-y">
                @foreach ($items as $item)
                    <div class="p-4 flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                            @if ($item['image'])
                                <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="object-cover w-full h-full">
                            @else
                                <span class="text-xs text-gray-400">No image</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium truncate">{{ $item['name'] }}</div>
                            <div class="text-sm text-gray-500">Giá: {{ number_format($item['price'], 0, ',', '.') }} đ</div>
                            <div class="text-sm text-gray-500">Số lượng: x{{ $item['quantity'] }}</div>
                        </div>
                        <div class="w-32 text-right font-semibold">
                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ
                        </div>
                        @if(isset($buyNow) && $buyNow)
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
                        @else
                            <input type="hidden" name="selected[]" value="{{ $item['id'] }}">
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ giao hàng</label>
                        <input name="shipping_address" required class="w-full rounded-lg border-gray-300" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                        <input name="phone" required class="w-full rounded-lg border-gray-300" placeholder="090xxxxxxx" />
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                        <textarea name="note" rows="3" class="w-full rounded-lg border-gray-300" placeholder="Yêu cầu giao hàng, thời gian nhận..."></textarea>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phương thức thanh toán</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-500 transition payment-option">
                                <input type="radio" name="payment_method" value="cod" checked class="sr-only peer" onchange="updatePaymentUI()">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-2xl peer-checked:bg-green-100">
                                        🚚
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-bold text-gray-900">Ship COD</div>
                                        <div class="text-sm text-gray-500">Thanh toán khi nhận hàng</div>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-green-600 peer-checked:bg-green-600 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 12 12"><path d="M10 3L4.5 8.5L2 6"/></svg>
                                </div>
                            </label>
                            <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-500 transition payment-option">
                                <input type="radio" name="payment_method" value="qr" class="sr-only peer" onchange="updatePaymentUI()">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-2xl peer-checked:bg-blue-100">
                                        📱
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-bold text-gray-900">Quét QR</div>
                                        <div class="text-sm text-gray-500">Chuyển khoản qua QR code</div>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-green-600 peer-checked:bg-green-600 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 12 12"><path d="M10 3L4.5 8.5L2 6"/></svg>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-xl font-bold">Tổng thanh toán: {{ number_format($total, 0, ',', '.') }} đ</div>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold">Xác nhận đặt hàng</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function updatePaymentUI() {
            const options = document.querySelectorAll('.payment-option');
            options.forEach(opt => {
                const radio = opt.querySelector('input[type="radio"]');
                if (radio.checked) {
                    opt.classList.add('border-green-500', 'bg-green-50');
                    opt.classList.remove('border-gray-200');
                } else {
                    opt.classList.remove('border-green-500', 'bg-green-50');
                    opt.classList.add('border-gray-200');
                }
            });
        }
        updatePaymentUI();
    </script>
</body>
</html>
