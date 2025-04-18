@extends('admin.layouts.base')
@section('title', 'Data Pembayaran')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Pembayaran</h4>
        </div>

        <div class="card-body">
            <!-- Form Pencarian -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Form Pencarian Siswa -->
                <div class="form-group mb-0 w-75">
                    <label for="siswa" class="font-weight-bold">Cari Siswa</label>
                    <form action="{{ route('data-kelas.tagihanSiswa', ['id' => ':id']) }}" method="GET" id="searchForm">
                        <select class="form-control" id="siswa" name="siswa" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Tombol-tombol: RESET dan SEARCH -->
                <div class="form-group mb-0">
                    <!-- Tombol RESET -->
                    <button type="button" class="btn btn-secondary mb-2"
                        onclick="window.location.href='{{ route('data-kelas.index') }}'">RESET</button>

                    <!-- Tombol SEARCH -->
                    <button type="submit" form="searchForm" class="btn btn-primary mb-2 ml-2">Search</button>
                </div>
            </div>




            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Tagihan</th>
                            <th>Tanggal</th>
                            <th>Batas Waktu</th>
                            <th>Kelas</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach ($tagihanSiswa as $key => $tagihan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $tagihan->user ? $tagihan->user->nama_lengkap : 'No User' }}</td>
                                <!-- Check if 'user' exists -->
                                <td>{{ $tagihan->tagihan }}</td>
                                <td>{{ $tagihan->tanggal }}</td>
                                <td>{{ $tagihan->batas_waktu }}</td>
                                <td>{{ $tagihan->kelas }}</td>
                                <td>{{ $tagihan->nominal }}</td>
                                <td>{{ $tagihan->keterangan }}</td>

                                <td>{{ \Carbon\Carbon::parse($tagihan->terdaftar)->format('d-m-Y') }}</td>

                            </tr>
                        @endforeach
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('siswa').addEventListener('change', function() {
            var siswaId = this.value;
            var form = document.querySelector('form');
            var baseUrl = '{{ route('data-kelas.tagihanSiswa', ':id') }}'; // URL dasar dengan placeholder :id
            if (siswaId) {
                form.action = baseUrl.replace(':id', siswaId); // Gantikan :id dengan ID siswa yang dipilih
            }
        });
    </script>

@endsection
