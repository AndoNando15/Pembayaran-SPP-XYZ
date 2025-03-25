<?php
namespace App\Http\Controllers\Siswa;
use Illuminate\Support\Facades\Auth;  // Correct import of Auth
use App\Models\Tagihan;
use App\Models\User;
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

        // dd($request->all()); // This will display all the data received from the form
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Validasi data form
        $request->validate([
            'nisn_id' => 'required',
            'nama_lengkap_id' => 'required',
            'tagihan' => 'required',
            'tanggal' => 'required|date',
            'batas_waktu' => 'required|date',
            'kelas' => 'required',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'terdaftar' => 'required|date',
            'cash' => 'required|string',
            'status' => 'required|string',
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // Validate the uploaded file
        ]);

        // Memformat tanggal ke format yang sesuai dengan MySQL (YYYY-MM-DD)
        $tanggal = Carbon::createFromFormat('d F Y', $request->tanggal)->format('Y-m-d');
        $batas_waktu = Carbon::createFromFormat('d F Y', $request->batas_waktu)->format('Y-m-d');
        $terdaftar = Carbon::createFromFormat('d F Y', $request->terdaftar)->format('Y-m-d');

        // Menyimpan bukti pembayaran jika ada
        $bukti_pembayaran_path = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            // Menyimpan file ke folder 'public/bukti_pembayaran' dan mendapatkan path-nya
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
        $tagihan->nominal = $request->nominal;
        $tagihan->keterangan = $request->keterangan;
        $tagihan->terdaftar = $terdaftar;
        $tagihan->pembayaran = $request->pembayaran;
        $tagihan->bukti_pembayaran = $bukti_pembayaran_path; // Path file
        $tagihan->cash = $request->cash;
        $tagihan->status = $request->status;
        $tagihan->user = $user->nama_lengkap;

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

}