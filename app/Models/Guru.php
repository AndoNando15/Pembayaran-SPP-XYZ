<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Guru extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's plural convention
    protected $table = 'guru';

    // Define which columns are mass assignable
    protected $fillable = [
        'foto_profile',
        'nuptk',
        'nama_guru',
        'email',
        'nomor_telepon',
        'status',
        'tergabung',
        'terakhir_di_perbarui',
        'terdaftar', // Kolom 'terdaftar' harus tetap ada di sini
    ];

    // Define the date fields that should be cast to Carbon instances
    protected $casts = [
        'terdaftar' => 'date', // Pastikan 'terdaftar' di-cast ke objek Carbon
        'tergabung' => 'datetime',
        'terakhir_di_perbarui' => 'datetime',
    ];
}