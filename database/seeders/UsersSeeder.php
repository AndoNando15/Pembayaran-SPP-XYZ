<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'foto_profile' => 'admin.png',
            'nisn' => 1234567890,
            'nuptk' => 1234567890,
            'jabatan' => 'Admin',
            'nama_lengkap' => 'Admin School',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'alamat' => 'Jl. Admin No. 1, Jakarta',
            'kelas' => 'Admin',
            'email' => 'admin@school.com',
            'no_telepon' => '08123456789',
            'terdaftar' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin', // Role Admin
        ]);

        // Siswa
        User::create([
            'foto_profile' => 'siswa.png',
            'nisn' => 9876543210,
            'nuptk' => 9876543210,
            'jabatan' => 'Siswa',
            'nama_lengkap' => 'Siswa A',
            'jenis_kelamin' => 'Perempuan',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-05-10',
            'alamat' => 'Jl. Siswa No. 2, Bandung',
            'kelas' => 'XII IPA 1',
            'email' => 'siswa@school.com',
            'no_telepon' => '08234567890',
            'terdaftar' => now(),
            'password' => Hash::make('siswa123'),
            'role' => 'siswa', // Role Siswa
        ]);
    }
}