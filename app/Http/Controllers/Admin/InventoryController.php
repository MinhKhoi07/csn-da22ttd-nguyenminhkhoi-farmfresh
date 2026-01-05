<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    /**
     * Display inventory list
     */
    public function index()
    {
        $products = Product::with('category')
            ->orderByDesc('updated_at')
            ->paginate(20);

        // Tính tổng giá trị kho
        $totalInventoryValue = Product::sum(DB::raw('quantity * price'));
        $lowStockCount = Product::where('quantity', '<', 10)->count();
        $outOfStockCount = Product::where('quantity', 0)->count();

        return view('admin.inventory.index', compact(
            'products',
            'totalInventoryValue',
            'lowStockCount',
            'outOfStockCount'
        ));
    }

    /**
     * Show adjustment form for a product
     */
    public function edit(Product $product)
    {
        return view('admin.inventory.edit', compact('product'));
    }

    /**
     * Update product quantity
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldQuantity = $product->quantity;
        $newQuantity = $validated['quantity'];
        $difference = $newQuantity - $oldQuantity;

        $product->update(['quantity' => $newQuantity]);

        // Log lại lịch sử thay đổi (tùy chọn)
        $diffString = ($difference >= 0 ? '+' : '') . $difference;
        Log::info("Inventory adjusted for product {$product->id} ({$product->name}): {$oldQuantity} → {$newQuantity} ({$diffString}). Reason: {$validated['reason']}");

        return redirect()->route('admin.inventory.index')
            ->with('success', "Cập nhật kho sản phẩm '{$product->name}' thành công! (Thay đổi: {$diffString} cái)");
    }

    /**
     * Adjust quantity (add/remove)
     */
    public function adjust(Request $request, Product $product)
    {
        $validated = $request->validate([
            'adjustment' => 'required|integer',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldQuantity = $product->quantity;
        $newQuantity = max(0, $oldQuantity + $validated['adjustment']);
        $adjustment = $newQuantity - $oldQuantity;

        $product->update(['quantity' => $newQuantity]);

        $adjString = ($adjustment >= 0 ? '+' : '') . $adjustment;
        Log::info("Inventory adjustment for product {$product->id}: {$oldQuantity} → {$newQuantity}. Adjustment: {$adjString}. Reason: {$validated['reason']}");

        return redirect()->route('admin.inventory.index')
            ->with('success', "Điều chỉnh kho sản phẩm '{$product->name}' thành công! (Thay đổi: {$adjString} cái)");
    }

    /**
     * Export inventory report
     */
    public function report()
    {
        $products = Product::with('category')->get();
        $totalValue = $products->sum(fn($p) => $p->quantity * $p->price);

        return view('admin.inventory.report', compact('products', 'totalValue'));
    }
}
