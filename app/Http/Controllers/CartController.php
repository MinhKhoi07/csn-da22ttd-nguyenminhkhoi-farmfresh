<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected function getCart(): array
    {
        return session()->get('cart', []);
    }

    protected function putCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart = $this->getCart();
        $items = array_values($cart);
        $total = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);
        
        // Get recent orders for logged-in users
        $recentOrders = [];
        if (Auth::check()) {
            $recentOrders = Order::where('user_id', Auth::id())
                ->latest()
                ->limit(5)
                ->get();
        }
        
        return view('cart.index', compact('items', 'total', 'recentOrders'));
    }

    public function add(Request $request, Product $product)
    {
        // Check authentication
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'unauthenticated',
                    'message' => 'Vui lòng đăng nhập để thêm vào giỏ hàng.',
                    'redirect' => route('login'),
                ], 401);
            }
            return redirect()->route('login');
        }

        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = $this->getCart();

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Sử dụng giá giảm nếu có khuyến mãi
            $price = $product->has_promotion && $product->discounted_price 
                ? (float) $product->discounted_price 
                : (float) $product->price;
            
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'original_price' => (float) $product->price, // Lưu giá gốc
                'has_promotion' => $product->has_promotion ?? false,
                'discount_percentage' => $product->discount_percentage ?? 0,
                'image' => $product->image ?? null,
                'quantity' => $quantity,
            ];
        }

        $this->putCart($cart);

        $cartCount = collect($this->getCart())->sum(fn($item) => $item['quantity']);

        // Return JSON for AJAX requests to avoid page reload/scroll reset
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Đã thêm vào giỏ hàng.',
                'cartCount' => $cartCount,
            ]);
        }

        return redirect()->back()->with('status', 'Đã thêm vào giỏ hàng.');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);
        $quantity = $quantity < 1 ? 1 : $quantity;

        $cart = $this->getCart();
        if (isset($cart[$product->id])) {
            // Cập nhật số lượng, đồng thời đảm bảo giá luôn là giá giảm nếu có
            $price = $product->has_promotion && $product->discounted_price 
                ? (float) $product->discounted_price 
                : (float) $product->price;
            
            $cart[$product->id]['quantity'] = $quantity;
            $cart[$product->id]['price'] = $price;
            $cart[$product->id]['original_price'] = (float) $product->price;
            $cart[$product->id]['has_promotion'] = $product->has_promotion ?? false;
            $cart[$product->id]['discount_percentage'] = $product->discount_percentage ?? 0;
            $this->putCart($cart);
        }

        return redirect()->route('cart.index')->with('status', 'Cập nhật số lượng thành công.');
    }

    public function remove(Product $product)
    {
        $cart = $this->getCart();
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            $this->putCart($cart);
        }
        return redirect()->route('cart.index')->with('status', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function clear()
    {
        $this->putCart([]);
        return redirect()->route('cart.index')->with('status', 'Đã làm trống giỏ hàng.');
    }

    public function checkout(Request $request)
    {
        $ids = $request->input('selected', []);
        if (!is_array($ids) || count($ids) === 0) {
            return redirect()->route('cart.index')->with('status', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
        }

        $cart = $this->getCart();
        $items = [];
        foreach ($ids as $id) {
            $id = (int) $id;
            if (isset($cart[$id])) {
                $items[] = $cart[$id];
            }
        }

        if (empty($items)) {
            return redirect()->route('cart.index')->with('status', 'Các sản phẩm đã chọn không còn trong giỏ.');
        }

        $total = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Lưu tạm lựa chọn để dùng cho bước đặt hàng sau này (nếu cần)
        session(['checkout_selected' => array_column($items, 'id')]);

        return view('cart.checkout', compact('items', 'total'));
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:cod,qr',
        ]);

        $selected = $request->input('selected', session('checkout_selected', []));
        if (!is_array($selected) || count($selected) === 0) {
            return redirect()->route('cart.index')->with('status', 'Không có sản phẩm được chọn để đặt hàng.');
        }

        $cart = $this->getCart();
        $items = [];
        foreach ($selected as $id) {
            $id = (int) $id;
            if (isset($cart[$id])) {
                $items[] = $cart[$id];
            }
        }
        if (empty($items)) {
            return redirect()->route('cart.index')->with('status', 'Các sản phẩm đã chọn không còn trong giỏ.');
        }

        $total = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => 'pending',
                'payment_method' => $request->input('payment_method', 'cod'),
                'shipping_address' => $request->input('shipping_address'),
                'phone' => $request->input('phone'),
                'note' => $request->input('note'),
            ]);

            foreach ($items as $it) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $it['id'],
                    'quantity' => $it['quantity'],
                    'price' => $it['price'],
                ]);
            }

            // Remove only selected items from cart
            foreach ($selected as $id) {
                unset($cart[(int)$id]);
            }
            $this->putCart($cart);
            session()->forget('checkout_selected');

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('status', 'Có lỗi khi tạo đơn hàng, vui lòng thử lại.');
        }

        return redirect()->route('cart.success', ['order' => $order->id]);
    }

    // --- Buy Now: checkout a single product without adding to cart ---
    public function buyNow(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        $item = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float) $product->price,
            'image' => $product->image ?? null,
            'quantity' => $quantity,
        ];

        $items = [$item];
        $total = $item['price'] * $item['quantity'];

        // Render the same checkout view, with a flag to change form action
        return view('cart.checkout', [
            'items' => $items,
            'total' => $total,
            'buyNow' => true,
        ]);
    }

    public function confirmBuyNow(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:cod,qr',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->input('product_id'));
        if (!$product) {
            return redirect()->route('home')->with('status', 'Sản phẩm không tồn tại.');
        }

        $quantity = (int) $request->input('quantity', 1);
        $price = (float) $product->price;
        $total = $price * $quantity;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => 'pending',
                'payment_method' => $request->input('payment_method', 'cod'),
                'shipping_address' => $request->input('shipping_address'),
                'phone' => $request->input('phone'),
                'note' => $request->input('note'),
            ]);

            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('status', 'Có lỗi khi tạo đơn hàng, vui lòng thử lại.');
        }

        return redirect()->route('cart.success', ['order' => $order->id]);
    }

    public function showOrder(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này.');
        }

        $order->load('details.product');
        
        // Get user's existing reviews for products in this order
        $userReviews = [];
        if ($order->status === 'completed') {
            foreach ($order->details as $detail) {
                $review = $detail->product->reviews()->where('user_id', Auth::id())->first();
                if ($review) {
                    $userReviews[$detail->product_id] = $review;
                }
            }
        }

        return view('orders.show', compact('order', 'userReviews'));
    }

    public function storeReview(Request $request, Order $order, Product $product)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này.');
        }

        // Check if order is completed
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'Chỉ có thể đánh giá đơn hàng đã hoàn thành.');
        }

        // Check if product is in this order
        $hasProduct = $order->details()->where('product_id', $product->id)->exists();
        if (!$hasProduct) {
            return redirect()->back()->with('error', 'Sản phẩm không có trong đơn hàng này.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Update or create review
        \App\Models\Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => Auth::id()],
            [
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
            ]
        );

        return redirect()->back()->with('status', 'Cảm ơn bạn đã đánh giá sản phẩm này!');
    }
}
