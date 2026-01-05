<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // <--- Gọi Model Sản phẩm
use App\Models\Category; // <--- Gọi Model Danh mục (để dùng cho lúc thêm/sửa)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <--- Để xử lý xóa ảnh

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy danh sách sản phẩm, kèm theo thông tin danh mục (để hiện tên danh mục thay vì ID)
        // with('category') giúp tối ưu câu lệnh SQL
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách danh mục để chọn khi thêm sản phẩm
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'unit' => 'required|string',
            'image' => 'nullable|image|max:2048', // Ảnh tối đa 2MB
            'origin' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // 2. Xử lý Upload ảnh (Nếu có)
        if ($request->hasFile('image')) {
            // Lưu ảnh vào thư mục 'storage/app/public/products'
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // 3. Tạo sản phẩm
        Product::create($validated);

        // 4. Quay về
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Lấy danh mục để hiển thị lại trong thẻ select
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        // 1. Validate dữ liệu (Ảnh lúc này là nullable - không bắt buộc)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'unit' => 'required|string',
            'image' => 'nullable|image|max:2048', // Có thể không up ảnh mới
            'origin' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // 2. Xử lý ảnh (Nếu người dùng có up ảnh mới)
        if ($request->hasFile('image')) {
            // 2a. Xóa ảnh cũ đi (nếu có) để tránh rác server
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            // 2b. Lưu ảnh mới
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // 3. Cập nhật vào CSDL
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // 1. Xóa file ảnh trong ổ cứng (Quan trọng)
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Xóa dữ liệu trong CSDL
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    // ... (Các hàm khác tạm thời để trống)
}