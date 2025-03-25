@extends('admin.layouts.base')
@section('title', 'Data Kelas')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Kelas</h4>
            <a href="{{ route('data-kelas.create') }}" class="btn btn-success bg-primary">Tambah Kelas</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>KELAS</th>
                            <th>LEVEL</th>
                            <th>WALI KELAS</th>
                            <th>TAGIHAN</th>
                            <th>TAGIHAN KELAS</th>
                            <th>TERAKHIR DI PERBARUI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->kelas }}</td>
                                <td>{{ $k->level }}</td>
                                <td>{{ $k->waliKelas->nama_guru }}</td>

                                <td>{{ $k->jatuh_tempo ? $k->jatuh_tempo->format('Y-m-d') : 'Tidak Ada' }}</td>
                                <td>
                                    <a href="{{ route('data-kelas.tagihan', ['id' => $k->id]) }}"
                                        class="btn btn-primary btn-sm">LIHAT TAGIHAN</a>
                                </td>


                                <td>{{ $k->updated_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('data-kelas.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('data-kelas.destroy', $k->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
