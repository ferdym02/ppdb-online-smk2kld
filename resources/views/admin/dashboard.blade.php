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
                            Info lengkap <i class="bi bi-link-45deg"></i>
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
                            <p>Pendaftar Lulus</p>
                        </div>
                        <i class="fa fa-check small-box-icon"></i>
                        <a href="{{ route('admin.pendaftar.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Info lengkap <i class="bi bi-link-45deg"></i>
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
                            <p>Pendaftar Tidak Lulus</p>
                        </div>
                        <i class="fa fa-times small-box-icon"></i>
                        <a href="{{ route('admin.pendaftar.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Info lengkap <i class="bi bi-link-45deg"></i>
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
                            Info lengkap <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                    <!--end::Small Box Widget 4-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <div class="row">
                <!-- Diagram Line (Lebih Lebar) -->
                <div class="col-md-8">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Pendaftar</h3>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 300px;">
                            <canvas id="pendaftarChart"></canvas>
                        </div>
                    </div>
                </div>
            
                <!-- Diagram Gender (Lebih Kecil) -->
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Pendaftar (L/P) Tahun {{ $tahunSekarang }}</h3>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 300px;">
                            <canvas id="genderChart"></canvas>
                        </div>                        
                    </div>
                </div>
            </div>
            
            <div class="card my-3">
                <div class="card-body text-center">
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let tahun = {!! json_encode(array_keys($pendaftarPerTahun)) !!}; // Tahun
            let jumlahPendaftar = {!! json_encode(array_values($pendaftarPerTahun)) !!}; // Total pendaftar
            let jumlahDiterima = {!! json_encode(array_values($diterimaPerTahun)) !!}; // Total diterima
            let jumlahGugur = {!! json_encode(array_values($gugurPerTahun)) !!}; // Total gugur
    
            let ctx = document.getElementById('pendaftarChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: tahun, // Tahun sebagai label sumbu X
                    datasets: [
                        {
                            label: 'Total Pendaftar',
                            data: jumlahPendaftar, 
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            fill: true
                        },
                        {
                            label: 'Lulus',
                            data: jumlahDiterima, 
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Tidak Lulus',
                            data: jumlahGugur, 
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 2,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 25 
                        }
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('genderChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [{{ $totalLakiLaki }}, {{ $totalPerempuan }}],
                        backgroundColor: ['#36A2EB', '#FF6384']
                    }]
                }
            });
        });
    </script>
@endsection