<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Modern</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #fff;
            display: flex;
            min-height: 100vh;
        }

        nav {
            width: 260px;
            background: #111;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 10px rgba(0, 255, 255, 0.1);
        }

        nav h4 {
            font-size: 1.5rem;
            color: #00e5ff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        nav ul {
            list-style: none;
        }

        nav ul li {
            margin: 20px 0;
        }

        nav ul li a {
            text-decoration: none;
            color: #bbb;
            font-size: 1rem;
            transition: 0.3s;
            display: block;
        }

        nav ul li a:hover {
            color: #00e5ff;
        }

        main {
            flex: 1;
            padding: 40px;
        }

        header {
    display: flex;
    justify-content: center; /* Tengah horizontal */
    align-items: center;
    margin-bottom: 40px;
}

header h2 {
    font-weight: 600;
    font-size: 2rem;
    color: #00e5ff;
}

        .btn {
            padding: 10px 20px;
            background: transparent;
            border: 2px solid #ff4d4d;
            color: #ff4d4d;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #ff4d4d;
            color: #fff;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 0 25px rgba(0, 229, 255, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 35px rgba(0, 229, 255, 0.2);
        }

        .card-title {
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: #00e5ff;
        }

        .card-text {
            font-size: 1.1rem;
            color: #ddd;
        }

        @media (max-width: 768px) {
            nav {
                display: none;
            }
            main {
                padding: 20px;
            }
        }
    </style>
</head>
<<!-- ... head tetap sama ... -->
<body>

<!-- Sidebar -->
<nav>
    <div>
        <h4><img src="assets/images/logo.png" alt="Logo" width="30"> UMKM Panel</h4>
        <ul>
            <li><a href="dashboard">🏠 Beranda</a></li>
            <li><a href="Pengguna">👥 Pengguna</a></li>
            <li><a href="#">⚙️ Pengaturan</a></li>
        </ul>
    </div>

    <!-- Form logout -->
    <form method="POST" action="/logout">
        @csrf
        <button type="submit" class="btn">Keluar</button>
    </form>
</nav>

<!-- Konten Utama -->
<main>
    <header>
        <h2>Selamat datang DI Dasboard Prediksi UMKM !</h2>
    </header>
        
    <section class="row">
        <div class="card">
          @yield('konten')
        </div>
    </section>
</main>

</body>
</html>
