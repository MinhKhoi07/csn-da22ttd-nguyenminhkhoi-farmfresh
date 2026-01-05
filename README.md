## FARM FRESH - Nền tảng bán nông sản sạch

Ứng dụng thương mại điện tử cho nông sản sạch. Khách hàng có thể duyệt sản phẩm, thêm giỏ hàng, thanh toán COD/QR, đánh giá; Admin có dashboard, thống kê, quản lý danh mục/sản phẩm/đơn/khuyến mãi/liên hệ/đánh giá.

### Công nghệ
- Backend: Laravel 10, PHP 8.2+
- Frontend: Blade + TailwindCSS, Vite
- JS: Alpine.js (UI tương tác), Chart.js (biểu đồ thống kê)
- Database: MariaDB/MySQL

## Tính năng chi tiết
- **Khách hàng**: xem danh mục, tìm kiếm, lọc sản phẩm, yêu thích, giỏ hàng, đặt hàng, chọn thanh toán COD hoặc QR, theo dõi đơn, đánh giá sản phẩm, gửi liên hệ.
- **Khuyến mãi**: áp dụng theo danh mục hoặc sản phẩm, kiểu giảm % hoặc số tiền, kiểm soát hiệu lực theo ngày bắt đầu/kết thúc.
- **Admin**:
  - Dashboard: tổng sản phẩm, đơn, khách hàng, doanh thu; sản phẩm bán chạy; đơn gần đây.
  - Thống kê: doanh thu 6 tháng, cơ cấu trạng thái đơn (Chờ xử lý/Đã xác nhận/Hoàn thành/Đã hủy), top sản phẩm/danh mục, đơn gần đây (biểu đồ Chart.js).
  - Quản lý: danh mục, sản phẩm, đơn hàng (cập nhật trạng thái), liên hệ (đọc/trả lời/xóa), khuyến mãi, đánh giá.

## Cấu trúc thư mục (rút gọn)
- `app/Models`: `Product`, `Category`, `Order`, `OrderDetail`, `Promotion`, `Review`, `Contact`, `Favorite`, `User`
- `app/Http/Controllers`: web & admin (`AdminController`, `AdminOrderController`, `AdminContactController`, `ProductController`, `CartController`, ...)
- `app/Http/Middleware`: `AdminMiddleware` (bảo vệ route admin)
- `resources/views`: giao diện chính `welcome.blade.php`, auth, admin (`admin/dashboard.blade.php`, `admin/stats.blade.php`, ...)
- `routes/web.php`: định tuyến web; nhóm `admin/` dùng middleware `auth` + `admin`
- `database/migrations`: schema các bảng; `database/db_nongsan.sql`: dump dữ liệu mẫu
- `public/`, `storage/`: chứa ảnh sản phẩm/danh mục (đã liên kết storage)

## Cài đặt & chạy dự án (local)
1) Yêu cầu: PHP 8.2+, Composer, Node 18+, MariaDB/MySQL.
2) Sao chép `.env.example` -> `.env`; cập nhật `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
3) Cài dependencies:
	- `composer install`
	- `npm install`
4) Tạo key ứng dụng: `php artisan key:generate`
5) Dữ liệu:
	- Chạy migrations: `php artisan migrate`
	- (Tùy chọn) nhập dữ liệu mẫu: import `database/db_nongsan.sql` vào DB (chứa sẵn danh mục, sản phẩm, user mẫu...).
6) Build frontend: `npm run dev` (watch) hoặc `npm run build` (production).
7) Chạy server: `php artisan serve`

## Thông tin database (chính)
- **users**: tài khoản, `is_admin` xác định quyền admin.
- **categories**: danh mục sản phẩm, icon và mô tả.
- **products**: thuộc danh mục; giá gốc, giá giảm, phần trăm giảm, đơn vị, xuất xứ, ảnh.
- **orders**: đơn hàng (trạng thái: pending, confirmed, completed, cancelled), phương thức thanh toán, địa chỉ giao, ghi chú.
- **order_details**: các dòng sản phẩm trong đơn (số lượng, giá tại thời điểm đặt).
- **favorites**: sản phẩm yêu thích của người dùng.
- **reviews**: điểm và bình luận sản phẩm.
- **contacts**: liên hệ của khách hàng (new/read/replied).
- **promotions**: khuyến mãi theo danh mục hoặc sản phẩm, giảm % hoặc số tiền, hiệu lực theo thời gian.

## Tài khoản mẫu
- Nếu import `database/db_nongsan.sql`, dùng email đã có trong dump (mật khẩu lưu dạng bcrypt, ví dụ `khoiminh.071204@gmail.com` là admin `is_admin=1`).
- Nếu tự tạo, thêm user rồi cập nhật `is_admin = 1` trong bảng `users` để truy cập admin.

## Lệnh hữu ích
- Chạy test: `php artisan test`
- Dọn cache cấu hình/route/view: `php artisan optimize:clear`
- Queue (nếu dùng): `php artisan queue:work`

## Ghi chú bảo mật & kiểm thử
- Luôn bật CSRF (mặc định Laravel).
- Thêm rate limiting cho form login/đặt hàng nếu cần.
- Kiểm tra validation ở controller/form request khi mở rộng tính năng.
- Bổ sung test cho quy trình đặt hàng, tính khuyến mãi và phân quyền admin.
