<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Category;
use App\Models\Product;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::with(['category', 'product'])
                               ->latest()
                               ->paginate(15);
        
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $products = Product::with('category')->get();
        
        return view('admin.promotions.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:category,product',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category_id' => 'required_if:type,category|nullable|exists:categories,id',
            'product_id' => 'required_if:type,product|nullable|exists:products,id',
            'is_active' => 'boolean'
        ]);

        // Validate discount percentage
        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            return back()->withErrors(['discount_value' => 'Phần trăm giảm giá không được vượt quá 100%'])->withInput();
        }

        Promotion::create($validated);

        return redirect()->route('admin.promotions.index')
                        ->with('success', 'Tạo khuyến mãi thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        $categories = Category::all();
        $products = Product::with('category')->get();
        
        return view('admin.promotions.edit', compact('promotion', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:category,product',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category_id' => 'required_if:type,category|nullable|exists:categories,id',
            'product_id' => 'required_if:type,product|nullable|exists:products,id',
            'is_active' => 'boolean'
        ]);

        // Validate discount percentage
        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            return back()->withErrors(['discount_value' => 'Phần trăm giảm giá không được vượt quá 100%'])->withInput();
        }

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')
                        ->with('success', 'Cập nhật khuyến mãi thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
                        ->with('success', 'Xóa khuyến mãi thành công!');
    }
}

