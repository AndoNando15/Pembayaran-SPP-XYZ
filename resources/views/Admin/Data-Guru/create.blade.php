@extends('admin.layouts.base')
@section('title', 'Tambah Guru')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Tambah Guru</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('data-guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Foto Profile -->
                <div class="form-group">
                    <label for="foto_profile">Foto Profile</label>
                    <input type="file" class="form-control" id="foto_profile" name="foto_profile" accept="image/*">
                </div>

                <!-- NUPTK -->
                <div class="form-group">
                    <label for="nuptk">NUPTK</label>
                    <input type="text" class="form-control" id="nuptk" name="nuptk" required>
                </div>

                <!-- Nama Guru -->
                <div class="form-group">
                    <label for="nama_guru">Nama Guru</label>
                    <input type="text" class="form-control" id="nama_guru" name="nama_guru" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <!-- Nomor Telepon -->
                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="terdaftar">Tanggal Terdaftar</label>
                    <input type="date" class="form-control" id="terdaftar" name="terdaftar" required>
                    @error('terdaftar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Tambah Guru</button>
                <a href="{{ route('data-guru.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
