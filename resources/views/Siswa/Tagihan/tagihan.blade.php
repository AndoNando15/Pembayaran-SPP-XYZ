@extends('siswa.layouts.base')
@section('title', 'Show Siswa')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">DATA TAGIHAN</h4>
        </div>

        <div class="card-body">

            {{-- <h5 class="font-weight-bold">Data Tagihan</h5> --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
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
                                // Cek apakah keterangan dan terdaftar pada tagihan sama dengan yang ada di riwayat pembayaran
                                foreach ($tagihanSiswas as $tagihanSiswa) {
                                    if (
                                        $tagihan->keterangan == $tagihanSiswa->keterangan &&
                                        $tagihan->terdaftar == $tagihanSiswa->terdaftar
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
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal"
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


        <!-- Modal -->
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
                        <p><strong>Tagihan:</strong> <span id="modalTagihan"></span></p>
                        <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                        <p><strong>Batas Waktu:</strong> <span id="modalBatasWaktu"></span></p>
                        <p><strong>Kelas Tagihan:</strong> <span id="modalKelasTagihan"></span></p>
                        <p><strong>Nominal:</strong> <span id="modalNominal"></span></p>
                        <p><strong>Keterangan:</strong> <span id="modalKeterangan"></span></p>
                        <p><strong>Terdaftar:</strong> <span id="modalTerdaftar"></span></p>

                        <div id="paymentAmountSection">
                            {{-- <label for="paymentAmount"><strong>Tunai:</strong></label> --}}
                            <form action="{{ route('tagihan.siswas.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Hidden inputs to store data -->
                                <input type="hidden" class="form-control" name="nisn_id" id="nisn_id"
                                    value="{{ $tagihanSiswara->nisn }}">
                                <input type="hidden" class="form-control" name="nama_lengkap_id" id="nama_lengkap_id"
                                    value="{{ $tagihanSiswara->nama_lengkap }}">
                                <input type="hidden" class="form-control" name="tagihan" id="tagihan">
                                <input type="hidden" class="form-control" name="tanggal" id="tanggal">
                                <input type="hidden" class="form-control" name="batas_waktu" id="batas_waktu">
                                <input type="hidden" class="form-control" name="kelas" id="kelas">
                                <input type="hidden" class="form-control" name="nominal" id="nominal">
                                <input type="hidden" class="form-control" name="keterangan" id="keterangan">
                                <input type="hidden" class="form-control" name="terdaftar" id="terdaftar">
                                <input type="hidden" class="form-control" name="pembayaran" value="Transfer">

                                <!-- File input for bukti_pembayaran -->
                                <label for="bukti_pembayaran"><strong>Bukti Pembayaran:</strong></label>
                                <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran"
                                    accept="image/*,application/pdf">

                                <!-- Tunai input field -->
                                <input type="hidden" class="form-control" name="cash" value="0">
                                <input type="hidden" class="form-control" name="status" value="pending">

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



    @endsection

    @section('scripts')

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
                // document.querySelector('[name="cash"]').value = tagihan.paymentAmount || ''; // Cash field
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
