@extends('layouts.app')

@section('content')
<img src="{{ asset('images/smk2.png') }}" style="width: 100px; height: auto;" alt="Login Image">
<div class="login-container mt-3">
    <h2>Reset Password</h2>
    <p>Masukkan password baru Anda dan konfirmasi password.</p>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 14px;">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" style="font-size: 14px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Reset -->
    <form id="resetForm" method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Input Password -->
        <div class="form-floating position-relative mb-3">
            <input type="password" class="form-control" id="password" name="password" required placeholder="Password Baru">
            <label for="password">Password Baru</label>
            <div class="invalid-feedback" id="passwordFeedback"></div>
            
            <!-- Ikon Mata untuk Password -->
            <span class="position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;">
                <i class="bi bi-eye"></i>
            </span>
        </div>

        <!-- Input Konfirmasi Password -->
        <div class="form-floating position-relative mb-3">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Konfirmasi Password Baru">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <div class="invalid-feedback" id="passwordConfirmationFeedback"></div>
            
            <!-- Ikon Mata untuk Konfirmasi Password -->
            <span class="position-absolute top-50 end-0 translate-middle-y me-3" id="togglePasswordConfirmation" style="cursor: pointer;">
                <i class="bi bi-eye"></i>
            </span>
        </div>

        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>

    <div class="footer mt-3">
        <a href="/login">&larr; Kembali ke Login</a>
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
    document.getElementById('resetForm').addEventListener('submit', function() {
        document.querySelector('.loading-overlay').style.display = 'flex';
    });

    // Toggle visibility for password
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // Toggle ikon mata
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });

    // Toggle visibility for password confirmation
    document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
        const passwordField = document.getElementById('password_confirmation');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // Toggle ikon mata
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });
</script>
@endsection
