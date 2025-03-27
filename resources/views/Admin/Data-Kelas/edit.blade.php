@extends('admin.layouts.base')
@section('title', 'Edit Kelas')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Edit Kelas</h4>

        </div>

        <div class="card-body">
            <form action="{{ route('data-kelas.update', $kelas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Kelas -->
                <div class="form-group">
                    <label for="kelas">Nama Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="kelas"
                        value="{{ old('kelas', $kelas->kelas) }}" required>
                    @error('kelas')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Level Kelas -->
                <div class="form-group">
                    <label for="level">Level</label>
                    <input type="text" class="form-control" id="level" name="level"
                        value="{{ old('level', $kelas->level) }}" required>
                    @error('level')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Wali Kelas (Dropdown from teachers) -->
                <div class="form-group">
                    <label for="wali_kelas">Wali Kelas</label>
                    <select class="form-control" id="wali_kelas" name="wali_kelas" required>
                        <option value="">Pilih Wali Kelas</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}"
                                {{ old('wali_kelas', $kelas->wali_kelas) == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                    @error('wali_kelas')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update Kelas</button>
                <a href="{{ route('data-kelas.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
