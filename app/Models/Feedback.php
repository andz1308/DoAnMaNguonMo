<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    
    protected $table = 'feedback';
    protected $fillable = ['user_id', 'chu_de', 'noi_dung', 'email', 'loai', 'trang_thai'];

    // Enable timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

