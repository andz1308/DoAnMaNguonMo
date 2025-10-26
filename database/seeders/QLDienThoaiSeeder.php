<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QLDienThoaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bảng roles
        DB::table('roles')->insert([
            ['name' => 'Admin'],
            ['name' => 'NguoiDung']
        ]);

        // Bảng users
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'dien_thoai' => '0123456789',
                'dia_chi' => '123 ltt',
                'password' => bcrypt('123'),
                'gioi_tinh' => 'Nam',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_id' => 2,
                'name' => 'Le Manh Tuong',
                'email' => 'lemanhtuong@gmail.com',
                'dien_thoai' => '0987654321',
                'dia_chi' => '456 ltt',
                'password' => bcrypt('123456'),
                'gioi_tinh' => 'Nu',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Bảng loai_san_pham
        DB::table('loai_san_pham')->insert([
            ['name' => 'Điện Thoại'],
            ['name' => 'LapTop'],
            ['name' => 'Tablet'],
            ['name' => 'Ipad']
        ]);

        // Bảng san_pham
        DB::table('san_pham')->insert([
            [
                'id' => 1,
                'name' => 'iPhone 16 Pro Max 256GB Chính Hãng (VN/A)',
                'gia' => 34000000,
                'gioi_thieu' => 'iPhone 16 Pro Max 256GB là kế nhiệm iPhone 15 Pro Max đã chính thức được Apple giới thiệu vào lúc 0h sáng thứ Ba, ngày 10/09 với hàng loạt cải tiến đáng kể.',
                'mo_ta' => '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 Pro Max 256GB</strong></h2>

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
</ul>',
                'thuong_hieu' => 'Apple',
                'man_hinh' => 'OLED 6.9 inch',
                'do_phan_giai' => '2868x1320 pixel',
                'camera' => 'Fusion 48MP, Ultra Wide 48MP, Telephoto 5x 12MP',
                'cpu' => 'Chip A18 Pro, CPU 6 lõi mới với 2 lõi hiệu năng và 4 lõi tiết kiệm điện',
                'pin' => '4422mAh',
                'ngay_phat_hanh' => '2024-01-16 00:00:00',
                'dung_luong' => '16GB - 256GB',
                'kich_thuoc' => 'Dài 163 mm - Ngang 77.6 mm - Dày 8.25 mm',
                'trong_luong' => '227 gram',
                'so_luong_con' => 20,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'iPhone 16 Pro 128GB Chính Hãng (VN/A)',
                'gia' => 28790000,
                'gioi_thieu' => 'Là một trong những sản phẩm tiên phong của dòng iPhone năm 2024, iPhone 16 Pro 128GB mang đến một làn gió mới cho thị trường smartphone cao cấp với những cải tiến đột phá về thiết kế, hiệu năng và camera.',
                'mo_ta' => '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 Pro 128GB</strong></h2>

<p>Dưới đây là những đặc điểm nổi bật khiến Apple iPhone 16 Pro 128GB trở thành tâm điểm chú ý:</p>

<ul>
	<li>Thiết kế sang trọng, tinh tế với khung viền titan bền bỉ.</li>
	<li>Màn hình OLED 6.3 inch, tần số quét 120Hz, hiển thị sắc nét, sống động.</li>
	<li>Chip Apple A18 Pro mạnh mẽ, xử lý mượt mà mọi tác vụ.</li>
	<li>Hệ thống camera 48MP ấn tượng, nâng cấp khả năng chụp ảnh thiếu sáng.</li>
	<li>Dung lượng pin được cải thiện, hỗ trợ sạc nhanh và sạc không dây MagSafe.</li>
</ul>',
                'thuong_hieu' => 'Apple',
                'man_hinh' => 'OLED 6.3 inch',
                'do_phan_giai' => '2622x1206 pixel',
                'camera' => 'Fusion 48MP, Ultra Wide 48MP, Telephoto 5x 12MP',
                'cpu' => 'Chip A18 Pro, CPU 6 lõi mới với 2 lõi hiệu năng và 4 lõi tiết kiệm điện',
                'pin' => '4422mAh',
                'ngay_phat_hanh' => '2024-06-20 00:00:00',
                'dung_luong' => '16GB - 128GB',
                'kich_thuoc' => 'Dài 149.6 mm - Ngang 71.5 mm - Dày 8.25 mm',
                'trong_luong' => '199 gram',
                'so_luong_con' => 23,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'iPhone 16 128GB Chính Hãng (VN/A)',
                'gia' => 21990000,
                'gioi_thieu' => 'iPhone 16 128GB đã chính thức được trình làng vừa qua, với những nâng cấp đầy ấn tượng, từ thiết kế ngoại hình, đến sức mạnh bên trong.',
                'mo_ta' => '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 128GB</strong></h2>

<p>Điện thoại iPhone 16 128GB là một bản nâng cấp đáng giá với nhiều cải tiến đáng chú ý. Máy được trang bị con chip Apple A18 mạnh mẽ, hứa hẹn mang đến hiệu năng vượt trội và trải nghiệm sử dụng mượt mà hơn.</p>',
                'thuong_hieu' => 'Apple',
                'man_hinh' => 'OLED 6.1 inch',
                'do_phan_giai' => '2556x1179 pixel',
                'camera' => 'Fusion 48MP - Telephoto 2x 12MP - Ultra Wide 12MP',
                'cpu' => 'A18 Bionic, CPU 6 lõi mới với 2 lõi hiệu năng và 4 lõi tiết kiệm điện',
                'pin' => '3422mAh',
                'ngay_phat_hanh' => '2023-05-12 00:00:00',
                'dung_luong' => '8GB - 128GB',
                'kich_thuoc' => 'Dài 147.6 mm - Ngang 71.6 mm - Dày 7.80 mm',
                'trong_luong' => '170 gram',
                'so_luong_con' => 12,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'iPhone 16 Plus 128GB Chính hãng (VN/A)',
                'gia' => 24990000,
                'gioi_thieu' => 'iPhone 16 Plus 128GB là một trong những mẫu điện thoại cao cấp mới nhất của Apple, được thiết kế để đáp ứng nhu cầu của người dùng hiện đại với nhiều tính năng nổi bật.',
                'mo_ta' => '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 Plus 128GB </strong></h2>

<p>Điện thoại iPhone 16 Plus 128GB nổi bật với nhiều tính năng ấn tượng, bao gồm hiệu năng ấn tượng từ chip Apple A18 mới hoàn toàn.</p>',
                'thuong_hieu' => 'Apple',
                'man_hinh' => 'OLED 6.7 inch',
                'do_phan_giai' => '2796x1290 pixel',
                'camera' => 'Fusion 48MP - Telephoto 2x 12MP - Ultra Wide 12MP',
                'cpu' => 'Chip A18, CPU 6 lõi mới với 2 lõi hiệu năng và 4 lõi tiết kiệm điện',
                'pin' => '4422mAh',
                'ngay_phat_hanh' => '2021-06-18 00:00:00',
                'dung_luong' => '16GB - 128GB',
                'kich_thuoc' => 'Dài 160.9 mm - Ngang 77.8 mm - Dày 7.80 mm',
                'trong_luong' => '199 gram',
                'so_luong_con' => 34,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'Xiaomi Redmi 12C 64GB Chính Hãng',
                'gia' => 2390000,
                'gioi_thieu' => 'Xiaomi Redmi 12C 64GB thuộc phân khúc tầm trung với hiệu năng đáp ứng tốt các nhu cầu cơ bản của người dùng.',
                'mo_ta' => '<h2><strong>Xiaomi Redmi 12C - Pin cực khủng, hiệu năng tốt trong tầm giá</strong></h2>

<p>Xiaomi Redmi 12C là chiếc điện thoại thuộc phân khúc tầm trung tiếp theo của Xiaomi. Thiết bị sở hữu kích thước màn hình lớn lên đến 6.71 inches mang đến không gian hiển thị rộng rãi.</p>',
                'thuong_hieu' => 'Xiaomi',
                'man_hinh' => '6.71 inches',
                'do_phan_giai' => '720 x 1650 pixels',
                'camera' => '50MP chính & 0.08MP chiều sâu',
                'cpu' => 'Mediatek Helio G85',
                'pin' => '5422mAh',
                'ngay_phat_hanh' => '2023-07-18 00:00:00',
                'dung_luong' => '4GB - 16GB',
                'kich_thuoc' => '168.8 x 76.4 x 8.8 mm',
                'trong_luong' => '192 g',
                'so_luong_con' => 57,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Bảng images
        DB::table('images')->insert([
            ['name' => 'i1_1.png', 'san_pham_id' => 1],
            ['name' => 'i1_2.png', 'san_pham_id' => 1],
            ['name' => 'i1_3.png', 'san_pham_id' => 1],
            ['name' => 'i1_4.png', 'san_pham_id' => 1],
            ['name' => 'i2_1.png', 'san_pham_id' => 2],
            ['name' => 'i2_2.png', 'san_pham_id' => 2],
            ['name' => 'i2_3.png', 'san_pham_id' => 2],
            ['name' => 'i2_4.png', 'san_pham_id' => 2],
            ['name' => 'i3_1.png', 'san_pham_id' => 3],
            ['name' => 'i3_2.png', 'san_pham_id' => 3],
            ['name' => 'i3_3.png', 'san_pham_id' => 3],
            ['name' => 'i3_4.png', 'san_pham_id' => 3],
            ['name' => 'i4_1.png', 'san_pham_id' => 4],
            ['name' => 'i4_2.png', 'san_pham_id' => 4],
            ['name' => 'i4_3.png', 'san_pham_id' => 4],
            ['name' => 'i4_4.png', 'san_pham_id' => 4],
            ['name' => 'x1_1.png', 'san_pham_id' => 5],
            ['name' => 'x1_2.png', 'san_pham_id' => 5],
            ['name' => 'x1_3.png', 'san_pham_id' => 5],
            ['name' => 'x1_4.png', 'san_pham_id' => 5]
        ]);

        // Bảng don_hang
        DB::table('don_hang')->insert([
            [
                'ghi_chu' => 'Đơn hàng Apple',
                'trang_thai' => 1,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ghi_chu' => 'Đơn hàng SamSung',
                'trang_thai' => 0,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Bảng chi_tiet_don_hang
        DB::table('chi_tiet_don_hang')->insert([
            [
                'so_luong' => 2,
                'san_pham_id' => 1,
                'don_hang_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'so_luong' => 1,
                'san_pham_id' => 2,
                'don_hang_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Bảng khuyen_mai
        DB::table('khuyen_mai')->insert([
            [
                'name' => 'BACK TO SCHOOL',
                'gia' => 10.0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'MERRY CHRISTMAS',
                'gia' => 20.0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Bảng chi_tiet_khuyen_mai
        DB::table('chi_tiet_khuyen_mai')->insert([
            [
                'khuyen_mai_id' => 1,
                'san_pham_id' => 1,
                'ngay_bd' => '2024-01-10',
                'ngay_kt' => '2024-01-20',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'khuyen_mai_id' => 2,
                'san_pham_id' => 2,
                'ngay_bd' => '2024-02-10',
                'ngay_kt' => '2024-02-20',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Bảng danh_gia
        DB::table('danh_gia')->insert([
            [
                'user_id' => 2,
                'san_pham_id' => 1,
                'noi_dung' => 'Good product',
                'vote' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'san_pham_id' => 2,
                'noi_dung' => 'Average product',
                'vote' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'san_pham_id' => 1,
                'noi_dung' => 'Sản phẩm chất lượng',
                'vote' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Bảng feedback
        DB::table('feedback')->insert([
            [
                'tieu_de' => 'Web chạy chậm',
                'noi_dung' => 'Còn 1 số lỗi trên Web, đứng và giật thường xuyên, Web chạy chậm load phải chờ lâu',
                'ngay_phan_hoi' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tieu_de' => 'Lỗi về feedback sản phẩm',
                'noi_dung' => 'Về phần đánh giá sản phẩm, có lúc hiện có lúc không',
                'ngay_phan_hoi' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Bảng thanh_toan
        DB::table('thanh_toan')->insert([
            [
                'don_hang_id' => 1,
                'ngay_thanh_toan' => now(),
                'tong_tien' => 35000000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'don_hang_id' => 2,
                'ngay_thanh_toan' => now(),
                'tong_tien' => 50000000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
};
