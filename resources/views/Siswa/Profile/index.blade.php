@extends('siswa.layouts.base')
@section('title', 'Edit Profile')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Edit Profile</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('siswa.updateProfile', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Picture -->
                <div class="form-group">
                    <label for="foto_profile">Profile Picture</label>
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

                <!-- Full Name -->
                <div class="form-group">
                    <label for="nama_lengkap">Full Name</label>
                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                        value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                </div>

                <!-- Gender -->
                <div class="form-group">
                    <label for="jenis_kelamin">Gender</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                        <option value="Laki-laki"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Male</option>
                        <option value="Perempuan"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Female
                        </option>
                    </select>
                </div>

                <!-- Place of Birth -->
                <div class="form-group">
                    <label for="tempat_lahir">Place of Birth</label>
                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                        value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
                </div>

                <!-- Date of Birth -->
                <div class="form-group">
                    <label for="tanggal_lahir">Date of Birth</label>
                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="alamat">Address</label>
                    <input type="text" class="form-control" name="alamat" id="alamat"
                        value="{{ old('alamat', $user->alamat) }}" required>
                </div>

                <!-- Class -->
                <div class="form-group">
                    <label for="kelas">Class</label>
                    <select class="form-control" name="kelas" id="kelas" required>
                        @foreach ($kelas as $kelasItem)
                            @if ($kelasItem->kelas !== 'SEMUA KELAS')
                                <option value="{{ $kelasItem->level }}"
                                    {{ old('kelas', $user->kelas) == $kelasItem->level ? 'selected' : '' }}>
                                    {{ $kelasItem->level }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ old('email', $user->email) }}" required>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="no_telepon">Phone Number</label>
                    <input type="text" class="form-control" name="no_telepon" id="no_telepon"
                        value="{{ old('no_telepon', $user->no_telepon) }}" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                    <small class="text-muted">Leave empty if you don't want to change the password</small>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('siswa.profile') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
