<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanPham extends Model
{
    use HasFactory;

    protected $table = 'san_pham';
    protected $fillable = [
        'name',
        'gia',
        'gioi_thieu',
        'mo_ta',
        'thuong_hieu',
        'man_hinh',
        'do_phan_giai',
        'camera',
        'cpu',
        'pin',
        'ngay_phat_hanh',
        'dung_luong',
        'kich_thuoc',
        'trong_luong',
        'so_luong_con',
        'loai_san_pham_id'
    ];
    protected $appends = ['image', 'price', 'quantity', 'description', 'introduction', 'brand'];

    public function getImageAttribute()
    {
        $image = $this->images()->first();
        if ($image) {
            return $image->name;
        }

        // Fallback images based on product ID
        $fallbackImages = [
            1 => 'i1_1.png',
            2 => 'i2_1.png',
            3 => 'i3_1.png',
            4 => 'i4_1.png',
            5 => 'x1_1.png',
            6 => 's1_1.png',
            7 => 'o1_1.png',
            8 => 'i5_1.png',
            9 => 's2_1.png',
            10 => 'h1_1.png',
            11 => 's3_1.png',
            12 => 'o2_1.png'
        ];

        return $fallbackImages[$this->id] ?? '1.jpg';
    }

    public function getPriceAttribute()
    {
        return $this->gia;
    }

    public function getQuantityAttribute()
    {
        return $this->so_luong_con;
    }

    public function getDescriptionAttribute()
    {
        return $this->mo_ta;
    }

    public function getIntroductionAttribute()
    {
        return $this->gioi_thieu;
    }

    public function getBrandAttribute()
    {
        return $this->thuong_hieu;
    }

    public function loaiSanPham()
    {
        return $this->belongsTo(LoaiSanPham::class, 'loai_san_pham_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'san_pham_id');
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'san_pham_id');
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'san_pham_id');
    }

    public function chiTietKhuyenMai()
    {
        return $this->hasMany(ChiTietKhuyenMai::class, 'san_pham_id');
    }
    public function getGiaBanAttribute()
    {
        // 1. Tìm khuyến mãi hợp lệ (đang diễn ra)
        $khuyenMai = $this->chiTietKhuyenMai()
            ->whereDate('ngay_bd', '<=', Carbon::now())
            ->whereDate('ngay_kt', '>=', Carbon::now())
            ->with('khuyenMai') // Eager load bảng khuyen_mai để lấy % hoặc số tiền giảm
            ->first();

        // 2. Nếu có khuyến mãi, tính giá giảm
        if ($khuyenMai && $khuyenMai->khuyenMai) {
            // Giả sử bảng khuyen_mai lưu giá trị giảm trực tiếp hoặc %
            // Bạn cần kiểm tra cấu trúc bảng khuyen_mai của bạn. 
            // Dựa vào migration ban đầu: table->string('name'); table->float('gia');
            // Tôi đoán 'gia' ở đây là số tiền giảm hoặc % giảm.
            
            // Trường hợp 1: Giảm tiền trực tiếp (Ví dụ gia = 500000)
            // return $this->gia - $khuyenMai->khuyenMai->gia;

            // Trường hợp 2: Nếu 'gia' là phần trăm (Ví dụ gia = 10 tức 10%)
            return $this->gia * (1 - ($khuyenMai->khuyenMai->gia / 100));
        }

        // 3. Nếu không có khuyến mãi, trả về giá gốc
        return $this->gia;
    }
}
