<?php

namespace App\Http\Controllers;

use App\Models\TagihanSiswa;
use App\Models\User;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    public function index()
    {

        $tagSiswa = User::all();

        return view('admin.data-siswa.show-siswa', compact('tagSiswa'));
    }
}