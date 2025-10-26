-- MySQL version of the database
-- Converted from SQL Server to MySQL

CREATE DATABASE IF NOT EXISTS qldienthoai;
USE qldienthoai;

-- Bảng ChiTiet_DonHang
CREATE TABLE IF NOT EXISTS chi_tiet_don_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    so_luong INT NULL,
    san_pham_id INT NULL,
    don_hang_id INT NULL
);

-- Bảng ChiTiet_KhuyenMai
CREATE TABLE IF NOT EXISTS chi_tiet_khuyen_mai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    khuyen_mai_id INT NULL,
    san_pham_id INT NULL,
    ngay_bd DATE NULL,
    ngay_kt DATE NULL
);

-- Bảng DanhGia
CREATE TABLE IF NOT EXISTS danh_gia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    san_pham_id INT NULL,
    noi_dung TEXT NULL,
    vote INT NULL
);

-- Bảng DonHang
CREATE TABLE IF NOT EXISTS don_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ghi_chu TEXT NULL,
    trang_thai INT NULL,
    user_id INT NULL
);

-- Bảng Feedback
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tieu_de VARCHAR(255) NULL,
    noi_dung TEXT NULL,
    ngay_phan_hoi DATETIME NULL
);

-- Bảng Images
CREATE TABLE IF NOT EXISTS images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NULL,
    san_pham_id INT NULL
);

-- Bảng KhuyenMai
CREATE TABLE IF NOT EXISTS khuyen_mai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NULL,
    gia FLOAT NULL
);

-- Bảng Loai_San_Pham
CREATE TABLE IF NOT EXISTS loai_san_pham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NULL
);

-- Bảng Role
CREATE TABLE IF NOT EXISTS role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NULL
);

-- Bảng San_Pham
CREATE TABLE IF NOT EXISTS san_pham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NULL,
    gia FLOAT NULL,
    gioi_thieu TEXT NULL,
    mo_ta TEXT NULL,
    thuong_hieu VARCHAR(100) NULL,
    man_hinh VARCHAR(100) NULL,
    do_phan_giai VARCHAR(100) NULL,
    camera VARCHAR(100) NULL,
    cpu VARCHAR(100) NULL,
    pin VARCHAR(100) NULL,
    ngay_phat_hanh DATETIME NULL,
    dung_luong VARCHAR(100) NULL,
    kich_thuoc VARCHAR(100) NULL,
    trong_luong VARCHAR(100) NULL,
    so_luong_con INT NULL,
    loai_san_pham_id INT NULL
);

-- Bảng ThanhToan
CREATE TABLE IF NOT EXISTS thanh_toan (
    don_hang_id INT PRIMARY KEY,
    ngay_thanh_toan DATETIME NULL,
    tong_tien FLOAT NULL
);

-- Bảng User
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NULL,
    name VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    dien_thoai VARCHAR(20) NULL,
    dia_chi VARCHAR(255) NULL,
    password VARCHAR(100) NULL,
    gioi_tinh VARCHAR(10) NULL
);

-- Thêm Foreign Keys
ALTER TABLE chi_tiet_don_hang 
ADD CONSTRAINT fk_chi_tiet_don_hang_don_hang 
FOREIGN KEY (don_hang_id) REFERENCES don_hang(id);

ALTER TABLE chi_tiet_don_hang 
ADD CONSTRAINT fk_chi_tiet_don_hang_san_pham 
FOREIGN KEY (san_pham_id) REFERENCES san_pham(id);

ALTER TABLE chi_tiet_khuyen_mai 
ADD CONSTRAINT fk_chi_tiet_khuyen_mai_khuyen_mai 
FOREIGN KEY (khuyen_mai_id) REFERENCES khuyen_mai(id);

ALTER TABLE chi_tiet_khuyen_mai 
ADD CONSTRAINT fk_chi_tiet_khuyen_mai_san_pham 
FOREIGN KEY (san_pham_id) REFERENCES san_pham(id);

ALTER TABLE danh_gia 
ADD CONSTRAINT fk_danh_gia_san_pham 
FOREIGN KEY (san_pham_id) REFERENCES san_pham(id);

ALTER TABLE danh_gia 
ADD CONSTRAINT fk_danh_gia_user 
FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE images 
ADD CONSTRAINT fk_images_san_pham 
FOREIGN KEY (san_pham_id) REFERENCES san_pham(id);

