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
                                <td>Rp. {{ number_format($tagihan->nominal, 2) }}</td>
                                <td>{{ $tagihan->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                                <td>{{ $tagihan->keterangan }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->terdaftar)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->updated_at)->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('data-tagihan.edit', $tagihan->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{ $tagihan->id }}" data-name="{{ $tagihan->tagihan }}">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus tagihan <strong id="tagihanName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <!-- Correct the form method here -->
                    <form action="{{ route('data-tagihan.destroy', $tagihan->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger ">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Set up the modal with the correct ID and name when the delete button is clicked
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var tagihanId = button.data('id'); // Extract the tagihan ID
            var tagihanName = button.data('name'); // Extract the tagihan name

            // Update the modal's content
            var modal = $(this);
            modal.find('#tagihanName').text(tagihanName);
            modal.find('#tagihanId').val(tagihanId); // Set the ID in the hidden input field

            // Update the form action URL with the tagihanId
            modal.find('#deleteForm').attr('action', '/data-tagihan/destroy/' + tagihanId);
        });
    </script>
@endsection
