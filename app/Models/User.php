<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    // Define the table name (optional)

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'foto_profile',
        'nisn',
        'nuptk',
        'jabatan',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'kelas',
        'jatuh_tempo',
        'email',
        'no_telepon',
        'terdaftar',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function kelasGes()
    {
        return $this->belongsTo(Kelas::class, 'kelas'); // Make sure 'kelas' is the correct foreign key
    }


    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas'); // 'wali_kelas' is the foreign key
    }

    public function tagihan()
    {
        return $this->belongsToMany(Tagihan::class, 'user_tagihan', 'user_id', 'tagihan_id');  // Sesuaikan tabel pivot jika ada
    }
    public function tagihanSiswa()
    {
        return $this->hasMany(TagihanSiswa::class, 'user_id');
    }


}