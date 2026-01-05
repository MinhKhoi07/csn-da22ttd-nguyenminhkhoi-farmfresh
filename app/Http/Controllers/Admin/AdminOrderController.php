<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->withCount('details')->latest();

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Tìm kiếm theo mã đơn hoặc tên khách
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(15)->withQueryString();
        
        // Thống kê
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'shipping' => Order::where('status', 'shipping')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'details.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled'
        ]);

        $newStatus = $request->status;
        $currentStatus = $order->status;

        // Định nghĩa thứ tự trạng thái
        $statusOrder = [
            'pending' => 1,
            'confirmed' => 2,
            'shipping' => 3,
            'completed' => 4,
            'cancelled' => 5,
        ];

        // Kiểm tra không cho phép quay lại trạng thái trước
        // Ngoại trừ trạng thái "cancelled" có thể chuyển từ bất kỳ trạng thái nào
        if ($newStatus !== 'cancelled') {
            $currentOrder = $statusOrder[$currentStatus] ?? 0;
            $newOrder = $statusOrder[$newStatus] ?? 0;
            
            if ($newOrder <= $currentOrder && $currentStatus !== 'pending') {
                return redirect()->route('admin.orders.show', $order)
                    ->with('error', 'Không thể quay lại trạng thái trước đó.');
            }
        }

        // Không cho phép thay đổi nếu đã hoàn thành hoặc đã hủy
        if (in_array($currentStatus, ['completed', 'cancelled'])) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Không thể thay đổi trạng thái của đơn hàng đã hoàn thành hoặc đã hủy.');
        }

        $order->update(['status' => $newStatus]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
