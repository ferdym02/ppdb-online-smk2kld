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

    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 1-->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ $totalPendaftar }}</h3>
                            <p>Jumlah Pendaftar</p>
                        </div>
                        <i class="fa fa-users small-box-icon"></i>
                        <a href="{{ route('admin.pendaftar.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 1-->
                </div>
                <!--end::Col-->
                
                <!--begin::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 2-->
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ $totalDiterima }}</h3>
                            <p>Pendaftar Diterima</p>
                        </div>
                        <i class="fa fa-check small-box-icon"></i>
                        <a href="{{ route('pendaftar.status', 'diterima') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 2-->
                </div>
                <!--end::Col-->
                
                <!--begin::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 3-->
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{ $totalGugur }}</h3>
                            <p>Pendaftar Gugur</p>
                        </div>
                        <i class="fa fa-times small-box-icon"></i>
                        <a href="{{ route('pendaftar.status', 'gugur') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 3-->
                </div>
                <!--end::Col-->
                
                <!--begin::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3>{{ $totalJurusan }}</h3>
                            <p>Jumlah Jurusan</p>
                        </div>
                        <i class="fas fa-list small-box-icon"></i>
                        <a href="{{ route('jurusan.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 4-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!-- Informasi Sekolah -->
            <div class="row justify-content-center my-3">
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('storage/' . $schoolProfile->logo_sekolah) }}" alt="Logo Sekolah" class="img-fluid mb-1" style="max-width: 100px;">
                    <h4>{{ $schoolProfile->nama_sekolah }}</h4>
                    <p class="mb-0">{{ $schoolProfile->alamat_sekolah }}</p>
                    <p class="mb-0">{{ $schoolProfile->email_sekolah }}</p>
                    <p>NPSN: {{ $schoolProfile->npsn }}</p>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
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
        @if(session('error'))
            var toastError = new bootstrap.Toast(document.getElementById('toastDanger'));
            toastError.show();
        @endif
    </script>
@endsection