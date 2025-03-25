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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>TAGIHAN</th>
                            <th>SISWA</th>
                            <th>NISN</th>
                            <th>NOMINAL</th>
                            <th>USER</th>
                            <th>BUKTI PEMBAYARAN</th>
                            <th>TERDAFTAR</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($pembayarans as $key => $pembayaran)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $pembayaran->tagihan }}</td>
                                <td>{{ $pembayaran->siswa->name }}</td>
                                <td>{{ $pembayaran->siswa->nisn }}</td>
                                <td>Rp. {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                                <td>{{ $pembayaran->user->name }}</td>
                                <td>{{ $pembayaran->bukti_pembayaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($pembayaran->terdaftar)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning">PRINT</a>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
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
