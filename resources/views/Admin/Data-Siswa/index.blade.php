@extends('admin.layouts.base')
@section('title', 'Data Siswa')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-weight-bold text-primary">Daftar Siswa</h4>
            <a href="{{ route('data-siswa.create') }}" class="btn btn-success bg-primary">Tambah Siswa</a>
        </div>

        <div class="card-body">
            <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr class="text-center">
                            <th>NO</th>
                            <th>PROFILE</th>
                            <th>NISN</th>
                            <th>NAMA LENGKAP</th>
                            <th>JENIS KELAMIN</th>
                            <th>TEMPAT LAHIR</th>
                            <th>TANGGAL LAHIR</th>
                            <th>ALAMAT</th>
                            <th>KELAS</th>
                            <th>EMAIL</th>
                            <th>NO TELEPON</th>
                            <th>TERDAFTAR</th>
                            <th>TERAKHIR DI EDIT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ asset('storage/foto_profile_siswa/' . $user->foto_profile) }}"
                                        alt="Profile" width="100"></td>
                                <td>{{ $user->nisn }}</td>
                                <td>{{ $user->nama_lengkap }}</td>
                                <td>{{ $user->jenis_kelamin }}</td>
                                <td>{{ $user->tempat_lahir }}</td>
                                <td>{{ $user->tanggal_lahir }}</td>
                                <td>{{ $user->alamat }}</td>
                                <td>{{ $user->kelas }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_telepon }}</td>
                                <td>{{ $user->terdaftar }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    <a href="{{ route('data-siswa.edit', $user->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <!-- Trigger modal -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{ $user->id }}" data-name="{{ $user->nama_lengkap }}">Hapus</button>
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
                    <p>Apakah Anda yakin ingin menghapus siswa <strong id="siswaName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('data-siswa.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger ">Delete</button>
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
            var siswaId = button.data('id'); // Extract the siswa ID
            var siswaName = button.data('name'); // Extract the siswa name

            // Update the modal's content
            var modal = $(this);
            modal.find('#siswaName').text(siswaName);
            modal.find('#siswaId').val(siswaId); // Set the ID in the hidden input field

            // Update the form action URL with the siswaId
            modal.find('#deleteForm').attr('action', '/data-siswa/destroy/' + siswaId);
        });
    </script>
@endsection
