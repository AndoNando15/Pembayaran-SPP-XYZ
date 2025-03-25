<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    // Define the correct table name
    protected $table = 'tagihan';  // Use the correct table name

    // The attributes that are mass assignable
    protected $fillable = [
        'tagihan',
        'tanggal',
        'batas_waktu',
        'kelas',   // Relasi ke tabel kelas
        'nominal',
        'status',
        'keterangan',
        'terdaftar',
    ];

    // Define the relationship with the Kelas model
    public function kelas_tagihan()
    {
        return $this->belongsTo(Kelas::class, 'kelas', 'id');  // Pastikan 'kelas' adalah foreign key yang benar
    }

    // Di model Tagihan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Gantilah dengan nama kolom yang benar, jika perlu
    }

    public function tagihanSiswa()
    {
        return $this->hasMany(TagihanSiswa::class, 'tagihan_id');
    }

}