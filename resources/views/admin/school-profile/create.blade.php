@extends('admin.main')

@section('content')
<main class="app-main">
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $title }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $title }}
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->
    
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline mb-4">
                        <form action="{{ route('school-profile.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                                    <input type="text" name="nama_sekolah" id="nama_sekolah" 
                                        class="form-control @error('nama_sekolah') is-invalid @enderror" 
                                        value="{{ old('nama_sekolah', $schoolProfile->nama_sekolah ?? '') }}" required>
                                    @error('nama_sekolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="npsn" class="form-label">NPSN</label>
                                    <input type="number" name="npsn" id="npsn" 
                                        class="form-control @error('npsn') is-invalid @enderror" 
                                        value="{{ old('npsn', $schoolProfile->npsn ?? '') }}" required>
                                    @error('npsn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="alamat_sekolah" class="form-label">Alamat Sekolah</label>
                                    <textarea name="alamat_sekolah" id="alamat_sekolah" 
                                        class="form-control @error('alamat_sekolah') is-invalid @enderror" required>{{ old('alamat_sekolah', $schoolProfile->alamat_sekolah ?? '') }}</textarea>
                                    @error('alamat_sekolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email_sekolah" class="form-label">Email Sekolah</label>
                                    <input type="email" name="email_sekolah" id="email_sekolah" 
                                        class="form-control @error('email_sekolah') is-invalid @enderror" 
                                        value="{{ old('email_sekolah', $schoolProfile->email_sekolah ?? '') }}" required>
                                    @error('email_sekolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="telepon_sekolah" class="form-label">Telepon Sekolah</label>
                                    <input type="text" name="telepon_sekolah" id="telepon_sekolah" 
                                        class="form-control @error('telepon_sekolah') is-invalid @enderror" 
                                        value="{{ old('telepon_sekolah', $schoolProfile->telepon_sekolah ?? '') }}" required>
                                    @error('telepon_sekolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="logo_sekolah" class="form-label">Logo Sekolah</label>
                                    <input type="file" class="form-control @error('logo_sekolah') is-invalid @enderror" id="logo_sekolah" name="logo_sekolah">
                                    @error('logo_sekolah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if(isset($schoolProfile->logo_sekolah))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $schoolProfile->logo_sekolah) }}" alt="Logo Sekolah" width="150">
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="call_center_1" class="form-label">Call Center 1</label>
                                    <input type="text" name="call_center_1" id="call_center_1" 
                                        class="form-control @error('call_center_1') is-invalid @enderror" 
                                        value="{{ old('call_center_1', $schoolProfile->call_center_1 ?? '') }}">
                                    @error('call_center_1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="call_center_2" class="form-label">Call Center 2</label>
                                    <input type="text" name="call_center_2" id="call_center_2" 
                                        class="form-control @error('call_center_2') is-invalid @enderror" 
                                        value="{{ old('call_center_2', $schoolProfile->call_center_2 ?? '') }}">
                                    @error('call_center_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="url" name="facebook" id="facebook" 
                                        class="form-control @error('facebook') is-invalid @enderror" 
                                        value="{{ old('facebook', $schoolProfile->facebook ?? '') }}">
                                    @error('facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="url" name="instagram" id="instagram" 
                                        class="form-control @error('instagram') is-invalid @enderror" 
                                        value="{{ old('instagram', $schoolProfile->instagram ?? '') }}">
                                    @error('instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="x" class="form-label">X</label>
                                    <input type="url" name="x" id="x" 
                                        class="form-control @error('x') is-invalid @enderror" 
                                        value="{{ old('x', $schoolProfile->x ?? '') }}">
                                    @error('x')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tiktok" class="form-label">TikTok</label>
                                    <input type="url" name="tiktok" id="tiktok" 
                                        class="form-control @error('tiktok') is-invalid @enderror" 
                                        value="{{ old('tiktok', $schoolProfile->tiktok ?? '') }}">
                                    @error('tiktok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Element -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastSuccess" class="toast toast-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header"> <i class="bi bi-circle me-2"></i> <strong class="me-auto">Success</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastDanger" class="toast toast-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header"> <i class="bi bi-circle me-2"></i> <strong class="me-auto">Error</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> </div>
        <div class="toast-body">
            {{ session('error') }}
        </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Show toast notification if session has 'success' or 'error'
    @if(session('success'))
    var toastSuccess = new bootstrap.Toast(document.getElementById('toastSuccess'));
    toastSuccess.show();
    @endif

    @if(session('error'))
    var toastError = new bootstrap.Toast(document.getElementById('toastError'));
    toastError.show();
    @endif
});
</script>
@endsection