<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | PPDB Online SMKN 2 Kalianda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-32x32.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    @yield('css')
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            flex: 1;
        }

        footer {
            background: #0a369d;
            color: white;
            padding: 10px 0;
            text-align: center;
            flex-shrink: 0;
        }

        .card-header {
            background: #0A7F9D;
        }
        
        @media (max-width: 768px) {
            .navbar-title {
                font-size: 14px;
            }
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: #0a369d; /* Warna biru */
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 9999;
            transition: opacity 0.3s, transform 0.3s;
        }

        .back-to-top:hover {
            background-color: #0056b3; /* Warna biru lebih gelap */
        }

        .back-to-top i {
            font-size: 20px;
        }
    </style>
</head>
<body class="bg-body-tertiary">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0a369d">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="/user/dashboard">
                <img class="mx-3 ps-1" src="{{ asset('storage/logos/school-logo.png') }}" alt="Logo" width="auto" height="40" class="d-inline-block align-text-top">
                <span class="navbar-title">PPDB SMKN 2 Kalianda</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-2">
                        <a class="nav-link {{ request()->is('user/dashboard*') ? 'active' : '' }}" href="/user/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link {{ request()->is('user/pendaftaran*') ? 'active' : '' }}" href="/user/pendaftaran">Pendaftaran</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link {{ request()->is('user/pengumuman*') ? 'active' : '' }}" href="/user/pengumuman">Pengumuman</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item logout-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-3">
        @yield('content')
    </div>
    
    <footer class="main-footer">
        <strong>Hak Cipta &copy; 2024 PPDB SMKN 2 Kalianda.</strong>
        Semua hak dilindungi.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const backToTopButton = document.getElementById('backToTop');
    
            // Tampilkan tombol jika halaman di-scroll ke bawah
            window.addEventListener('scroll', () => {
                if (window.scrollY > 200) { // Jika scroll lebih dari 200px
                    backToTopButton.classList.remove('d-none');
                    backToTopButton.style.opacity = '1';
                    backToTopButton.style.transform = 'scale(1)';
                } else {
                    backToTopButton.style.opacity = '0';
                    backToTopButton.style.transform = 'scale(0.9)';
                    setTimeout(() => backToTopButton.classList.add('d-none'), 300);
                }
            });
    
            // Scroll halus ke atas saat tombol diklik
            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
