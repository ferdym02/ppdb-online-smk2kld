@extends('layouts.app')

@section('content')
<img src="{{ asset('images/smk2.png') }}" style="width: 100px; height: auto;" alt="Login Image">
<div class="login-container mt-3">
    <h2>Lupa Password</h2>
    <p>Masukkan email Anda untuk menerima link reset password.</p>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert" style="font-size: 14px;">
            <div>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert" style="font-size: 14px;">
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Reset -->
    <form id="resetForm" method="POST" action="{{ route('forgot.password.act') }}">
        @csrf
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" required placeholder="name@example.com">
            <label for="email">Email</label>
            <div class="invalid-feedback" id="emailFeedback"></div>
        </div>         
        <button type="submit" class="btn w-100 mb-3 text-white btn-login">Kirim Link Reset Password</button>
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
</script>
@endsection
