@extends('admin.layouts.base')
@section('title', 'Tambah Tagihan')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Tambah Tagihan</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('data-tagihan.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="tagihan">Tagihan</label>
                    <select class="form-control" name="tagihan" id="tagihan" required>
                        <option value="">Pilih Bulan</option>
                        <option value="Januari" {{ old('tagihan') == 'Januari' ? 'selected' : '' }}>Januari</option>
                        <option value="Februari" {{ old('tagihan') == 'Februari' ? 'selected' : '' }}>Februari</option>
                        <option value="Maret" {{ old('tagihan') == 'Maret' ? 'selected' : '' }}>Maret</option>
                        <option value="April" {{ old('tagihan') == 'April' ? 'selected' : '' }}>April</option>
                        <option value="Mei" {{ old('tagihan') == 'Mei' ? 'selected' : '' }}>Mei</option>
                        <option value="Juni" {{ old('tagihan') == 'Juni' ? 'selected' : '' }}>Juni</option>
                        <option value="Juli" {{ old('tagihan') == 'Juli' ? 'selected' : '' }}>Juli</option>
                        <option value="Agustus" {{ old('tagihan') == 'Agustus' ? 'selected' : '' }}>Agustus</option>
                        <option value="September" {{ old('tagihan') == 'September' ? 'selected' : '' }}>September</option>
                        <option value="Oktober" {{ old('tagihan') == 'Oktober' ? 'selected' : '' }}>Oktober</option>
                        <option value="November" {{ old('tagihan') == 'November' ? 'selected' : '' }}>November</option>
                        <option value="Desember" {{ old('tagihan') == 'Desember' ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="batas_waktu">Batas Waktu</label>
                    <input type="date" class="form-control" name="batas_waktu" id="batas_waktu"
                        value="{{ old('batas_waktu') }}" required>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select class="form-control" name="kelas" id="kelas" required>
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->level }}" {{ old('kelas') == $k->id ? 'selected' : '' }}>
                                {{ $k->level }} <!-- Menampilkan kolom 'level' -->
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="nominal">Nominal</label>
                    <input type="number" class="form-control" name="nominal" id="nominal" value="{{ old('nominal') }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Tambah Tagihan</button>
            </form>
        </div>
    </div>

@endsection
