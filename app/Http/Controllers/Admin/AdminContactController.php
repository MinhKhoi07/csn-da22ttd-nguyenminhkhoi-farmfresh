<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    // Hiển thị danh sách liên hệ
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'read' => Contact::where('status', 'read')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
        ];
        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    // Hiển thị chi tiết liên hệ
    public function show(Contact $contact)
    {
        // Đánh dấu là đã đọc
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }
        return view('admin.contacts.show', compact('contact'));
    }

    // Cập nhật trạng thái liên hệ
    public function updateStatus(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,replied',
        ]);

        $contact->update($validated);

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    // Xóa liên hệ
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Xóa liên hệ thành công!');
    }

    // Xóa nhiều liên hệ
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Contact::whereIn('id', $ids)->delete();
            return back()->with('success', 'Xóa các liên hệ thành công!');
        }
        return back()->with('error', 'Vui lòng chọn ít nhất một liên hệ!');
    }
}
