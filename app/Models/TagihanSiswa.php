<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanSiswa extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow Laravel's default naming convention
    protected $table = 'tagihan_siswa';

    // Define the fillable fields (those that can be mass-assigned)
    protected $fillable = [
        'user',                  // Name of the user (Admin)
        'nisn_id',               // NISN of the student
        'nama_lengkap_id',       // Full name of the student
        'tagihan',               // The type of bill
        'tanggal',               // Date of the bill
        'batas_waktu',           // Due date for the bill
        'kelas',                 // Class of the student
        'nominal',               // Amount to be paid
        'keterangan',            // Description or remarks
        'terdaftar',             // Registered date
        'pembayaran',            // Payment method
        'bukti_pembayaran',      // Proof of payment (if any)
        'cash',                  // Cash payment amount
        'status',                  // Cash payment amount
    ];

    // You can define relationships if needed. For example, this model might have a relationship with the Tagihan model:
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'nisn_id', 'nisn');  // Match 'nisn_id' to 'nisn' in User model
    }

    // In the TagihanSiswa model
    public function users()
    {
        return $this->belongsTo(User::class, 'user', 'id');  // Match 'user' to 'id' in User model
    }

}