<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKelas = Kelas::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalTagihan = Tagihan::where('status', '1')->count();
        $totalTagihanSiswa = User::where('role', 'siswa')
            ->whereNotNull('jatuh_tempo') // Hanya hitung jika jatuh_tempo tidak null
            ->count();
        // Hitung total tagihan siswa dari tabel tagihan

        return view('admin.dashboard.index', compact('totalKelas', 'totalSiswa', 'totalTagihanSiswa', 'totalTagihan'));
    }
}