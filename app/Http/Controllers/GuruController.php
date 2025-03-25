<?php
namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    // Display the list of teachers
    public function index()
    {
        $gurus = Guru::all();
        return view('admin.data-guru.index', compact('gurus'));
    }

    // Show the form to create a new teacher
    public function create()
    {
        return view('admin.data-guru.create');
    }

    // Store a newly created teacher in the database
    public function store(Request $request)
    {
        $request->validate([
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nuptk' => 'required|numeric|unique:guru,nuptk',
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:guru,email',
            'nomor_telepon' => 'required|string|max:15',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'terdaftar' => 'required|date',
        ]);

        $fotoProfilePath = null;
        if ($request->hasFile('foto_profile')) {
            $fotoProfilePath = $request->file('foto_profile')->store('public/foto_profiles');
        }

        Guru::create([
            'foto_profile' => $fotoProfilePath,
            'nuptk' => $request->nuptk,
            'nama_guru' => $request->nama_guru,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'status' => $request->status,
            'terdaftar' => $request->terdaftar,
            'created_at' => now(),
            'updated_at' => now(),
            'tergabung' => now(),
        ]);

        return redirect()->route('data-guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    // Show the form to edit a teacher's data
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('admin.data-guru.edit', compact('guru'));
    }

    // Update a teacher's data in the database
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nuptk' => 'required|numeric|unique:guru,nuptk,' . $guru->id,
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:guru,email,' . $guru->id,
            'nomor_telepon' => 'required|string|max:15',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'terdaftar' => 'required|date',
        ]);

        // Handle file upload for profile picture (if updated)
        if ($request->hasFile('foto_profile')) {
            // Delete the old profile image if it exists
            if ($guru->foto_profile && \Storage::exists($guru->foto_profile)) {
                \Storage::delete($guru->foto_profile);
            }
            $fotoProfilePath = $request->file('foto_profile')->store('public/foto_profiles');
            $guru->foto_profile = $fotoProfilePath;
        }

        // Update teacher data
        $guru->update([
            'nuptk' => $request->nuptk,
            'nama_guru' => $request->nama_guru,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'status' => $request->status,
            'terdaftar' => $request->terdaftar,
            'updated_at' => now(),
        ]);

        return redirect()->route('data-guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    // Delete a teacher from the database
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        // Delete the profile picture if it exists
        if ($guru->foto_profile && \Storage::exists($guru->foto_profile)) {
            \Storage::delete($guru->foto_profile);
        }
        $guru->delete();

        return redirect()->route('data-guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}