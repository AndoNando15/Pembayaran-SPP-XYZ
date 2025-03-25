@extends('siswa.layouts.base')
@section('title', 'Dashboard')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Halaman Utama</h1>
    <div class="row">

        <!-- Total Tagihan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tagihan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalTagihan }} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Riwayat Pembayaran Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Riwayat Pembayaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalTagihanSiswa }} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
