@extends('admin.layouts.base')
@section('title', 'Tambah Siswa')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Tambah Siswa</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('data-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Foto Profile -->
                <div class="form-group">
                    <label for="foto_profile">Foto Profile</label>
                    <input type="file" class="form-control" name="foto_profile" id="foto_profile">
                </div>

                <!-- NISN -->
                <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="number" class="form-control" name="nisn" id="nisn" value="{{ old('nisn') }}"
                        required>
                </div>



                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                        value="{{ old('nama_lengkap') }}" required>
                </div>

                <!-- Jenis Kelamin -->
                <!-- Jenis Kelamin -->
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                        <option value=""> Pilih Jenis Kelamin</option> <!-- Opsi default -->
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                </div>

                <!-- Tempat Lahir -->
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                        value="{{ old('tempat_lahir') }}" required>
                </div>

                <!-- Tanggal Lahir -->
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                        value="{{ old('tanggal_lahir') }}" required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" name="alamat" id="alamat" value="{{ old('alamat') }}"
                        required>
                </div>

                <!-- Kelas -->
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select class="form-control" name="kelas" id="kelas" required>
                        <option value=""> Pilih Kelas</option> <!-- Opsi default -->
                        @foreach ($kelas as $kelasItem)
                            @if ($kelasItem->kelas !== 'SEMUA KELAS')
                                <option value="{{ $kelasItem->level }}"
                                    {{ old('kelas') == $kelasItem->level ? 'selected' : '' }}>
                                    {{ $kelasItem->level }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>



                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}"
                        required>
                </div>

                <!-- No Telepon -->
                <div class="form-group">
                    <label for="no_telepon">No Telepon</label>
                    <input type="number" class="form-control" name="no_telepon" id="no_telepon"
                        value="{{ old('no_telepon') }}" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">Tambah Siswa</button>
                <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
