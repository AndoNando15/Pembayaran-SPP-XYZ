<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Daftar</title>
    <!-- Memasukkan link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling custom */
        .register-container {
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .register-box {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .register-button {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <div class="register-box">
            <h3 class="text-center mb-4">HALAMAN DAFTAR</h3>

            <!-- Form Register -->
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <!-- NIS -->
                <div class="form-group mb-3">
                    <label for="nisn">NIS</label>
                    <input type="number" name="nisn" id="nisn" class="form-control"
                        placeholder="Masukan NISN anda" required>
                </div>

                <!-- Nama Lengkap -->
                <div class="form-group mb-3">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                        placeholder="Masukan nama lengkap anda" required>
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group mb-3">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <!-- Tempat Lahir -->
                <div class="form-group mb-3">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                        placeholder="Masukan tempat lahir anda" required>
                </div>

                <!-- Tanggal Lahir -->
                <div class="form-group mb-3">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                </div>

                <!-- Kelas -->
                <div class="form-group mb-3">
                    <label for="kelas">Kelas</label>
                    <select name="kelas" id="kelas" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select>
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Masukan email anda" required>
                </div>

                <!-- Kata Sandi -->
                <div class="form-group mb-3">
                    <label for="password">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Masukan kata sandi anda" required>
                </div>

                <!-- Nomor Telepon -->
                <div class="form-group mb-3">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control"
                        placeholder="Masukan nomor telepon anda" required>
                </div>

                <!-- Alamat -->
                <div class="form-group mb-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan alamat anda" required></textarea>
                </div>

                <!-- Daftar Button -->
                <div class="form-group mb-3">
                    <button type="submit" class="btn register-button">Daftar</button>
                </div>

                <!-- Login Link -->
                <div class="login-link">
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Memasukkan link ke Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
