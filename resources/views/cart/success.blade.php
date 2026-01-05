<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-12">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold mb-3">Đặt hàng thành công!</h1>
            <p class="text-gray-600 mb-8">Cảm ơn bạn đã mua sắm tại Farm Fresh. Chúng tôi sẽ liên hệ để xác nhận và giao hàng sớm nhất.</p>
        </div>

        @php
            $order = null;
            if(request('order')) {
                $order = \App\Models\Order::find(request('order'));
            }
        @endphp

        @if($order && $order->payment_method === 'qr')
            <div class="bg-white rounded-2xl border shadow-sm p-6 mb-6">
                <h2 class="text-lg font-bold mb-4 text-center">Quét mã QR để thanh toán</h2>
                <div class="flex flex-col items-center">
                    <div class="bg-white p-4 rounded-lg border-2 border-gray-200 mb-4">
                        <img src="https://img.vietqr.io/image/{{ env('PAYMENT_BANK_CODE', 'MB') }}-{{ env('PAYMENT_ACCOUNT_NUMBER', '0905158855') }}-compact2.png?amount={{ $order->total_price }}&addInfo=FARMFRESH%20DH{{ $order->id }}" 
                             alt="QR Code" 
                             class="w-64 h-64">
                    </div>
                    <div class="text-center space-y-2">
                        <p class="font-semibold">Ngân hàng: {{ env('PAYMENT_BANK_NAME', 'MB Bank') }}</p>
                        <p class="text-gray-600">Chủ TK: <span class="font-semibold">{{ env('PAYMENT_ACCOUNT_NAME', '') }}</span></p>
                        <p class="text-gray-600">STK: <span class="font-mono font-bold">{{ env('PAYMENT_ACCOUNT_NUMBER', '0905158855') }}</span></p>
                        <p class="text-gray-600">Số tiền: <span class="font-bold text-green-600">{{ number_format($order->total_price, 0, ',', '.') }} đ</span></p>
                        <p class="text-gray-600">Nội dung: <span class="font-mono font-bold">FARMFRESH DH{{ $order->id }}</span></p>
                    </div>
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">⚠️ Vui lòng chuyển khoản đúng nội dung để đơn hàng được xử lý nhanh nhất.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="text-center space-x-3">
            <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-lg bg-green-600 text-white hover:bg-green-700">Tiếp tục mua sắm</a>
            <a href="{{ route('cart.index') }}" class="px-5 py-2.5 rounded-lg bg-white border hover:bg-gray-50">Xem giỏ hàng</a>
            @if($order)
                <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="px-5 py-2.5 rounded-lg bg-white border hover:bg-gray-50">Xem đơn #{{ $order->id }}</a>
            @endif
        </div>
    </div>
</body>
</html>
