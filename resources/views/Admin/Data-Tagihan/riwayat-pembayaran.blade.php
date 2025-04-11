@extends('admin.layouts.base')
@section('title', 'Riwayat Pembayaran')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Riwayat Pembayaran</h4>
        </div>

        <div class="card-body">
            <!-- Pencarian Otomatis Nama Lengkap -->
            <div class="mb-3">
                <input type="text" id="searchName" class="form-control" placeholder="Cari Nama Lengkap..."
                    style="width: 300px;">
            </div>

            <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">
                <table class="table table-bordered table-striped table-hover" id="paymentTable" width="100%"
                    cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>Tagihan</th>
                            <th>Tanggal</th>
                            <th>Batas Waktu</th>
                            <th>Kelas</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Terdaftar</th>
                            <th>Pembayaran</th>
                            <th>Bukti Pembayaran</th>
                            <th>Cash</th>
                            <th>Created At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihanSiswas as $tagihan)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tagihan->users ? $tagihan->users->nama_lengkap : 'No user' }}</td>
                                <td>{{ $tagihan->nisn_id }}</td>
                                <td>{{ $tagihan->nama_lengkap_id }}</td>
                                <td>{{ $tagihan->tagihan }}</td>
                                <td>{{ $tagihan->tanggal }}</td>
                                <td>{{ $tagihan->batas_waktu }}</td>
                                <td>{{ $tagihan->kelas }}</td>
                                <td>Rp. {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                                <td>{{ $tagihan->keterangan }}</td>
                                <td>{{ $tagihan->terdaftar }}</td>
                                <td>{{ $tagihan->pembayaran }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="showBukti('{{ asset('storage/' . $tagihan->bukti_pembayaran) }}')">
                                        Lihat Bukti
                                    </button>
                                </td>
                                <td>{{ $tagihan->cash }}</td>
                                <td>{{ $tagihan->created_at }}</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Print</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="text-center">No payment records found for this student.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for displaying proof of payment -->
    <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-top">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktiModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="buktiImage" src="" class="img-fluid" alt="Bukti Pembayaran">
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Script untuk modal dan search -->
    <script>
        function showBukti(imageUrl) {
            document.getElementById('buktiImage').src = imageUrl;
            $('#buktiModal').modal('show');
        }

        $(document).ready(function() {
            var table = $('#paymentTable').DataTable();

            $('#searchName').on('keyup change', function() {
                table.column(3).search(this.value).draw();
            });

            $('#buktiModal').on('hidden.bs.modal', function() {
                document.getElementById('buktiImage').src = '';
            });
        });
    </script>

@endsection

<!-- Add CSS for table styling -->
<style>
    #paymentTable th,
    #paymentTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    #paymentTable th {
        text-align: center;
    }

    #paymentTable td {
        vertical-align: middle;
    }

    .table-responsive {
        overflow-x: auto;
    }

    /* Menyesuaikan lebar kolom */
    #paymentTable th:nth-child(1) {
        width: 5%;
    }

    #paymentTable th:nth-child(2) {
        width: 10%;
    }

    #paymentTable th:nth-child(3) {
        width: 10%;
    }

    #paymentTable th:nth-child(4) {
        width: 20%;
    }

    #paymentTable th:nth-child(5) {
        width: 15%;
    }

    #paymentTable th:nth-child(6) {
        width: 10%;
    }

    #paymentTable th:nth-child(7) {
        width: 10%;
    }

    #paymentTable th:nth-child(8) {
        width: 10%;
    }

    #paymentTable th:nth-child(9) {
        width: 10%;
    }

    #paymentTable th:nth-child(10) {
        width: 15%;
    }

    #paymentTable th:nth-child(11) {
        width: 10%;
    }

    #paymentTable th:nth-child(12) {
        width: 15%;
    }

    #paymentTable th:nth-child(13) {
        width: 10%;
    }

    #paymentTable th:nth-child(14) {
        width: 10%;
    }

    #paymentTable th:nth-child(15) {
        width: 5%;
    }
</style>
