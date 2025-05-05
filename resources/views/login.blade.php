@extends('layouts.auth')
@section('judul', 'Masuk aplikasi Prediksi UMKM')

@section('konten')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Prediksi UMKM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #1e88e5;
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .input-wrapper {
            position: relative;
            width: 100%;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #888;
        }
        .btn {
            padding: 12px;
            background-color: #1e88e5;
            color: white;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 1rem;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #1565c0;
        }
        .register-link {
            display: block;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #1e88e5;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        {{-- Pesan Error kalau ada --}}
        @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login/submit" method="post">
            @csrf
            <input type="email" name="email" placeholder="Email" required>

            <div class="input-wrapper">
                <input type="password" id="password" name="password" placeholder="Kata Sandi" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

            <button type="submit" class="btn">Masuk</button>
        </form>

        <a href="/register" class="register-link">Belum punya akun? Daftar di sini</a>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var toggle = document.querySelector('.toggle-password');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggle.textContent = "🚫👁️"; // password terlihat, icon berubah jadi mata dicoret
            } else {
                passwordInput.type = "password";
                toggle.textContent = "👁️"; // password tersembunyi, icon kembali normal
            }
        }
    </script>
</body>
</html>
@endsection
