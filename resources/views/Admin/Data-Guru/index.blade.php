@extends('admin.layouts.base')
@section('title', 'Data Guru')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Guru</h4>
            <a href="{{ route('data-guru.create') }}" class="btn btn-success bg-primary">Tambah Guru</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>PROFILE</th>
                            <th>NUPTK</th>
                            <th>NAMA GURU</th>
                            <th>EMAIL</th>
                            <th>NO TELEPON</th>
                            <th>STATUS</th>
                            <th>TERGABUNG</th>
                            <th>TERAKHIR DI PERBARUI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gurus as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($guru->foto_profile)
                                        <img src="{{ Storage::url($guru->foto_profile) }}" alt="Foto Profile" width="100"
                                            height="auto">
                                    @else
                                        <span>No Photo</span>
                                    @endif
                                </td>
                                <td>{{ $guru->nuptk }}</td>
                                <td>{{ $guru->nama_guru }}</td>
                                <td>{{ $guru->email }}</td>
                                <td>{{ $guru->nomor_telepon }}</td>
                                <td>{{ $guru->status }}</td>
                                <td>{{ $guru->tergabung }}</td>
                                <td>{{ $guru->updated_at }}</td>
                                <td>
                                    <a href="{{ route('data-guru.edit', $guru->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <!-- Trigger modal for delete -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{ $guru->id }}" data-name="{{ $guru->nama_guru }}">Delete</button>
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
                    <p>Apakah Anda yakin ingin menghapus guru <strong id="guruName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('data-guru.destroy', $guru->id) }}" method="POST" style="display:inline;">
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
            var guruId = button.data('id'); // Extract the guru ID
            var guruName = button.data('name'); // Extract the guru name

            // Update the modal's content
            var modal = $(this);
            modal.find('#guruName').text(guruName);
            modal.find('#guruId').val(guruId); // Set the ID in the hidden input field

            // Update the form action URL with the guruId
            modal.find('#deleteForm').attr('action', '/data-guru/destroy/' + guruId);
        });
    </script>
@endsection
