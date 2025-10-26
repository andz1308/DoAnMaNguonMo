# Hướng dẫn Setup Laravel Project với MySQL

## Bước 1: Cài đặt XAMPP

1. Tải và cài đặt XAMPP từ: https://www.apachefriends.org/download.html
2. Khởi động XAMPP Control Panel
3. Start Apache và MySQL services

## Bước 2: Tạo Database MySQL

1. Mở trình duyệt và truy cập: http://localhost/phpmyadmin
2. Tạo database mới tên: `qldienthoai`
3. Import file SQL: `database/mysql_qldienthoai.sql` (nếu muốn dùng SQL trực tiếp)

## Bước 3: Cấu hình Laravel

1. Copy file `.env.example` thành `.env`:
```bash
copy .env.example .env
```

2. Cập nhật file `.env` với thông tin database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qldienthoai
DB_USERNAME=root
DB_PASSWORD=
```

3. Generate application key:
```bash
php artisan key:generate
```

## Bước 4: Chạy Migration và Seeder

1. Chạy migration để tạo bảng:
```bash
php artisan migrate
```

2. Chạy seeder để thêm dữ liệu mẫu:
```bash
php artisan db:seed
```

## Bước 5: Khởi động server

```bash
php artisan serve
```

Truy cập: http://localhost:8000

## Cấu trúc Database

### Các bảng chính:
- `roles` - Vai trò người dùng (Admin, NguoiDung)
- `users` - Thông tin người dùng
- `loai_san_pham` - Loại sản phẩm (Điện Thoại, Laptop, Tablet, iPad)
- `san_pham` - Thông tin sản phẩm
- `images` - Hình ảnh sản phẩm
- `don_hang` - Đơn hàng
- `chi_tiet_don_hang` - Chi tiết đơn hàng
- `khuyen_mai` - Khuyến mãi
- `chi_tiet_khuyen_mai` - Chi tiết khuyến mãi
- `danh_gia` - Đánh giá sản phẩm
- `feedback` - Phản hồi từ khách hàng
- `thanh_toan` - Thông tin thanh toán

### Dữ liệu mẫu:
- 2 vai trò: Admin, NguoiDung
- 2 người dùng: Admin (admin@gmail.com/123), Le Manh Tuong (lemanhtuong@gmail.com/123456)
- 4 loại sản phẩm: Điện Thoại, Laptop, Tablet, iPad
- 5 sản phẩm điện thoại: iPhone 16 series và Xiaomi Redmi 12C
- Hình ảnh cho từng sản phẩm
- Đơn hàng và chi tiết đơn hàng mẫu
- Khuyến mãi và đánh giá mẫu

## Lưu ý:
- Đảm bảo PHP và Composer đã được cài đặt
- Đảm bảo XAMPP đang chạy (Apache và MySQL)
- Database `qldienthoai` đã được tạo trong MySQL
- File `.env` đã được cấu hình đúng
