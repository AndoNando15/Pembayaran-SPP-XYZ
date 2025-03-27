@extends('admin.layouts.base')
@section('title', 'Tagihan Kelas')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Kelas: {{ $kelas->kelas }} - Level: {{ $kelas->level }}</h4>
            <h4 class="m-0 font-weight-bold text-primary">Wali Kelas: {{ $kelas->waliKelas->nama_guru }}</h4>
            <a href="{{ route('data-kelas.index') }}" class="btn btn-success bg-primary">Kembali</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>NO</th>
                            <th>NISN</th>
                            <th>NAMA SISWA</th>
                            {{-- <th>TAGIHAN</th> --}}
                            <th>TAGIHAN SISWA</th>
                            {{-- <th>TERAKHIR DI PERBARUI</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $s)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nisn }}</td>
                                <td>{{ $s->nama_lengkap }}</td>
                                {{-- <td>{{ $s->jatuh_tempo }}</td> --}}
                                <td>
                                    <a href="{{ route('data-kelas.tagihanSiswa', $s->id) }}"
                                        class="btn btn-warning btn-sm">Lihat
                                        Tagihan</a>
                                </td>


                                {{-- <td>{{ $s->updated_at->format('Y-m-d H:i:s') }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
