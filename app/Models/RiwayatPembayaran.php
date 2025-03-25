<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pembayaran';

    protected $fillable = [
        'nisn_id',
        'nama_lengkap_id',
        'tagihan',
        'tanggal',
        'batas_waktu',
        'kelas',
        'nominal',
        'keterangan',
        'terdaftar',
        'bukti_pembayaran',
        'cash',
        'user',
        'pembayaran',
    ];
}