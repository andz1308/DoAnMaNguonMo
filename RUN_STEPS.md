# HƯỚNG DẪN CHẠY ỨNG DỤNG LARAVEL

## Bước 1: Mở Command Prompt hoặc PowerShell
Mở Command Prompt hoặc PowerShell với quyền Administrator

## Bước 2: Di chuyển vào thư mục dự án
```bash
cd "C:\Users\ADMIN\Downloads\DoAnMaNguonMo-main\DoAnMaNguonMo-main"
```

## Bước 3: Chạy Migration để tạo bảng
```bash
php artisan migrate --force
```

## Bước 4: Chạy Seeder để thêm dữ liệu
```bash
php artisan db:seed --class=QLDienThoaiSeeder
```

## Bước 5: Chạy ứng dụng
```bash
php artisan serve
```

## Bước 6: Mở trình duyệt
Truy cập: http://127.0.0.1:8000

## Lưu ý:
- Đảm bảo XAMPP đã chạy và MySQL đang hoạt động
- Database `qldienthoai` đã được tạo
- Username: root, Password: (để trống)

## Nếu gặp lỗi:
1. Kiểm tra file .env có đúng cấu hình database không
2. Đảm bảo MySQL đang chạy
3. Kiểm tra quyền truy cập database
