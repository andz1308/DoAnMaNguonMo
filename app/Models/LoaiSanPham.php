<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoaiSanPham extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'loai_san_pham';
    protected $fillable = ['name'];

    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'loai_san_pham_id');
    }
}
