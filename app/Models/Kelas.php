<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    // Define the table name (optional)
    protected $table = 'kelas';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'kelas',
        'level',
        'wali_kelas', // Store the teacher's ID

    ];

    // Define the relationship with the Guru model
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas'); // 'wali_kelas' is the foreign key
    }

    public function users()
    {
        return $this->hasMany(User::class);  // Relasi satu kelas memiliki banyak user
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'kelas');  // Pastikan 'kelas' adalah foreign key yang tepat
    }

}