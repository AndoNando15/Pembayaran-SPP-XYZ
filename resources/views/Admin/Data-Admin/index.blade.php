@extends('admin.layouts.base')
@section('title', 'Data Admin')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Data Admin</h4>
            <a href="{{ route('data-admin.create') }}" class="btn btn-success bg-primary">Tambah Admin</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>PROFILE</th>
                            <th>NUPTK</th>
                            <th>NAMA LENGKAP</th>
                            <th>EMAIL</th>
                            <th>JABATAN</th>
                            <th>TERDAFTAR</th>
                            <th>TERAKHIR DI PERBARUI</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td> <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Profile Photo"
                                        width="100"></td>
                                <td>{{ $user->nuptk }}</td>
                                <td>{{ $user->nama_lengkap }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->jabatan }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->terdaftar)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('data-admin.edit', $user->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->nama_lengkap }}">Delete</button>
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
                    <p>Apakah Anda yakin ingin menghapus admin <strong id="adminName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('data-admin.destroy', $user->id) }}" method="POST" style="display:inline;">
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
            var adminId = button.data('id'); // Extract the admin ID
            var adminName = button.data('name'); // Extract the admin name

            // Update the modal's content
            var modal = $(this);
            modal.find('#adminName').text(adminName);
            modal.find('#adminId').val(adminId); // Set the ID in the hidden input field

            // Update form action dynamically to include the correct admin ID
            var actionUrl = "{{ route('data-admin.destroy', ':id') }}".replace(':id', adminId);
            modal.find('#deleteForm').attr('action', actionUrl);
        });
    </script>
@endsection
