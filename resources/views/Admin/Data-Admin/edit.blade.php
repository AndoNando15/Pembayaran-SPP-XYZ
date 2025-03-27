@extends('admin.layouts.base')
@section('title', 'Edit Admin')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Edit Admin</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('data-admin.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Picture Upload -->
                <div class="form-group">
                    <label for="foto_profile">Upload Foto Profil</label>
                    <input type="file" class="form-control-file" id="foto_profile" name="foto_profile"
                        onchange="previewImage(event)">
                </div>
                <!-- Display Existing Photo if available -->
                @if ($user->foto_profile)
                    <div class="form-group">
                        <label>Foto Profil Saat Ini</label><br>
                        <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Profile Photo" width="100"
                            id="current-photo">
                    </div>
                @endif

                <!-- Image Preview -->
                <div class="form-group" id="preview-container" style="display:none;">
                    <label>Preview Foto Profil</label><br>
                    <img id="preview-image" width="100">
                </div>


                <div class="form-group">
                    <label for="nuptk">NUPTK</label>
                    <input type="text" class="form-control" id="nuptk" name="nuptk" value="{{ $user->nuptk }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                        value="{{ $user->nama_lengkap }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $user->jabatan }}"
                        required>
                </div>

                <!-- Optional Change Password Field -->
                <div class="form-group">
                    <label for="password">Ganti Sandi (Optional)</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Leave blank if you don't want to change the password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Sandi</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm password">
                </div>



                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Admin</button>
                    <a href="{{ route('data-admin.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

@endsection

<script>
    function previewImage(event) {
        var previewContainer = document.getElementById('preview-container');
        var previewImage = document.getElementById('preview-image');
        var currentPhoto = document.getElementById('current-photo');

        // Show the preview container
        previewContainer.style.display = 'block';

        // Set the preview image to the selected file
        previewImage.src = URL.createObjectURL(event.target.files[0]);

        // Hide the current profile picture if a new one is selected
        if (currentPhoto) {
            currentPhoto.style.display = 'none';
        }
    }
</script>
