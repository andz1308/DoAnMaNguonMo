<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanPham extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'san_pham';
    protected $fillable = [
        'name', 'gia', 'gioi_thieu', 'mo_ta', 'thuong_hieu', 'man_hinh', 'do_phan_giai',
        'camera', 'cpu', 'pin', 'ngay_phat_hanh', 'dung_luong', 'kich_thuoc', 
        'trong_luong', 'so_luong_con', 'loai_san_pham_id'
    ];

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

    /**
     * Accessor for legacy attribute name used across views/controllers.
     * Allows $sanPham->ten_san_pham to return the `name` column.
     */
    public function getTenSanPhamAttribute()
    {
        return $this->attributes['name'] ?? null;
    }
}
