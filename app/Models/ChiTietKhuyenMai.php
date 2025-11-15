<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChiTietKhuyenMai extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_khuyen_mai';
    protected $fillable = ['khuyen_mai_id', 'san_pham_id', 'ngay_bd', 'ngay_kt'];

    public function khuyenMai()
    {
        return $this->belongsTo(KhuyenMai::class, 'khuyen_mai_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
