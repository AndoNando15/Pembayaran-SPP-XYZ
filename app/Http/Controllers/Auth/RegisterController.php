<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        // Validate form input
        $validator = Validator::make($request->all(), [
            'nis' => 'required|numeric',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            // Add more validation as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Store the user data
        $user = User::create([
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'role' => 'siswa', // Default role, adjust based on needs
        ]);

        // Automatically login the user after successful registration
        Auth::login($user);

        return redirect()->route('siswa.dashboard');  // Redirect to the appropriate dashboard
    }
}