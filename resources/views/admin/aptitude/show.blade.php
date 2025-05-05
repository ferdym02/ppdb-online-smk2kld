@extends('admin.main')

@section('css')
<link href="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
<main class="app-main">
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center">
                  <!-- Tombol ikon kembali -->
                    <a href="{{ session('aptitude_tests_url') }}" class="me-3">
                      <i class="fas fa-arrow-left"></i>
                    </a>
                    <h3 class="mb-0">{{ $title }}</h3>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('aptitudes.index') }}">Tes Minat Bakat</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
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
              <div class="col-12">
                <div class="card card-success card-outline">
                  <div class="card-body">
                    <div class="row">
                      <!-- Column 1 -->
                      <h5 class="text-center">Data Tes Minat Bakat</h5>
                      <div class="col-md-6">
                        <table class="table">
                          <tr>
                              <th>Periode Pendaftaran</th>
                              <td>: {{ $aptitudes->periode->tahun_pelajaran }}</td>
                          </tr>
                          <tr>
                              <th>Kuota Per Hari</th>
                              <td>: {{ $aptitudes->kuota_per_hari }}</td>
                          </tr>
                          <tr>
                              <th>Status</th>
                              <td>: {{ $aptitudes->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table">
                          <tr>
                              <th>Tanggal Buka Tes</th>
                              <td>: {{ \Carbon\Carbon::parse($aptitudes->tanggal_buka_tes)->format('d-m-Y') }}</td>
                          </tr>
                          <tr>
                              <th>Tanggal Tutup Tes</th>
                              <td>: {{ \Carbon\Carbon::parse($aptitudes->tanggal_tutup_tes)->format('d-m-Y') }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end::Row-->
            
            <!-- Filter Data Pendaftar -->
            <div class="row mt-4">
              <div class="col-12">
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">Data Pendaftar</h3>
                  </div>
                  <div class="card-body">
                    <form class="mb-5" method="GET" action="{{ route('aptitudes.show', $aptitudes->id) }}">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="tanggal_tes">Pilih Tanggal Tes</label>
                            <select name="tanggal_tes" id="tanggal_tes" class="form-control">
                              <option value="">Semua Tanggal</option>
                              @foreach (range(strtotime($aptitudes->tanggal_buka_tes), strtotime($aptitudes->tanggal_tutup_tes), 86400) as $date)
                                <option value="{{ date('Y-m-d', $date) }}" {{ $tanggalTes == date('Y-m-d', $date) ? 'selected' : '' }}>
                                  {{ date('d-m-Y', $date) }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="status_tes">Pilih Status Tes</label>
                            <select name="status_tes" id="status_tes" class="form-control">
                              <option value="">Semua Status</option>
                              <option value="belum" {{ $statusTes == 'belum' ? 'selected' : '' }}>Belum</option>
                              <option value="sudah" {{ $statusTes == 'sudah' ? 'selected' : '' }}>Sudah</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                          <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                      </div>
                    </form>
                    <table id="pendaftarTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">No</th>
                          <th class="text-center">Nomor Pendaftaran</th>
                          <th>Nama Lengkap</th>
                          <th class="text-center">L/P</th>
                          <th class="text-center">Tanggal Tes</th>
                          <th class="text-center">Status Tes</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#pendaftarTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ route('aptitudes.pendaftar', $aptitudes->id) }}",
        data: function (d) {
          d.tanggal_tes = $('#tanggal_tes').val();
          d.status_tes = $('#status_tes').val();
        }
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
        { data: 'nomor_pendaftaran', name: 'nomor_pendaftaran', className: 'text-center' },
        { data: 'nama_lengkap', name: 'nama_lengkap' },
        { data: 'jenis_kelamin', name: 'jenis_kelamin', className: 'text-center' },
        { data: 'tanggal_tes', name: 'tanggal_tes', className: 'text-center' },
        { data: 'status_tes', name: 'status_tes', className: 'text-center' },
        { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' },
      ],
      order: [[1, 'asc']],
    });

    // reload datatable saat filter berubah
    $('form').on('submit', function(e) {
      e.preventDefault();
      $('#pendaftarTable').DataTable().ajax.reload();
    });
  });
</script>
@endsection
