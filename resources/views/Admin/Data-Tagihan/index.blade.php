@extends('admin.layouts.base')
@section('title', 'Data Tagihan')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Tagihan</h4>
            <a href="{{ route('data-tagihan.create') }}" class="btn btn-success bg-primary">Tambah Tagihan</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>TAGIHAN</th>
                            <th>TANGGAL</th>
                            <th>BATAS WAKTU</th>
                            <th>KELAS</th>
                            <th>NOMINAL</th>
                            <th>STATUS</th>
                            <th>KETERANGAN</th>
                            <th>TERDAFTAR</th>
                            <th>TERAKHIR DI EDIT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tagihans as $key => $tagihan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $tagihan->tagihan }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->batas_waktu)->format('Y-m-d') }}</td>
                                <td>{{ $tagihan->kelas ?? 'Tidak ada kelas' }}</td>
                                <!-- Assuming kelas is a relationship -->
                                <td>Rp. {{ number_format($tagihan->nominal, 2) }}</td>

                                <td>{{ $tagihan->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                                <td>{{ $tagihan->keterangan }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->terdaftar)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->updated_at)->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('data-tagihan.edit', $tagihan->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('data-tagihan.destroy', $tagihan->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
