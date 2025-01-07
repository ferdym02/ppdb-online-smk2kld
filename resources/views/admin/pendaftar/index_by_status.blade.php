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
            <a href="{{ session('index_url') }}" class="me-3">
              <i class="fas fa-arrow-left"></i>
            </a>
            <h3 class="mb-0">{{ $title }} {{ ucfirst($status) }}</h3>
        </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    {{ $title }} {{ ucfirst($status) }}
                  </li>
              </ol>
          </div>
      </div> <!--end::Row-->
    </div> <!--end::Container-->
  </div> <!--end::App Content Header-->

  <div class="app-content">
      <div class="container-fluid">
        @if ($status === 'diterima') <!-- Filter hanya muncul jika status "diterima" -->
<div class="row mb-3">
  <div class="col-md-3">
    <select id="filterDaftarUlang" class="form-select">
      <option value="">Semua Status Daftar Ulang</option>
      <option value="ya">Sudah Daftar Ulang</option>
      <option value="null">Belum Daftar Ulang</option>
    </select>
  </div>
</div>
@endif

          <div class="row">
              <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <table id="pendaftar-status-table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nomor Pendaftaran</th>
                                <th class="text-center">NISN</th>
                                <th>Nama Lengkap</th>
                                <th class="text-center">L/P</th>
                                <th>Asal Sekolah</th>
                                <th class="text-center">Tanggal Pendaftaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
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
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.js"></script>
<script>
  $(document).ready(function () {
    const table = $('#pendaftar-status-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('pendaftar.status.data', $status) }}",
            data: function (d) {
                d.daftar_ulang = $('#filterDaftarUlang').val(); // Kirim nilai filter daftar_ulang
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'nomor_pendaftaran', name: 'nomor_pendaftaran', className: 'text-center' },
            { data: 'nisn', name: 'nisn', className: 'text-center' },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            {
              data: 'jenis_kelamin',
              name: 'jenis_kelamin',
              className: 'text-center'
            },
            { data: 'asal_sekolah', name: 'asal_sekolah' },
            { data: 'tanggal_pendaftaran', name: 'tanggal_pendaftaran', className: 'text-center' },
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data) {
                    return `<a href="/admin/pendaftar/${data}" class="btn btn-sm btn-primary">Detail</a>`;
                }
            }
        ]
    });

    // Event listener untuk filter
    $('#filterDaftarUlang').on('change', function () {
        table.ajax.reload(); // Reload data tabel dengan parameter filter baru
    });
});


  // Show toast notification if session has 'success' or 'error'
  @if(session('success'))
    var toastSuccess = new bootstrap.Toast(document.getElementById('toastSuccess'));
    toastSuccess.show();
  @endif

  @if(session('error'))
    var toastError = new bootstrap.Toast(document.getElementById('toastDanger'));
    toastError.show();
  @endif
</script>

@endsection
