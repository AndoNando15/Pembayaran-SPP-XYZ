<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Menampilkan daftar admin
    public function index()
    {
        // Retrieve only users with the role 'admin'
        $users = User::where('role', 'admin')->get();
        return view('admin.data-admin.index', compact('users'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.data-admin.edit', compact('user'));
    }
    public function create()
    {
        return view('admin.data-admin.create'); // Simply return the create view without needing an ID
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data-admin.index')->with('success', 'Admin deleted successfully.');
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate form data
        $request->validate([
            'nuptk' => 'required|string',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email',
            'jabatan' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image upload
        ]);

        // Handle profile photo upload if exists
        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('foto_profile', 'public');
            $user->foto_profile = $path;
        }

        // Handle password update if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Update other fields
        $user->nuptk = $request->nuptk;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;

        $user->save();

        return redirect()->route('data-admin.index')->with('success', 'Admin updated successfully');
    }

    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validate file upload (optional)
            'nuptk' => 'required|numeric', // Validate NUPTK
            'nama_lengkap' => 'required|string|max:255', // Validate nama lengkap
            'email' => 'required|email|unique:users,email', // Validate email, should be unique
            'jabatan' => 'required|string|max:255', // Validate jabatan
            'terdaftar' => 'required|date', // Validate date of registration
            'password' => 'required|string|min:8|confirmed', // Validate password with confirmation
        ]);

        // Handle file upload for profile picture (same directory as the update method)
        $fotoProfilePath = null;
        if ($request->hasFile('foto_profile')) {
            // Store the uploaded image in 'public/foto_profile'
            $fotoProfilePath = $request->file('foto_profile')->store('public/foto_profile');
        }

        // Create a new admin user
        $user = User::create([
            'foto_profile' => $fotoProfilePath, // Save the file path (if any)
            'nuptk' => $request->nuptk,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'terdaftar' => $request->terdaftar,
            'password' => bcrypt($request->password), // Hash the password
            'role' => 'admin', // Automatically set role to 'admin'
        ]);

        // Redirect back with a success message
        return redirect()->route('data-admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }






}