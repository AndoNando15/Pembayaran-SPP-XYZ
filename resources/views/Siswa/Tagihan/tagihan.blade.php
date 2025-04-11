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
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
                                                nominal: {{ $tagihan->nominal }} ,
                                                keterangan: '{{ addslashes($tagihan->keterangan) }}',
                                                terdaftar: '{{ \Carbon\Carbon::parse($tagihan->terdaftar)->format('d F Y') }}',
                                                tagihanId: {{ $tagihan->id }}
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
                        <form action="{{ route('tagihan.siswas.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" name="nisn_id" id="nisn_id"
                                value="{{ $tagihanSiswara->nisn }}">
                            <input type="hidden" class="form-control" name="nama_lengkap_id" id="nama_lengkap_id"
                                value="{{ $tagihanSiswara->nama_lengkap }}">
                            <input type="hidden" class="form-control" name="pembayaran" value="Transfer">
                            <input type="hidden" class="form-control" name="cash" value="0">
                            <input type="hidden" class="form-control" name="status" value="pending">

                            <div class="form-group">
                                <label for="tagihan"><strong>Tagihan:</strong></label>
                                <input type="text" class="form-control" name="tagihan" id="modalTagihan" readonly>
                            </div>

                            <div class="form-group">
                                <label for="tanggal"><strong>Tanggal:</strong></label>
                                <input type="text" class="form-control" name="tanggal" id="modalTanggal" readonly>
                            </div>

                            <div class="form-group">
                                <label for="batas_waktu"><strong>Batas Waktu:</strong></label>
                                <input type="text" class="form-control" name="batas_waktu" id="modalBatasWaktu" readonly>
                            </div>

                            <div class="form-group">
                                <label for="kelas"><strong>Kelas:</strong></label>
                                <input type="text" class="form-control" name="kelas" id="modalKelasTagihan" readonly>
                            </div>

                            <div class="form-group">
                                <label for="nominal"><strong>Nominal:</strong></label>
                                <input type="text" class="form-control" name="nominal" id="modalNominal" readonly>
                            </div>

                            <div class="form-group">
                                <label for="keterangan"><strong>Keterangan:</strong></label>
                                <input type="text" class="form-control" name="keterangan" id="modalKeterangan" readonly>
                            </div>

                            <div class="form-group">
                                <label for="terdaftar"><strong>Terdaftar:</strong></label>
                                <input type="text" class="form-control" name="terdaftar" id="modalTerdaftar" readonly>
                            </div>

                            <div class="form-group">
                                <label for="bukti_pembayaran"><strong>Bukti Pembayaran:</strong></label>
                                <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran"
                                    accept="image/*,application/pdf">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let rows = document.querySelectorAll('table tbody tr');

            rows.forEach(function(row) {
                let keterangan = row.querySelector('td:nth-child(7)').textContent.trim();
                let terdaftar = row.querySelector('td:nth-child(8)').textContent.trim();

                @foreach ($tagihanSiswas as $tagihanSiswa)
                    if (keterangan === '{{ addslashes($tagihanSiswa->keterangan) }}' &&
                        terdaftar ===
                        '{{ \Carbon\Carbon::parse($tagihanSiswa->terdaftar)->format('d F Y') }}') {
                        row.style.display = 'none';
                    }
                @endforeach
            });
        });
    </script>

    <script>
        function showDetailModal(tagihan) {
            console.log('Tagihan Data:', tagihan);

            // Populate modal fields
            document.getElementById('modalTagihan').innerText = tagihan.tagihan || 'No data available';
            document.getElementById('modalTanggal').innerText = tagihan.tanggal || 'No data available';
            document.getElementById('modalBatasWaktu').innerText = tagihan.batas_waktu || 'No data available';
            document.getElementById('modalKelasTagihan').innerText = tagihan.kelas_tagihan || 'N/A';
            document.getElementById('modalNominal').innerText = 'Rp. ' + new Intl.NumberFormat().format(tagihan.nominal ||
                0);
            document.getElementById('modalKeterangan').innerText = tagihan.keterangan || 'No data available';
            document.getElementById('modalTerdaftar').innerText = tagihan.terdaftar || 'No data available';

            // Populate input fields with data
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
            document.getElementById('buktiImage').src = imageUrl;
            $('#buktiModal').modal('show');
        }
    </script>


@endsection
@yield('scripts')
