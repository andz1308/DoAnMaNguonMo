<?php

namespace App\Models;

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

    public function chiTietKhuyenMais()
    {
        return $this->hasMany(ChiTietKhuyenMai::class, 'san_pham_id');
    }
}
