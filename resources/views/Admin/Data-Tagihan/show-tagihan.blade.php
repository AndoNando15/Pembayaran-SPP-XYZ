@extends('admin.layouts.base')
@section('title', 'Detail Tagihan')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Detail Tagihan</h4>
        </div>

        <div class="card-body">
            <!-- Tagihan Details -->
            <div class="form-group">
                <label for="tagihan">Tagihan</label>
                <p>ID Tagihan: {{ $tagihan->id }}</p>
                <p>Tagihan: {{ $tagihan->tagihan }}</p>
                <p>Tanggal: {{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d F Y') }}</p>
                <p>Batas Waktu: {{ \Carbon\Carbon::parse($tagihan->batas_waktu)->format('d F Y') }}</p>
                <p>Kelas: {{ $tagihan->kelas_tagihan->kelas ?? 'N/A' }}</p>
                <p>Nominal: Rp. {{ number_format($tagihan->nominal, 0, ',', '.') }}</p>
                <p>Keterangan: {{ $tagihan->keterangan }}</p>
                <p>Terdaftar pada: {{ \Carbon\Carbon::parse($tagihan->terdaftar)->format('d F Y') }}</p>
            </div>

            <!-- Button to go back to previous page -->
            <a href="{{ route('data-tagihan.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

@endsection
