@extends('user.layouts.app')
@section('css')
<style>
    .pengumuman-content img {
        width: 100%;
        height: auto;
        max-width: 100%;
        display: block;
        margin: 10px auto;
        object-fit: contain;
    }

    @media (min-width: 768px) {
        .pengumuman-content img {
            max-width: 500px;
        }
    }
</style>
@endsection
@section('content')
<div class="card mb-4 shadow-sm mt-3 mx-auto" style="max-width: 1000px;">
    <div class="card-header text-white d-flex align-items-center">
        <a href="{{ route('pengumumanUser') }}" class="btn me-2 p-0">
            <i class="fas fa-arrow-left"></i>
        </a>
        <p class="card-title mb-0">Detail Pengumuman</p>
    </div>
    <div class="card-body">
        <h4>{{ $pengumuman->judul }}</h4>
        <p class="text-muted">{{ $pengumuman->created_at->format('d M Y H:i') }}</p>
        
        <div class="mb-3 pengumuman-content">
            {!! $pengumuman->isi !!}
        </div>

        @if($pengumuman->file_lampiran)
            <div class="mt-3">
                <a href="{{ asset('storage/' . $pengumuman->file_lampiran) }}" class="btn btn-primary" download>
                    <i class="fas fa-download"></i> Download Lampiran
                </a>
            </div>
        @endif
    </div>
</div>
@endsection