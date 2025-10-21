<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DanhGia extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'danh_gia';
    protected $fillable = ['user_id', 'san_pham_id', 'noi_dung', 'vote'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
