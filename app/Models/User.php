<?php

namespace App\Models;


use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements AuthenticatableContract
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'dien_thoai',
        'dia_chi',
        'password',
        'gioi_tinh',
        'trang_thai',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
    ];

    protected $appends = [
        'phone',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->dien_thoai;
    }

    public function setPhoneAttribute(?string $value): void
    {
        $this->attributes['dien_thoai'] = $value;
    }
}