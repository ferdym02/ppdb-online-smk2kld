@extends('layouts.app')

@section('content')
<img src="{{ asset('images/smk2.png') }}" style="width: 100px; height: auto;" alt="SMKN 2 Kalianda">
<div class="login-container mt-3">
    <h2>Verifikasi Email</h2>
    <p>Terima kasih telah mendaftar! Sebelum melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirim ke email Anda.</p>
    <p>Jika Anda belum menerima email tersebut, klik tombol di bawah ini untuk mengirim ulang tautan verifikasi.</p>

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert" style="font-size: 14px;">
            <div>{{ session('message') }}</div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form untuk mengirim ulang email verifikasi -->
    <form id="resendForm" method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn w-100 mb-3 text-white btn-login">Kirim Ulang Email Verifikasi</button>
    </form>

    <div class="footer mt-3">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            &larr; Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
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
    // Tampilkan overlay loading saat form dikirim
    document.getElementById('resendForm').addEventListener('submit', function() {
        document.querySelector('.loading-overlay').style.display = 'flex';
    });
</script>
@endsection
