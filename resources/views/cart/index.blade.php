<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Giỏ hàng</h1>
            <a href="{{ route('home') }}" class="text-green-600 hover:text-green-700">← Tiếp tục mua sắm</a>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 rounded-md bg-green-50 text-green-700 border border-green-200">{{ session('status') }}</div>
        @endif

        @if (empty($items))
            <div class="bg-white rounded-xl border p-8 text-center text-gray-600 mb-6">
                Giỏ hàng của bạn đang trống.
            </div>
        @else
            <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b">
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        Chọn tất cả
                    </label>
                    <div class="text-sm text-gray-500">Đã chọn: <span id="selectedCount">0</span></div>
                </div>
                <div class="divide-y" id="cartItems">
                    @foreach ($items as $item)
                        <div class="p-4 flex items-center gap-4" data-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}" data-qty="{{ $item['quantity'] }}">
                            <div>
                                <input type="checkbox" class="select-item rounded border-gray-300 w-5 h-5" value="{{ $item['id'] }}">
                            </div>
                            <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                                @if ($item['image'])
                                    <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="object-cover w-full h-full">
                                @else
                                    <span class="text-xs text-gray-400">No image</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium truncate">{{ $item['name'] }}</div>
                                @if(!empty($item['has_promotion']) && $item['has_promotion'])
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-sm font-semibold text-red-600">{{ number_format($item['price'], 0, ',', '.') }} đ</span>
                                        <span class="text-xs text-gray-400 line-through">{{ number_format($item['original_price'], 0, ',', '.') }} đ</span>
                                        <span class="text-xs font-bold text-white bg-red-500 px-1.5 py-0.5 rounded">-{{ $item['discount_percentage'] }}%</span>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">{{ number_format($item['price'], 0, ',', '.') }} đ</div>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('cart.update', $item['id']) }}" class="flex items-center gap-2">
                                    @csrf
                                    <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="w-20 rounded-lg border-gray-300" />
                                    <button class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm" type="submit">Cập nhật</button>
                                </form>
                                <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                    @csrf
                                    <button class="px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-sm" type="submit">Xóa</button>
                                </form>
                            </div>
                            <div class="w-32 text-right font-semibold">
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-4 flex items-center justify-between bg-gray-50">
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700" type="submit">Làm trống giỏ</button>
                    </form>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Tổng giỏ: {{ number_format($total, 0, ',', '.') }} đ</div>
                        <div class="text-xl font-bold">Tổng (đã chọn): <span id="selectedTotal">0</span> đ</div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <form id="checkoutForm" method="POST" action="{{ route('cart.checkout') }}">
                    @csrf
                    <div id="selectedInputs"></div>
                    <button class="px-6 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold" type="submit">Thanh toán</button>
                </form>
            </div>
        @endif
    </div>

    <script>
        (function(){
            const selectAll = document.getElementById('selectAll');
            const container = document.getElementById('cartItems');
            const countEl = document.getElementById('selectedCount');
            const totalEl = document.getElementById('selectedTotal');
            const form = document.getElementById('checkoutForm');
            const inputsHolder = document.getElementById('selectedInputs');

            function getItems(){
                return Array.from(container.querySelectorAll('.select-item'));
            }

            function updateSummary(){
                const items = getItems();
                const checked = items.filter(i => i.checked);
                countEl.textContent = checked.length;

                let total = 0;
                checked.forEach(chk => {
                    const row = chk.closest('[data-id]');
                    const price = parseFloat(row.dataset.price || '0');
                    const qty = parseInt(row.dataset.qty || '1');
                    total += price * qty;
                });
                totalEl.textContent = new Intl.NumberFormat('vi-VN').format(total);

                selectAll.checked = checked.length === items.length && items.length > 0;
                selectAll.indeterminate = checked.length > 0 && checked.length < items.length;
            }

            selectAll && selectAll.addEventListener('change', () => {
                getItems().forEach(i => i.checked = selectAll.checked);
                updateSummary();
            });

            container && container.addEventListener('change', (e) => {
                if (e.target.classList.contains('select-item')) updateSummary();
            });

            // When quantities are updated via the small form, we cannot intercept server update here.
            // But we keep dataset qty in sync when input changes before submit.
            container && container.addEventListener('input', (e) => {
                if (e.target.name === 'quantity'){
                    const row = e.target.closest('[data-id]');
                    row.dataset.qty = e.target.value;
                    updateSummary();
                }
            });

            form && form.addEventListener('submit', (e) => {
                inputsHolder.innerHTML = '';
                const checked = getItems().filter(i => i.checked);
                if (checked.length === 0){
                    e.preventDefault();
                    alert('Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
                    return false;
                }
                checked.forEach(chk => {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'selected[]';
                    hidden.value = chk.value;
                    inputsHolder.appendChild(hidden);
                });
            });

            // Initialize summary on load
            updateSummary();
        })();
    </script>

    <!-- Recent Orders Section -->
    @if(Auth::check() && $recentOrders->count() > 0)
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">📦 Đơn hàng gần đây</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($recentOrders as $order)
                    <a href="{{ route('orders.show', $order->id) }}" class="bg-white rounded-xl border shadow-sm hover:shadow-lg transition p-4 block">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-gray-500">Đơn #{{ $order->id }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ 
                                $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                ($order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))
                            }}">
                                {{ $order->status === 'pending' ? '⏳ Chờ xử lý' : 
                                   ($order->status === 'confirmed' ? '✓ Đã xác nhận' : 
                                   ($order->status === 'completed' ? '✓✓ Đã giao' : '❌ Hủy')) }}
                            </span>
                        </div>
                        <div class="space-y-2 mb-3 pb-3 border-b">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Thời gian:</span> {{ $order->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Phương thức:</span> 
                                {{ $order->payment_method === 'cod' ? '🚚 Ship COD' : '💳 Quét QR' }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $order->details->sum('quantity') }} sản phẩm</span>
                            <span class="text-lg font-bold text-green-600">{{ number_format($order->total_price, 0, ',', '.') }} đ</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</body>
</html>
