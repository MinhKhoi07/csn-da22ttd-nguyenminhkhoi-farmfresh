<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm yêu thích</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Sản phẩm yêu thích</h1>
            <a href="{{ route('home') }}" class="text-green-600 hover:text-green-700">← Về trang chủ</a>
        </div>

        @if ($favorites->isEmpty())
            <div class="bg-white border rounded-2xl shadow-sm p-10 text-center text-gray-500">
                Chưa có sản phẩm yêu thích nào.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($favorites as $fav)
                    @php($product = $fav->product)
                    @if ($product)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-lg transition flex flex-col">
                        <div class="relative h-48 bg-gray-100 rounded-t-2xl overflow-hidden">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                            @endif
                            <button
                                class="js-fav-btn absolute top-3 right-3 bg-white/90 backdrop-blur p-2.5 rounded-full shadow-lg text-red-500 hover:scale-110 transition duration-300"
                                data-product-id="{{ $product->id }}"
                                aria-pressed="true"
                                title="Bỏ yêu thích">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                        <div class="p-4 flex flex-col gap-2 flex-1">
                            <div class="text-sm text-gray-500">{{ $product->category->name ?? 'Danh mục' }}</div>
                            <div class="text-lg font-bold text-gray-900 line-clamp-2">{{ $product->name }}</div>
                            <div class="text-xl font-extrabold text-green-600">{{ number_format($product->price) }}đ <span class="text-sm text-gray-500">/{{ $product->unit }}</span></div>
                            <div class="mt-auto flex gap-2">
                                <form class="js-add-to-cart-form flex-1" method="POST" action="{{ route('cart.add', $product->id) }}">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full py-2 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition">Thêm vào giỏ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-6">
                {{ $favorites->links() }}
            </div>
        @endif
    </div>
</body>
</html>
