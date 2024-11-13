<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class
User extends Authenticatable
{
    use HasFactory, Notifiable;
    const LIST_AKSES = ['Admin Siap Kerja', 'Admin Caker', 'Admin Konsultasi Karir', 'Masyarakat', 'Perusahaan', 'Sekolah'];
    const BASE_ROUTES = [
        'Admin Siap Kerja' => 'admin',
        'Admin Caker' => 'caker',
        'Admin Konsultasi Karir' => 'admin_konsultasi',
        'Masyarakat' => '/',
        'Perusahaan' => 'perusahaan',
        'Sekolah' => 'sekolah'
    ];
    protected $table = "user";
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function akses()
    {
        return $this->hasOne(UserAkses::class);
    }

    public function list_akses()
    {
        return $this->hasMany(UserAkses::class);
    }
}
