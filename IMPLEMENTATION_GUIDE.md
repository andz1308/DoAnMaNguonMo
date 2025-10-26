# Laravel E-commerce Website

Dự án Laravel này được tạo dựa trên dự án C# QuanLi_WebDienThoai với các tính năng tương tự.

## Các tính năng đã được triển khai

### 1. Layout chính (app.blade.php)
- Header với logo, search box, navigation menu
- Carousel slider
- Sidebar với danh mục sản phẩm
- Footer với thông tin liên hệ

### 2. Trang chủ (Home)
- Hiển thị danh sách sản phẩm với carousel featured products
- Grid layout hiển thị tất cả sản phẩm
- Sidebar với danh mục và thương hiệu

### 3. Chức năng tìm kiếm
- Tìm kiếm sản phẩm theo tên, mô tả, giới thiệu
- URL: `/search?query=từ_khóa`

### 4. Lọc sản phẩm theo thương hiệu
- Lọc sản phẩm theo thương hiệu và loại sản phẩm
- URL: `/products/by-brand?brand=Apple&category=1`

### 5. Lọc sản phẩm theo danh mục
- Hiển thị sản phẩm theo loại sản phẩm
- URL: `/products/by-category/{categoryId}`

## Cấu trúc thư mục

```
resources/views/
├── layouts/
│   ├── app.blade.php          # Layout chính
│   └── sidebar.blade.php     # Sidebar với danh mục
└── home/
    ├── index.blade.php        # Trang chủ
    ├── search.blade.php       # Trang tìm kiếm
    └── products-by-brand.blade.php # Trang lọc theo thương hiệu

app/Http/Controllers/
└── HomeController.php         # Controller xử lý logic

app/Models/
├── SanPham.php               # Model sản phẩm
└── LoaiSanPham.php          # Model loại sản phẩm

public/images/
├── products/                 # Hình ảnh sản phẩm
├── carousel/                 # Hình ảnh carousel
└── social/                  # Hình ảnh social media
```

## Routes

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/products/by-brand', [HomeController::class, 'productsByBrand'])->name('products.by-brand');
Route::get('/products/by-category/{categoryId}', [HomeController::class, 'productsByCategory'])->name('products.by-category');
```

## Cách sử dụng

1. **Chạy dự án:**
   ```bash
   php artisan serve
   ```

2. **Truy cập trang chủ:**
   ```
   http://localhost:8000
   ```

3. **Tìm kiếm sản phẩm:**
   ```
   http://localhost:8000/search?query=iPhone
   ```

4. **Lọc theo thương hiệu:**
   ```
   http://localhost:8000/products/by-brand?brand=Apple&category=1
   ```

## Lưu ý

- Cần có dữ liệu trong database để hiển thị sản phẩm
- Thay thế các file placeholder trong thư mục `public/images/` bằng hình ảnh thực tế
- Cấu hình database trong file `.env`
- Chạy migration để tạo bảng: `php artisan migrate`

## Tính năng tương tự với dự án C#

- ✅ Layout giống hệt dự án C#
- ✅ Trang chủ với carousel và grid sản phẩm
- ✅ Chức năng tìm kiếm
- ✅ Lọc sản phẩm theo thương hiệu
- ✅ Sidebar với danh mục sản phẩm
- ✅ Responsive design với Bootstrap
