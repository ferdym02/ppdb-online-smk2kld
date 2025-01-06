@extends('user.layouts.app')

@section('content')

<div class="card mb-4 shadow-sm mt-3">
    <div class="card-header text-white">
        <h5 class="card-title mb-0">Pengumuman</h5>
    </div>
    <div class="card-body">
        @foreach($pengumumans as $pengumuman)
            <p>{{ $loop->iteration }}. <a href="{{ asset('storage/'.$pengumuman->file_lampiran) }}" download>{{ $pengumuman->judul }}</a></p>
        @endforeach
    </div>
</div>

@endsection
