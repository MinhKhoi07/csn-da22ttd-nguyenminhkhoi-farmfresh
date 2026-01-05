<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chi tiết Liên hệ #{{ $contact->id }}
            </h2>
            <a href="{{ route('admin.contacts.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                ← Quay lại
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Thông tin cơ bản -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Thông tin khách hàng</h3>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Họ tên</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $contact->name }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="text-lg font-semibold text-blue-600">
                                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                </p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Số điện thoại</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $contact->phone ?? 'Không cung cấp' }}
                                </p>
                            </div>
                        </div>

                        <!-- Trạng thái -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Thông tin liên hệ</h3>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Tiêu đề</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $contact->subject }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Trạng thái</p>
                                <form action="{{ route('admin.contacts.updateStatus', $contact->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                                        <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>Mới</option>
                                        <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Đã đọc</option>
                                        <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Đã trả lời</option>
                                    </select>
                                </form>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Ngày gửi</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Nội dung tin nhắn -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Nội dung tin nhắn</h3>
                        <div class="p-4 bg-gray-50 border border-gray-300 rounded-lg">
                            <p class="text-gray-800 whitespace-pre-wrap">{{ $contact->message }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <a href="mailto:{{ $contact->email }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg">
                            ✉️ Gửi Email
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                🗑️ Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
