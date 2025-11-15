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
        DB::table('role')->insert([
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
</ul>

<h3><strong>Thiết kế</strong></h3>

<p>iPhone 16 Pro Max 256GB được trang bị nút&nbsp;<strong>"Capture Button"</strong>&nbsp;hoàn toàn mới. Nút này tái hiện lại trải nghiệm của máy ảnh kỹ thuật số chuyên nghiệp, cho phép người dùng dễ dàng chuyển đổi giữa các chức năng lấy nét, chụp ảnh và quay video. Do đó, việc ghi lại những khoảnh khắc đáng nhớ trở nên nhanh chóng và linh hoạt hơn bao giờ hết.</p>

<p>Không chỉ dừng lại ở các tính năng kỹ thuật, điện thoại&nbsp;còn gây ấn tượng với sự xuất hiện của một màu sắc mới&nbsp;là&nbsp;<strong>Desert Titanium</strong>. Tông màu vàng đồng độc đáo này mang đến một phong cách vừa mạnh mẽ vừa cá nhân, lý tưởng cho những ai muốn khẳng định dấu ấn riêng. Với sắc thái ấm áp và tinh tế, Desert Titanium chắc chắn sẽ nổi bật giữa các tùy chọn màu sắc truyền thống.</p>

<h3><strong>Hiệu năng</strong></h3>

<p>iPhone 16 Pro Max 256GB được trang bị chip&nbsp;<strong>A18 Pro</strong>. Nó&nbsp;được phát triển trên tiến trình&nbsp;<strong>N3E 3nm</strong>&nbsp;tiên tiến của TSMC. Quy trình sản xuất thế hệ thứ hai này không chỉ nâng cao độ ổn định mà còn tối ưu hóa hiệu quả tiêu thụ năng lượng.</p>

<p>Bên cạnh đó, Apple còn tích hợp hệ thống tản nhiệt graphene mới, giúp bạn trải nghiệm game trên iPhone 16 Pro Max một cách mượt mà, không phải lo lắng về tình trạng máy nóng hay giật lag.</p>
',
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
                'gioi_thieu' => 'Là một trong những sản phẩm tiên phong của dòng iPhone năm 2024, iPhone 16 Pro 128GB mang đến một làn gió mới cho thị trường smartphone cao cấp với những cải tiến đột phá về thiết kế, hiệu năng và camera. Di Động Việt tự hào là đơn vị phân phối điện thoại iPhone 16 Pro 128GB chính hãng với mức giá cạnh tranh cùng vô vàn ưu đãi hấp dẫn.',
                'mo_ta' => '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 Pro 128GB</strong></h2>

<p>Dưới đây là những đặc điểm nổi bật khiến&nbsp;Apple iPhone 16 Pro 128GB&nbsp;trở thành tâm điểm chú ý:</p>

<ul>
	<li>Thiết kế sang trọng, tinh tế với khung viền titan bền bỉ.</li>
	<li>Màn hình OLED 6.3 inch, tần số quét 120Hz, hiển thị sắc nét, sống động.</li>
	<li>Chip Apple A18 Pro&nbsp;mạnh mẽ, xử lý mượt mà mọi tác vụ.</li>
	<li>Hệ thống camera&nbsp;48MP&nbsp;ấn tượng, nâng cấp khả năng chụp ảnh thiếu sáng.</li>
	<li>Dung lượng pin được cải thiện, hỗ trợ sạc nhanh và sạc không dây MagSafe.</li>
</ul>

<h3><strong>Thiết kế</strong></h3>

<p>Viền của iPhone 15 Pro chỉ dày&nbsp;<strong>1.71 mm</strong>&nbsp;còn&nbsp;iPhone 16 Pro có viền mỏng hơn nữa, chỉ&nbsp;<strong>1.2 mm</strong>. Nhờ vào cấu trúc BRS (Border Reduction Structure) – một giải pháp giúp thu gọn các mạch dưới màn hình, viền máy đã được thu nhỏ đáng kể mà vẫn đảm bảo chất lượng hiển thị không bị ảnh hưởng.</p>

<p>Ngoài ra, màn hình của iPhone 16 Pro 128GB chính hãng cũng lớn hơn so với iPhone 15 Pro, từ 6.1 inch tăng lên&nbsp;<strong>6.3 inch</strong>. Kích thước màn hình rộng hơn này mang lại không gian hiển thị thoải mái hơn, giúp xem video, lướt web và sử dụng các ứng dụng dễ dàng và tiện lợi hơn.</p>

<h3><strong>Hiệu năng</strong></h3>

<p>Apple đã trang bị chip&nbsp;<strong>A18 Pro</strong>&nbsp;mới&nbsp;trên iPhone 16 Pro 128GB chính hãng. Nó&nbsp;được sản xuất trên tiến trình&nbsp;<strong>3nm</strong>&nbsp;tiên tiến.</p>

<p>Bộ vi xử lý này không chỉ đem lại hiệu năng xuất sắc mà còn nâng cao khả năng xử lý trí tuệ nhân tạo. Đáng chú ý, iPhone 16 series sở hữu một khuôn chip lớn hơn, chứa nhiều bóng bán dẫn và các thành phần chuyên biệt hơn, tạo điều kiện cho những cải tiến đáng kể trong lĩnh vực AI.</p>

<h3><strong>Các tính năng mới</strong></h3>

<p>Lần đầu tiên, Apple đã áp dụng&nbsp;<strong>vỏ kim loại&nbsp;</strong>cho pin trên iPhone&nbsp;để thay thế lớp phủ bạc truyền thống mà hãng từng sử dụng. Bước tiến này hứa hẹn cải thiện đáng kể khả năng tản nhiệt của iPhone 16 Pro&nbsp;128GB quốc tế, giúp kéo dài thời lượng pin và cho phép thiết bị hoạt động với hiệu suất cao trong thời gian dài mà không gặp phải vấn đề quá nhiệt như trên iPhone 15 Pro.</p>

<h2><strong>Có nên mua iPhone 16 Pro 128GB không?</strong></h2>

<p>Nếu bạn đang tìm kiếm một chiếc điện thoại cao cấp với hiệu năng mạnh mẽ nhưng vẫn giữ được thiết kế nhỏ gọn thì Apple&nbsp;<strong><a href="https://didongviet.vn/iphone-16-series.html#pro" rel="noopener" target="_blank">iPhone 16 Pro</a>&nbsp;</strong>dung lượng 128GB chắc chắn là lựa chọn lý tưởng.</p>

<p>Thiết bị này được trang bị chip A18 Pro tiên tiến, hỗ trợ nhiều tính năng AI tiên tiến và tiện ích. Hệ thống camera cũng được cải tiến đáng kể so với các phiên bản trước với camera góc siêu rộng 48MP và camera tele kính tiềm vọng hỗ trợ zoom quang 5X.</p>

<p>Không chỉ vậy, smartphone&nbsp;còn có nút chụp Capture mới, mang lại trải nghiệm chụp ảnh chuyên nghiệp như một chiếc máy ảnh thực thụ. Viên pin dung lượng lớn hơn cùng hệ thống tản nhiệt tiên tiến giúp khắc phục những vấn đề của iPhone 15 Pro, mang lại hiệu suất sử dụng ổn định hơn. Hãy đến ngay Di Động Việt để sở hữu iPhone 16 Pro và khám phá những công nghệ mới nhất từ Apple!</p>
',
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
                'gioi_thieu' => 'iPhone 16 128GB đã chính thức được trình làng vừa qua, với những nâng cấp đầy ấn tượng, từ thiết kế ngoại hình, đến sức mạnh bên trong. Với sức mạnh của con chip A18 Bionic hoàn toàn mới, sức mạnh iPhone 16 năm nay chắc chắn sẽ mang đến nhiều điều bất ngờ cho người dùng.',
                'mo_ta' => '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 128GB</strong></h2>

<p>Điện thoại iPhone 16 128GB là một bản nâng cấp đáng giá với nhiều cải tiến đáng chú ý. Máy được trang bị con chip&nbsp;<strong>Apple A18</strong>&nbsp;mạnh mẽ, hứa hẹn mang đến hiệu năng vượt trội và trải nghiệm sử dụng mượt mà hơn. Hệ thống camera cũng được nâng cấp đáng kể với cảm biến lớn hơn và thuật toán xử lý hình ảnh tiên tiến, cho phép chụp ảnh chất lượng cao hơn, đặc biệt trong điều kiện thiếu sáng.&nbsp;</p>

<p>Màn hình OLED chất lượng cao sẽ mang đến hình ảnh sống động, màu sắc chân thực. Với dung lượng lưu trữ 128GB, người dùng sẽ có không gian thoải mái để lưu trữ ảnh, video và các ứng dụng cho các tác vụ công việc cơ bản hằng ngày.&nbsp;</p>

<h3><strong>Thiết kế mới mẻ đầy thu hút</strong></h3>

<p>iPhone 16 128GB sở hữu thiết kế mới mẻ nhưng vẫn mang nét quen thuộc. Năm nay, Apple đã quay trở lại với kiểu dáng camera dọc, thay vì bố trí chéo như trước đây. Đặc biệt, hãng đã bỏ đi khung viền camera hình vuông, tạo nên sự khác biệt rõ rệt so với các thế hệ iPhone 11 và iPhone 12.</p>

<p>Theo thông tin từ Apple, điều này nhằm hỗ trợ tính năng quay video không gian cho kính thực tế ảo Vision Pro, tính năng từng xuất hiện trên các mẫu iPhone 15 Pro năm ngoái. Mặc dù có nhiều cải tiến, thiết kế của iPhone 16 128GB vẫn giữ được vẻ sang trọng đặc trưng của Apple.&nbsp;</p>

<p>Khung viền nhôm cao cấp với các cạnh vát phẳng tinh tế và bốn góc bo cong mềm mại mang lại cảm giác cầm nắm chắc chắn. Trọng lượng của sản phẩm cũng rất hợp lý, không quá nặng hay nhẹ, tạo cảm giác thoải mái khi sử dụng.</p>

<p>iPhone 16 128GB ra mắt với<strong>&nbsp;5 phiên bản màu sắc phong phú bao gồm Trắng, Đen, Hồng, Xanh da trời, Xanh lá cây.</strong>&nbsp;Các màu sắc này đều là tông màu tươi mới nhẹ nhàng, mang đến vẻ trẻ trung và hiện đại cho thiết bị. Ngoài ra, thiết bị cũng được trang bị chuẩn chống nước và kháng bụi IP68, đảm bảo tính bền bỉ và an toàn cho người dùng.</p>

<h3><strong>Hiệu năng mạnh mẽ với con chip A18 hoàn toàn mới</strong></h3>

<p>Thông thường, các mẫu iPhone tiêu chuẩn sẽ sử dụng lại chipset từ các phiên bản Pro và Pro Max của năm trước. Tuy nhiên, dòng iPhone 16 128GB đã được trang bị hoàn toàn chip A18 Series mới mẻ. Cụ thể, iPhone 16 được cung cấp sức mạnh bởi<strong>&nbsp;chip Apple A18</strong>, được sản xuất trên quy trình 3nm, hứa hẹn mang lại hiệu suất vượt trội và tiết kiệm năng lượng đáng kể.</p>

<h3><strong>Các tính năng mới</strong></h3>

<p>iPhone 16 128GB được cài đặt sẵn&nbsp;<strong>hệ điều hành iOS 18&nbsp;</strong>ngay từ lúc ra mắt. Như đã được giới thiệu tại sự kiện WWDC 2024, bản cập nhật này mang đến nhiều tính năng mới hấp dẫn, bao gồm tùy chỉnh màn hình chính, khóa ứng dụng và điều chỉnh kích thước chữ.&nbsp;</p>

<p>Đặc biệt, iPhone 16 còn hỗ trợ các tính năng trí tuệ nhân tạo từ Apple Intelligence, giúp nâng cao trải nghiệm người dùng một cách thú vị và tiện lợi hơn. Một số công cụ AI nổi bật trong iOS 18 bao gồm Image Playground, Clean Up (giúp xóa bỏ các vật thể không mong muốn), Genmoji và trợ lý ảo Siri được tích hợp với ChatGPT.</p>

<h2><strong>Có nên mua iPhone 16 128GB không?</strong></h2>

<p>Việc quyết định có nên mua&nbsp;<strong>iPhone 16&nbsp;</strong>dung lượng 128GB hay không phụ thuộc vào nhu cầu và sở thích cá nhân của bạn. Sản phẩm này nổi bật với hiệu năng mạnh mẽ nhờ chip A18 mới, mang lại tốc độ xử lý nhanh và tiết kiệm năng lượng. Hệ thống camera ấn tượng với ống kính chính 48MP và nhiều tính năng AI giúp bạn chụp ảnh đẹp hơn.&nbsp;</p>

<p><strong>Màn hình Super Retina XDR OLED</strong>&nbsp;cung cấp màu sắc sống động và độ sáng tối ưu, trong khi iOS 18 với nhiều tính năng mới làm phong phú thêm trải nghiệm sử dụng và mức giá có thể cao hơn so với một số smartphone khác.&nbsp;</p>

<p>Nếu bạn đang tìm kiếm một chiếc smartphone cao cấp với hiệu suất tốt và camera chất lượng,&nbsp;<strong><a href="https://didongviet.vn/iphone-16-series.html#thuong" rel="noopener" target="_blank" title="iPhone 16">iPhone 16</a></strong>&nbsp;là một lựa chọn xứng đáng. Tuy nhiên, nếu bạn cần tính năng cụ thể hơn hoặc có ngân sách hạn chế, có thể bạn nên cân nhắc thêm các lựa chọn khác.</p>
',
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
                'gioi_thieu' => 'iPhone 16 Plus 128GB là một trong những mẫu điện thoại cao cấp mới nhất của Apple, được thiết kế để đáp ứng nhu cầu của người dùng hiện đại với nhiều tính năng nổi bật. Được trang bị chip A18 Bionic, iPhone 16 Plus cung cấp hiệu suất mạnh mẽ, thiết kế mới mẻ đầy ấn tượng.',
                'mo_ta' => '<h2><strong>Đặc điểm nổi bật của điện thoại iPhone 16 Plus 128GB&nbsp;</strong></h2>

<p>Điện thoại iPhone 16 Plus 128GB nổi bật với nhiều tính năng ấn tượng, bao gồm hiệu năng ấn tượng từ chip<strong>&nbsp;Apple A18&nbsp;</strong>mới hoàn toàn, cùng với&nbsp;<strong>nút Tác vụ (Action Button)&nbsp;</strong>và nút chụp ảnh (Capture Button) tiện lợi.&nbsp;</p>

<p>Màn hình&nbsp;<strong>OLED 6,7 inch</strong>&nbsp;mang đến trải nghiệm hiển thị sống động với màu sắc rực rỡ, trong khi camera 48MP cho phép chụp ảnh với chất lượng tuyệt vời. Năm nay thiết kế iPhone 16 Plus có chút thay đổi với cụm camera xếp dọc đầy mới mẻ, cùng với 7 tông màu Pastel tươi sáng đầy thu hút gồm xanh lá, hồng, xanh dương, đen, trắng, tím và vàng.&nbsp;</p>

<h3><strong>Thiết kế có sự thay đổi mới mẻ, thu hút</strong></h3>

<p>iPhone 16 Plus 128GB nổi bật với những khác biệt so với phiên bản 15 Plus trước đó. Cụm camera kép được bố trí theo chiều dọc, với đèn LED đặt bên ngoài, tương tự như thiết kế của các mẫu iPhone 12 trước đây. Sự thay đổi này tạo nên một vẻ ngoài tối giản và hài hòa hơn cho toàn bộ thiết bị.</p>

<p>Về màu sắc, iPhone 16 Plus năm nay mang đến cho người dùng với 5 phiên bản màu sắc đa dạng,&nbsp;<strong>bao gồm Đen, Xanh dương, Xanh lá, Hồng, Trắng.&nbsp;</strong>Sự phong phú này là một điểm cộng lớn cho những ai yêu thích sự cá tính và khác biệt trong thiết kế.</p>

<h3><strong>Màn hình lớn, chuẩn màu sắc</strong></h3>

<p>iPhone 16 Plus 128GB mang đến một màn hình đột phá so với các phiên bản trước. Giống như iPhone 15 Plus, iPhone 16 Plus được trang bị&nbsp;<strong>màn hình OLED 6.7 inch&nbsp;</strong>với tần số quét 60Hz. Nhờ vào công nghệ OLED tiên tiến, màn hình của thiết bị này hiển thị màu sắc rực rỡ và độ tương phản ấn tượng.</p>

<p>Thêm vào đó, iPhone 16 Plus còn tích hợp tính năng Always-on display, cho phép người dùng xem thông báo và thời gian mà không cần phải bật màn hình. Điều này không chỉ giúp tiết kiệm pin mà còn nâng cao tính tiện lợi.&nbsp;</p>

<h3><strong>Hiệu năng đầy mới mẻ với con chip A18 Bionic hoàn toàn mới</strong></h3>

<p>Một trong những yếu tố quyết định khi đánh giá một chiếc điện thoại chính là cấu hình chip, và iPhone 16 Plus đã có những cải tiến đáng kể so với các phiên bản trước. Mẫu điện thoại này được trang bị&nbsp;<strong>chip A18 Bionic</strong>&nbsp;mới nhất, được sản xuất trên quy trình 3nm, mang lại hiệu năng và khả năng xử lý vượt trội hơn nhiều so với chip A16 trên iPhone 15 Plus.</p>

<p>Cụ thể, chipset này cung cấp hiệu năng xử lý nhanh hơn 50% và khả năng đồ họa tốt hơn 30%. Cho phép người dùng chơi các trò chơi nặng, xem phim hoặc lướt web một cách mượt mà hơn bao giờ hết. Với cú nhảy vọt khác biệt so với các phiên bản tiền nhiệm sở hữu 1 con chip hoàn toàn mới chắc chắn sẽ đem đến hiệu năng ổn định, vượt trội cho người dùng.&nbsp;</p>

<h3><strong>Các tính năng mới</strong></h3>

<p>Trên iPhone 16 Plus 128GB, người dùng sẽ được trải nghiệm iOS 18 mới nhất từ Apple. Phiên bản này tích hợp nhiều tính năng AI độc quyền, nâng cao tính tiện lợi và hiệu suất sử dụng của thiết bị.&nbsp;</p>

<p>Một trong những điểm nổi bật là sự cải tiến của trợ lý ảo Siri, giờ đây có khả năng học hỏi và tư duy thông minh hơn. Thêm vào đó, iOS 18 cũng hỗ trợ tính năng gửi tin nhắn bằng giọng nói, giúp người dùng có thể gửi tin nhắn nhanh chóng và thuận tiện hơn bao giờ hết.</p>

<h2><strong>Có nên mua iPhone 16 Plus 128GB không?</strong></h2>

<p><strong><a href="https://didongviet.vn/iphone-16-series.html#plus">iPhone 16 Plus</a></strong>&nbsp;dung lượng 128GB hoàn toàn có khả năng đáp ứng tốt mọi nhu cầu sử dụng cơ bản của người dùng với những nâng cấp về hiệu năng, camera, màn hình ấn tượng. Nếu bạn đang tìm kiếm một chiếc smartphone cao cấp với thiết kế sang trọng, màn hình lớn và hiệu năng mạnh mẽ có mức giá tốt hơn dòng Pro thì iPhone 16 Plus chính là sự lựa chọn lý tưởng dành cho bạn.&nbsp;</p>
',
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
                'gioi_thieu' => 'Xiaomi Redmi 12C 64GB thuộc phân khúc tầm trung với hiệu năng đáp ứng tốt các nhu cầu cơ bản của người dùng. Thế hệ điện thoại tiếp theo của Xiaomi sở hữu chip Helio G85 khá tốt trong tầm giá. Đi kèm với đó là bộ ống kính 50MP hỗ trợ bắt trọn các khoảnh khắc trong cuộc sống và nhiều tác vụ liên quan.',
                'mo_ta' => '<h2><strong>Xiaomi Redmi 12C - Pin cực khủng, hiệu năng tốt trong tầm giá</strong></h2>

<p>Xiaomi Redmi 12C là chiếc điện thoại thuộc phân khúc tầm trung tiếp theo của Xiaomi. Thiết bị sở hữu kích thước màn hình lớn lên đến 6.71 inches mang đến không gian hiển thị rộng rãi. Đi kèm với đó là chip Helio G85 và camera chính 50MP đáp nhu cầu chụp ảnh tốt trong tầm giá.</p>

<h3><strong>Thiết kế chống vân tay, nổi bật</strong></h3>

<p>Xiaomi Redmi 12C sở hữu kích thước lên đến&nbsp;<strong>168.8 x 76.4 x 8.8 mm</strong>&nbsp;nhưng lại khá mỏng nhẹ. Trọng lượng của máy chỉ&nbsp;<strong>192g</strong>&nbsp;mang lại cảm giác cầm tay chắc chắn, vừa vặn trong thời gian dài mà không gây khó chịu. Ngoài ra, Xiaomi vẫn tiếp tục sử dụng cổng sạc MicroUSB cho chiếc&nbsp;<a href="https://didongviet.vn/dien-thoai.html" rel="noopener" target="_blank">điện thoại</a>&nbsp;này. Bù lại, máy có cổng sạc 3.5mm chuyên dụng giúp nghe nhạc và gọi điện bằng tai nghe có dây thay vì tích hợp chung với cổng sạc.</p>

<h3><strong>Màn hình LCD HD+&nbsp;sắc nét, chất lượng cao</strong></h3>

<p>Lần này, Xiaomi đã ưu ái mang đến góc nhìn rộng rãi cho một chiếc điện thoại tầm trung - giá rẻ. Thiết bị hoạt động trên tấm nền&nbsp;<strong>IPS LCD</strong>&nbsp;với kích thước&nbsp;<strong>6.71 inches</strong>&nbsp;và độ phân giải&nbsp;<strong>HD+ 720 x 1650 pixels</strong>. Màu sắc hiển thị trên màn hình khá ấn tượng và hài hòa, đem lại trải nghiệm tốt trong tầm giá.</p>

<h3><strong>Camera ấn tượng, chất lượng ảnh đẹp</strong></h3>

<p>Xiaomi Redmi 12C được trang bị bộ đôi camera sau, gồm: camera góc rộng&nbsp;<strong>50MP&nbsp;</strong>và camera chiều sâu&nbsp;<strong>0.08MP</strong>. Hệ thống camera được đánh giá khá ổn trong phân khúc điện thoại Android tầm trung. Chưa hết, chế độ chụp HDR cũng góp phần mang đến những bức ảnh có độ chi tiết cao, được cân bằng màu sắc và ánh sáng hài hòa.&nbsp;</p>

<h3><strong>Hiệu năng cao với chip MediaTek Helio G85</strong></h3>

<p>Xiaomi Redmi 12C được trang bị chip<strong>&nbsp;Helio G85</strong>&nbsp;dành cho phân khúc bình dân của Mediatek. Chip xử lý được đánh giá khá ổn định, chuyên sử dụng cho các tác vụ cơ bản. Ngoài ra, hiệu năng từ chip cũng đáp ứng nhu cầu “chiến” vài tựa game phổ biến hiện nay với mức đồ họa phù hợp.</p>

<h2><strong>Nên mua Xiaomi Redmi 12C hay không?</strong></h2>

<p>Redmi 12C là chiếc điện thoại đáng sở hữu nếu xét về chi phí, bởi nó có mức giá rất hợp lý so với những tính năng mà nó mang lại. Thiết bị sở hữu màn hình lớn, pin trâu, camera đủ tốt để chụp ảnh hàng ngày và hiệu năng đủ để sử dụng các ứng dụng thông dụng một cách mượt mà. Nếu bạn đang tìm kiếm một chiếc điện thoại giá rẻ nhưng vẫn đáp ứng được nhu cầu sử dụng cơ bản thì đây là một lựa chọn tốt. Ngoài ra, Xiaomi cũng là một thương hiệu được đánh giá cao về chất lượng sản phẩm và dịch vụ khách hàng.</p>
',
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
            ],
            [
                'id' => 6,
                'name' => 'Samsung Galaxy S23 Ultra 5G 512GB Chính Hãng',
                'gia' => 23890000,
                'gioi_thieu' => 'Samsung Galaxy S23 Ultra 512GB ra đời là để ghi dấu ấn khó phai trong lòng người hâm mộ. Đặc biệt với nhiều cải tiến bứt phá so với thế hệ trước nhờ vào chipset khủng, không chỉ dừng lại ở hiệu năng mà còn vươn tầm xa hơn với camera chính sở hữu độ phân giải gấp đôi bản cũ. Hơn thế, cấu tạo kiểu dáng và màu sắc của máy cũng là một yếu tố khiến cho smartphone trở nên hút khách hơn bao giờ hết.',
                'mo_ta' => '<h2 style="text-align:justify"><strong>Đặc điểm nổi bật</strong></h2>

<ul>
	<li style="text-align: justify;">Thiết kế vuông vắn viền bezel siêu mỏng</li>
	<li style="text-align: justify;">Làm từ chất liệu nhôm Armor cứng cáp</li>
	<li style="text-align: justify;">Màn hình tràn 6.8 inch - tấm nền Dynamic AMOLED 2X</li>
	<li style="text-align: justify;">Tần số quét cao 120Hz</li>
	<li style="text-align: justify;">Sử dụng bộ vi xử lý Qualcomm Snapdragon 8 Gen 2</li>
	<li style="text-align: justify;">Hệ điều hành Android 13 - OneUI 5.0</li>
	<li style="text-align: justify;">Camera chính 200MP, ống kính siêu rộng 12MP, ống kính tele 10MP</li>
	<li style="text-align: justify;">Hỗ trợ bút cảm ứng S-Pen</li>
	<li style="text-align: justify;">Chống nước IPX8</li>
	<li style="text-align: justify;">Kết nối: mmWave 5G, Wi-Fi 6E, Bluetooth 5.2, NFC, GPS</li>
	<li style="text-align: justify;">Dung lượng pin 5000mAh kết hợp sạc nhanh 45W</li>
	<li style="text-align: justify;">Nâng tầm trải nghiệm với Galaxy AI</li>
</ul>

<h2 style="text-align:justify"><strong>Đánh giá điện thoại Samsung Galaxy S23 Ultra 512GB</strong></h2>

<p style="text-align:justify">Samsung Galaxy S23 Ultra 5G 512GB của năm 2023&nbsp; sẽ sở hữu hiệu năng có chipset Snapdragon 8 Gen 2 mang những gì “tinh tuý” nhất khi nâng cấp lên tầm cao mới so với chipset Gen 1. Bên cạnh đó là thiết kế với đa dạng màu sắc hơn, màn hình lớn 6.8 inch Dynamic AMOLED, cấu tạo từ nhôm Armor bền đẹp theo thời gian. Camera chính 200MP &amp; 50MP và dung lượng pin 5000mAh, góp sức liên tục hỗ trợ bạn giải quyết công việc, giải trí nghỉ ngơi mỗi ngày, xứng đáng là sự lựa chọn trên cả tuyệt vời.</p>

<h3 style="text-align:justify"><strong>Nét đẹp cứng cáp, thanh thoát</strong></h3>

<p style="text-align:justify">Samsung Galaxy S23 Ultra 5G 512GB tạo cho người dùng một xúc cảm về độ cứng cỏi, thiết kế viền vuông vức mang phong cách hiện đại và cá tính riêng. Viền của thiết bị mới đây được Samsung cắt giảm thêm một chút, giúp mở rộng và tối ưu hoá màn hình tràn viền, cung cấp cho bạn kích cỡ giao diện rộng lớn nhất có thể.</p>

<p style="text-align:justify">Về màu sắc, Samsung Galaxy S23 Ultra 512GB có thêm các gam màu mới, đa dạng hoá sự lựa chọn của bạn hơn so với dòng S22 Ultra tiền nhiệm như Cotton Flower (hồng nhạt), Botanic Green (xanh lá nhạt), và Misty Lilac (tím nhạt), máy vẫn trọng lượng nhẹ nhàng và khả năng chống nước IPX8, tiện cho bạn sử dụng ở nhiều môi trường thời tiết khác nhau.</p>

<p style="text-align:justify">Samsung Galaxy S23 Ultra 5G lần này quay trở lại vẫn được đi kèm theo chiếc bút thông minh S-Pen đã có mặt trên dòng Samsung Galaxy Note trước đây. Kết hợp với màn hình rộng, S-Pen có thể thoả sức sáng tạo cũng bàn tay nghệ thuật của bạn để tạo ra những tác phẩm nghệ thuật, ca thơ viết lách giờ đây thật dễ dàng. Hơn thế, cả mặt trước và sau đều dùng loại kính cường lực được dùng cho Samsung Galaxy S23 Ultra 5G sẽ được nâng cấp hơn với kính Corning Gorilla Glass Victus 2, bảo vệ điện thoại khỏi va đập lên đến 2m.</p>

<h3 style="text-align:justify"><strong>Màn hình có độ phân giải cao, tuỳ chỉnh bảo vệ đôi mắt</strong></h3>

<p style="text-align:justify">Samsung Galaxy S23 Ultra 5G 512GB rất ư là được lòng các SamFan nhờ vào thiết kế màn hình với thông số kỹ thuật hoàn hảo, kích thước chuẩn 6.8 inch, là số đo lớn nhất trong bộ sưu tập Samsung Galaxy S23 Series. Công nghệ tấm nền được áp dụng là Dynamic AMOLED 2X, LTPO 2.0 mang độ phân giải 1440 x 3088 pixels cực cao, cung cấp trải nghiệm hình ảnh nổi bật như đang hiện ngay trước mắt.</p>

<p style="text-align:justify">Cụ thể hơn nữa, màn hình còn trang bị tần số quét 120Hz, liên tục làm mới hình ảnh theo từng nội dung bạn đang lướt xem, cộng thêm việc tự động điều chỉnh ánh sáng rất tốt, tiết kiệm pin tối ưu và “không quên” bảo vệ đôi mắt không bị mỏi, khô sau nhiều giờ nhìn vào màn hình. Tiếp đến là mật độ điểm ảnh là 516 PPI, tỷ lệ so với thân máy chiếm đến 87.81%. Thông số này cung cấp độ chi tiết về hình ảnh sâu với màu sắc chân thực gần như tuyệt đối, giúp ích cho bạn với kỳ tác vụ nào trong cuộc sống hằng ngày.</p>

<h3><strong>Chipset mới có sức mạnh “oanh tạc”</strong></h3>

<p>Samsung Galaxy S23 Ultra 512GB có một sự mạnh mẽ ấn tượng chắc chắn là “cánh tay phải” của bạn mỗi ngày, cùng bạn xử lý đa nhiệm các tác vụ, hoàn thành tốt các công việc và cũng là “trợ thủ” đắc lực trong những trận game hot hit mà không bị giật lag, hay buộc phải dừng giữa chừng vì máy quá nóng, đường truyền không ổn định.</p>

<p style="text-align:justify">Tất cả những điều này đều dựa vào bộ vi xử lý gọi là Snapdragon 8 Gen 2, một bước cải tiến đột phá mới so với thế hệ Gen 1 đã ra mắt trước đó trên Samsung Galaxy S22 Ultra. Chipset được thiết kế và sản xuất bởi công ty Qualcomm trứ danh, chi tiết hơn, bên trong được tích hợp một GPU Adreno 740 cho phép hiệu suất đa nhiệm nâng cao hơn lên 35%, tốc độ xử lý hình ảnh, video động thì tăng thêm 25% và tiết kiệm năng lượng hơn 40% nữa.&nbsp;</p>

<p style="text-align:justify">Hiệu năng có 4 lõi hiệu suất cao, kết hợp hỗ trợ thêm Unreal Engine 5 Metahumans Framework nâng tầm chơi game như một game thủ chuyên nghiệp và bài bản, nay gói gọn hết trong kích thước nhỏ bé, cái mà khi xưa chỉ có thể chạy trên các máy lớn như PC, laptop có độ phải giải cao. Samsung Galaxy S23 Ultra 5G dùng hệ điều hành Android 13 - OneUI 5.0, ngoài ra máy có RAM 12GB và bộ nhớ trong ROM 512GB, gần như là lớn nhất trong bộ dung lượng tích hợp sẵn, chỉ đứng sau bản 1TB.</p>

<h3><strong>Các tính năng mới</strong></h3>

<p>Samsung còn mang đến trải nghiệm sử dụng vượt trội khi tích hợp công nghệ Galaxy AI trên phiên bản này với hàng loạt các tính năng đột phá. Đó là:&nbsp;<strong>Circle to Search (Khoanh tròn để tìm kiếm), Photo assist (Trợ lý chỉnh ảnh chuyên nghiệp), Chat assist (Trợ lý chat thông minh) và Note assist (Trợ lý Note quyền năng).</strong></p>
',
                'thuong_hieu' => 'SamSung',
                'man_hinh' => '6.8" - Tần số quét 120Hz',
                'do_phan_giai' => 'QHD+ (3088x1440 pixels)',
                'camera' => 'Chính 200 MP & Phụ 12 MP + 10 MP',
                'cpu' => 'Qualcomm Snapdragon 8 Gen 2 (4 nm)',
                'pin' => '5000mAh',
                'ngay_phat_hanh' => '2024-02-15 00:00:00',
                'dung_luong' => '12 GB - 512 GB',
                'kich_thuoc' => 'Dài : 163.4 mm - Ngang : 78.1 mm - Dày : 8.9 mm',
                'trong_luong' => '234 g',
                'so_luong_con' => 23,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'name' => 'OPPO A17K 64GB Chính Hãng',
                'gia' => 2490000,
                'gioi_thieu' => 'OPPO A17K là sản phẩm mới vừa được cho ra mắt của nhà OPPO. Chiếc smartphone này sở hữu vẻ ngoài với thiết kế hiện đại, tinh tế và tỉ mỉ trong từng chi tiết. Nó được trang bị màn hình rộng lớn giúp nâng cao trải nghiệm của người dùng. Bên cạnh đó, với dung lượng pin lên đến 5000mAh, bạn có thể tha hồ giải trí, làm việc mà không sợ bị gián đoạn.',
                'mo_ta' => '<h2><strong>Đặc điểm nổi bật của sản phẩm</strong></h2>

<ul>
	<li>Thiết kế hiện đại, độc đáo</li>
	<li>Sở hữu màn hình LCD rộng 6.56 inch với độ phân giải HD</li>
	<li>Camera hỗ trợ người dùng ghi lại khoảnh khắc nhanh chóng</li>
	<li>Chipset MediaTek Helio G35 8 nhân mang lại hiệu năng ổn định</li>
	<li>Được trang bị viên pin có dung lượng lên đến 5000mAh</li>
	<li>Chạy trên hệ điều hành Android 12&nbsp;</li>
</ul>

<h3><strong>Thiết kế hiện đại, độc đáo</strong></h3>

<p>OPPO A17K 64GB được kế thừa thiết kế tinh tế từ người anh tiền nhiệm OPPO A16K. Nó sở hữu một thiết kế hiện đại, tinh tế và nếu quan sát kĩ thì có thể thấy được nhà sản xuất cũng đã rất chú trọng để tạo ra một thiết kế đẹp. Từ đó, chiếc smartphone này không chỉ đóng vai trò là một thiết bị nghe gọi mà nó còn là một phụ kiện giúp người dùng tự tin hơn khi mang nó theo bên mình.</p>

<p>Bên cạnh đó, với kích thước dài 164.2 mm - ngang 75.6 mm - dày 8.3 mm, trọng lượng chỉ 189g, chiếc điện thoại này đảm bảo được độ mỏng nhẹ. Người dùng có thể mang theo bên mình đi bất cứ nơi đâu mà không sợ bị nặng hay chiếm quá nhiều diện tích.</p>

<p>Ngoài ra, nhằm giúp nâng cao bảo mật và thao tác được nhanh chóng hơn, nhà sản xuất còn hỗ trợ mở khóa bằng dấu vân tay và mở khóa bằng khuôn mặt cho người dùng.</p>

<h3><strong>Sở hữu màn hình LCD rộng 6.56 inch với độ phân giải HD</strong></h3>

<p>Bên cạnh việc sở hữu thiết kế hiện đại, chiếc điện thoại OPPO A17K này cũng được trang bị màn hình rộng lớn. Sở hữu màn hình LCD rộng 6.56 inch với độ phân giải HD, nó mang đến cho bạn không gian trải nghiệm tốt hơn, màu sắc khá trung thực với những hình ảnh rõ ràng. Từ đó, giúp bạn có được những trải nghiệm giải trí và làm việc thú vị hơn trên thiết bị của mình.</p>

<h3><strong>Chipset MediaTek Helio G35 8 nhân mang lại hiệu năng ổn định</strong></h3>

<p>Nhà Oppo đã trang bị cho chiếc OPPO A17K chipset MediaTek Helio G35 8 nhân cho hiệu năng hoạt động ổn định. Với con chip này, thiết bị sẽ hỗ trợ người dùng thực hiện các tác vụ cơ bản như đọc báo, xem phim, chơi các tựa game có đồ họa nhẹ nhàng.</p>

<p>Bên cạnh đó, A17K cũng được trang bị bộ nhớ 3GB RAM giúp các tác vụ cơ bản. Ngoài ra, nó còn hỗ trợ bộ nhớ lưu trữ hình ảnh, âm thanh với bộ nhớ trong 64GB. Đây không phải là một dung lượng chứa quá lớn nhưng bạn hãy yên tâm vì thiết bị còn được hỗ trợ thẻ nhớ ngoài lên đến 1TB.</p>

<h3><strong>Được trang bị viên pin có dung lượng lên đến 5000mAh</strong></h3>

<p>Ngoài những tính năng nêu trên thì chiếc smartphone này còn gây án tượng với người dùng khi sở hữu viên pin có dung lượng cực lớn. Cụ thể, OPPO A17K sở hữu dung lượng pin lên đến 5000mAh cho phép sử dụng cả ngày dài và thậm chí là lên đến hai ngày sử dụng đối với những tác vụ nhắn tin, nghe gọi cơ bản.&nbsp;</p>

<h2><strong>OPPO A17K có gì nâng cấp so với thế hệ trước?</strong></h2>

<p>A17K được xem là thế hệ tiếp theo sau OPPO A16K, là một sản phẩm nổi bật ở phân khúc giá rẻ. Vậy liệu nhà OPPO đã mang đến sự khác biệt nào so với tiền nhiệm? Sau đây là một số chi tiết bạn cần quan tâm:</p>

<table border="1">
	<tbody>
		<tr>
			<td>Thông số kỹ thuật</td>
			<td><strong>OPPO A17K</strong></td>
			<td><strong>OPPO A16K</strong></td>
		</tr>
		<tr>
			<td>Kích thước màn hình</td>
			<td>6.65 inch</td>
			<td>6.52 inch</td>
		</tr>
		<tr>
			<td>Camera</td>
			<td>8MP (sau) + 5MP (trước)</td>
			<td>13MP (sau) + 5MP (trước)</td>
		</tr>
		<tr>
			<td>Dung lượng pin</td>
			<td>5.000 mAh</td>
			<td>4.230 mAh</td>
		</tr>
	</tbody>
</table>
',
                'thuong_hieu' => 'Oppo',
                'man_hinh' => '6.56" - Tần số quét 60 Hz',
                'do_phan_giai' => 'HD+ (720 x 1612 Pixels)',
                'camera' => 'FullHD 1080p@30fps HD 720p@30fps',
                'cpu' => 'MediaTek Helio G35 8 nhân',
                'pin' => '5000mAh',
                'ngay_phat_hanh' => '2024-01-31 00:00:00',
                'dung_luong' => '3 GB - 64 GB',
                'kich_thuoc' => 'Dài 164.2 mm - Ngang 75.6 mm - Dày 8.3 mm',
                'trong_luong' => '189 g',
                'so_luong_con' => 53,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'name' => 'iPhone 13 256GB Chính Hãng (VN/A)',
                'gia' => 16990000,
                'gioi_thieu' => 'iPhone 13 256GB mang nhiều cải tiến đến từ chipset mang lại cấu hình đã khủng nay càng khủng hơn, phần notch iPhone 13 có kích thước nhỏ hơn, cụm camera được hỗ trợ nhiều tính năng hơn.',
                'mo_ta' => '<h3><strong>iPhone 13 256GB sở hữu màn hình OLED tuyệt mỹ</strong></h3>

<p>iPhone 13 256GB sẽ có màn hình OLED 6.1 inch cùng tấm nền mang công nghệ Super Retina XDR&nbsp;được cải tiến mang lại tỷ lệ tương phản đáng kinh ngạc cho màu đen thực sự và tăng 28% độ sáng tối đa ngoài trời ở 800 nits, với độ sáng cao nhất cho nội dung HDR như ảnh và video ở 1200 nits, đồng thời tiết kiệm điện hơn.</p>

<p>Đây vẫn là màn hình OLED, hỗ trợ dải màu rộng, Apple cho rằng hình ảnh trên iPhone 13 cho cảm giác chân thực nhất, màu sắc chính xác nhất. Hỗ trợ công nghệ Super Renita XDR với mật độ điểm ảnh cao, cho hình ảnh luôn sắc nét.</p>

<h3><strong>Hiệu năng mạnh mẽ với A15 Bionic</strong></h3>

<p>iPhone 13 128GB được trang bị con chip Apple A15 Bionic. Theo Apple,&nbsp;A15 Bionic nhanh hơn nhiều so với các&nbsp;đối thủ khác, mang lại hiệu năng cao hơn và tiết kiệm&nbsp;năng lượng tốt hơn, khiến mọi thứ trở nên trôi chảy hơn trong dòng sản phẩm iPhone 13.&nbsp;chip A15 mới (5nm) - 6 nhân CPU (2 nhận mạnh và 4 nhân tiết kiệm điện. CPU cho hiệu năng nhanh hơn 50%, GPU có 4 nhân, cho hiệu năng đồ hoạ nhanh hơn 30%.</p>

<p>Thế giới đang nhanh chóng chuyển sang 5G và iPhone cung cấp trải nghiệm 5G tiên tiến, thay đổi cách người dùng kết nối, chia sẻ và thưởng thức nội dung. Thiết kế phần cứng tùy chỉnh trong dòng sản phẩm iPhone 13 có nhiều băng tần 5G hơn, cho phép nó hoạt động ở nhiều nơi hơn trên 5G để có vùng phủ sóng và chất lượng cuộc gọi cao hơn.&nbsp;Bên cạnh đó,&nbsp;chế độ Dữ liệu thông minh sẽ tiết kiệm pin một cách thông minh bằng cách tự động chuyển iPhone sang LTE khi không cần đến tốc độ 5G.</p>

<h3><strong>Cụm camera mặt sau tiên tiến nhất trên iPhone</strong></h3>

<p>iPhone 13 256GB được trang bị hai cụm camera đặt xéo với camera rộng và góc siêu rộng. Camera chính 12MP f/1.6, cảm biến lớn hơn, thu sáng nhiều hơn 47% cũng như ít noise hơn. Điều này giúp cải thiện khả năng chụp đêm trên iPhone 13 hơn rất nhiều giúp người dùng có thể thoải mái sáng tạo trong mọi điều kiện ánh sáng khác nhau.</p>

<p>Apple giới thiệu thêm tính năng Cinematic Mode - giúp người dùng quay video như các bộ phim điện ảnh với tính năng làm mờ hậu cảnh khi quay để có chiều sâu hơn. Đặc biệt là khả năng lấy nét chuyển giao giữa hai vật thể trong thời gian thực để tạo cảm giác chú ý hơn.</p>

<h3><strong>Viên pin cung cấp thời lượng sử dụng đáng chú ý</strong></h3>

<p>Với bộ vi xử lý mới được tối ưu,&nbsp;<strong><a href="https://didongviet.vn/iphone-13.html#thuong">điện thoại iPhone 13</a></strong>&nbsp;mang lại viên pin với thời gian sử dụng lâu dài hơn. Cũng như mọi năm, Apple không tiết lộ chính xác dung lượng pin cụ thể trên thiết bị của mình. Tuy nhiên, theo hãng công bố thì thời lượng sử dụng pin trên iPhone 13 sẽ được gia tăng đáng kể lên khoảng 2,5 tiếng so với thế hệ trước đó.</p>
',
                'thuong_hieu' => 'Apple',
                'man_hinh' => '6.1" - Tần số quét 60 Hz',
                'do_phan_giai' => '1170 x 2532 Pixels',
                'camera' => '2 camera 12 MP',
                'cpu' => 'Apple A15 Bionic',
                'pin' => '3422mAh',
                'ngay_phat_hanh' => '2024-03-23 00:00:00',
                'dung_luong' => '4 GB - 256 GB',
                'kich_thuoc' => '146.7 x 71.5 x 7.4 mm',
                'trong_luong' => '164 g',
                'so_luong_con' => 21,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 9,
                'name' => 'Samsung Galaxy Z Flip5 5G 256GB Chính Hãng',
                'gia' => 14990000,
                'gioi_thieu' => 'Samsung Galaxy Z Flip5 256GB không chỉ là chiếc smartphone thông thường mà chúng còn đại diện cho sự sáng tạo và đổi mới không ngừng. Với khả năng gập linh hoạt, tân binh này mở ra không gian công nghệ mới đáp ứng hầu hết mọi nhu cầu của người dùng từ công việc cho đến giải trí. Đây chính là sự lựa chọn hoàn hảo cho những ai muốn nắm bắt xu hướng và thể hiện sự khác biệt.',
                'mo_ta' => '<h2><strong>Những điểm nổi bật của điện thoại gập Z Flip5</strong></h2>

<ul>
	<li>Thiết kế hiện đại phù hợp với mọi phong cách đi kèm những game màu nổi bật lấy cảm hứng từ thiên nhiên.</li>
	<li>Cung cấp trải nghiệm tuyệt vời cho việc chụp ảnh tự sướng và sáng tạo với camera selfie. Kết hợp cùng camera sau hỗ trợ AI xử lí cực sắc nét.</li>
	<li>Cấu hình mạnh mẽ với chip Snapdragon 8 Gen 2 For Galaxy mới nhất.</li>
	<li>Khung viền nhôm Armor Aluminum bền bỉ giúp hạn chế trầy xước, va đập đảm bảo điện thoại sẽ vẫn trông mới mẻ dù trong mọi tình huống.</li>
	<li>Nâng tầm trải nghiệm cùng hệ thống Galaxy AI hiện đại và tiện lợi.</li>
</ul>

<h3><strong>Thiết kế thừa hưởng thế hệ trước</strong></h3>

<p>Samsung Galaxy Z Flip5 vẫn tiếp tục kế thừa thiết kế gập tinh xảo - một biểu tượng đặc trưng từ những thế hệ tiền nhiệm trước. Theo đó, chiếc máy này khi gập lại sẽ rất nhỏ gọn, vừa vặn khi cầm nắm và dễ dàng đặt trong túi mà không chiếm quá nhiều diện tích.</p>

<p>Samsung cũng không ngừng cải tiến công nghệ bản lề khiến chúng trở nên bền bỉ và có độ chịu lực tốt hơn qua việc sử dụng cơ chế rãnh kép. Nhờ vậy mà tân binh này sẽ mang lại trải nghiệm mở đóng êm ái, liền mạch và ổn định. Đặc biệt, phần nếp gấp màn hình sẽ được làm mờ đáng kể và khoảng hở giữa hai phần màn hình sẽ được loại bỏ hầu như là hoàn toàn.</p>

<p>Không những vậy, chiếc điện thoại Samsung này cũng được đánh giá là có độ bền bỉ và khả năng chịu lực cao do được trang bị khung Armor Aluminum chắc chắn. Bên cạnh đó, sản phẩm này cũng có mặt lưng được bao phủ bởi lớp kính Gorilla Glass Victus 2 giúp chống trầy xước khá tốt đồng thời là điểm nhấn thẩm mỹ, khẳng định phong cách của chủ sở hữu.</p>

<h3><strong>Công nghệ màn hình vô cùng sắc nét</strong></h3>

<p>Z Flip5 mang đến không gian trải nghiệm rộng lớn ở màn hình 6.7inch đi kèm công nghệ nền Dynamic AMOLED 2X cao cấp cùng độ phân giải FHD+. Nhờ vậy mà chúng có khả năng tái tạo màu sắc với độ chính xác cao nhất và chân thực đến từng chi tiết cũng như đảm bảo mọi nội dung hiển thị trên đây đều rõ nét.</p>

<p>Bên cạnh đó, tần số quét 120Hz cũng được hỗ trợ ngay trên này hứa hẹn sẽ đem đến trải nghiệm hình ảnh mượt mà và phản hồi thao tác người dùng một cách nhanh chóng.</p>

<p>Tân binh Samsung cũng có màn hình phụ lớn hơn so với bản tiền nhiệm với kích thước lên tới 3.4inch. Dù vậy, độ phân giải và tần số quét màn hình sẽ bị giảm xuống ở thông số 720 x 748pixels và 60Hz. Bù lại là người chơi có thể tùy biến các Widget theo nhu cầu sử dụng của mình cũng như thực hiện nhiều thao tác ngay cả khi máy đang gập.</p>

<h3><strong>Hiệu năng cực kì vượt trội</strong></h3>

<p>Samsung Z Flip5 được trang bị vi xử lý Snapdragon 8 Gen 2 phiên bản For Galaxy có tốc độ xung nhịp cao nhất đạt 3.36GHz. Không chỉ thế, CPU này còn khẳng định sức mạnh với hiệu suất tăng vọt lên đến 34% so với người tiền nhiệm. Nhờ vậy mà chúng có thể xử lý các tác vụ đa nhiệm phức tạp và chạy mượt các ứng dụng nặng hay đáp ứng khả năng chơi game đòi hỏi đồ họa cao.&nbsp;</p>

<h3><strong>Camera bắt trọn mọi khoảnh khắc</strong></h3>

<p>Tân binh mới nhất của nhà Samsung được trang bị hệ thống camera gồm cảm biến chính 12MP và camera góc rộng 12MP. Điều đặc biệt là các ống kính này đã được tối ưu hóa nhằm mang đến hình ảnh sắc nét, có độ chi tiết rõ rệt dù chụp trong điều kiện ánh sáng yếu. Bên cạnh đó, người dùng cũng có thể sử dụng FlexCam trên thế hệ mới này để tùy biến thay đổi góc máy linh hoạt.</p>

<p>Ngoài ra, thiết bị cũng có camera trước 10MP cực kỳ sắc nét giúp những bức ảnh selfie hay chân dung đều toát lên vẻ đẹp riêng biệt. Không những vậy, bạn còn có thể ghi lại từng khoảnh khắc sống động với video chất lượng cao, mà không lo lắng về việc hình ảnh bị vỡ hay mất chi tiết.</p>

<h3><strong>Dung lượng pin đủ cho cả ngày</strong></h3>

<p>Được trang bị viên pin khủng 3700 mAh, chiếc Galaxy Z Flip5 có thể hoạt động liên tục suốt cả ngày dài. Không chỉ thế, với sự hỗ trợ của công nghệ sạc nhanh 25 W, việc nạp năng lượng cho thiết bị trở nên nhanh chóng, giúp bạn sẵn sàng cho mọi cuộc phiêu lưu mà không cần phải chờ quá lâu.</p>

<h2><strong>Tham khảo những lý do nên sở hữu ngay Samsung Galaxy Z Flip5</strong></h2>

<p>Galaxy Z Flip5 sở hữu thiết kế gập vỏ sò giúp điện thoại trở nên gọn gàng và tiện lợi khi được gập lại. Nhờ vậy mà người dùng có thể dễ dàng cầm tay một cách thoải mái hay bỏ vào túi mà không chiếm quá nhiều diện tích.</p>

<p>Không những vậy, tân binh gập này còn có màn hình phụ kích thước 3.4inch mang lại nhiều tiện ích và trải nghiệm tiện lợi cho người dùng. Đặc biệt với tính năng Flex Window cho phép bạn trả lời tin nhắn và thao tác với các menu widget đa dạng ngay khi điện thoại đang ở trạng thái gập. Ấn tượng hơn là bạn có thể selfie thoải mái linh hoạt các góc quay với chế độ Flexcam ngay trên này.</p>
',
                'thuong_hieu' => 'SamSung',
                'man_hinh' => 'Màn hình phụ: 3.4 inch; Màn hình chính: 6.7 inch',
                'do_phan_giai' => 'Chính: FHD+ (2640 x 1080 Pixels); Phụ: HD+ (720 x 748 Pixels)',
                'camera' => '12 MP (wide) + 12 MP (ultrawide)',
                'cpu' => 'Snapdragon 8 Gen 2 For Galaxy',
                'pin' => '3700 mAh',
                'ngay_phat_hanh' => '2024-10-08 00:00:00',
                'dung_luong' => '8GB - 256GB',
                'kich_thuoc' => 'Khi mở: 165.1 x 71.9 x 6.9 mm; Khi gập: 85.1 x 71.9 x 15.1 mm',
                'trong_luong' => '187 g',
                'so_luong_con' => 86,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 10,
                'name' => 'Honor X6a 4GB/128GB Chính Hãng',
                'gia' => 2490000,
                'gioi_thieu' => 'Điện thoại Honor X6a ra mắt trong phân khúc giá rẻ nhưng vẫn đảm bảo về thiết kế và cấu hình. Tuy sở hữu viên pin khủng 5200mAh nhưng máy chỉ nặng 188g. Màn hình 6.56 inch có khả năng hiển thị 16.7 triệu màu với tần số quét 90Hz. Chip xử lý Helio G36 và camera chính 50MP cũng đáp ứng nhu cầu giải trí thường ngày của người dùng.',
                'mo_ta' => '<h2><strong>Những điểm nổi bật của điện thoại Honor X6a</strong></h2>

<p>Đặc điểm nổi bật của điện thoại Honor X6a như sau:</p>

<ul>
	<li>Thiết kế tuyệt đẹp với hai phiên bản màu Bạc Ánh Sao và Đen Huyền Bí.</li>
	<li>Màn hình rộng 6.56 inch mang lại trải nghiệm cầm nắm vừa vặn và chắc chắn.</li>
	<li>Tần số quét 90Hz cho mọi chuyển động đều mượt mà và cực nhanh trong tầm giá.</li>
	<li>Hiệu năng ổn định nhờ chip Helio G36 thế hệ mới với tốc độ xung nhịp tối đa đạt 2.2GHz.</li>
	<li>Nhiều tính năng hỗ trợ, cảm ứng đa điểm, thao tác đơn giản.</li>
	<li>Cung cấp trải nghiệm mượt mà, bền bỉ với tấm nền TFT LCD.</li>
	<li>Pin 5200mAh cho thời gian sử dụng lâu hỗ trợ sạc nhanh 22.5W.</li>
	<li>Chất lượng vượt kỳ vọng trong tầm giá 3 - 4 triệu đồng.</li>
</ul>

<h2><strong>Thiết kế phẳng sáng bóng, mỏng nhẹ</strong></h2>

<p>Honor X6a sở hữu mặt lưng sáng bóng được hoàn thiện tỉ mỉ càng làm nổi bật hai phiên bản màu&nbsp;<strong>Bạc Ánh Sao</strong>&nbsp;và<strong>&nbsp;Đen Huyền Bí</strong>. Viền màn hình được làm mỏng đáng kể so với các sản phẩm trong tầm giá, giúp tăng không gian hiển thị và mang đến góc nhìn rộng rãi hơn. Module camera tàng hình chứa bốn ống kính nổi hẳn lên trên bề mặt cũng tạo nên điểm nhấn cho chiếc smartphone giá rẻ mới này.</p>

<p>Được biết, điện thoại Honor X6a có kích thước<strong>&nbsp;163.32 x 75.07 x 8.35mm&nbsp;</strong>nhưng chỉ nặng khoảng&nbsp;<strong>188g</strong>. Sự mỏng nhẹ này kết các góc cạnh được bo cong mềm mại đem lại trải nghiệm cầm nắm đã tay. Qua đó giúp bạn thoải mái mang theo máy đến bất kỳ đâu mà không lo bị cấn hay khó chịu.</p>

<h2><strong>Màn hình LCD 6.56 inch 16.7 triệu màu</strong></h2>

<p>Honor X6a giá rẻ hoạt động trên tấm nền<strong>&nbsp;TFT LCD</strong>&nbsp;với kích thước&nbsp;<strong>6.56 inch</strong>&nbsp;và tỷ lệ&nbsp;<strong>20.15:9</strong>&nbsp;phù hợp với hầu hết các yêu cầu hiển thị hiện nay. Chưa hết, màn hình có độ phân giải&nbsp;<strong>720 x 1612 pixels</strong>&nbsp;và khả năng hiển thị lên đến 16.7 triệu màu giúp mọi hình ảnh được tái hiện một cách chân thực và sống động trong tầm giá.&nbsp;</p>

<p>Đặc biệt, bạn sẽ khó tìm kiếm một chiếc smartphone giá rẻ dưới 4 triệu sở hữu tần số quét lên đến<strong>&nbsp;90Hz</strong>. Mức thông số mang đến trải nghiệm vuốt chạm mượt mà và linh hoạt cho mọi thao tác của người dùng.&nbsp;</p>

<h2><strong>Camera 50MP hỗ trợ lấy nét, làm đẹp</strong></h2>

<p>Điện thoại Honor X6a mới được trang bị module camera hình vuông ở mặt sau với ba ống kính và đèn flash LED được bố trí ở bốn góc. Trải nghiệm chụp ảnh trở nên ấn tượng hơn bao giờ hết trong tầm giá 3 triệu nhờ camera chính&nbsp;<strong>50MP</strong>, camera chân dung&nbsp;<strong>2MP&nbsp;</strong>và camera macro<strong>&nbsp;2MP</strong>. Đặc biệt, camera sau còn có khả năng zoom kỹ thuật số 10x cho phép bạn thoải mái chụp ảnh từ khoảng cách xa.</p>

<p>Ngoài ra, camera selfie trước&nbsp;<strong>5MP</strong>&nbsp;tuy không quá lớn nhưng vẫn hỗ trợ quay chụp cơ bản cho người dùng.&nbsp;</p>

<h2><strong>Honor X6a tích hợp chip Helio G36 thế hệ mới</strong></h2>

<p>Honor X6a được trang bị chip xử lý<strong>&nbsp;Helio G36&nbsp;</strong>thế hệ mới của nhà Mediatek chuyên dành cho phần khúc giá rẻ. Chip hoạt động với CPU 8 nhân có tốc độ xung nhịp cao nhất lên đến<strong>&nbsp;2.2GHz</strong>&nbsp;và GPU<strong>&nbsp;IMG GE8320</strong>. Bộ vi xử lý cho phép máy hoạt động ổn định với các tác vụ cơ bản như xem phim, lướt web, đọc báo,...&nbsp;</p>

<h2><strong>Pin 5200mAh cho ngày dài hoạt động, nạp pin tiện lợi</strong></h2>

<p><a href="https://didongviet.vn/dien-thoai-honor.html" rel="noopener" target="_blank">Điện thoại Honor mới</a>&nbsp;tạo ấn tượng mạnh mẽ nhờ viên pin&nbsp;<strong>5200mAh</strong>&nbsp;rất cao trong phân khúc giá rẻ. Mức pin cho phép máy hoạt động liên tục suốt cả ngày dài, giúp bạn yên tâm khi sử dụng thiết bị. Chưa kể, thương hiệu Honor còn hỗ trợ công suất sạc&nbsp;<strong>22.5W</strong>&nbsp;cho chiếc X6a. Tuy vẫn mất hơn một tiếng để sạc đầy pin điện thoại nhưng đây vẫn là một mức thông số cao trong tầm giá.</p>
',
                'thuong_hieu' => 'Honor',
                'man_hinh' => '6.56 inch - Tần số quét: 90Hz',
                'do_phan_giai' => '720 x 1650 pixels',
                'camera' => 'Chính 50 MP & Chân dung 2MP & Macro 2MP',
                'cpu' => 'MediaTek Helio G36',
                'pin' => '5200 mAh',
                'ngay_phat_hanh' => '2023-07-13 00:00:00',
                'dung_luong' => '4GB - 128GB',
                'kich_thuoc' => '163.32 x 75.07 x 8.35mm',
                'trong_luong' => '188g',
                'so_luong_con' => 67,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 11,
                'name' => 'Samsung Galaxy A05s 128GB Chính Hãng',
                'gia' => 3590000,
                'gioi_thieu' => 'Samsung Galaxy A05s 128G Chính Hãng là chiếc smartphone series A của Samsung sở hữu thiết kế tinh tế, hiệu suất mạnh mẽ và màn hình rộng rãi. Dù có mức giá phải chăng, sản phẩm vẫn sở hữu pin khủng cho bạn thoải mái sử dụng trong thời gian dài.',
                'mo_ta' => '<h2>Những điểm nổi bật của điện thoại Samsung Galaxy A05s:</h2>

<ul>
	<li>Mang đến không gian hiển thị sống động với kích thước 6.7inch.</li>
	<li>Vận hành mượt mà các tác vụ với chip Snapdragon 680.</li>
	<li>Ghi lại mọi khoảnh khắc trọn vẹn với bộ ba camera cao cấp.</li>
	<li>Trải nghiệm pin ấn tượng xuyên suốt ngày dài.</li>
</ul>

<h3><strong>Thiết kế đẹp mắt, gần gũi</strong></h3>

<p>Samsung A05s sở hữu ngoại hình vuông vức với từng đường nét được chú trọng tỉ mỉ tạo nên thành một vẻ ngoài mạnh mẽ, hết sức sang trọng. Dù vậy, máy lại có thiết kế khá lớn với độ dày lên tới 8.8mm. Tuy nhiên chúng vẫn đem đến cảm giác cầm nắm thoải mái do toàn thân máy đều được hoàn thiện bằng chất liệu nhựa với kiểu lưng nhám mịn, nhẹ nhàng.</p>

<p>Quay ra mặt sau, A05s cũng gây ấn tượng không kém với bộ ba camera được bố trí một cách tinh tế theo chiều dọc. Điểm nhấn này không chỉ phản ánh sự đổi mới trong ngôn ngữ thiết kế của Samsung mà còn là biểu tượng của phong cách hiện đại và đẳng cấp.</p>

<p>Ngoài ra, Samsung cũng đem đến cho người dùng nhiều sự lựa chọn hơn qua 3 gam màu là Đen Đá, Xanh Matcha và Bạc Xỉu. Đây đều là những bản màu vừa an toàn lại vừa hiện đại mà lại không bị lỗi thời theo xu hướng ngày nay.</p>

<h3><strong>Màn hình rộng mở</strong></h3>

<p>A05s cũng đem đến trải nghiệm sử dụng ổn định với màn hình PLS LCD kích thước 6.7inch, kết hợp cùng độ phân giải FHD+ cho ra chất lượng hình ảnh siêu sắc nét. Không chỉ dừng lại ở đó, máy còn tích hợp tần số quét 90Hz mang lại trải nghiệm vuốt chạm mượt mà, linh hoạt với tốc độ phản hồi nhanh chóng.</p>

<p>Ngoài ra, thiết bị còn sở hữu độ sáng màn hình lên tới 500nits. Dù đây không phải là thông số quá lớn nhưng vẫn đảm bảo người dùng có thể nhìn thấy rõ nội dung khi ở ngoài trời nắng.</p>

<h3><strong>Hiệu năng vượt đỉnh</strong></h3>

<p>Galaxy A05s được trang bị bộ vi xử lý Snapdragon 680 được sản xuất trên tiến trình 6nm với xung nhịp cao nhất đạt được là 2.4GHz. Nhờ vật mà chúng không chỉ đem lại hiệu năng ấn tượng mà còn đảm bảo một trải nghiệm mượt mà và cho phép bạn tận hưởng mọi ứng dụng và trò chơi mà không lo gián đoạn. Tuy nhiên, vì đây là dòng chip giá rẻ nên việc chơi game có đồ họa cao sẽ có khả năng gặp khó khăn. Vì vậy mà bạn nên cân nhắc kỹ điều này.</p>

<p>Bên cạnh đó, tân binh này còn hỗ trợ bộ nhớ RAM 4GB giúp duy trì hoạt động đa nhiệm cho các ứng dụng cơ bản khá tốt. Cộng thêm bộ nhớ trong lên tới 128GB mà bạn có thể tha hồ lưu trữ mọi dữ liệu cần thiết.</p>

<h3><strong>Camera cho hình ảnh sắc nét</strong></h3>

<p>Samsung A05s được trang bị ba ống kính camera sau lưng với độ phân giải cảm biến hoàn toàn khác nhau. Cụ thể, máy sẽ có camera chính 50MP bắt trọn từng chi tiết với độ sắc nét cao, trong khi 2 ống kính phụ 2 MP cho phép người dùng chụp ảnh cận cảnh hay tạo hiệu ứng xóa phông mượt mà. Điểm nhấn của thiết bị này là dù trong điều kiện ánh sáng không lý tưởng chúng vẫn đáp ứng khả năng xử lý hình ảnh xuất sắc.</p>

<p>Chưa dừng lại ở đó, khả năng chụp tự sướng trên đây cũng được máy đáp ứng khá tốt nhờ vào camera selfie 13MP ở mặt trước. Đặc biệt hơn khi trên đây, máy còn tích hợp nhiều tính năng làm đẹp hoàn hảo giúp bạn có thể tự chia sẻ hình ngay lên mạng mà không cần rà chỉnh gì nhiều.</p>

<h3><strong>Thời lượng pin và tốc độ sạc giúp trải nghiệm suốt cả ngày dài</strong></h3>

<p>Galaxy A05s còn có một điểm sáng là hỗ trợ pin 5000mAh mà người dùng có thể trải nghiệm suốt cả ngày dài. Bên cạnh đó, máy cũng hỗ trợ sạc nhanh 25W giúp máy nhanh chóng được sạc đầy mà không cần đợi quá lâu.</p>

<h2><strong>Tham khảo những lý do nên sở hữu ngay Samsung Galaxy A05s</strong></h2>

<p>Những lý do bạn nên sở hữu ngay Samsung Galaxy A05s:</p>

<ul>
	<li>Thiết kế sang trọng, hiện đại với mặt lưng nhám mịn, mềm mại.</li>
	<li>Màn hình giọt nước quen thuộc mang đến không gian hiển thị sống động.</li>
	<li>Camera có độ phân giải cao 50MP cho khả năng chụp ảnh chi tiết, rõ ràng trong mọi điều kiện ánh sáng.</li>
	<li>Vi xử lý Snapdragon 680 8 nhân cho hiệu năng ổn định, xử lý đa nhiệm mượt mà đáp ứng mọi tác vụ.</li>
	<li>Thoải mái giải trí mà không lo hết pin với dung lượng 5000mAh.</li>
	<li>Mức giá tầm trung phù hợp với nhiều đối tượng người dùng.</li>
</ul>
',
                'thuong_hieu' => 'SamSung',
                'man_hinh' => '6.7 inches - Tần số quét 90Hz',
                'do_phan_giai' => '1080 x 2400',
                'camera' => '50MP + 2MP + 2MP',
                'cpu' => 'Snapdragon 680',
                'pin' => '5000 mAh',
                'ngay_phat_hanh' => '2024-05-13 00:00:00',
                'dung_luong' => '4 GB - 128 GB',
                'kich_thuoc' => '168 x 77.8 x 8.8 mm',
                'trong_luong' => '194 g',
                'so_luong_con' => 86,
                'loai_san_pham_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 12,
                'name' => 'OPPO Find N3 512GB Chính Hãng',
                'gia' => 42990000,
                'gioi_thieu' => 'OPPO Find N3 512GB là thế hệ điện thoại gập ngang đầu tiên của OPPO được ra mắt tại thị trường Việt Nam. Máy có thiết kế gập như quyển sách với module camera sau hình tròn đầy thanh lịch và tinh tế, mang đến nét ấn tượng mới cho dòng điện thoại gập OPPO. Chưa kể, khả năng nhiếp ảnh cũng được tăng cường với ống kính Hasselblad. Đặc biệt, chip Snapdragon 8 Gen 2 và dung lượng pin đến 4805 mAh sẽ mang đến hiệu năng mạnh mẽ và kéo dài thời gian sử dụng suốt cả ngày dài.',
                'mo_ta' => '<h2>Những điểm nổi bật của OPPO Find N3</h2>

<p>Tham khảo những đặc điểm nổi bật của điện thoại Find N3 mới dưới đây:</p>

<ul>
	<li>Thiết kế mỏng nhẹ với trọng lượng 239g, độ dày chỉ 5.8mm khi mở ra và 11.7mm khi gập lại.</li>
	<li>Màn hình Canvas độc đáo và sáng tạo với kích thước lớn hơn đời trước, trong đó màn hình ngoài 6.3 inch và màn hình trong 7.8 inch.</li>
	<li>Sự hợp tác với Hasselblad mang đến bộ 3 camera sắc nét có cảm biến lớn cho phép bất kỳ ống kính nào cũng là camera chính.</li>
	<li>Hiệu năng mạnh mẽ của chip Snapdragon 8 Gen 2 giúp máy xử lý tốt mọi yêu cầu của người dùng.</li>
	<li>Dung lượng pin 4805 mAh và công suất sạc nhanh 67W kéo dài thời gian sử dụng liền mạch cho người dùng.</li>
</ul>

<h2><strong>Thiết kế siêu mỏng, đường nét tinh xảo, nếp gấp tàng hình</strong></h2>

<p>OPPO Find N3 sở hữu thiết kế Fold, mang đến trải nghiệm như đang cầm một quyển sách trên tay. Khung viền được gia công từ chất liệu kim loại và các cạnh mềm mại giúp tăng độ bền bỉ và mang lại sự thoải mái khi sử dụng.&nbsp;</p>

<p>Điện thoại cũng sở hữu kích thước lớn hơn so với đời trước nhưng vẫn duy trì sự mỏng nhẹ chỉ&nbsp;<strong>293g</strong>. Phần viền màn hình siêu mỏng cho góc nhìn rộng rãi hơn đi kèm nếp gấp tàng hình và cử chỉ ngón tay tiện lợi giúp nâng cao trải nghiệm khi sử dụng và thao tác. Đặc biệt, đây là lần đầu tiên OPPO trang bị thanh trượt trạng thái cho điện thoại gập của hãng.</p>

<p>Chưa kể sản phẩm không bị thay đổi layout khi đóng mở điện thoại vậy nên bạn không cần phải mất thời gian để làm quen lại từ đầu.</p>

<p>Tuy nhiên, điều thú vị nhất chính là cụm camera sau đổi mới đầy thời thượng. Thay vì sử dụng một module camera hình chữ nhật như các model trước đó, hãng điện thoại OPPO đã táo bạo đổi mới bằng cách thiết kế cụm camera hình tròn. Điều này không chỉ mang lại vẻ ngoài độc đáo mà còn tạo nên sự cuốn hút và ấn tượng đối với người dùng.</p>

<h2><strong>Màn hình sắc nét, nâng cấp khả năng tương tác</strong></h2>

<p>Màn hình chính của OPPO Find N3 sử dụng tấm nền&nbsp;<strong>LTPO3 OLED</strong>&nbsp;cao cấp với kích thước&nbsp;<strong>7.82 inch</strong>&nbsp;khi mở ra. Điều này này không chỉ mang lại trải nghiệm hấp dẫn như một chiếc tablet thu nhỏ, mà còn nâng cao sự tiện ích cho người dùng khi bạn mong muốn thao tác trên một màn hình lớn. Độ phân giải lên đến&nbsp;<strong>2268 x 2440 pixels</strong><strong>&nbsp;</strong>cũng góp phần giúp bạn có thể tận hưởng một không gian mở rộng để xem phim, chơi game hay làm việc mà không cần mang theo một thiết bị khác.&nbsp;</p>

<p>Màn hình phụ của OPPO Find N3 Fold cũng rất ấn tượng với kích thước&nbsp;<strong>6.31 inch</strong><strong>&nbsp;</strong>và độ phân giải đạt&nbsp;<strong>1116 x 2484 pixels</strong>. So với phiên bản trước đó, đây thực sự là một bước tiến đáng kể. Kích thước này tương đương màn hình của những chiếc smartphone thông thường, và dĩ nhiên đảm bảo các tính năng giống hệt như màn hình chính. Ước tính thời gian sử dụng màn hình ngoài lên đến 50%. Bạn có thể dễ dàng cầm nắm chiếc điện thoại trong lòng bàn tay hoặc nhét trong túi quần, túi xách mà không gặp bất kỳ khó khăn nào.</p>

<p>Đặc biệt, tần số quét của màn hình phụ cũng là&nbsp;<strong>120Hz</strong>&nbsp;cho trải nghiệm vuốt chạm siêu mượt mà. Bạn có thể thoải mái thao tác trên màn hình phụ cho các nhu cầu hàng ngày mà không cần phải luôn gập mở thiết bị.</p>

<h2><strong>Ấn tượng camera đỉnh cao ứng dụng công nghệ từ Hasselblad</strong></h2>

<p>OPPO Find N3 sở hữu hệ thống camera gồm 3 ống kính cao cấp, hiện đại với độ phân giải&nbsp;<strong>48MP + 48MP + 64MP</strong>. Tuy nhiên, OPPO không chỉ dừng lại ở đó mà tiếp tục hợp tác với Hasselblad để cải tiến chất lượng camera, mang đến những trải nghiệm nhiếp ảnh tuyệt vời.</p>

<p>Bạn có thể thỏa sức chụp ảnh và quay video với độ phân giải cao hơn, tái hiện mọi chi tiết một cách rõ nét và sống động. Sự kết hợp giữa OPPO và Hasselblad mang đến sự chính xác và chất lượng hình ảnh đáng kinh ngạc, giúp bạn ghi lại những khoảnh khắc đáng nhớ với độ tương phản tốt, màu sắc trung thực và chi tiết sắc nét.</p>

<p>Không chỉ riêng về camera chính, điện thoại cũng sẽ được trang bị camera selfie&nbsp;tương tự thế hệ trước, cho phép bạn chụp ảnh tự sướng với độ phân giải cao và màu sắc chân thực. Đồng thời, hãng còn nâng cao trải nghiệm chụp ảnh ở dòng&nbsp;<a href="https://didongviet.vn/oppo-find-n.html" rel="noopener" target="_blank">Find N</a>&nbsp;bằng cách tích hợp thêm nhiều tính năng chụp ảnh trí tuệ nhân tạo (AI) giúp bạn tạo ra những bức ảnh tự nhiên và chất lượng hơn. Bạn có thể tận hưởng việc chụp ảnh một cách sáng tạo và sắc nét hơn bao giờ hết.</p>

<h2><strong>Trang bị chip Snapdragon cao cấp</strong></h2>

<p>Chiếc điện thoại OPPO Find N3 Fold được trang bị vi xử lý&nbsp;<strong>Snapdragon 8 Gen 2</strong>, không chỉ vượt trội hơn đời tiền nhiệm mà còn mang đến hiệu năng mạnh mẽ nếu so với những chiếc smartphone gập khác. Con chip hàng đầu này không chỉ cung cấp hiệu năng mạnh mẽ mà còn tiết kiệm năng lượng, đồng thời nâng cao khả năng xử lý đồ hoạ cho Find N3.</p>

<p>Để đáp ứng các tác vụ đa nhiệm và xử lý đồ họa chuyên nghiệp, Find N3 còn được trang bị&nbsp;<strong>RAM</strong><strong>&nbsp;12GB</strong>&nbsp;chuẩn LPDDR5 mới nhất. Điều này đảm bảo rằng bạn có đủ dung lượng RAM để xử lý mượt mà các tác vụ phức tạp mà không gặp trục trặc. Bên cạnh đó, điện thoại cũng sở hữu bộ nhớ trong 512GB hoặc 1TB, cho phép bạn lưu trữ nhiều dữ liệu và ứng dụng mà không cần lo lắng về không gian lưu trữ hạn chế.</p>

<h2><strong>Pin trâu và sạc nhanh thần tốc</strong></h2>

<p>Một trong những điểm đáng chú ý và hấp dẫn của OPPO Find N3 chính là sự nâng cấp về mức pin. Chiếc điện thoại này được trang bị viên pin dung lượng&nbsp;<strong>4805 mAh</strong>, khá ấn tượng trong phân khúc điện thoại gập. Với mức pin này, bạn có thể yên tâm sử dụng điện thoại suốt cả ngày mà không cần lo lắng về việc sạc pin liên tục.</p>
',
                'thuong_hieu' => 'Oppo',
                'man_hinh' => 'AMOLED / Tần số quét: 120Hz',
                'do_phan_giai' => '2268 x 2440 pixels (màn hình chính) / 1116 x 2484 pixels (màn hình phụ)',
                'camera' => '48MP OIS (Chính) + 48MP (Góc rộng) + 64MP (Tele)',
                'cpu' => 'Snapdragon 8 Gen 2',
                'pin' => '4805 mAh',
                'ngay_phat_hanh' => '2024-09-28 00:00:00',
                'dung_luong' => '12GB - 512GB',
                'kich_thuoc' => 'Mở: 153.4 x 143.1 x 5.8 mm / Gập: 153.4 x 73.3 x 11.7 mm',
                'trong_luong' => '239g',
                'so_luong_con' => 5,
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
            ['name' => 'x1_4.png', 'san_pham_id' => 5],

            // Dữ liệu còn lại (sản phẩm 6-12)
            ['name' => 's1_1.png', 'san_pham_id' => 6],
            ['name' => 's1_2.png', 'san_pham_id' => 6],
            ['name' => 's1_3.png', 'san_pham_id' => 6],
            ['name' => 's1_4.png', 'san_pham_id' => 6],
            ['name' => 'o1_1.png', 'san_pham_id' => 7],
            ['name' => 'o1_2.png', 'san_pham_id' => 7],
            ['name' => 'o1_3.png', 'san_pham_id' => 7],
            ['name' => 'o1_4.png', 'san_pham_id' => 7],
            ['name' => 'i5_1.png', 'san_pham_id' => 8],
            ['name' => 'i5_2.png', 'san_pham_id' => 8],
            ['name' => 'i5_3.png', 'san_pham_id' => 8],
            ['name' => 'i5_4.png', 'san_pham_id' => 8],
            ['name' => 's2_1.png', 'san_pham_id' => 9],
            ['name' => 's2_2.png', 'san_pham_id' => 9],
            ['name' => 's2_3.png', 'san_pham_id' => 9],
            ['name' => 's2_4.png', 'san_pham_id' => 9],
            ['name' => 'h1_1.png', 'san_pham_id' => 10],
            ['name' => 'h1_2.png', 'san_pham_id' => 10],
            ['name' => 'h1_3.png', 'san_pham_id' => 10],
            ['name' => 'h1_4.png', 'san_pham_id' => 10],
            ['name' => 's3_1.png', 'san_pham_id' => 11],
            ['name' => 's3_2.png', 'san_pham_id' => 11],
            ['name' => 's3_3.png', 'san_pham_id' => 11],
            ['name' => 's3_4.png', 'san_pham_id' => 11],
            ['name' => 'o2_1.png', 'san_pham_id' => 12],
            ['name' => 'o2_2.png', 'san_pham_id' => 12],
            ['name' => 'o2_3.png', 'san_pham_id' => 12],
            ['name' => 'o2_4.png', 'san_pham_id' => 12]
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
}
;
