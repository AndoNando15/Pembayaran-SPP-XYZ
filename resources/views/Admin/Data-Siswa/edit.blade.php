@extends('admin.layouts.base')
@section('title', 'Edit Siswa')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Edit Siswa</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('data-siswa.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Foto Profile -->
                <div class="form-group">
                    <label for="foto_profile">Foto Profile</label>
                    <input type="file" class="form-control" name="foto_profile" id="foto_profile">
                    @if ($user->foto_profile)
                        <img src="{{ asset('storage/foto_profile_siswa/' . $user->foto_profile) }}" alt="Profile Picture"
                            width="100" class="mt-2">
                    @endif
                </div>

                <!-- NISN -->
                <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="text" class="form-control" name="nisn" id="nisn"
                        value="{{ old('nisn', $user->nisn) }}" required>
                </div>

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                        value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                        <option value="Laki-laki"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="Perempuan"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                </div>

                <!-- Tempat Lahir -->
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                        value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
                </div>

                <!-- Tanggal Lahir -->
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" name="alamat" id="alamat"
                        value="{{ old('alamat', $user->alamat) }}" required>
                </div>

                <!-- Kelas -->
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select class="form-control" name="kelas" id="kelas" required>
                        @foreach ($kelas as $kelasItem)
                            <option value="{{ $kelasItem->level }}"
                                {{ old('kelas', $user->kelas) == $kelasItem->level ? 'selected' : '' }}>
                                {{ $kelasItem->level }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ old('email', $user->email) }}" required>
                </div>

                <!-- No Telepon -->
                <div class="form-group">
                    <label for="no_telepon">No Telepon</label>
                    <input type="text" class="form-control" name="no_telepon" id="no_telepon"
                        value="{{ old('no_telepon', $user->no_telepon) }}" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
