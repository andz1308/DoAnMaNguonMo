<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'dien_thoai',
        'phone', // Alias for dien_thoai
        'dia_chi',
        'password',
        'gioi_tinh',
        'trang_thai',
    ];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
