@extends('admin.layouts.base')
@section('title', 'Dashboard')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Halaman Utama</h1>
    <div class="row">

        <!-- Total Kelas Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Kelas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKelas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-success"></i> <!-- Updated Icon -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Siswa Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Siswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalSiswa }} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i> <!-- Updated Icon -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <i class="fas fa-credit-card fa-2x text-primary"></i> <!-- Updated Icon -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Siswa Belum Lunas Tagihan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Siswa Belum Lunas Tagihan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalTagihanSiswa }} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-warning"></i> <!-- Updated Icon -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
