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
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
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