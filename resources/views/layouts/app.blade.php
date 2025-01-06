<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | PPDB Online SMK Negeri 2 Kalianda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-32x32.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e9eef7;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 16px;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .footer {
            font-size: 12px;
            color: #777;
        }

        .footer a {
            color: #2c80c9;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            display: none; /* Hidden by default */
        }

        .invalid-feedback {
            display: block;
            text-align: left; /* Set feedback alignment to left */
        }

        .btn-login {
            background-color: #0a369d;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #082c78; /* Warna lebih gelap saat dihover */
        }

        #togglePassword, #togglePasswordConfirmation {
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
</head>
<body class="py-3 min-vh-100 p-3">
    
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>
</html>
