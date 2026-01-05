<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👥 Quản Lý Người Dùng
            </h2>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm Người Dùng
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Thông báo -->
            @if ($message = session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    {{ $message }}
                </div>
            @endif

            @if ($message = session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    {{ $message }}
                </div>
            @endif

            <!-- Bảng danh sách người dùng -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">ID</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Tên</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Quyền</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Ngày tạo</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900">#{{ $user->id }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if ($user->is_admin)
                                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 font-semibold rounded-full text-xs">👤 Admin</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 font-semibold rounded-full text-xs">👤 Khách</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-xs">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                        👁️ Xem
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold">
                                        ✏️ Sửa
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                                🗑️ Xóa
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 font-semibold cursor-not-allowed">🗑️ Xóa</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Không có người dùng nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
