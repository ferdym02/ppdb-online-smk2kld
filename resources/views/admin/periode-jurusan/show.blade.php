@extends('admin.main')

@section('css')
<link href="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 d-flex align-items-center">
          <a href="{{ route('periode-jurusan.index', ['periode_id' => $periodeJurusan->periode_id]) }}" class="me-3">
            <i class="fas fa-arrow-left"></i>
          </a>
          <h3 class="mb-0">{{ $title }}</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">

      <div class="card card-secondary card-outline">
        <div class="card-body">
          <div class="row">
            <!-- Column 1 -->
            <h5 class="text-center">Informasi Kuota Jurusan</h5>
            <div class="col-md-6">
              <table class="table">
                <tr>
                    <th>Periode Pendaftaran</th>
                    <td>: {{ $periodeJurusan->periode->tahun_pelajaran }}</td>
                </tr>
                <tr>
                    <th>Jurusan</th>
                    <td>: {{ $periodeJurusan->jurusan->nama }}</td>
                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table">
                <tr>
                    <th>Kuota Jurusan</th>
                    <td>: {{ $periodeJurusan->kuota + $periodeJurusan->terpakai }}</td>
                </tr>
                <tr>
                    <th>Kuota Jurusan Terpakai</th>
                    <td>: {{ $periodeJurusan->terpakai }}</td>
                </tr>
                <tr>
                    <th>Kuota Jurusan Tersedia</th>
                    <td>: {{ $periodeJurusan->kuota }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h4 class="card-title">Pendaftar Diterima di Jurusan {{ $periodeJurusan->jurusan->nama }}</h4>
            </div>
            <div class="card-body">
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
              @if($pendaftarDiterima->isEmpty())
                <p class="text-muted text-center m-0">Belum ada pendaftar yang diterima di jurusan ini.</p>
              @else
              <div class="table-responsive">
                <table id="dataTablePendaftar" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th class="text-center">No. Pendaftaran</th>
                      <th>Nama Lengkap</th>
                      <th>Asal Sekolah</th>
                      <th class="text-center">L/P</th>
                      <th>Status Pendaftaran</th>
                      <th class="text-center">Tanggal Daftar</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pendaftarDiterima as $index => $pendaftar)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="text-center">{{ $pendaftar->nomor_pendaftaran }}</td>
                      <td>{{ $pendaftar->nama_lengkap }}</td>
                      <td>{{ $pendaftar->asal_sekolah }}</td>
                      <td class="text-center">{{ $pendaftar->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                      <td>{{ $statusMapping[$pendaftar->status_pendaftaran] ?? '-' }}</td>
                      <td class="text-center">{{ $pendaftar->created_at->format('d-m-Y') }}</td>
                      <td class="text-center">
                        <a href="{{ route('admin.pendaftar.show', $pendaftar->id) }}" class="btn btn-sm btn-info">
                          Detail
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#dataTablePendaftar').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      lengthChange: true,
      autoWidth: false,
    });
  });
</script>
@endsection