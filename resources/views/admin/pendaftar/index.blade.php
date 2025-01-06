@extends('admin.main')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $title }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <!-- Dropdown untuk memilih periode -->
                            <form method="GET" action="{{ route('admin.pendaftar.index') }}">
                                <div class="form-group">
                                    <label for="periode_id">Periode Pendaftaran:</label>
                                    <select name="periode_id" id="periode_id" class="form-control" onchange="this.form.submit()">
                                        <option value="" selected disabled>-- Pilih Periode Pendaftaran --</option>
                                        @foreach ($periodes as $periode)
                                            <option value="{{ $periode->id }}" {{ $selectedPeriodId == $periode->id ? 'selected' : '' }}>
                                                {{ $periode->tahun_pelajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tampilkan data jika ada -->
                    @if ($totalPending || $totalVerified || $totalRejected || $totalDiterima || $totalGugur || $totalCadangan)
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 10%">No.</th>
                                        <th>Status Pendaftaran</th>
                                        <th class="text-center">Total Pendaftar</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Pending</td>
                                        <td class="text-center">{{ $totalPending }}</td>
                                        <td class="text-center"><a href="{{ route('pendaftar.status', ['status' => 'pending', 'periode_id' => $selectedPeriodId]) }}" class="btn btn-secondary">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Diverifikasi</td>
                                        <td class="text-center">{{ $totalVerified }}</td>
                                        <td class="text-center"><a href="{{ route('pendaftar.status', ['status' => 'verified', 'periode_id' => $selectedPeriodId]) }}" class="btn btn-primary">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>Ditolak</td>
                                        <td class="text-center">{{ $totalRejected }}</td>
                                        <td class="text-center"><a href="{{ route('pendaftar.status', ['status' => 'rejected', 'periode_id' => $selectedPeriodId]) }}" class="btn btn-warning">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td>Diterima</td>
                                        <td class="text-center">{{ $totalDiterima }}</td>
                                        <td class="text-center"><a href="{{ route('pendaftar.status', ['status' => 'diterima', 'periode_id' => $selectedPeriodId]) }}" class="btn btn-success">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">5</td>
                                        <td>Gugur</td>
                                        <td class="text-center">{{ $totalGugur }}</td>
                                        <td class="text-center"><a href="{{ route('pendaftar.status', ['status' => 'gugur', 'periode_id' => $selectedPeriodId]) }}" class="btn btn-danger">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">6</td>
                                        <td>Cadangan</td>
                                        <td class="text-center">{{ $totalCadangan }}</td>
                                        <td class="text-center"><a href="{{ route('pendaftar.status', ['status' => 'cadangan', 'periode_id' => $selectedPeriodId]) }}" class="btn btn-info">Detail</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Belum ada data pendaftar untuk periode yang dipilih.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
