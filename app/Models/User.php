<?php

namespace App\Models;


use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements AuthenticatableContract
{
    use HasFactory, Notifiable;


    public $timestamps = false;

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'dien_thoai',
        'dia_chi',
        'password',
        'gioi_tinh',
    ];

    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}