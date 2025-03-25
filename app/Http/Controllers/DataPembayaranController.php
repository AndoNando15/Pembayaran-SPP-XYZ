<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DataPembayaranController extends Controller
{
    public function index()
    {

        // Ambil daftar user dengan role 'siswa' untuk dropdown siswa
        $siswas = User::where('role', 'siswa')->get(); // Filter hanya yang memiliki role 'siswa'
        return view('admin.data-pembayaran.index', compact('siswas'));
    }

}