<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonHang extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'don_hang';
    protected $fillable = ['ghi_chu', 'trang_thai', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }

    public function thanhToan()
    {
        return $this->hasOne(ThanhToan::class, 'don_hang_id');
    }
}
