@extends('layouts.app')

@section('content')
    <img src="{{ asset('images/smk2.png') }}" style="width: 100px; height: auto;" alt="Login Image">
    <div class="login-container mt-3">
        <h2>Login</h2>
        <p>Selamat datang di aplikasi PPDB SMK Negeri 2 Kalianda Tahun {{ date('Y') }}</p>

        @if (session('loginError'))
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                <div>{{ session('loginError') }}</div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                <div>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Login -->
        <form id="loginForm" method="POST" action="{{ route('user.login') }}">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                <label for="email">Email</label>
                <div class="invalid-feedback" id="emailFeedback"></div>
            </div>
            <div class="form-floating position-relative mb-3">
                <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
                <label for="password">Password</label>
                <div class="invalid-feedback" id="passwordFeedback"></div>
                
                <!-- Ikon Mata -->
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;">
                    <i class="bi bi-eye"></i> <!-- Ikon Bootstrap Icons -->
                </span>
            </div>            
            <button type="submit" class="btn w-100 mb-3 text-white btn-login">Login</button>
        </form>

        <div class="additional-info">
            Belum memiliki akun? <a href="/register">Klik Disini untuk Daftar!</a>
        </div>

        <div class="additional-info">
            <a href="{{ route('forgot.password') }}">Lupa Password?</a>
        </div>        

        <div class="footer mt-3">
            <a href="/">&larr; Kembali ke Home</a>
        </div>
        
        <!-- Loading overlay -->
        <div class="loading-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Tampilkan overlay loading saat form disubmit
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.querySelector('.loading-overlay').style.display = 'flex';
        });

        // Validasi email secara real-time
        document.getElementById('email').addEventListener('input', function() {
            const emailField = this;
            const emailFeedback = document.getElementById('emailFeedback');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(emailField.value)) {
                emailField.classList.add('is-invalid');
                emailFeedback.textContent = 'Masukkan email yang valid.';
            } else {
                emailField.classList.remove('is-invalid');
                emailFeedback.textContent = '';
            }
        });

        // Validasi password secara real-time
        document.getElementById('password').addEventListener('input', function() {
            const passwordField = this;
            const passwordFeedback = document.getElementById('passwordFeedback');
            const togglePasswordIcon = document.getElementById('togglePassword');

            if (passwordField.value.length < 8) {
                passwordField.classList.add('is-invalid');
                passwordFeedback.textContent = 'Password harus minimal 8 karakter.';
                
                // Sembunyikan ikon mata jika password invalid
                togglePasswordIcon.style.display = 'none';
            } else {
                passwordField.classList.remove('is-invalid');
                passwordFeedback.textContent = '';

                // Tampilkan ikon mata kembali jika password valid
                togglePasswordIcon.style.display = 'block';
            }
        });

        // Jika ada sesi login sukses, tampilkan SweetAlert
        @if(session('successLogin'))
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: '{{ session('successLogin') }}',
                timer: 1000, // Durasi 1 detik sebelum dialihkan
                showConfirmButton: false,
                didClose: () => {
                    // Redirect setelah SweetAlert ditutup
                    window.location.href = "{{ url('/user/dashboard') }}";
                }
            });
        @endif

        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle ikon mata
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>
@endsection
