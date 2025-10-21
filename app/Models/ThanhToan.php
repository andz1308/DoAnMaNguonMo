<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThanhToan extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'thanh_toan';
    protected $primaryKey = 'don_hang_id';
    protected $fillable = ['don_hang_id', 'ngay_thanh_toan', 'tong_tien'];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }
}
