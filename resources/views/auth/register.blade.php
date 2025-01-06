@extends('layouts.app')

@section('content')
    <img src="{{ asset('images/smk2.png') }}" style="width: 100px; height: auto;" alt="Logo">
    <div class="login-container mt-3">
        <h2>Daftar Akun</h2>
        <p>Selamat datang di aplikasi PPDB SMK Negeri 2 Kalianda Tahun {{ date('Y') }}</p>

        @if (session('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('loginError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Form Pendaftaran -->
        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap">
                <label for="name">Nama Lengkap</label>
                <div class="invalid-feedback" id="nameFeedback"></div>
            </div>
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
            <div class="form-floating position-relative mb-3">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Konfirmasi Password">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="invalid-feedback" id="passwordConfirmationFeedback"></div>
                
                <!-- Ikon Mata untuk Konfirmasi Password -->
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" id="togglePasswordConfirmation" style="cursor: pointer;">
                    <i class="bi bi-eye"></i> <!-- Ikon Bootstrap Icons -->
                </span>
            </div>
            
            <button type="submit" class="btn w-100 my-3 text-white btn-login">Daftar</button>
        </form>

        <div class="additional-info">
            Sudah memiliki akun? <a href="/login">Login</a>
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
        document.getElementById('registerForm').addEventListener('submit', function () {
            document.querySelector('.loading-overlay').style.display = 'flex';
        });

        // Validasi nama
        document.getElementById('name').addEventListener('input', function () {
            const nameField = this;
            const nameFeedback = document.getElementById('nameFeedback');
            if (!nameField.checkValidity()) {
                nameField.classList.add('is-invalid');
                nameFeedback.textContent = 'Nama wajib diisi.';
            } else {
                nameField.classList.remove('is-invalid');
                nameFeedback.textContent = '';
            }
        });

        // Validasi email
        document.getElementById('email').addEventListener('input', function () {
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

        // Validasi password
        document.getElementById('password').addEventListener('input', function () {
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

        // Validasi konfirmasi password
        document.getElementById('password_confirmation').addEventListener('input', function () {
            const passwordField = document.getElementById('password');
            const passwordConfirmationField = this;
            const passwordConfirmationFeedback = document.getElementById('passwordConfirmationFeedback');
            const togglePasswordIcon = document.getElementById('togglePasswordConfirmation');

            if (passwordField.value !== passwordConfirmationField.value) {
                passwordConfirmationField.classList.add('is-invalid');
                passwordConfirmationFeedback.textContent = 'Konfirmasi password tidak cocok.';
                // Sembunyikan ikon mata jika password invalid
                togglePasswordIcon.style.display = 'none';
            } else {
                passwordConfirmationField.classList.remove('is-invalid');
                passwordConfirmationFeedback.textContent = '';
                // Tampilkan ikon mata kembali jika password valid
                togglePasswordIcon.style.display = 'block';
            }
        });

        // Jika ada sesi login sukses, tampilkan SweetAlert
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Daftar Akun Berhasil',
            text: '{{ session('success') }}',
            timer: 1000, // Durasi 1 detik sebelum dialihkan
            showConfirmButton: false,
            didClose: () => {
                // Redirect setelah SweetAlert ditutup
                window.location.href = "{{ url('/login') }}";
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

        document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
            const passwordConfirmationField = document.getElementById('password_confirmation');
            const type = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationField.setAttribute('type', type);

            // Toggle ikon mata
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

    </script>
@endsection