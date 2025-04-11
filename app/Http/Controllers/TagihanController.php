<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;  // Assuming Tagihan model exists
use App\Models\Kelas;    // Assuming Kelas model exists
use App\Models\TagihanSiswa;
use App\Models\User;    // Assuming Kelas model exists
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    // Display the list of tagihans
    public function index()
    {
        $tagihans = Tagihan::all(); // Eager load 'kelas' to avoid N+1 query problem
        return view('admin.data-tagihan.index', compact('tagihans'));
    }

    // Show the form to create a new tagihan
    public function create()
    {
        $kelas = Kelas::all();  // Mengambil kelas unik berdasarkan nama kelas

        return view('admin.data-tagihan.create', compact('kelas'));
    }

    // Store a newly created tagihan
    public function store(Request $request)
    {
        $request->validate([
            'tagihan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'batas_waktu' => 'required|date',
            'kelas' => 'required|exists:kelas,level',  // kelas harus valid
            'nominal' => 'required|numeric',
            'status' => 'required|boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Store the tagihan data
        $tagihan = Tagihan::create([
            'tagihan' => $request->tagihan,
            'tanggal' => $request->tanggal,
            'batas_waktu' => $request->batas_waktu,
            'kelas' => $request->kelas,
            'nominal' => $request->nominal,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'terdaftar' => now(),
        ]);

        // If the tagihan is active, update the jatuh_tempo of the users in the same class
        if ($tagihan->status == 1) {  // If the tagihan status is active

            // Check if the kelas is "Semua Kelas"
            if ($tagihan->kelas == 'SEMUA KELAS') {
                // Count how many active tagihans there are for the "Semua Kelas"
                $tagihanCount = Tagihan::where('kelas', 'SEMUA KELAS')
                    ->where('status', 1)  // Only active tagihans
                    ->count();

                // Add 1 to the tagihanCount for the "Semua Kelas" scenario
                $tagihanCount += 1;

                // Increment 'jatuh_tempo' for all users by the updated tagihan count
                User::increment('jatuh_tempo', $tagihanCount);
            } else {
                // Count how many active tagihans there are for the specific class
                $tagihanCount = Tagihan::where('kelas', $tagihan->kelas)
                    ->where('status', 1)  // Only active tagihans
                    ->count();

                // Update jatuh_tempo for users in the same class based on the number of active tagihans
                User::where('kelas', $tagihan->kelas)->increment('jatuh_tempo', $tagihanCount);
            }
        }



        return redirect()->route('data-tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }




    // Show the form to edit an existing tagihan
    public function edit($id)
    {
        // Find the tagihan by ID
        $tagihan = Tagihan::findOrFail($id);

        // Retrieve all classes to show in the dropdown
        $kelas = Kelas::all();  // Mengambil kelas unik berdasarkan nama kelas
        // Return the edit view with the tagihan and kelas data
        return view('admin.data-tagihan.edit', compact('tagihan', 'kelas'));
    }

    // Update the tagihan in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'tagihan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'batas_waktu' => 'required|date',
            'kelas' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'status' => 'required|boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Find the tagihan by ID and update it
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update([
            'tagihan' => $request->tagihan,
            'tanggal' => $request->tanggal,
            'batas_waktu' => $request->batas_waktu,
            'kelas' => $request->kelas,
            'nominal' => $request->nominal,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);
        // If the tagihan is active, update the jatuh_tempo of the users in the same class
        if ($tagihan->status == 1) {  // If the tagihan status is active
            if ($tagihan->kelas == 'Semua Kelas') {  // If tagihan is for all classes
                // Update jatuh_tempo for all users with any value in the 'kelas' column
                User::whereNotNull('kelas')->increment('jatuh_tempo');
            } else {  // If tagihan is for a specific class
                // Update jatuh_tempo for users in the same class
                User::where('kelas', $tagihan->kelas)->increment('jatuh_tempo');
            }
        }
        // Redirect back to the index page with a success message
        return redirect()->route('data-tagihan.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    // Delete an existing tagihan
    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();

        return redirect()->route('data-tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    public function tagihanSiswa($kelas_id, $tagihan_id)
    {
        // Ambil data tagihan berdasarkan ID
        $tagihan = Tagihan::findOrFail($tagihan_id);

        // Anda bisa menambahkan logika lain yang diperlukan, seperti mengirimkan data kelas

        return view('admin.data-kelas.tagihanSiswa', compact('tagihan'));
    }

    public function riwayatPembayaran()
    {
        $tagihanSiswas = TagihanSiswa::with('user')->get();
        return view('admin.data-tagihan.riwayat-pembayaran', compact('tagihanSiswas'));
    }
}