<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // <--- Quan trọng: Gọi Model Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Lấy danh sách danh mục, mới nhất lên đầu, phân trang 10 cái
        $categories = Category::latest()->paginate(10);

        // 2. Trả về giao diện và gửi kèm biến $categories
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hiển thị form thêm mới (chúng ta sẽ làm view này ở bước sau)
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Kiểm tra dữ liệu (Validation)
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
        ]);

        // 2. Xử lý upload ảnh icon
        if ($request->hasFile('icon_image')) {
            $validated['icon_image'] = $request->file('icon_image')->store('categories', 'public');
        }

        // 3. Lưu vào CSDL
        Category::create($validated);

        // 4. Quay về trang danh sách
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    // ... Các hàm show, edit, update, destroy cứ để nguyên mặc định
     /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 1. Tìm danh mục cần sửa theo ID
        // Nếu không tìm thấy (ví dụ id=9999) thì báo lỗi 404
        $category = Category::findOrFail($id);

        // 2. Trả về view sửa và gửi kèm dữ liệu cũ ($category) sang đó
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Tìm danh mục cần sửa
        $category = Category::findOrFail($id);

        // 2. Kiểm tra dữ liệu (Validation)
        // unique:categories,name,'.$id nghĩa là: Tên được phép trùng với chính nó (trường hợp người dùng không sửa tên mà chỉ sửa mô tả)
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id,
            'description' => 'nullable|string',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
        ]);

        // 3. Xử lý upload ảnh icon (nếu có)
        if ($request->hasFile('icon_image')) {
            // Xóa ảnh cũ nếu có
            if ($category->icon_image) {
                Storage::disk('public')->delete($category->icon_image);
            }
            // Upload ảnh mới
            $validated['icon_image'] = $request->file('icon_image')->store('categories', 'public');
        }

        // 4. Cập nhật dữ liệu mới vào CSDL
        $category->update($validated);

        // 5. Quay về trang danh sách và báo thành công
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 1. Tìm danh mục cần xóa
        $category = Category::findOrFail($id);

        // 2. Xóa
        $category->delete();

        // 3. Quay về danh sách và báo thành công
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}