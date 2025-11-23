<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'danh_gia';
    protected $fillable = ['tieu_de', 'noi_dung', 'ngay_phan_hoi'];

}