ALTER TABLE san_pham 
ADD CONSTRAINT fk_san_pham_loai_san_pham 
FOREIGN KEY (loai_san_pham_id) REFERENCES loai_san_pham(id);

ALTER TABLE thanh_toan 
ADD CONSTRAINT fk_thanh_toan_don_hang 
FOREIGN KEY (don_hang_id) REFERENCES don_hang(id);

ALTER TABLE users 
ADD CONSTRAINT fk_users_role 
FOREIGN KEY (role_id) REFERENCES role(id);

ALTER TABLE don_hang 
ADD CONSTRAINT fk_don_hang_user 
FOREIGN KEY (user_id) REFERENCES users(id);

-- Thêm dữ liệu mẫu
-- Bảng Role
INSERT INTO role (name) VALUES 
('Admin'), 
('NguoiDung');

-- Bảng User
INSERT INTO users (role_id, name, email, dien_thoai, dia_chi, password, gioi_tinh) VALUES 
(1, 'Admin', 'admin@gmail.com', '0123456789', '123 ltt', '123', 'Nam'),
(2, 'Le Manh Tuong', 'lemanhtuong@gmail.com', '0987654321', '456 ltt', '123456', 'Nu');

-- Bảng Loai_San_Pham
INSERT INTO loai_san_pham (name) VALUES 
('Điện Thoại'), 
('LapTop'),
('Tablet'),
('Ipad');

