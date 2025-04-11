<?php
namespace App\Http\Controllers\Siswa;
use Illuminate\Support\Facades\Auth;  // Correct import of Auth
use App\Models\Tagihan;
use App\Models\User;
use App\Models\Kelas;
use App\Http\Controllers\Controller;

use App\Models\TagihanSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;


class SiswasController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user
        $kelasSiswa = $user->kelas; // Get the student's class (kelas)

        // Get the total Tagihan for the class of the logged-in student
        $totalTagihan = Tagihan::where('kelas', $kelasSiswa)->count();  // Count tagihan filtered by class
        $totalTagihanSiswa = TagihanSiswa::where('nisn_id', $user->nisn_id)->count();  // Count tagihan for the student

        // Pass the variables to the view
        return view('siswa.dashboard.index', compact('totalTagihan', 'totalTagihanSiswa'));
    }

    public function tagihanSiswa()
    {
        // Ambil data pengguna yang sedang login
        $tagihanSiswara = auth()->user();  // Mengambil pengguna yang sedang login

        // Ambil data TagihanSiswa berdasarkan nisn_id siswa yang sedang login
        $tagihanSiswas = TagihanSiswa::where('nisn_id', $tagihanSiswara->nisn)->get();

        // Cek apakah siswa memiliki tagihan atau tidak
        $hasTagihan = !$tagihanSiswas->isEmpty();  // Boolean flag untuk menandakan ada atau tidaknya tagihan

        // Ambil data tagihan berdasarkan kelas siswa
        $dataTagihan = Tagihan::where('kelas', $tagihanSiswara->kelas)
            ->get();  // Dapatkan data tagihan hanya untuk kelas yang sesuai dengan kelas siswa

        // Kembalikan ke view dengan data yang dibutuhkan
        return view('siswa.tagihan.tagihan', compact('tagihanSiswara', 'dataTagihan', 'tagihanSiswas', 'hasTagihan'));
    }





    public function saveTagihan(Request $request)
    {

        // Memformat tanggal ke format yang sesuai dengan MySQL (YYYY-MM-DD)
        $tanggal = Carbon::createFromFormat('d F Y', $request->tanggal)->format('Y-m-d');
        $batas_waktu = Carbon::createFromFormat('d F Y', $request->batas_waktu)->format('Y-m-d');
        $terdaftar = Carbon::createFromFormat('d F Y', $request->terdaftar)->format('Y-m-d');

        // Menghapus simbol 'Rp.' dan tanda titik pemisah ribuan dari nominal
        $nominal = preg_replace('/[^\d]/', '', $request->nominal); // Hanya angka yang disimpan
        $nominal = (int) $nominal; // Mengonversi ke tipe integer

        // Menyimpan bukti pembayaran jika ada
        $bukti_pembayaran_path = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $bukti_pembayaran_path = $file->store('bukti_pembayaran', 'public');
        }

        // Membuat entri baru di tabel TagihanSiswa
        $tagihan = new TagihanSiswa();
        $tagihan->nisn_id = $request->nisn_id;
        $tagihan->nama_lengkap_id = $request->nama_lengkap_id;
        $tagihan->tagihan = $request->tagihan;
        $tagihan->tanggal = $tanggal;
        $tagihan->batas_waktu = $batas_waktu;
        $tagihan->kelas = $request->kelas;
        $tagihan->nominal = $nominal;  // Simpan nominal dalam bentuk integer
        $tagihan->keterangan = $request->keterangan;
        $tagihan->terdaftar = $terdaftar;
        $tagihan->pembayaran = $request->pembayaran;
        $tagihan->bukti_pembayaran = $bukti_pembayaran_path; // Path file
        $tagihan->cash = $request->cash;
        $tagihan->status = $request->status;
        $tagihan->user = Auth::user()->nama_lengkap;

        // Menyimpan data ke database
        $tagihan->save();

        // Mengarahkan kembali dengan pesan sukses dan data tagihan yang disimpan
        return back()->with('success', 'Tagihan berhasil disimpan')->with('tagihan', $tagihan);
    }



    public function riwayatPembayaran()
    {
        // Mengambil data pengguna yang sedang login
        $tagihanSiswa = auth()->user();  // Mendapatkan pengguna yang sedang login

        // Ambil riwayat tagihan untuk siswa yang sedang login berdasarkan nisn_id
        $tagihanSiswas = TagihanSiswa::where('nisn_id', $tagihanSiswa->nisn)->get();

        // Kembalikan ke view dengan data tagihanSiswas yang sesuai dengan nisn_id siswa yang login
        return view('siswa.tagihan.riwayat-pembayaran', compact('tagihanSiswas'));
    }

    public function updateProfile()
    {
        // Get the logged-in user
        $user = auth()->user();
        $kelas = Kelas::all();
        // Pass the user data to the view
        return view('siswa.profile.index', compact('user', 'kelas'));
    }

    public function update(Request $request, $id)
    {

        // dd($request->all());
        // Validate input
        $validated = $request->validate([
            'foto_profile' => 'nullable|image|mimes:jpg,png,jpeg',
            'nisn' => 'required|numeric|unique:users,nisn,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telepon' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Retrieve the user to be updated
        $user = User::findOrFail($id);

        // Handle profile picture upload
        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('public/foto_profile_siswa');
            $validated['foto_profile'] = basename($path);
        } else {
            // If no file is uploaded, keep the old profile picture
            $validated['foto_profile'] = $user->foto_profile;
        }

        // Update the password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Update the user data
        $user->update([
            'foto_profile' => $validated['foto_profile'], // Profile Picture
            'nisn' => $validated['nisn'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat' => $validated['alamat'],
            'kelas' => $validated['kelas'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'],
            'terdaftar' => now(),
            'password' => $request->password ? bcrypt($validated['password']) : $user->password, // Password only changed if filled
        ]);

        return redirect()->route('siswa.tagihan.tagihan')->with('success', 'Profile successfully updated.');
    }


}