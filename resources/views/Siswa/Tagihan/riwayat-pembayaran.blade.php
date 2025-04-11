@extends('siswa.layouts.base')
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

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="paymentTable" width="100%"
                    cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
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
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihanSiswas as $tagihan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tagihan->nisn_id }}</td>
                                <td>{{ $tagihan->nama_lengkap_id }}</td>
                                <td>{{ $tagihan->tagihan }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->batas_waktu)->format('d F Y') }}</td>
                                <td>{{ $tagihan->kelas }}</td>
                                <td>Rp. {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                                <td>{{ $tagihan->keterangan }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->terdaftar)->format('d F Y') }}</td>
                                <td>{{ $tagihan->pembayaran }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="showBukti('{{ asset('storage/' . $tagihan->bukti_pembayaran) }}')">
                                        Lihat Bukti
                                    </button>
                                </td>

                                <td>{{ $tagihan->cash }}</td>
                                <td>
                                    <span
                                        class="badge text-white p-2 {{ $tagihan->status == 'pending' ? 'bg-warning' : ($tagihan->status == 'disetujui' ? 'bg-success' : 'bg-secondary') }}">
                                        {{ $tagihan->status }}
                                    </span>
                                </td>

                                <td>{{ \Carbon\Carbon::parse($tagihan->updated_at)->format('d F Y H:i') }}</td>
                                {{-- <td>
                                    <a href="#" class="btn btn-info btn-sm">Print</a>
                                </td> --}}
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
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktiModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <!-- Displaying the image here -->
                    <img id="buktiImage" src="" class="img-fluid" alt="Bukti Pembayaran">
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')


    <script>
        // Function to display the proof of payment in the modal
        function showBukti(imageUrl) {
            document.getElementById('buktiImage').src = imageUrl;
            $('#buktiModal').modal('show');
        }

        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#paymentTable').DataTable();

            // Apply search on 'Nama Lengkap' column (index 3)
            $('#searchName').on('keyup change', function() {
                // Search only in the 'Nama Lengkap' column (index 3)
                table.column(2).search(this.value).draw();
            });
        });
    </script>

@endsection

<!-- Bootstrap JS and jQuery -->
{{-- <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
<script>
    function showBukti(imageUrl) {
        // Set the source of the image to the URL provided
        document.getElementById('buktiImage').src = imageUrl;

        // Show the modal
        $('#buktiModal').modal('show');
    }
</script>
