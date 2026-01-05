<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - FARM FRESH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 h-20 flex items-center justify-between gap-4 md:gap-8">
            <a href="/" class="flex items-center gap-2 flex-shrink-0 group">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-2xl shadow-lg">🥦</div>
                <span class="text-xl font-extrabold text-gray-900 hidden sm:block">FARM<span class="text-green-600">FRESH</span></span>
            </a>
            <div class="flex-1"></div>
            <a href="{{ route('home') }}" class="text-green-600 hover:text-green-700 font-bold">← Quay lại</a>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 py-8">
        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 border border-green-200">{{ session('status') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Product Image -->
            <div class="bg-white rounded-2xl border shadow-sm p-6">
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-gray-300 text-center">
                            <svg class="w-20 h-20 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-semibold">Ảnh đang cập nhật</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <!-- Category and Rating -->
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-green-50 border border-green-200 text-green-700 text-xs font-bold uppercase">
                        {{ $product->category->name ?? 'Nông sản' }}
                    </span>
                </div>

                <!-- Title and Price -->
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <div class="flex items-baseline gap-2 mb-4">
                        @if($product->has_promotion)
                            <div class="flex flex-col gap-2">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-extrabold text-red-600">{{ number_format($product->discounted_price, 0, ',', '.') }}đ</span>
                                    <span class="text-lg text-gray-600">/ {{ $product->unit }}</span>
                                    <span class="text-lg font-bold text-red-600 bg-red-50 px-3 py-1 rounded-lg border border-red-200">
                                        -{{ number_format($product->discount_percentage, 0) }}%
                                    </span>
                                </div>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-xl text-gray-400 line-through">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                    <span class="text-sm text-gray-500">Giá gốc</span>
                                </div>
                            </div>
                        @else
                            <span class="text-4xl font-extrabold text-green-600">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                            <span class="text-lg text-gray-600">/ {{ $product->unit }}</span>
                        @endif
                    </div>
                </div>

                <!-- Rating Summary -->
                <div class="border-t border-b py-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <div class="flex items-center gap-1 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($product->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($product->average_rating, 1) }}</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p class="font-semibold">{{ $product->review_count }} đánh giá</p>
                        </div>
                    </div>
                </div>

                <!-- Origin -->
                @if($product->origin)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-600 font-medium">📍 Nguồn gốc</p>
                        <p class="text-lg font-semibold text-blue-900">{{ $product->origin }}</p>
                    </div>
                @endif

                <!-- Description -->
                @if($product->description)
                    <div>
                        <h3 class="text-lg font-bold mb-2">Mô tả sản phẩm</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Add to Cart Button -->
                <form class="js-add-to-cart-form" method="POST" action="{{ route('cart.add', $product->id) }}">
                    @csrf
                    <div class="flex gap-4">
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-white">
                            <button type="button" data-qty-dec class="px-4 py-3 hover:bg-gray-100 font-bold text-lg transition">−</button>
                            <input type="number" name="quantity" value="1" min="1" step="1" data-qty-input 
                                class="w-16 text-center border-none outline-none font-bold text-lg py-3 appearance-none" 
                                style="-moz-appearance: textfield; appearance: textfield;">
                            <button type="button" data-qty-inc class="px-4 py-3 hover:bg-gray-100 font-bold text-lg transition">+</button>
                        </div>
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg">
                            🛒 Thêm vào giỏ
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="bg-white rounded-2xl border shadow-sm p-8">
            <h2 class="text-2xl font-bold mb-6">💬 Đánh giá từ khách hàng</h2>

            <!-- Reviews List -->
            <div class="space-y-4">
                @forelse($product->reviews()->latest()->get() as $review)
                    <div class="border rounded-lg p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="font-bold text-gray-900">{{ $review->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $review->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                                <span class="ml-2 font-bold text-gray-900">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="text-gray-700">{{ $review->comment }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-8">Chưa có đánh giá nào. Hãy là người đầu tiên mua và đánh giá sản phẩm!</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        // Quantity control handlers
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.querySelector('[data-qty-input]');
            const incBtn = document.querySelector('[data-qty-inc]');
            const decBtn = document.querySelector('[data-qty-dec]');

            if (input && incBtn && decBtn) {
                const clampValue = (value) => {
                    const parsed = Number.parseInt(value, 10);
                    return Number.isNaN(parsed) || parsed < 1 ? 1 : parsed;
                };

                incBtn.addEventListener('click', () => {
                    input.value = clampValue(input.value) + 1;
                });

                decBtn.addEventListener('click', () => {
                    const next = clampValue(input.value) - 1;
                    input.value = next < 1 ? 1 : next;
                });

                input.addEventListener('input', () => {
                    input.value = clampValue(input.value);
                });

                // Ensure initial value is valid
                input.value = clampValue(input.value || 1);
            }
        });

        // Add to cart AJAX handler
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.js-add-to-cart-form');
            if (!form) return;

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '⏳ Đang thêm...';
                
                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    // Nếu không nhận JSON hợp lệ thì coi như lỗi
                    let data = {};
                    try {
                        data = await response.json();
                    } catch (_) {}

                    if (response.status === 401) {
                        window.location.href = (data && data.redirect) ? data.redirect : '/login';
                        return;
                    }

                    if (data.status === 'ok' || data.status === 'success') {
                        submitBtn.innerHTML = '✓ Đã thêm!';
                        submitBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                        submitBtn.classList.add('bg-green-500');

                        setTimeout(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.classList.remove('bg-green-500');
                            submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                            submitBtn.disabled = false;
                        }, 1500);
                        return;
                    }

                    // Trường hợp không có status ok/success
                    submitBtn.innerHTML = '❌ Lỗi';
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 1500);
                } catch (error) {
                    console.error('Error:', error);
                    submitBtn.innerHTML = '❌ Lỗi';
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 1500);
                }
            });
        });
    </script>
</body>
</html>
