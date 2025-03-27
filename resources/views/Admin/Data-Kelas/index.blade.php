@extends('admin.layouts.base')
@section('title', 'Data Kelas')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Kelas</h4>
            <a href="{{ route('data-kelas.create') }}" class="btn btn-success bg-primary">Tambah Kelas</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>KELAS</th>
                            <th>LEVEL</th>
                            <th>WALI KELAS</th>
                            {{-- <th>TAGIHAN</th> --}}
                            <th>TAGIHAN KELAS</th>
                            <th>TERAKHIR DI PERBARUI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $k)
                            @if ($k->kelas != 'SEMUA KELAS')
                                <!-- Cek jika kelas bukan "SEMUA KELAS" -->
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $k->kelas }}</td>
                                    <td>{{ $k->level }}</td>
                                    <td>{{ $k->waliKelas->nama_guru }}</td>

                                    <td>
                                        <a href="{{ route('data-kelas.tagihan', ['id' => $k->id]) }}"
                                            class="btn btn-warning btn-sm">LIHAT TAGIHAN</a>
                                    </td>

                                    <td>{{ $k->updated_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('data-kelas.edit', $k->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"
                                            data-id="{{ $k->id }}" data-name="{{ $k->kelas }}">Delete</button>
                                    </td>
                                </tr>
                            @endif
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
                    <p>Apakah Anda yakin ingin menghapus kelas <strong id="kelasName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('data-kelas.destroy', $k->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
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
            var kelasId = button.data('id'); // Extract the kelas ID
            var kelasName = button.data('name'); // Extract the kelas name

            // Update the modal's content
            var modal = $(this);
            modal.find('#kelasName').text(kelasName);
            modal.find('#kelasId').val(kelasId); // Set the ID in the hidden input field

            // Update form action dynamically to include the correct kelas ID
            var actionUrl = "{{ route('data-kelas.destroy', ':id') }}".replace(':id', kelasId);
            modal.find('#deleteForm').attr('action', actionUrl);
        });
    </script>
@endsection
