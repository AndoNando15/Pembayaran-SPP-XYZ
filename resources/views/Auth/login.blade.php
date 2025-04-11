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
        body {
            background-color: #f4f4f4;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .logo-container h3 {
            margin-top: 10px;
        }

        .form-group label {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .login-button {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        .register-button {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .register-button:hover {
            background-color: #218838;
        }

        .forgot-password {
            text-align: right;
            font-size: 14px;
            margin-top: 10px;
        }

        .alert {
            font-size: 14px;
            margin-top: 10px;
        }

        .alert ul {
            padding-left: 20px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-box">
            <!-- Logo and School name -->
            <div class="logo-container mb-4">
                <img src="img/logo/logo-xyz.png" alt="Logo">
                <h3 class="text-primary mt-2">SMA XYZ</h3>
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
