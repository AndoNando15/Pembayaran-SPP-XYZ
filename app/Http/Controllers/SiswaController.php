<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;  // Correct import of Auth
use App\Models\Tagihan;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TagihanSiswa; // Ensure this line is added at the top
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    // Show the list of all students (users)
    public function index()
    {
        $users = User::where('role', 'siswa')->get();
        $tagihans = TagihanSiswa::all();
        return view('admin.data-siswa.index', compact('users', 'tagihans'));
    }

    // Show the form for creating a new student (user)
    // Show the form for creating a new student (user)
    public function create()
    {
        $kelas = Kelas::all(); // Ambil semua kelas
        return view('admin.data-siswa.create', compact('kelas'));
    }
    // Menampilkan form edit siswa
    public function edit($id)
    {
        // Mengambil data user beserta relasi kelas
        $user = User::findOrFail($id);
        // Mengambil semua kelas
        $kelas = Kelas::all();

        // Mengirim data ke view
        return view('admin.data-siswa.edit', compact('user', 'kelas'));
    }

    // Store a newly created student (user)
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'foto_profile' => 'nullable|image|mimes:jpg,png,jpeg',
            'nisn' => 'required|numeric|unique:users,nisn,',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,',
            'no_telepon' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);



        // Handle foto profile upload
        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('public/foto_profile_siswa');
            $validated['foto_profile'] = basename($path);
        }

        // Menyimpan data pengguna
        User::create([


            'password' => Hash::make($validated['password']),
            'role' => 'siswa', // Role Siswa
            'foto_profile' => $validated['foto_profile'],
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

        ]);

        return redirect()->route('data-siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {

        // dd($request->all());
        // Validasi input
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

        // Mendapatkan user yang akan diupdate
        $user = User::findOrFail($id);

        // Handle foto profile upload
        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('public/foto_profile_siswa');
            $validated['foto_profile'] = basename($path);
        } else {
            // Jika tidak ada foto yang di-upload, tetap gunakan foto lama
            $validated['foto_profile'] = $user->foto_profile;
        }

        // Handle password update if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Update data pengguna
        $user->update([
            'foto_profile' => $validated['foto_profile'], // Foto Profile
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
            'password' => $request->password ? bcrypt($validated['password']) : $user->password, // Password hanya diubah jika diisi
        ]);

        return redirect()->route('data-siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }



    public function destroy($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus user
        $user->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('data-siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function tagihanSiswa($id)
    {

        $pendingTagihan = TagihanSiswa::where('status', 'pending')->get();
        $approvedTagihan = TagihanSiswa::where('status', 'disetujui')->get();

        // Pass data to the view
        $user = Auth::user();
        // Ambil data siswa berdasarkan ID
        $tagihanSiswara = User::findOrFail($id);

        // Get TagihanSiswa records that match the student's nisn_id
        $tagihanSiswas = TagihanSiswa::where('nisn_id', $tagihanSiswara->nisn)->get();

        // Check if the student has any tagihan records
        $hasTagihan = !$tagihanSiswas->isEmpty();  // Boolean flag to indicate if there are tagihan records

        // Ambil tagihan hanya untuk kelas yang sesuai dengan kelas siswa
        $dataTagihan = Tagihan::where('kelas', $tagihanSiswara->kelas)  // Filter tagihan berdasarkan kelas siswa
            ->with('kelas_tagihan')  // Memuat relasi kelas
            ->get();

        // Return the view with filtered data and the flag indicating whether there are tagihan
        return view('admin.data-siswa.show-siswa', compact('tagihanSiswara', 'dataTagihan', 'tagihanSiswas', 'hasTagihan', 'pendingTagihan', 'approvedTagihan', 'user'));
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
        $tagihan->user = $user->id;

        // Menyimpan data ke database
        $tagihan->save();

        // Mengarahkan kembali dengan pesan sukses dan data tagihan yang disimpan
        return back()->with('success', 'Tagihan berhasil disimpan')->with('tagihan', $tagihan);
    }








}