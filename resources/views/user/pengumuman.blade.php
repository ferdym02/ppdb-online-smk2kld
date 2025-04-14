@extends('user.layouts.app')

@section('content')

<div class="card mb-4 shadow-sm mt-3 mx-auto" style="max-width: 750px;">
    <div class="card-header text-white d-flex align-items-center">
        <p class="card-title mb-0">Pengumuman</p>
    </div>
    <div class="card-body">
        @forelse($pengumumans as $pengumuman)
            <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                <i class="fas fa-bullhorn text-primary me-2"></i> <!-- Ikon Pengumuman -->
                <p class="mb-0">
                    <strong>{{ $loop->iteration }}.</strong> 
                    <a href="{{ route('pengumumanUser.show', $pengumuman->id) }}" class="text-decoration-none">
                        {{ $pengumuman->judul }}
                    </a>
                </p>
            </div>
        @empty
            <p class="text-muted text-center">Belum ada pengumuman.</p>
        @endforelse
    </div>
</div>

@endsection
