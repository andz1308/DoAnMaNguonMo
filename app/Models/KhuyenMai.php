<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KhuyenMai extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'khuyen_mai';
    protected $fillable = ['name', 'gia'];

    public function chiTietKhuyenMais()
    {
        return $this->hasMany(ChiTietKhuyenMai::class, 'khuyen_mai_id');
    }
}