-- Bảng San_Pham
INSERT INTO san_pham (id, name, gia, gioi_thieu, mo_ta, thuong_hieu, man_hinh, do_phan_giai, camera, cpu, pin, ngay_phat_hanh, dung_luong, kich_thuoc, trong_luong, so_luong_con, loai_san_pham_id) VALUES 
(1, 'iPhone 16 Pro Max 256GB Chính Hãng (VN/A)', 34000000, 'iPhone 16 Pro Max 256GB là kế nhiệm iPhone 15 Pro Max đã chính thức được Apple giới thiệu vào lúc 0h sáng thứ Ba, ngày 10/09 với hàng loạt cải tiến đáng kể.', '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 Pro Max 256GB</strong></h2>

<p>Apple iPhone 16 Pro Max 256GB sở hữu những tính năng nào nổi bật? Hãy cùng Di Động Việt khám phá ngay:</p>

<ul>
	<li>Chip A18 Pro được phát triển trên tiến trình 3nm kết hợp với thiết kế Neural Engine cải tiến để hỗ trợ các tính năng AI độc quyền.</li>
	<li>Màn hình được mở rộng từ 6.7 inch lên 6.9 inch.</li>
	<li>Nút Capture cảm ứng lực trên iPhone 16 Pro Max mang đến trải nghiệm chụp ảnh, quay video chuyên nghiệp như máy ảnh DSLR.</li>
	<li>Camera góc siêu rộng (Ultrawide) đạt độ phân giải 48MP.</li>
	<li>Camera "siêu" tele mô phỏng tiêu cự 300mm, hỗ trợ zoom quang học 5X.</li>
	<li>Công nghệ kết nối 5G và Wi-Fi 7 với tốc độ cao và độ ổn định vượt trội.</li>
	<li>Hệ thống tản nhiệt graphene giúp giảm nhiệt độ thiết bị.</li>
	<li>Cải tiến về dung lượng pin và khả năng sạc nhanh.</li>
</ul>', 'Apple', ' OLED 6.9 inch', '2868x1320 pixel', 'Fusion 48MP, Ultra Wide 48MP, Telephoto 5x 12MP', 'Chip A18 Pro, CPU 6 lõi mới với 2 lõi hiệu năng và 4 lõi tiết kiệm điện', '4422mAh', '2024-01-16 00:00:00', '16GB - 256GB', 'Dài 163 mm - Ngang 77.6 mm - Dày 8.25 mm', ' 227 gram', 20, 1),

(2, 'iPhone 16 Pro 128GB Chính Hãng (VN/A)', 28790000, 'Là một trong những sản phẩm tiên phong của dòng iPhone năm 2024, iPhone 16 Pro 128GB mang đến một làn gió mới cho thị trường smartphone cao cấp với những cải tiến đột phá về thiết kế, hiệu năng và camera.', '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 Pro 128GB</strong></h2>

<p>Dưới đây là những đặc điểm nổi bật khiến Apple iPhone 16 Pro 128GB trở thành tâm điểm chú ý:</p>

<ul>
	<li>Thiết kế sang trọng, tinh tế với khung viền titan bền bỉ.</li>
	<li>Màn hình OLED 6.3 inch, tần số quét 120Hz, hiển thị sắc nét, sống động.</li>
	<li>Chip Apple A18 Pro mạnh mẽ, xử lý mượt mà mọi tác vụ.</li>
	<li>Hệ thống camera 48MP ấn tượng, nâng cấp khả năng chụp ảnh thiếu sáng.</li>
	<li>Dung lượng pin được cải thiện, hỗ trợ sạc nhanh và sạc không dây MagSafe.</li>
</ul>', 'Apple', 'OLED 6.3 inch', '2622x1206 pixel', 'Fusion 48MP, Ultra Wide 48MP, Telephoto 5x 12MP', 'Chip A18 Pro, CPU 6 lõi mới với 2 lõi hiệu năng và 4 lõi tiết kiệm điện', '4422mAh', '2024-06-20 00:00:00', '16GB - 128GB', 'Dài 149.6 mm - Ngang 71.5 mm - Dày 8.25 mm', ' 199 gram', 23, 1),

(3, 'iPhone 16 128GB Chính Hãng (VN/A)', 21990000, 'iPhone 16 128GB đã chính thức được trình làng vừa qua, với những nâng cấp đầy ấn tượng, từ thiết kế ngoại hình, đến sức mạnh bên trong. Với sức mạnh của con chip A18 Bionic hoàn toàn mới, sức mạnh iPhone 16 năm nay chắc chắn sẽ mang đến nhiều điều bất ngờ cho người dùng.', '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 128GB</strong></h2>

<p>Điện thoại iPhone 16 128GB là một bản nâng cấp đáng giá với nhiều cải tiến đáng chú ý. Máy được trang bị con chip Apple A18 mạnh mẽ, hứa hẹn mang đến hiệu năng vượt trội và trải nghiệm sử dụng mượt mà hơn. Hệ thống camera cũng được nâng cấp đáng kể với cảm biến lớn hơn và thuật toán xử lý hình ảnh tiên tiến, cho phép chụp ảnh chất lượng cao hơn, đặc biệt trong điều kiện thiếu sáng.</p>', 'Apple', 'OLED 6.1 inch', '2556x1179 pixel', 'Fusion 48MP - Telephoto 2x 12MP - Ultra Wide 12MP', ' A18 Bionic, CPU 6 lõi mới với 2 lõi hiệu năng và 4 lõi tiết kiệm điện', '3422mAh', '2023-05-12 00:00:00', '8GB - 128GB', 'Dài 147.6 mm - Ngang 71.6 mm - Dày 7.80 mm', ' 170 gram', 12, 1),

(4, 'iPhone 16 Plus 128GB Chính hãng (VN/A)', 24990000, 'iPhone 16 Plus 128GB là một trong những mẫu điện thoại cao cấp mới nhất của Apple, được thiết kế để đáp ứng nhu cầu của người dùng hiện đại với nhiều tính năng nổi bật. Được trang bị chip A18 Bionic, iPhone 16 Plus cung cấp hiệu suất mạnh mẽ, thiết kế mới mẻ đầy ấn tượng.', '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 Plus 128GB </strong></h2>

<p>Điện thoại iPhone 16 Plus 128GB nổi bật với nhiều tính năng ấn tượng, bao gồm hiệu năng ấn tượng từ chip Apple A18 mới hoàn toàn, cùng với nút "Capture Button" hoàn toàn mới. Nút này tái hiện lại trải nghiệm của máy ảnh kỹ thuật số chuyên nghiệp, cho phép người dùng dễ dàng chuyển đổi giữa các chức năng lấy nét, chụp ảnh và quay video.</p>', 'Apple', 'OLED 6.7 inch', '2796x1290 pixel', ' Fusion 48MP - Telephoto 2x 12MP - Ultra Wide 12MP', ' Chip A18, CPU 6 lõi mới với 2 lõi hiệu năng và 4 lõi tiết kiệm điện', '4422mAh', '2021-06-18 00:00:00', '16GB - 128GB', 'Dài 160.9 mm - Ngang 77.8 mm - Dày 7.80 mm', '199 gram', 34, 1),

(5, 'Xiaomi Redmi 12C 64GB Chính Hãng', 2390000, 'Xiaomi Redmi 12C 64GB thuộc phân khúc tầm trung với hiệu năng đáp ứng tốt các nhu cầu cơ bản của người dùng. Thế hệ điện thoại tiếp theo của Xiaomi sở hữu chip Helio G85 khá tốt trong tầm giá. Đi kèm với đó là bộ ống kính 50MP hỗ trợ bắt trọn các khoảnh khắc trong cuộc sống và nhiều tác vụ liên quan.', '<h2><strong>Xiaomi Redmi 12C - Pin cực khủng, hiệu năng tốt trong tầm giá</strong></h2>

<p>Xiaomi Redmi 12C là chiếc điện thoại thuộc phân khúc tầm trung tiếp theo của Xiaomi. Thiết bị sở hữu kích thước màn hình lớn lên đến 6.71 inches mang đến không gian hiển thị rộng rãi. Đi kèm với đó là chip Helio G85 và camera chính 50MP đáp nhu cầu chụp ảnh tốt trong tầm giá.</p>', 'Xiaomi ', '6.71 inches', ' 720 x 1650 pixels', '50MP chính & 0.08MP chiều sâu', 'Mediatek Helio G85', '5422mAh', '2023-07-18 00:00:00', '4GB - 16GB', '168.8 x 76.4 x 8.8 mm', ' 192 g', 57, 1);

-- Bảng DonHang
INSERT INTO don_hang (ghi_chu, trang_thai, user_id) VALUES 
('Đơn hàng Apple', 1, 2),
('Đơn hàng SamSung', 0, 2);

-- Bảng ChiTiet_DonHang
INSERT INTO chi_tiet_don_hang (so_luong, san_pham_id, don_hang_id) VALUES 
(2, 1, 1),
(1, 2, 2);

-- Bảng KhuyenMai
INSERT INTO khuyen_mai (name, gia) VALUES 
('BACK TO SCHOOL', 10.0), 
('MERRY CHRISTMAS', 20.0);

-- Bảng ChiTiet_KhuyenMai
INSERT INTO chi_tiet_khuyen_mai (khuyen_mai_id, san_pham_id, ngay_bd, ngay_kt) VALUES 
(1, 1, '2024-01-10', '2024-01-20'),
(2, 2, '2024-02-10', '2024-02-20');

-- Bảng DanhGia
INSERT INTO danh_gia (user_id, san_pham_id, noi_dung, vote) VALUES 
(2, 1, 'Good product', 5),
(2, 2, 'Average product', 3),
(1, 1, 'Sản phẩm chất lượng', 5);

-- Bảng Feedback
INSERT INTO feedback (tieu_de, noi_dung, ngay_phan_hoi) VALUES 
('Web chạy chậm', 'Còn 1 số lỗi trên Web, đứng và giật thường xuyên, Web chạy chậm load phải chờ lâu', NOW()),
('Lỗi về feedback sản phẩm', 'Về phần đánh giá sản phẩm, có lúc hiện có lúc không', NOW());

-- Bảng Images
INSERT INTO images (id, name, san_pham_id) VALUES 
(1, 'i1_1.png', 1),
(2, 'i1_2.png', 1),
(3, 'i1_3.png', 1),
(4, 'i1_4.png', 1),
(5, 'i2_1.png', 2),
(6, 'i2_2.png', 2),
(7, 'i2_3.png', 2),
(8, 'i2_4.png', 2),
(9, 'i3_1.png', 3),
(10, 'i3_2.png', 3),
(11, 'i3_3.png', 3),
(12, 'i3_4.png', 3),
(13, 'i4_1.png', 4),
(14, 'i4_2.png', 4),
(15, 'i4_3.png', 4),
(16, 'i4_4.png', 4),
(17, 'x1_1.png', 5),
(18, 'x1_2.png', 5),
(19, 'x1_3.png', 5),
(20, 'x1_4.png', 5);

-- Bảng ThanhToan
INSERT INTO thanh_toan (don_hang_id, ngay_thanh_toan, tong_tien) VALUES 
(1, NOW(), 35000000), 
(2, NOW(), 50000000);
