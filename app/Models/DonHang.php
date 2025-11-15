<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonHang extends Model
{
    use HasFactory;


    protected $table = 'don_hang';
    protected $fillable = ['ghi_chu', 'trang_thai', 'user_id'];

    protected $casts = [
        'trang_thai' => 'int',
    ];

    public const STATUS_PENDING = 0;
    public const STATUS_PROCESSING = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELLED = 3;

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Chờ xử lý',
            self::STATUS_PROCESSING => 'Đang xử lý',
            self::STATUS_COMPLETED => 'Hoàn thành',
            self::STATUS_CANCELLED => 'Đã hủy',
        ];
    }

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

    public function getTrangThaiLabelAttribute(): string
    {
        return self::statusOptions()[$this->trang_thai] ?? 'Không xác định';
    }

    public function getTongTienAttribute(): float
    {
        if ($this->relationLoaded('thanhToan') && $this->thanhToan) {
            return (float) $this->thanhToan->tong_tien;
        }

        if ($this->thanhToan) {
            return (float) $this->thanhToan->tong_tien;
        }

        if ($this->relationLoaded('chiTietDonHang')) {
            return $this->chiTietDonHang->sum(function ($item) {
                return ($item->sanPham->gia ?? 0) * ($item->so_luong ?? 0);
            });
        }

        return 0;
    }
}
