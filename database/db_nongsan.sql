-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 04, 2026 lúc 11:44 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_nongsan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1767521737),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1767521737;', 1767521737),
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1767522248),
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1767522248;', 1767522248),
('laravel-cache-linh123@gmail.com|127.0.0.1', 'i:1;', 1767521759),
('laravel-cache-linh123@gmail.com|127.0.0.1:timer', 'i:1767521759;', 1767521759);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `icon_image`, `created_at`, `updated_at`) VALUES
(1, 'Rau củ quả', 'Rau củ quả là tên gọi chung cho các bộ phận ăn được của thực vật (lá, thân, rễ, hoa, quả, hạt) cung cấp vitamin, khoáng chất, chất xơ dồi dào, thiết yếu cho sức khỏe, giúp tăng cường sức đề kháng, phòng ngừa bệnh tật và hỗ trợ tiêu hóa. Chúng bao gồm nhiều loại như rau ăn lá (cải, xà lách), củ (cà rốt, khoai tây), quả (cà chua, bí, dưa chuột) và các loại khác, có thể ăn tươi hoặc chế biến.', 'categories/hIx9tjCD66P2wrJeOztPSG7jWW9czmatMshflWZp.png', '2025-11-29 09:27:42', '2026-01-03 09:41:08'),
(2, 'Trái cây', 'Trái cây là phần bầu nhụy chín (thường ngọt, mọng nước) hoặc khô của cây có hoa, có chức năng bao bọc và phân tán hạt giống, đồng thời là nguồn cung cấp vitamin, khoáng chất, chất xơ quan trọng cho con người và động vật. Về thực vật học, cà chua, dưa chuột, bơ... cũng là trái cây, nhưng trong ẩm thực chúng thường được xếp vào nhóm rau quả.', 'categories/nroQLIIn3seCOJSvsAMJ1yAakYHMB0KAcQ1gD0JD.png', '2025-12-04 07:48:24', '2026-01-03 09:49:41'),
(4, 'Ngũ cốc', 'Ngũ cốc là tên gọi chung các loại hạt lương thực như gạo, lúa mì, ngô, yến mạch, lúa mạch, kê, quinoa, và các loại đậu, giàu dinh dưỡng như chất xơ, vitamin, khoáng chất và protein, mang lại nhiều lợi ích sức khỏe như hỗ trợ tiêu hóa, kiểm soát cân nặng, làm đẹp da, và phòng ngừa bệnh tật, thường được dùng làm thực phẩm ăn sáng, ăn dặm, hoặc chế biến đa dạng thành bánh mì, mì ống, bột dinh dưỡng.', 'categories/72y7k9P18w5J1Tswz8MnUyKxOPz3pTn6855Ot0m8.png', '2025-12-22 02:05:25', '2026-01-03 09:42:26'),
(6, 'Gạo', 'Gạo là hạt thu được từ cây lúa sau khi xay xát để loại bỏ vỏ trấu, là nguồn lương thực thiết yếu và phổ biến nhất ở châu Á, cung cấp năng lượng chủ yếu dưới dạng tinh bột cùng nhiều dinh dưỡng khác như protein, chất xơ, vitamin và khoáng chất. Nó có nhiều loại (trắng, lứt, đỏ, nếp) và được dùng để nấu cơm, cháo hoặc chế biến thành các sản phẩm như bún, bánh, phở.', 'categories/NAbF7ayyY06dggJJkPrmulOkFCicWgh3yrE7k58v.png', '2026-01-03 08:48:48', '2026-01-03 09:38:15'),
(8, 'Sản phẩm chăn nuôi', 'Sản phẩm chăn nuôi là tất cả những gì thu hoạch được từ việc nuôi dưỡng động vật (gia súc, gia cầm, thủy sản) như thịt, trứng, sữa, mật ong, tơ tằm, tổ yến, cùng các bộ phận khác như da, lông, xương, sừng, nội tạng, và cả phân bón hữu cơ, phục vụ nhu cầu thực phẩm, nguyên liệu công nghiệp, và kinh tế cho con người.', 'categories/EC2UuJnuIa17LRBi1Zf09kUKEUBoFsFoAAAz7dN9.png', '2026-01-03 09:00:10', '2026-01-03 09:44:07'),
(9, 'Sản phẩm sấy khô', 'Sản phẩm sấy/khô là các loại thực phẩm, nông sản, dược liệu đã được loại bỏ phần lớn lượng nước/độ ẩm bằng nhiệt, không khí (sấy), phơi nắng hoặc công nghệ hiện đại (sấy thăng hoa), giúp kéo dài thời gian bảo quản, giảm trọng lượng, tiện lợi khi vận chuyển, đồng thời cô đọng dinh dưỡng và tạo ra món ăn vặt tiện dụng. Các loại phổ biến bao gồm trái cây sấy, thịt sấy (khô bò, khô gà), hải sản khô (tôm, mực), rau củ sấy, hạt sấy, và dược liệu.', 'categories/hH6tjiFlOjJYZqM7tCEjS49neq4PABtJcNSPBn1C.png', '2026-01-03 09:02:47', '2026-01-03 09:48:15'),
(10, 'Đồ uống', 'Đồ uống từ nông sản là các loại thức uống được chế biến từ sản phẩm trực tiếp của hoạt động trồng trọt và chăn nuôi (nông sản) như trái cây, rau củ, ngũ cốc, sữa, cà phê, chè (trà), ca cao, được biến đổi qua các quy trình sơ chế hoặc chế biến thành dạng lỏng, sẵn sàng để tiêu thụ, ví dụ như nước ép trái cây, trà sữa, cà phê pha, sữa hạt, nước ngọt, rượu, bia.', 'categories/xlwSHLa42Ec0E48N75USfP7cE9Eeyph7BGW8zBgj.png', '2026-01-03 09:05:35', '2026-01-03 09:48:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `status` enum('new','read','replied') NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, 3, 4, '2025-12-25 09:04:51', '2025-12-25 09:04:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_14_075101_create_categories_table', 1),
(5, '2025_11_14_075256_create_products_table', 1),
(6, '2025_11_14_075305_create_orders_table', 1),
(7, '2025_11_14_075315_create_order_details_table', 1),
(8, '2025_11_29_152234_add_is_admin_to_users_table', 2),
(9, '2025_12_22_170144_update_old_order_status_from_processing_to_confirmed', 3),
(10, '2025_12_25_000500_create_favorites_table', 4),
(11, '2025_12_26_063610_add_payment_method_to_orders_table', 5),
(12, '2025_12_26_065602_create_reviews_table', 6),
(13, '2025_12_31_163001_create_contacts_table', 7),
(14, '2026_01_02_150616_create_promotions_table', 8),
(15, '2026_01_03_152242_add_discounted_price_to_products_table', 9),
(16, '2026_01_03_163132_add_icon_image_to_categories_table', 10),
(17, '2026_01_03_163151_add_icon_image_to_categories_table', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `shipping_address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_address`, `phone`, `note`, `created_at`, `updated_at`) VALUES
(1, 3, 300000.00, 'confirmed', 'cod', '308 Dau Giong Cang Long Vinh Long', '0866085947', 'giao nhanh', '2025-12-22 09:22:09', '2025-12-22 10:02:59'),
(2, 3, 35000.00, 'completed', 'cod', '308 Dau Giong Cang Long Vinh Long', '0866085947', '1111', '2025-12-22 09:27:15', '2025-12-25 23:33:35'),
(3, 3, 10000.00, 'pending', 'cod', '308 Dau Giong Cang Long Vinh Long', '0866085947', NULL, '2025-12-25 23:41:37', '2025-12-25 23:41:37'),
(4, 3, 20000.00, 'pending', 'qr', '308 Dau Giong Cang Long Vinh Long', '0866085947', NULL, '2025-12-25 23:43:36', '2025-12-25 23:43:36'),
(5, 1, 150000.00, 'completed', 'cod', '308 Dau Giong Cang Long Vinh Long', '0866085947', NULL, '2025-12-31 10:06:42', '2025-12-31 10:07:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 2, 150000.00, '2025-12-22 09:22:09', '2025-12-22 09:22:09'),
(2, 2, 6, 1, 35000.00, '2025-12-22 09:27:15', '2025-12-22 09:27:15'),
(3, 3, 4, 1, 10000.00, '2025-12-25 23:41:37', '2025-12-25 23:41:37'),
(4, 4, 3, 1, 20000.00, '2025-12-25 23:43:36', '2025-12-25 23:43:36'),
(5, 5, 5, 1, 150000.00, '2025-12-31 10:06:42', '2025-12-31 10:06:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `has_promotion` tinyint(1) NOT NULL DEFAULT 0,
  `discount_percentage` int(11) DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `discounted_price`, `has_promotion`, `discount_percentage`, `unit`, `origin`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cà rốt', 'Cà rốt là một loại rau củ phổ biến, có vị ngọt nhẹ và giòn, được sử dụng làm thực phẩm và có nhiều lợi ích sức khỏe do chứa nhiều vitamin, chất chống oxy hóa và chất xơ. Nó giàu tiền tố vitamin A (beta carotene), vitamin C, vitamin K1, kali, và có lợi cho sức khỏe mắt, tim mạch, làm đẹp da, và hỗ trợ giảm cân.', 15000.00, NULL, 0, NULL, 'kg', 'Đà Lạt', 'products/4u6VFCziWAsNiLtMFSdtitK5XjICrwvfyerEIrXs.jpg', '2025-12-04 08:44:41', '2025-12-04 08:58:44'),
(3, 1, 'Khoai Tây', 'Khoai tây là một loại củ thân thảo phổ biến, được trồng và tiêu thụ rộng rãi trên toàn thế giới. Chúng là một nguồn thực phẩm đa năng và bổ dưỡng, có thể chế biến thành nhiều món ăn khác nhau.', 20000.00, 20000.00, 1, 20, 'kg', 'Đà Lạt', 'products/nd9KLlfhkw0ysrqYV3YdelXqRiWIdPpQVCCAJRlX.jpg', '2025-12-04 22:18:01', '2025-12-04 22:18:01'),
(4, 1, 'Bí ngô', NULL, 10000.00, NULL, 0, NULL, 'kg', 'Đà Lạt', 'products/LYA5CFzGfujpuERELmL9yi1uPaEBxnLnMNSoTaI9.jpg', '2025-12-05 00:23:19', '2025-12-21 02:23:28'),
(5, 4, 'Yến mạch', 'Yến mạch là một loại ngũ cốc nguyên hạt giàu dinh dưỡng, đặc biệt là chất xơ hòa tan (beta-glucan) và chất chống oxy hóa, giúp giảm cholesterol, ổn định đường huyết và tốt cho tim mạch, thường được dùng làm bột yến mạch ăn sáng, cháo, hoặc nguyên liệu làm bánh, có vị bùi thơm, được chế biến thành nhiều dạng khác nhau như cán dẹt, cán vỡ.', 150000.00, NULL, 0, NULL, 'kg', 'Việt Nam', 'products/SuJdZ5uOoXGz8F9S4A5Og3INGmRu8zMV8vQEgogR.jpg', '2025-12-22 02:12:13', '2025-12-22 02:12:13'),
(6, 4, 'Ngô (Bắp)', 'Ngô (hay bắp) là một loại cây lương thực ngũ cốc quan trọng, có nguồn gốc từ Mexico, vừa được coi là rau, vừa là ngũ cốc, giàu chất xơ và dinh dưỡng, được dùng làm thực phẩm (bắp luộc, bánh ngô, bột ngô) hoặc thức ăn chăn nuôi, nhiên liệu sinh học.', 35000.00, NULL, 0, NULL, 'kg', 'Việt Nam', 'products/KLRwj83b5AwfIwiM3F0KYPVLEd37c7xJWxnbLnbS.jpg', '2025-12-22 02:16:00', '2025-12-22 02:16:00'),
(7, 6, 'Gạo Lức Huyết Rồng', 'Là giống lúa sạ được trồng ở vùng nước ngập sâu, hạt lúa mẩy, màu đỏ nâu, bẻ đôi hạt gạo vẫn còn màu đỏ bên trong, gạo nấu cơm thơm ngậy, cơm gạo huyết rồng càng nhai càng có vị ngọt và béo bùi. Đây là loại gạo có giá trị dinh dưỡng cao, hay được dùng làm bột dinh dưỡng cho trẻ em.', 45000.00, NULL, 0, NULL, 'kg', 'Việt Nam', 'products/Q1jxMDFsKBSzL03RG03oq4ZFAw3TqoDD4cKcw21b.png', '2026-01-03 09:54:16', '2026-01-03 09:54:16'),
(8, 8, 'Ức Gà phi lê', 'Thịt gà là loại thịt gia cầm phổ biến, giàu protein chất lượng cao, ít chất béo (đặc biệt là ức gà), cung cấp nhiều vitamin (A, B, E, C) và khoáng chất (canxi, phốt pho, sắt) có lợi cho cơ bincludes xương, mắt, hệ miễn dịch và trao đổi chất, được chế biến thành vô số món ăn ngon như chiên, nướng, luộc, hấp, kho.', 80000.00, NULL, 0, NULL, 'kg', 'Việt Nam', 'products/0B0zNmRQoqTlUAkuz5rzoIaSSUzJEXC69g2fj4YJ.png', '2026-01-03 09:57:04', '2026-01-03 09:57:04'),
(9, 1, 'Xà lách', 'Xà lách được biết đến là cải bèo, cải tai bèo, là một loại rau thân thảo có nguồn gốc từ châu Âu. Hiện nay, xà lách đã được lai tạo thành nhiều giống khác nhau và được trồng ở khắp mọi nơi trên thế giới.', 25000.00, NULL, 0, NULL, 'bó(250g)', 'Việt Nam', 'products/TAleMsthWZcCG39G1OLPmJhpXxznQgsY3bmhdJmc.png', '2026-01-03 09:59:33', '2026-01-03 09:59:33'),
(10, 10, 'Nước ép Táo Vfresh', 'Nước ép táo là thức uống giải khát bổ dưỡng, làm từ táo tươi ép lấy nước, giàu vitamin C, kali và chất chống oxy hóa, giúp tăng cường miễn dịch, hỗ trợ tiêu hóa và làm đẹp da. Để làm nước ép táo, bạn chỉ cần rửa sạch, cắt miếng và ép lấy nước, có thể thêm chanh, quế hoặc cà rốt để tăng hương vị, thường uống lạnh để ngon hơn và bổ sung năng lượng.', 52000.00, NULL, 0, NULL, 'lít', 'Việt Nam', 'products/FhQJMVn5GYToQo0RVe58K4sfGB2TBbIKQ5UnOWXH.png', '2026-01-03 10:01:19', '2026-01-03 10:01:19'),
(11, 9, 'Mít sấy', 'Mít sấy là món ăn vặt phổ biến làm từ mít tươi sấy khô, có hai loại chính là giòn và dẻo, giữ được hương vị thơm ngon, ngọt bùi tự nhiên; giàu chất xơ, vitamin và khoáng chất, tốt cho tiêu hóa, tăng cường miễn dịch, bổ sung năng lượng nhưng cần ăn vừa phải vì có lượng calo và đường cao. Sản phẩm thường được chế biến bằng công nghệ sấy chân không hoặc sấy lạnh, có thể ăn liền, bảo quản lâu và làm quà biếu.', 40000.00, NULL, 0, NULL, 'Gói(100g)', 'Việt Nam', 'products/C6zUdu6gz7fLJ7dDFGr3Re39l1NDTppDhlcHwBXv.png', '2026-01-03 10:05:16', '2026-01-03 10:05:16'),
(12, 2, 'Bưởi da xanh', 'Bưởi da xanh là một giống bưởi có nguồn gốc phân bố đầu tiên ở xã Phước Mỹ Trung, huyện Mỏ Cày Bắc, tỉnh Bến Tre, sau đó được trồng rộng khắp tỉnh và được đưa vào xuất khẩu. Đây là một trong năm loại trái đặc sản, và được tỉnh xác định là cây ăn quả chủ lực. Năm 2018, bưởi da xanh được cấp chỉ dẫn địa lý.', 50000.00, NULL, 0, NULL, 'kg', 'Việt Nam', 'products/UgIoGY7lWDmV95oqchwzBjFuR2YJ8DKZQvaWCZrv.png', '2026-01-03 10:07:27', '2026-01-03 22:23:03'),
(13, 8, 'Trứng Gà', 'Trứng gà là một loại thực phẩm tự nhiên có giá trị dinh dưỡng cao, được sử dụng phổ biến, chứa đầy đủ protein, chất béo, vitamin (A, D, E, B12), khoáng chất (sắt, kẽm, phốt pho) và các axit amin thiết yếu, có vai trò quan trọng trong việc cung cấp năng lượng và xây dựng cơ thể, vừa là nguyên liệu linh hoạt trong nấu ăn và làm bánh, vừa có thể là trái cây lêkima có vị bùi giống lòng đỏ trứng.', 35000.00, NULL, 0, NULL, 'vỉ (10 trứng)', 'Việt Nam', 'products/X0pjmsxTtABeFcZ1SJGnsor2Q1E3F9OeDdD8LfrD.png', '2026-01-03 22:24:58', '2026-01-03 22:24:58'),
(14, 8, 'Mật Ong', 'Mật ong là một chất lỏng ngọt, sánh, có màu vàng óng hoặc sẫm, được ong thợ tạo ra từ mật hoa thực vật, trải qua quá trình tiêu hóa và chế biến enzym trong cơ thể ong rồi lưu trữ làm thức ăn, có chứa đường, nước, vitamin, khoáng chất, chất chống oxy hóa và axit amin, mang lại giá trị dinh dưỡng cao và được dùng làm thực phẩm, dược liệu, mỹ phẩm.', 400000.00, NULL, 0, NULL, 'lít', 'Việt Nam', 'products/r915nDRvN2H4jVqNzAwye2iuyXKKAIcZuSWLzoJQ.png', '2026-01-03 22:27:05', '2026-01-03 22:27:05'),
(15, 1, 'Mồng Tơi', 'Mồng tơi (hay mùng tơi) có hai nghĩa chính: (1) Một loại rau dây leo dân dã, bổ dưỡng (tên khoa học Basella alba), thân mọng nước, lá xanh hoặc tím, thường nấu canh và có tính mát. (2) Phần trên của chiếc áo tơi truyền thống (áo lá) dùng che mưa nắng, biểu tượng cho sự nghèo khó tột cùng trong thành ngữ \"nghèo rớt mồng tơi\".', 40000.00, NULL, 0, NULL, 'kg', 'Việt Nam', 'products/aiIR7OlOyhzi25nJpHR2AW0CyCwh5ycYdtSyJWv7.png', '2026-01-03 22:29:34', '2026-01-03 22:29:51'),
(16, 1, 'Cà Chua', 'Cà chua (tên khoa học: Solanum lycopersicum) là một loại quả mọng nước thuộc họ Cà, có nguồn gốc từ Nam Mỹ, thường được dùng như một loại rau trong ẩm thực vì vị hơi chua và được chế biến đa dạng, giàu dinh dưỡng với vitamin A, C, K, kali và chất chống oxy hóa mạnh như lycopene, tốt cho sức khỏe tim mạch và miễn dịch, dù về mặt thực vật nó là trái cây vì có hạt bên trong. \r\nĐặc điểm\r\nPhân loại: Về mặt thực vật học là trái cây, nhưng được xem như rau củ trong nấu ăn.\r\nMàu sắc & Hình dạng: Khi chín có màu đỏ, vàng, cam, xanh lá cây, tím; có nhiều hình dạng khác nhau (bi, lê, múi...).\r\nThành phần dinh dưỡng: Giàu nước, vitamin (C, K, B9), khoáng chất (kali), chất xơ và các hợp chất chống oxy hóa (lycopene, beta-carotene). \r\nLợi ích sức khỏe\r\nChống oxy hóa: Lycopene giúp giảm nguy cơ ung thư, bệnh tim.\r\nTăng cường miễn dịch: Vitamin C và beta-carotene hỗ trợ hệ miễn dịch.\r\nHỗ trợ tim mạch: Kali giúp kiểm soát huyết áp.\r\nHỗ trợ tiêu hóa: Chất xơ cải thiện chức năng tiêu hóa.\r\nLàm đẹp da: Sử dụng làm mặt nạ giúp đẹp da. \r\nSử dụng\r\nĂn sống, làm salad, nấu canh, sốt, nước ép.\r\nLá và thân cây cũng có thể dùng làm thuốc.', 40000.00, NULL, 0, NULL, 'kg', 'Đà Lạt, Việt Nam', 'products/JaYKkX2BKjChSfNuMbHVsTLuP24tu5nTbT74jOEb.png', '2026-01-03 22:32:15', '2026-01-03 22:32:15'),
(17, 6, 'Gạo ST25', 'Gạo ST25 là giống gạo thơm đặc sản Sóc Trăng, nổi tiếng thế giới (đạt danh hiệu Gạo ngon nhất thế giới 2019, 2023), có đặc điểm hạt dài, trắng trong, dẻo, thơm mùi lá dứa và cốm non, vị ngọt đậm đà, được lai tạo bởi kỹ sư Hồ Quang Cua và đồng nghiệp, có giá trị dinh dưỡng cao và khả năng kháng mặn tốt. \r\nĐặc điểm nổi bật\r\nHương vị: Thơm mùi lá dứa và cốm non đặc trưng, vị ngọt đậm đà, cơm dẻo mềm, không bị khô cứng khi nguội.\r\nHạt gạo: Dài, trắng trong, không bạc bụng, không gãy vụn.\r\nGiá trị dinh dưỡng: Giàu dinh dưỡng, có hàm lượng protein, chất xơ, khoáng chất (sắt, magie, canxi) cao, phù hợp cho người tiểu đường.\r\nKhả năng canh tác: Chống chịu tốt với điều kiện đất mặn, thích hợp với vùng đồng bằng sông Cửu Long, có thể canh tác 2-3 vụ/năm. \r\nDanh hiệu và công nhận\r\nĐược vinh danh là Gạo ngon nhất thế giới (World\'s Best Rice) vào các năm 2019, 2023 (và 2025) do The Rice Trader tổ chức, Siêu thị Điện Máy XANH và Tomax Holding. \r\nNguồn gốc và sản xuất\r\nTên gọi ST25 là viết tắt của \"Sóc Trăng 25\", là thành quả nghiên cứu 20 năm của kỹ sư Hồ Quang Cua, tiến sĩ Trần Tấn Phương và kỹ sư Nguyễn Thị Thu Hương.\r\nĐược trồng theo quy trình Hữu cơ (Organic), không sử dụng thuốc bảo vệ thực vật.', 84000.00, NULL, 0, NULL, 'kg', 'Sóc Trăng, Việt Nam', 'products/r077Bwzw1kPHgdYehNgkXRkUaWguDpL7PqixSlMs.png', '2026-01-03 22:35:51', '2026-01-03 22:35:51'),
(18, 1, 'Dưa Leo', 'Dưa leo (hay còn gọi là dưa chuột) là một loại quả thuộc họ bầu bí (Cucurbitaceae), có tên khoa học là Cucumis sativus, nổi tiếng với vị thanh mát, giòn và chứa hàm lượng nước rất cao (khoảng 95-97%). Nó được trồng rộng rãi, sử dụng như một loại rau ăn sống, nấu chín hoặc làm đẹp, cung cấp nhiều vitamin (A, C) và khoáng chất, giúp thanh nhiệt, giải độc, hỗ trợ tiêu hóa và làm đẹp da. \r\nĐặc điểm chính\r\nTên gọi: Dưa leo, Dưa chuột, Hoàng qua (tên gọi khác).\r\nHọ: Họ Bầu bí (Cucurbitaceae).\r\nHình dáng: Cây thân leo, có tua cuốn; quả thuôn dài, màu xanh, bề mặt có thể nhẵn hoặc có gai nhỏ; ruột giòn, nhiều nước.\r\nThành phần: Rất giàu nước, ít calo, chứa vitamin (A, B1, B2, C) và khoáng chất (sắt, canxi, phốt pho). \r\nCông dụng phổ biến\r\nẨm thực: Ăn sống trong salad, rau sống, hoặc chế biến món mặn.\r\nSức khỏe: Giúp giải khát, hỗ trợ tiêu hóa, giảm ợ chua, đầy hơi, và các vấn đề về dạ dày.\r\nLàm đẹp: Dùng làm mặt nạ giúp da mịn màng, thư giãn, và giảm sưng.', 20000.00, NULL, 0, NULL, 'kg', 'Đà Lạt, Việt Nam', 'products/MSlCGG1OOOLm1NdoQ3t56Nu2vvqwowctXPm95iZr.png', '2026-01-03 22:40:26', '2026-01-03 22:40:26'),
(19, 2, 'Cam Sành', 'Cam sành là một giống cam đặc sản nổi tiếng của Việt Nam, dễ nhận biết bởi lớp vỏ dày, sần sùi trông giống như mảnh sành, khi chín có màu xanh hoặc xanh vàng. Quả có múi màu vàng cam đậm, mọng nước, vị ngọt xen lẫn chua thanh, rất thơm và có nhiều hạt, thường được dùng để uống nước ép vì nhiều nước, giàu vitamin C và có lợi cho sức khỏe. \r\nĐặc điểm nhận dạng\r\nVỏ: Dày, sần sùi, màu xanh (khi chưa chín) đến xanh vàng hoặc cam (khi chín), đôi khi có đốm nám. Khác với cam Trung Quốc thường có vỏ láng bóng, nhẵn.\r\nRuột: Múi màu vàng cam đậm, nhiều nước, vị ngọt chua đậm đà và thơm.\r\nHạt: Có nhiều hạt (khoảng 8-16 hạt/trái). \r\nVùng trồng nổi tiếng\r\nVĩnh Long (đặc biệt là vùng Tam Bình).\r\nTuyên Quang (Hàm Yên).\r\nHậu Giang.\r\nĐồng Tháp. \r\nCông dụng\r\nBổ sung vitamin (A, C, E), chất xơ, folate, kali.\r\nPhù hợp làm nước ép, sinh tố.\r\nTốt cho sức khỏe, làm đẹp, giảm cân.', 35000.00, NULL, 0, NULL, 'kg', 'Vĩnh Long, Việt Nam', 'products/88ul3rc74AdIJgWcPn0xnJnNXxo9cTh3dVYXfkHP.png', '2026-01-03 22:41:58', '2026-01-03 22:41:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('category','product') NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `description`, `type`, `discount_type`, `discount_value`, `start_date`, `end_date`, `category_id`, `product_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Khuyến mãi đầu năm 2026', NULL, 'category', 'percentage', 20.00, '2026-01-01 22:34:00', '2026-01-11 22:34:00', 1, NULL, 1, '2026-01-02 08:35:06', '2026-01-02 08:35:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 4, 3, 3, NULL, '2025-12-26 00:06:16', '2025-12-26 00:06:16'),
(2, 6, 3, 5, 'ngon', '2025-12-26 01:09:24', '2025-12-26 01:09:24'),
(3, 5, 1, 4, 'Chất lượng sản phẩm tương đối tốt', '2025-12-31 10:11:30', '2025-12-31 10:11:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kAJn095JEvpFHpMDi203n9T72s2VAynQHz5VPvO8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidWY2Zk1mdnU1NFFSaEtGcEtMcWg2dE1kODBWMm5GT2RjSDZveDU4SCI7czoxMToiY2xlYXJBaUNoYXQiO2I6MTtzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO319', 1767522204);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 'Nguyễn Minh Khởi', 'khoiminh.071204@gmail.com', NULL, '$2y$12$0VItICZOd20THhOq9xYfqep.iVZ/AcuWCwBIQz23JcpaCCSdByEBe', 'MqTaiWE6V24Ukh4JeEyikrqkTO50YWu19gn84l9LnjJFHQ716AL0DzDu2y5r', '2025-11-29 08:18:51', '2025-11-29 08:18:51', 1),
(2, 'Linh', 'babilinh@gmail.com', NULL, '$2y$12$5rEzTisBayv.pbC9LcDZauG5jwm4rHj9mm7WWgpDzgL8LFD0Mnx82', NULL, '2025-12-04 21:53:32', '2025-12-04 21:53:32', 0),
(3, 'Khởi', 'khoi123@gmail.com', NULL, '$2y$12$wuOgtTTHxEEgjJT.47/ePuhpcMEipJ6x4bawsI6SWXMHGUWsSX4gi', NULL, '2025-12-22 09:05:37', '2025-12-22 09:05:37', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotions_category_id_foreign` (`category_id`),
  ADD KEY `promotions_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_product_id_user_id_unique` (`product_id`,`user_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
