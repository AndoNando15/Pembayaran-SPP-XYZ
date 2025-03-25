@extends('admin.layouts.base')
@section('title', 'Data Siswa')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Siswa</h4>
            <a href="{{ route('data-siswa.create') }}" class="btn btn-success bg-primary">Tambah Siswa</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>PROFILE</th>
                            <th>NISN</th>
                            <th>NAMA LENGKAP</th>
                            <th>JENIS KELAMIN</th>
                            <th>TEMPAT LAHIR</th>
                            <th>TANGGAL LAHIR</th>
                            <th>ALAMAT</th>
                            <th>KELAS</th>
                            <th>EMAIL</th>
                            {{-- <th>PASSWORD</th> --}}
                            <th>NO TELEPON</th>
                            <th>TAGIHAN</th>
                            <th>TERDAFTAR</th>
                            <th>TERAKHIR DI EDIT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <!-- Changed from $siswa to $users -->
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ asset('storage/foto_profile_siswa/' . $user->foto_profile) }}"
                                        alt="Profile" width="100">
                                </td>
                                <td>{{ $user->nisn }}</td>
                                <td>{{ $user->nama_lengkap }}</td>
                                <td>{{ $user->jenis_kelamin }}</td>
                                <td>{{ $user->tempat_lahir }}</td>
                                <td>{{ $user->tanggal_lahir }}</td>
                                <td>{{ $user->alamat }}</td>
                                <td>{{ $user->kelas }}</td>

                                <!-- Show class name and level -->
                                <td>{{ $user->email }}</td>
                                {{-- <td>{{ $user->password }}</td> --}}
                                <td>{{ $user->no_telepon }}</td>
                                <td>{{ $user->jatuh_tempo }}</td>
                                <td>{{ $user->terdaftar }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    <a href="{{ route('data-siswa.edit', $user->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('data-siswa.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
