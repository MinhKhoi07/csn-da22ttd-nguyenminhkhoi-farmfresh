<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Lấy thống kê
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $totalRevenue = Order::sum('total_price') ?? 0;
        
        // Sản phẩm bán chạy nhất
        $bestSellingProducts = Product::with('category')
            ->withCount('orderDetails')
            ->orderByDesc('order_details_count')
            ->limit(5)
            ->get();
        
        // Đơn hàng gần đây
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'bestSellingProducts',
            'recentOrders'
        ));
    }

    public function stats()
    {
        $overview = [
            'total_revenue'    => Order::sum('total_price') ?? 0,
            'avg_order_value'  => Order::avg('total_price') ?? 0,
            'total_orders'     => Order::count(),
            'orders_today'     => Order::whereDate('created_at', now()->toDateString())->count(),
            'pending'          => Order::where('status', 'pending')->count(),
            'confirmed'        => Order::where('status', 'confirmed')->count(),
            'completed'        => Order::where('status', 'completed')->count(),
            'cancelled'        => Order::where('status', 'cancelled')->count(),
            'total_customers'  => User::where('is_admin', false)->count(),
        ];

        $revenueByMonth = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_price) as revenue, COUNT(*) as orders')
            ->groupBy('month')
            ->orderByDesc('month')
            ->limit(6)
            ->get();

        $topProducts = OrderDetail::selectRaw('products.id, products.name, SUM(order_details.quantity) as qty, SUM(order_details.price * order_details.quantity) as revenue')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('qty')
            ->limit(5)
            ->get();

        $topCategories = OrderDetail::selectRaw('products.category_id, categories.name as category_name, SUM(order_details.quantity) as qty, SUM(order_details.price * order_details.quantity) as revenue')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->groupBy('products.category_id', 'categories.name')
            ->orderByDesc('qty')
            ->limit(5)
            ->get();

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.stats', compact(
            'overview',
            'revenueByMonth',
            'topProducts',
            'topCategories',
            'recentOrders'
        ));
    }
}
