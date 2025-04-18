@extends('admin.layouts.base')
@section('title', 'Show Siswa')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">DATA SISWA</h4>
        </div>

        <div class="card-body">
            <!-- Row for Data Siswa and Data Tagihan -->
            <div class="row">
                <!-- Left side: Data Siswa -->
                <div class="col-md-4 mb-4">
                    <h5 class="font-weight-bold">Data Siswa</h5>
                    <table class="table table-bordered table-striped table-striped">
                        <tr>
                            <td><strong>NISN</strong></td>
                            <td>{{ $tagihanSiswara->nisn }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Lengkap</strong></td>
                            <td>{{ $tagihanSiswara->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>{{ $tagihanSiswara->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat, Tgl Lahir</strong></td>
                            <td>{{ $tagihanSiswara->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($tagihanSiswara->tanggal_lahir)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $tagihanSiswara->alamat }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>{{ $tagihanSiswara->kelas }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Right side: Data Tagihan (Scrollable Horizontal) -->
                <div class="col-md-8 mb-4">
                    <h5 class="font-weight-bold">Data Tagihan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Tagihan</th>
                                    <th>Tanggal</th>
                                    <th>Batas Waktu</th>
                                    <th>Kelas</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th>Terdaftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataTagihan as $tagihan)
                                    @php
                                        $hideRow = false;
                                        // Check if the tagihan already exists in the Riwayat Pembayaran
                                        foreach ($approvedTagihan as $approved) {
                                            if (
                                                $tagihan->keterangan == $approved->keterangan &&
                                                $tagihan->terdaftar == $approved->terdaftar
                                            ) {
                                                $hideRow = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    @if (!$hideRow)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tagihan->tagihan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d F Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tagihan->batas_waktu)->format('d F Y') }}</td>
                                            <td>{{ $tagihan->kelas ?? 'N/A' }}</td>
                                            <td>Rp. {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                                            <td>{{ $tagihan->keterangan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tagihan->terdaftar)->format('d F Y') }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#detailModal"
                                                    onclick="showDetailModal({
                                                        tagihan: '{{ addslashes($tagihan->tagihan) }}',
                                                        tanggal: '{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d F Y') }}',
                                                        batas_waktu: '{{ \Carbon\Carbon::parse($tagihan->batas_waktu)->format('d F Y') }}',
                                                        kelas_tagihan: '{{ addslashes($tagihan->kelas ?? 'N/A') }}',
                                                        nominal: {{ $tagihan->nominal }},
                                                        keterangan: '{{ addslashes($tagihan->keterangan) }}',
                                                        terdaftar: '{{ \Carbon\Carbon::parse($tagihan->terdaftar)->format('d F Y') }}',
                                                        tagihanId: {{ $tagihan->id }},
                                                        paymentAmount: {{ $tagihan->nominal }}
                                                    })">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>


                        </table>

                    </div>
                </div>
            </div>
            <!-- Riwayat Pembayaran -->

            <div class="mb-4">
                <h5 class="font-weight-bold">Tagihan Pending</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingTagihan as $tagihan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tagihan->nisn_id }}</td>
                                    <td>{{ $tagihan->nama_lengkap_id }}</td>
                                    <td>{{ $tagihan->tagihan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tagihan->batas_waktu)->format('d F Y') }}</td>
                                    <td>{{ $tagihan->kelas ?? 'N/A' }}</td>
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
                                    <td>Rp. {{ number_format($tagihan->cash, 0, ',', '.') }}</td>
                                    <td>
                                        <!-- Button Terima -->
                                        <button class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#terimaModal" onclick="openTerimaModal({{ $tagihan->id }})">
                                            Terima
                                        </button>

                                        <!-- Button Tolak -->
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#tolakModal"
                                            onclick="openTolakModal({{ $tagihan->id }})">
                                            Tolak
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal Konfirmasi Terima -->
            <div class="modal fade" id="terimaModal" tabindex="-1" aria-labelledby="terimaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="terimaModalLabel">Konfirmasi Terima Tagihan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menerima tagihan ini?</p>
                        </div>
                        <div class="modal-footer">
                            <form id="terimaForm" method="POST" action="{{ route('approve.tagihan') }}">
                                @csrf
                                <input type="hidden" name="tagihan_id" id="tagihanIdTerima">
                                <button type="submit" class="btn btn-success">Terima</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Konfirmasi Tolak -->
            <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tolakModalLabel">Konfirmasi Tolak Tagihan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menolak tagihan ini? Tagihan akan dihapus.</p>
                        </div>
                        <div class="modal-footer">
                            <form id="tolakForm" method="POST" action="{{ route('reject.tagihan') }}">
                                @csrf
                                <input type="hidden" name="tagihan_id" id="tagihanIdTolak">
                                <button type="submit" class="btn btn-danger">Tolak</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Approving Pending Tagihan -->
            <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveModalLabel">Approve Tagihan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>User:</strong> <span id="modalUser"></span></p>

                            <p><strong>NISN:</strong> <span id="modalNisnId"></span></p>
                            <p><strong>Nama Lengkap:</strong> <span id="modalNamaLengkapId"></span></p>
                            <p><strong>Tagihan:</strong> <span id="modalTagihan"></span></p>
                            <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                            <p><strong>Batas Waktu:</strong> <span id="modalBatasWaktu"></span></p>
                            <p><strong>Kelas Tagihan:</strong> <span id="modalKelasTagihan"></span></p>
                            <p><strong>Nominal:</strong> <span id="modalNominal"></span></p>
                            <p><strong>Keterangan:</strong> <span id="modalKeterangan"></span></p>
                            <p><strong>Terdaftar:</strong> <span id="modalTerdaftar"></span></p>
                            <p><strong>Bukti Pembayaran:</strong> <span id="modalBuktiPembayaran"></span></p>
                            <p><strong>Cash:</strong> <span id="modalCash"></span></p>
                            <p><strong>Pembayaran:</strong> <span id="modalPembayaran"></span></p>

                            <!-- Approval Form -->
                            <form id="approveForm" method="POST" action="{{ route('approve.tagihan') }}">
                                @csrf
                                <input type="hidden" name="tagihan_id" id="tagihanId">
                                <input type="hidden" name="status" value="disetujui">
                                <input type="hidden" name="user" id="user">
                                <!-- Hidden input for logged-in user -->
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <!-- Reject Button to delete the tagihan -->
                            <form id="rejectForm" method="POST" action="{{ route('reject.tagihan') }}">
                                @csrf
                                <input type="hidden" name="tagihan_id" id="rejectTagihanId">
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>





            <!-- Riwayat Tagihan -->
            <div class="mb-4">
                <h5 class="font-weight-bold">Riwayat Pembayaran</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
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
                            @foreach ($approvedTagihan as $tagihan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tagihan->users ? $tagihan->users->nama_lengkap : 'No user' }}</td>

                                    <td>{{ $tagihan->nisn_id }}</td>
                                    <td>{{ $tagihan->nama_lengkap_id }}</td>
                                    <td>{{ $tagihan->tagihan }}</td>
                                    <td>{{ $tagihan->tanggal }}</td>
                                    <td>{{ $tagihan->batas_waktu }}</td>
                                    <td>{{ $tagihan->kelas }}</td>
                                    <td>{{ $tagihan->nominal }}</td>
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
                                    <td>print</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for displaying proof of payment -->
    <!-- Modal for displaying proof of payment -->
    <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktiModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="buktiImage" src="" class="img-fluid" alt="Pembayaran Cash">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Tagihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <p><strong>Tagihan:</strong> <span id="modalTagihan"></span></p>
                    <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                    <p><strong>Batas Waktu:</strong> <span id="modalBatasWaktu"></span></p>
                    <p><strong>Kelas Tagihan:</strong> <span id="modalKelasTagihan"></span></p>
                    <p><strong>Nominal:</strong> <span id="modalNominal"></span></p>
                    <p><strong>Keterangan:</strong> <span id="modalKeterangan"></span></p>
                    <p><strong>Terdaftar:</strong> <span id="modalTerdaftar"></span></p> --}}

                    <div id="paymentAmountSection">
                        {{-- <label for="paymentAmount"><strong>Tunai:</strong></label> --}}
                        <form action="{{ route('tagihan.siswa.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Input untuk NISN dengan readonly -->
                            <div class="form-group">
                                <label for="nisn_id"><strong>NISN:</strong></label>
                                <input type="text" class="form-control" name="nisn_id" id="nisn_id"
                                    value="{{ $tagihanSiswara->nisn }}" readonly>
                            </div>

                            <!-- Input untuk Nama Lengkap dengan readonly -->
                            <div class="form-group">
                                <label for="nama_lengkap_id"><strong>Nama Lengkap:</strong></label>
                                <input type="text" class="form-control" name="nama_lengkap_id" id="nama_lengkap_id"
                                    value="{{ $tagihanSiswara->nama_lengkap }}" readonly>
                            </div>

                            <!-- Input untuk Tagihan dengan readonly -->
                            <div class="form-group">
                                <label for="tagihan"><strong>Tagihan:</strong></label>
                                <input type="text" class="form-control" name="tagihan" id="tagihan" value=""
                                    readonly>
                            </div>

                            <!-- Input untuk Tanggal dengan readonly -->
                            <div class="form-group">
                                <label for="tanggal"><strong>Tanggal:</strong></label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" value=""
                                    readonly>
                            </div>

                            <!-- Input untuk Batas Waktu dengan readonly -->
                            <div class="form-group">
                                <label for="batas_waktu"><strong>Batas Waktu:</strong></label>
                                <input type="text" class="form-control" name="batas_waktu" id="batas_waktu"
                                    value="" readonly>
                            </div>

                            <!-- Input untuk Kelas dengan readonly -->
                            <div class="form-group">
                                <label for="kelas"><strong>Kelas:</strong></label>
                                <input type="text" class="form-control" name="kelas" id="kelas" value=""
                                    readonly>
                            </div>

                            <!-- Input untuk Nominal dengan readonly -->
                            <div class="form-group">
                                <label for="nominal"><strong>Nominal:</strong></label>
                                <input type="text" class="form-control" name="nominal" id="nominal" value=""
                                    readonly>
                            </div>

                            <!-- Input untuk Keterangan dengan readonly -->
                            <div class="form-group">
                                <label for="keterangan"><strong>Keterangan:</strong></label>
                                <input type="text" class="form-control" name="keterangan" id="keterangan"
                                    value="" readonly>
                            </div>

                            <!-- Input untuk Terdaftar dengan readonly -->
                            <div class="form-group">
                                <label for="terdaftar"><strong>Terdaftar:</strong></label>
                                <input type="text" class="form-control" name="terdaftar" id="terdaftar"
                                    value="" readonly>
                            </div>

                            <!-- Pembayaran (Transfer) diset otomatis -->
                            <div class="form-group">
                                <label for="pembayaran"><strong>Pembayaran:</strong></label>
                                <input type="text" class="form-control" name="pembayaran" id="pembayaran"
                                    value="Cash" readonly>
                            </div>

                            <!-- File input untuk bukti_pembayaran -->
                            {{-- <label for="bukti_pembayaran"><strong>Bukti Pembayaran:</strong></label> --}}
                            <input type="hidden" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran"
                                accept="image/*,application/pdf">

                            <!-- Input untuk nominal Tunai -->
                            <div class="form-group">
                                <label for="paymentAmount"><strong>Nominal Pembayaran (Tunai):</strong></label>
                                <input type="number" class="form-control" name="cash" id="paymentAmount"
                                    placeholder="Masukkan nominal">
                            </div>

                            <!-- Status diset otomatis -->
                            <input type="hidden" class="form-control" name="status" value="disetujui" readonly>

                            <!-- Button Simpan dan Close -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>



                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        // Fungsi untuk membuka modal Terima
        function openTerimaModal(tagihanId) {
            // Set ID tagihan yang akan diterima di dalam form
            document.getElementById('tagihanIdTerima').value = tagihanId;
        }

        // Fungsi untuk membuka modal Tolak
        function openTolakModal(tagihanId) {
            // Set ID tagihan yang akan ditolak di dalam form
            document.getElementById('tagihanIdTolak').value = tagihanId;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Iterasi untuk tabel tagihan
            let rows = document.querySelectorAll('table tbody tr');

            rows.forEach(function(row) {
                // Ambil data keterangan dan terdaftar dari baris
                let keterangan = row.querySelector('td:nth-child(7)').textContent.trim();
                let terdaftar = row.querySelector('td:nth-child(8)').textContent.trim();

                // Cek apakah keterangan dan terdaftar sama dengan yang ada di riwayat pembayaran
                @foreach ($tagihanSiswas as $tagihanSiswa)
                    if (keterangan === '{{ addslashes($tagihanSiswa->keterangan) }}' &&
                        terdaftar ===
                        '{{ \Carbon\Carbon::parse($tagihanSiswa->terdaftar)->format('d F Y') }}') {
                        row.style.display = 'none'; // Menyembunyikan baris jika data sama
                    }
                @endforeach
            });
        });
    </script>

    <script>
        // Fungsi untuk menampilkan detail modal
        function showDetailModal(tagihan) {
            console.log('Tagihan Data:', tagihan);

            // Menyisipkan data ke modal
            document.getElementById('modalTagihan').innerText = tagihan.tagihan || 'No data available';
            document.getElementById('modalTanggal').innerText = tagihan.tanggal || 'No data available';
            document.getElementById('modalBatasWaktu').innerText = tagihan.batas_waktu || 'No data available';
            document.getElementById('modalKelasTagihan').innerText = tagihan.kelas_tagihan || 'N/A';
            document.getElementById('modalNominal').innerText = 'Rp. ' + new Intl.NumberFormat().format(tagihan.nominal ||
                0);
            document.getElementById('modalKeterangan').innerText = tagihan.keterangan || 'No data available';
            document.getElementById('modalTerdaftar').innerText = tagihan.terdaftar || 'No data available';

            // Isi input form dengan data yang benar
            // document.querySelector('[name="nisn_id"]').value = tagihan.nisn_id;
            // document.querySelector('[name="nama_lengkap_id"]').value = tagihan.nama_lengkap_id;
            document.querySelector('[name="tagihan"]').value = tagihan.tagihan;
            document.querySelector('[name="tanggal"]').value = tagihan.tanggal;
            document.querySelector('[name="batas_waktu"]').value = tagihan.batas_waktu;
            document.querySelector('[name="kelas"]').value = tagihan.kelas_tagihan;
            document.querySelector('[name="nominal"]').value = tagihan.nominal;
            document.querySelector('[name="keterangan"]').value = tagihan.keterangan;
            document.querySelector('[name="terdaftar"]').value = tagihan.terdaftar;
            document.querySelector('[name="cash"]').value = tagihan.paymentAmount || ''; // Cash field
        }
    </script>
    <script>
        function showBukti(imageUrl) {
            // Set the source of the image to the URL provided
            document.getElementById('buktiImage').src = imageUrl;

            // Show the modal
            $('#buktiModal').modal('show');
        }
    </script>


@endsection

<!-- Bootstrap JS dan jQuery -->
{{-- <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}

<!-- Fungsi JavaScript custom -->
@yield('scripts')
