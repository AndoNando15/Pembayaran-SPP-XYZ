<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{

    // Menampilkan form login
    public function create()
    {
        return view('auth.login');
    }

    // Menangani login
    public function store(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Proses login
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Cek role pengguna dan alihkan ke halaman yang sesuai
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard.index');  // Updated route name
            } elseif (Auth::user()->role == 'siswa') {
                return redirect()->route('siswa.tagihan.tagihan');  // Route for siswa dashboard
            }

            // Jika role tidak valid, logout dan arahkan ke halaman login
            Auth::logout();
            return redirect()->route('login')->withErrors(['role' => 'Akses ditolak.']);
        }

        // Jika login gagal
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // Logout
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}