@extends('admin.layouts.base')
@section('title', 'Data Admin')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Data Admin</h4>
            <a href="{{ route('data-admin.create') }}" class="btn btn-success bg-primary">Tambah Admin</a>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>PROFILE</th>
                            <th>NUPTK</th>
                            <th>NAMA LENGKAP</th>
                            <th>EMAIL</th>
                            <th>JABATAN</th>
                            <th>TERDAFTAR</th>
                            <th>TERAKHIR DI PERBARUI</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td> <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Profile Photo"
                                        width="100"></td>

                                <td>{{ $user->nuptk }}</td>
                                <td>{{ $user->nama_lengkap }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->jabatan }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->terdaftar)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('data-admin.edit', $user->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('data-admin.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
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
