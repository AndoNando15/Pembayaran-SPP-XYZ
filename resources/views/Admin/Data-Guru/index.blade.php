@extends('admin.layouts.base')
@section('title', 'Data Guru')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Guru</h4>
            <a href="{{ route('data-guru.create') }}" class="btn btn-success bg-primary">Tambah Guru</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>PROFILE</th> <!-- Added Profile Picture column here -->
                            <th>NUPTK</th>
                            <th>NAMA GURU</th>
                            <th>EMAIL</th>
                            <th>NO TELEPON</th>
                            <th>STATUS</th>
                            <th>TERGABUNG</th>
                            <th>TERAKHIR DI PERBARUI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gurus as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <!-- Display the profile picture if available -->
                                    @if ($guru->foto_profile)
                                        <img src="{{ Storage::url($guru->foto_profile) }}" alt="Foto Profile" width="100"
                                            height="auto">
                                    @else
                                        <span>No Photo</span>
                                    @endif
                                </td>
                                <td>{{ $guru->nuptk }}</td>
                                <td>{{ $guru->nama_guru }}</td>
                                <td>{{ $guru->email }}</td>
                                <td>{{ $guru->nomor_telepon }}</td>
                                <td>{{ $guru->status }}</td>
                                <td>{{ $guru->tergabung }}</td>
                                <td>{{ $guru->updated_at }}</td>
                                <td>
                                    <a href="{{ route('data-guru.edit', $guru->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('data-guru.destroy', $guru->id) }}" method="POST"
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
