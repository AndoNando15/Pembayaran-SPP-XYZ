<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Masuk</title>
    <!-- Memasukkan link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menambahkan styling custom */
        .login-container {
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .logo-container {
            text-align: center;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .form-group label {
            font-weight: bold;
        }

        .login-button {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        .register-button {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        .forgot-password {
            text-align: right;
            font-size: 14px;
        }

        .alert {
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-box">
            <!-- Logo and School name -->
            <div class="logo-container mb-4 bg-success py-3">
                <img src="img/logo/logo-xyz.png" alt="Logo">
                <h3 class=" text-white mt-2">SMA XYZ</h3>
            </div>

            <!-- Form Login -->
            <h4 class="text-center mb-4">HALAMAN MASUK</h4>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="email">NIS/Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <button type="submit" class="btn login-button">Masuk</button>
                </div>

                <div class="form-group mb-3">
                    <a href="{{ route('register') }}" class="btn register-button">Daftar</a>
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
