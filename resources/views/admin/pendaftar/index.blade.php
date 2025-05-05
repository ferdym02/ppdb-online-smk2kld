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
                    @php
                        $statusMapping = [
                            'pending' => 'Pending',
                            'verified' => 'Terverifikasi',
                            'rejected' => 'Perlu Perbaikan',
                            'diterima' => 'Lulus',
                            'gugur' => 'Tidak Lulus',
                            'cadangan' => 'Cadangan'
                        ];
                    @endphp
                    <div class="row mb-3">
                        <div class="col-md-3">
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

                    @if ($totalPending || $totalVerified || $totalRejected || $totalDiterima || $totalGugur || $totalCadangan)
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" style="width: 10%">No.</th>
                                        <th class="align-middle">Status Pendaftaran</th>
                                        <th class="text-center align-middle">Pendaftar</th>
                                        <th class="text-center align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data = [
                                            ['status' => 'pending', 'jumlah' => $totalPending, 'btnClass' => 'secondary'],
                                            ['status' => 'verified', 'jumlah' => $totalVerified, 'btnClass' => 'primary'],
                                            ['status' => 'rejected', 'jumlah' => $totalRejected, 'btnClass' => 'warning'],
                                            ['status' => 'diterima', 'jumlah' => $totalDiterima, 'btnClass' => 'success'],
                                            ['status' => 'gugur', 'jumlah' => $totalGugur, 'btnClass' => 'danger'],
                                            ['status' => 'cadangan', 'jumlah' => $totalCadangan, 'btnClass' => 'info'],
                                        ];
                                    @endphp

                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td class="text-center align-middle">{{ $index + 1 }}</td>
                                            <td class="align-middle">{{ $statusMapping[$item['status']] }}</td>
                                            <td class="text-center align-middle">{{ $item['jumlah'] }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('pendaftar.status', ['status' => $item['status'], 'periode_id' => $selectedPeriodId]) }}" class="btn btn-{{ $item['btnClass'] }}">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-start align-middle">Total Pendaftar:</th>
                                        <td class="text-center align-middle"><strong>{{ $totalPending + $totalVerified + $totalRejected + $totalDiterima + $totalGugur + $totalCadangan }}</strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
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
