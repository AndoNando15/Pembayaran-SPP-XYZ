@extends('admin.layouts.base')
@section('title', 'Edit Guru')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Edit Data Guru ( WALI KELAS )</h4>

        </div>

        <div class="card-body">
            <form action="{{ route('data-guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Use PUT method for updating -->

                <!-- Foto Profile -->
                <div class="form-group">
                    <label for="foto_profile">Foto Profile</label>
                    <input type="file" class="form-control" id="foto_profile" name="foto_profile" accept="image/*">
                    @if ($guru->foto_profile)
                        <div class="mt-2">
                            <img src="{{ Storage::url($guru->foto_profile) }}" alt="Foto Profile" width="100"
                                height="auto">
                        </div>
                    @endif
                </div>

                <!-- NUPTK -->
                <div class="form-group">
                    <label for="nuptk">NUPTK</label>
                    <input type="number" class="form-control" id="nuptk" name="nuptk"
                        value="{{ old('nuptk', $guru->nuptk) }}" required>
                </div>

                <!-- Nama Guru -->
                <div class="form-group">
                    <label for="nama_guru">Nama Guru</label>
                    <input type="text" class="form-control" id="nama_guru" name="nama_guru"
                        value="{{ old('nama_guru', $guru->nama_guru) }}" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', $guru->email) }}" required>
                </div>

                <!-- Nomor Telepon -->
                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="number" class="form-control" id="nomor_telepon" name="nomor_telepon"
                        value="{{ old('nomor_telepon', $guru->nomor_telepon) }}" required>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Aktif" {{ $guru->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $guru->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                </div>

                <!-- Tanggal Terdaftar -->
                <div class="form-group">
                    <label for="terdaftar">Tanggal Terdaftar</label>
                    <input type="date" class="form-control" id="terdaftar" name="terdaftar"
                        value="{{ old('terdaftar', $guru->terdaftar ? $guru->terdaftar->toDateString() : \Carbon\Carbon::now()->toDateString()) }}"
                        required>

                </div>



                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update Guru</button>
                <a href="{{ route('data-guru.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
