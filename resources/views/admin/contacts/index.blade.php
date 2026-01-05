<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Liên hệ') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                ← Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Tổng liên hệ</p>
                            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['total'] }}</p>
                        </div>
                        <div class="text-3xl">📧</div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Mới</p>
                            <p class="text-3xl font-bold text-red-600 mt-1">{{ $stats['new'] }}</p>
                        </div>
                        <div class="text-3xl">⭐</div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Đã đọc</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['read'] }}</p>
                        </div>
                        <div class="text-3xl">👁️</div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Đã trả lời</p>
                            <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['replied'] }}</p>
                        </div>
                        <div class="text-3xl">✅</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Danh sách liên hệ -->
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($contacts as $contact)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap font-bold">{{ $contact->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $contact->email }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold">{{ Str::limit($contact->subject, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($contact->status === 'new')
                                            <span class="px-3 py-1 text-xs font-bold text-white bg-red-500 rounded-full">Mới</span>
                                        @elseif ($contact->status === 'read')
                                            <span class="px-3 py-1 text-xs font-bold text-white bg-yellow-500 rounded-full">Đã đọc</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold text-white bg-green-500 rounded-full">Đã trả lời</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $contact->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                            👁️ Xem
                                        </a>
                                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                                🗑️ Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Chưa có liên hệ nào
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
