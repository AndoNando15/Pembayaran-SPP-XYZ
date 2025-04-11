@extends('admin.layouts.base')
@section('title', 'Tambah Admin')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Tambah Admin</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('data-admin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Picture -->
                <div class="form-group">
                    <label for="foto_profile">Foto Profile</label>
                    <input type="file" class="form-control" id="foto_profile" name="foto_profile" accept="image/*">
                </div>

                <!-- NUPTK -->
                <div class="form-group">
                    <label for="nuptk">NUPTK</label>
                    <input type="number" class="form-control" id="nuptk" name="nuptk" required>
                </div>

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <!-- Jabatan -->
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                </div>

                <!-- Tanggal Terdaftar -->
                <div class="form-group">
                    <label for="terdaftar">Tanggal Terdaftar</label>
                    <input type="date" class="form-control" id="terdaftar" name="terdaftar" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Tambah Admin</button>
                <a href="{{ route('data-admin.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
