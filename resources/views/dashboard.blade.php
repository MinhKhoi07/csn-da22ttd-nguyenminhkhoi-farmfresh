<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Bảng điều khiển
                </h2>
                <p class="text-sm text-gray-500">Xin chào, <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span> 👋</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border hover:bg-gray-50 text-sm text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Về trang chủ
            </a>
        </div>
    </x-slot>

    @php
        $user = Auth::user();
        $ordersCount = \App\Models\Order::where('user_id', $user->id)->count();
        $pendingCount = \App\Models\Order::where('user_id', $user->id)->where('status','pending')->count();
        $cartCount = collect(session('cart', []))->sum('quantity');
        $recentOrders = \App\Models\Order::where('user_id', $user->id)->latest()->take(5)->get();
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <div class="text-sm text-gray-500">Tổng đơn hàng</div>
                    <div class="mt-2 text-2xl font-extrabold text-gray-900">{{ $ordersCount }}</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <div class="text-sm text-gray-500">Đang chờ xử lý</div>
                    <div class="mt-2 text-2xl font-extrabold text-yellow-600">{{ $pendingCount }}</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <div class="text-sm text-gray-500">Sản phẩm trong giỏ</div>
                    <div class="mt-2 text-2xl font-extrabold text-green-600">{{ $cartCount }}</div>
                </div>
            </div>

            <!-- Quick actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="{{ route('orders.index') }}" class="group bg-white border rounded-xl p-4 hover:shadow-md transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">📦</div>
                    <div class="font-semibold text-gray-800 group-hover:text-blue-700">Đơn hàng</div>
                </a>
                <a href="{{ route('cart.index') }}" class="group bg-white border rounded-xl p-4 hover:shadow-md transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">🛒</div>
                    <div class="font-semibold text-gray-800 group-hover:text-green-700">Giỏ hàng</div>
                </a>
                <a href="{{ route('profile.edit') }}" class="group bg-white border rounded-xl p-4 hover:shadow-md transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">👤</div>
                    <div class="font-semibold text-gray-800 group-hover:text-amber-700">Tài khoản</div>
                </a>
                <a href="{{ route('home') }}" class="group bg-white border rounded-xl p-4 hover:shadow-md transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-50 text-gray-600 flex items-center justify-center">🏬</div>
                    <div class="font-semibold text-gray-800 group-hover:text-gray-700">Cửa hàng</div>
                </a>
                @if($user->is_admin ?? false)
                <a href="{{ route('admin.dashboard') }}" class="group bg-white border rounded-xl p-4 hover:shadow-md transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">🛠</div>
                    <div class="font-semibold text-gray-800 group-hover:text-purple-700">Quản trị</div>
                </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="bg-white border rounded-xl p-4 hover:shadow-md transition">
                    @csrf
                    <button class="w-full flex items-center gap-3 text-left" type="submit">
                        <div class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">🚪</div>
                        <div class="font-semibold text-gray-800 hover:text-rose-700">Đăng xuất</div>
                    </button>
                </form>
            </div>

            <!-- Recent orders -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Đơn hàng gần đây</h3>
                    <a href="{{ route('orders.index') }}" class="text-sm text-green-700 hover:underline">Xem tất cả</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-6 py-3 text-left">Mã đơn</th>
                                <th class="px-6 py-3 text-left">Ngày tạo</th>
                                <th class="px-6 py-3 text-left">Trạng thái</th>
                                <th class="px-6 py-3 text-right">Tổng tiền</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($recentOrders as $o)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3 font-medium">#{{ $o->id }}</td>
                                    <td class="px-6 py-3 text-gray-600">{{ $o->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $o->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : 'bg-green-50 text-green-700' }}">{{ $o->status }}</span>
                                    </td>
                                    <td class="px-6 py-3 text-right font-semibold">{{ number_format($o->total_price, 0, ',', '.') }} đ</td>
                                    <td class="px-6 py-3 text-right"><a href="{{ route('orders.show', $o) }}" class="text-green-700 hover:underline">Xem</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">Bạn chưa có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
