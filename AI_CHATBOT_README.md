# 🤖 Hệ thống AI Chat Bot với Gemini Pro

Hệ thống trợ lý AI thông minh được tích hợp vào website FARM FRESH, sử dụng Google Gemini Pro API.

## ✅ Đã triển khai

### 1. Backend Components

#### GeminiService (`app/Services/GeminiService.php`)
- Kết nối và gọi Gemini Pro API
- Xây dựng prompt thông minh với context
- Xử lý response và error handling
- Tạo suggestions tự động

#### AiChatController (`app/Http/Controllers/Api/AiChatController.php`)
- Endpoint `/api/products/ai-feed`: Cung cấp dữ liệu sản phẩm cho AI
- Endpoint `/api/ai-chat`: Xử lý chat với AI
- Thu thập context từ user, giỏ hàng, yêu thích
- Tìm kiếm sản phẩm liên quan

### 2. API Endpoints

```
GET  /api/products/ai-feed?search={keyword}
POST /api/ai-chat
     Body: {
       "message": "Tôi muốn mua rau củ tươi",
       "search_keyword": "rau"
     }
```

### 3. Frontend Components

#### Chat Widget (`resources/views/components/ai-chat-widget.blade.php`)
- Bong bóng chat cố định góc dưới phải
- Giao diện đẹp với Alpine.js
- Lưu lịch sử chat trong localStorage
- Quick suggestions
- Typing indicator
- Responsive design

### 4. Tính năng

✅ **Context-Aware AI**
- Biết thông tin người dùng (tên, trạng thái)
- Biết sản phẩm trong giỏ hàng
- Biết sản phẩm yêu thích
- Biết danh sách sản phẩm có sẵn

✅ **Tìm kiếm thông minh**
- Tự động tìm sản phẩm liên quan
- Gợi ý sản phẩm phù hợp
- Hiển thị giá, khuyến mãi

✅ **Bảo mật**
- Rate limiting (20 requests/phút)
- CSRF protection
- Input validation
- Error handling

✅ **UX/UI**
- Animations mượt mà
- Real-time chat
- Lịch sử chat persistent
- Quick reply suggestions

## 🚀 Cách sử dụng

### Cho người dùng

1. **Mở chat**: Click vào nút bong bóng chat góc dưới phải
2. **Đặt câu hỏi**: Gõ câu hỏi về sản phẩm, giá cả, khuyến mãi
3. **Quick suggestions**: Click vào gợi ý nhanh
4. **Nhận trả lời**: AI sẽ trả lời ngay lập tức

### Ví dụ câu hỏi

- "Có sản phẩm nào đang giảm giá?"
- "Tôi muốn mua rau củ tươi"
- "Sản phẩm nào bán chạy nhất?"
- "Tôi muốn thanh toán"
- "Hướng dẫn đặt hàng"

## ⚙️ Cấu hình

### Environment Variables (.env)

```env
GEMINI_API_KEY=AIzaSyD0ZWZGPEhrL7vQnXXnkKUj5R_UA7cKgh8
```

### Config (config/services.php)

```php
'gemini' => [
    'api_key' => env('GEMINI_API_KEY'),
    'base_url' => 'https://generativelanguage.googleapis.com/v1beta',
    'model' => 'gemini-1.5-pro',
    'temperature' => 0.7,
    'max_tokens' => 512,
],
```

## 🔧 Tùy chỉnh

### Thay đổi prompt AI

Chỉnh sửa method `buildPrompt()` trong `GeminiService.php`:

```php
protected function buildPrompt($message, $context)
{
    $systemPrompt = "Bạn là trợ lý AI...";
    // Tùy chỉnh prompt tại đây
    return $systemPrompt;
}
```

### Thay đổi suggestions

Chỉnh sửa method `generateSuggestions()` trong `GeminiService.php`.

### Thay đổi giao diện

Chỉnh sửa `resources/views/components/ai-chat-widget.blade.php`.

## 📊 Model Context

AI nhận được các thông tin sau:

1. **User Info** (nếu đăng nhập)
   - Tên
   - Trạng thái thành viên

2. **Giỏ hàng**
   - Tên sản phẩm
   - Số lượng
   - Giá

3. **Yêu thích**
   - Danh sách sản phẩm yêu thích
   - Danh mục

4. **Sản phẩm**
   - Top 8-15 sản phẩm liên quan
   - Tên, giá, danh mục
   - Khuyến mãi

## 🛡️ Bảo mật

- ✅ Rate limiting: 20 requests/phút
- ✅ CSRF token validation
- ✅ Input validation (max 500 chars)
- ✅ API key bảo mật trong .env
- ✅ Error logging
- ✅ Timeout 30s

## 🎨 Customization

### Màu sắc

Widget sử dụng màu xanh lá (green) làm chủ đạo. Để thay đổi:

```html
<!-- Từ green-500 sang blue-500 -->
class="bg-gradient-to-r from-blue-500 to-blue-600"
```

### Vị trí

Mặc định: `bottom-6 right-6`

Để chuyển sang trái: `bottom-6 left-6`

### Kích thước

Mặc định: `w-96 h-[600px]`

Tùy chỉnh trong component.

## 📝 Logs

Logs được lưu tại `storage/logs/laravel.log`:

- API errors
- Service exceptions
- Request/response data

## 🔄 Workflow

```
User Message → Frontend (Alpine.js)
    ↓
POST /api/ai-chat
    ↓
AiChatController
    ↓
Gather Context (User, Cart, Products)
    ↓
GeminiService
    ↓
Build Prompt with Context
    ↓
Call Gemini API
    ↓
Parse Response
    ↓
Return JSON
    ↓
Display in Widget
```

## 🐛 Troubleshooting

### Chat không hoạt động

1. Kiểm tra API key trong `.env`
2. Kiểm tra console browser có lỗi không
3. Kiểm tra `storage/logs/laravel.log`

### AI trả lời sai

1. Kiểm tra prompt trong `buildPrompt()`
2. Tăng `max_tokens` nếu câu trả lời bị cắt
3. Điều chỉnh `temperature` (0.7 = cân bằng)

### Rate limit

Tăng trong routes:
```php
->middleware('throttle:30,1') // 30 requests/phút
```

## 📚 Dependencies

- Laravel 11
- Alpine.js 3.x (CDN)
- Tailwind CSS
- Google Gemini Pro API

## 🎯 Tính năng tương lai

- [ ] Voice input
- [ ] Image upload (nhận diện sản phẩm)
- [ ] Multi-language support
- [ ] Admin analytics dashboard
- [ ] Chat export
- [ ] Feedback rating

---

**Phát triển bởi:** AI Assistant  
**Ngày:** 03/01/2026  
**Version:** 1.0.0
