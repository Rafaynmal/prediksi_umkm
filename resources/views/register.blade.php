@extends('layouts.auth')
@section('judul', 'Daftar akun')

@section('konten')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
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
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
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
        <h2>Daftar</h2>
        <p>Silakan masukkan data diri Anda</p>
        
        <form action="/register/submit" method="post">
            @csrf
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukkan nama" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email" required>

            <label>Kata Sandi</label>
            <input type="password" name="password" placeholder="Kata Sandi" required>

            <button type="submit" class="btn">Daftar</button>
        </form>

        <a href="/login" class="register-link">Sudah punya akun? Masuk di sini</a>
    </div>
</body>
@endsection
