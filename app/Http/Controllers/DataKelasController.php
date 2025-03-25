<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;  // Correct import of Auth

use App\Models\Guru;
use App\Models\Tagihan;
use App\Models\TagihanSiswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;

class DataKelasController extends Controller
{
    // Display the list of classes
    public function index()
    {
        // Ambil semua kelas dan hitung jumlah tagihan terkait
        $kelas = Kelas::withCount('tagihan')->get();  // Menghitung jumlah tagihan terkait dengan kelas



        return view('admin.data-kelas.index', compact('kelas'));
    }


    // Show the form to create a new class
    public function create()
    {
        $gurus = Guru::all();  // Retrieve all teachers
        return view('admin.data-kelas.create', compact('gurus'));  // Pass gurus data to the view
    }

    // Show tagihan (fees) for a class
    public function showTagihanSiswa($id)
    {
        // Find the class based on ID
        $kelas = Kelas::findOrFail($id);

        // Get all students in the same class level as the selected class
        $siswa = User::where('kelas', $kelas->level)->get();

        return view('admin.data-kelas.show-tagihan', compact('kelas', 'siswa'));
    }

    // Store a newly created class in the database
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'kelas' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'wali_kelas' => 'required|exists:guru,id',  // Make sure the teacher exists
        ]);

        // Store the new class data
        Kelas::create([
            'kelas' => $request->kelas,
            'level' => $request->level,
            'wali_kelas' => $request->wali_kelas,
        ]);

        return redirect()->route('data-kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    // Show the form to edit a class
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $gurus = Guru::all();  // Retrieve all teachers to populate the dropdown
        return view('admin.data-kelas.edit', compact('kelas', 'gurus'));  // Pass $gurus to the view
    }

    // Update a class
    public function update(Request $request, $id)
    {
        // Validate incoming data
        $request->validate([
            'kelas' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'wali_kelas' => 'required|exists:gurus,id',  // Ensure the selected teacher exists in the `gurus` table
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'kelas' => $request->kelas,
            'level' => $request->level,
            'wali_kelas' => $request->wali_kelas,  // Store the selected teacher's ID
        ]);

        return redirect()->route('data-kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    // Delete a class
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('data-kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function tagihanSiswa($id)
    {
        $user = Auth::user();  // Get the logged-in user

        // Get the student's data
        $tagihanSiswara = User::findOrFail($id);

        // Filter pending and approved tagihan based on the student's NISN
        $pendingTagihan = TagihanSiswa::where('status', 'pending')
            ->where('nisn_id', $tagihanSiswara->nisn)  // Filter by NISN
            ->get();

        $approvedTagihan = TagihanSiswa::where('status', 'disetujui')
            ->where('nisn_id', $tagihanSiswara->nisn)  // Filter by NISN
            ->get();

        // Get tagihan records that match the student's NISN
        $tagihanSiswas = TagihanSiswa::where('nisn_id', $tagihanSiswara->nisn)->get();

        // If the student has no tagihan records
        $hasTagihan = !$tagihanSiswas->isEmpty();

        // Fetch dataTagihan based on the student's class
        $dataTagihan = Tagihan::where('kelas', $tagihanSiswara->kelas)
            ->with('kelas_tagihan')
            ->get();

        // Pass the filtered data to the view
        return view('admin.data-siswa.show-siswa', compact(
            'tagihanSiswara',
            'dataTagihan',
            'tagihanSiswas',
            'hasTagihan',
            'pendingTagihan',
            'approvedTagihan',
            'user'
        ));
    }



    public function approve(Request $request)
    {
        // Get the logged-in user directly using Auth::user()
        $user = Auth::user();

        // Find the tagihan by ID
        $tagihan = TagihanSiswa::findOrFail($request->tagihan_id);

        // Update the tagihan status to 'disetujui'
        $tagihan->status = 'disetujui';

        // Update the user field to the currently logged-in user
        $tagihan->user = $user->id;  // Updated to store the logged-in user's ID in the 'user' column

        // Save the changes
        $tagihan->save();

        // Redirect with success message
        return back()->with('success', 'Tagihan has been approved successfully!');
    }










}