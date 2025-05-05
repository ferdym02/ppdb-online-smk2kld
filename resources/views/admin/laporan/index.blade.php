@extends('admin.main')

@section('css')
<link href="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endsection

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
            <li class="breadcrumb-item active" aria-current="page">
              {{ $title }}
            </li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <!-- Baris 1: Filter Periode, Start Date, End Date -->
      <div class="row mb-3">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
            <select class="form-control" id="periode" placeholder="Periode">
              <option value="" selected>Semua Periode Pendaftaran</option>
              @foreach($periodes as $periode)
                <option value="{{ $periode->id }}" {{ $periode->is_active ? 'selected' : '' }}>
                  {{ $periode->tahun_pelajaran }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
  
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
            <input type="text" class="form-control datepicker" id="start_date" placeholder="Dari tanggal">
          </div>
        </div>
  
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
            <input type="text" class="form-control datepicker" id="end_date" placeholder="Sampai tanggal">
          </div>
        </div>
      </div>
  
      <!-- Baris 2: Filter Jurusan, Jurusan Diterima, Tombol Filter -->
      <div class="row mb-3">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-book"></i></span>
            <select class="form-control" id="jurusan">
              <option value="" selected>Semua Jurusan</option>
              @foreach($jurusans as $jurusan)
                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
              <span class="input-group-text"><i class="bi bi-flag"></i></span>
              <select class="form-control" id="status_pendaftaran">
                  <option value="" selected>Semua Status</option>
                  @foreach($status_pendaftaran as $status)
                      <option value="{{ $status }}">
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
                          {{ $statusMapping[strtolower($status)] ?? ucfirst($status) }}
                      </option>
                  @endforeach
              </select>
          </div>
        </div>      
        
        <div class="col-md-4">
          <button class="btn btn-primary w-100" id="filter">
            <i class="bi bi-funnel"></i> Filter
          </button>
        </div>
      </div>
  
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-end">
              <a href="#" id="cetak-pdf" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Laporan PDF
              </a>
              <a href="#" id="cetak-excel" class="btn btn-success ms-1">
                <i class="bi bi-file-earmark-excel"></i> Laporan Excel
              </a>            
            </div>
            <div class="card-body">
              <table id="pendaftar-table" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">No. Pendaftaran</th>
                    <th class="text-center">NISN</th>
                    <th>Nama Lengkap</th>
                    <th class="text-center">L/P</th>
                    <th>Asal Sekolah</th>
                    <th>Status Pendaftaran</th>
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
</main>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
  $(document).ready(function() {
    $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
    });

    var table = $('#pendaftar-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('laporan.getData') }}",
        data: function(d) {
          d.periode = $('#periode').val();
          d.start_date = $('#start_date').val();
          d.end_date = $('#end_date').val();
          d.jurusan = $('#jurusan').val();
          d.status_pendaftaran = $('#status_pendaftaran').val();
        }
      },
      columns: [
        {
          data: null,
          name: 'nomor',
          render: function (data, type, row, meta) {
            return meta.row + 1;
          },
          orderable: false,
          searchable: false,
          width: '5%',
          className: 'text-center align-middle'
        },
        { data: 'nomor_pendaftaran', name: 'nomor_pendaftaran', className: 'text-center align-middle', },
        { data: 'nisn', name: 'nisn', className: 'text-center align-middle', },
        { data: 'nama_lengkap', name: 'nama_lengkap', className: 'align-middle', },
        { 
            data: 'jenis_kelamin', 
            name: 'jenis_kelamin',
            render: function(data, type, row) {
                return data === 'Laki-laki' ? 'L' : 'P';
            },
            className: 'text-center align-middle'
        },
        { data: 'asal_sekolah', name: 'asal_sekolah', className: 'align-middle', },
        { 
          data: 'status_pendaftaran', 
          name: 'status_pendaftaran',
          render: function(data, type, row) {
            var statusMapping = {
                'pending': { label: 'Pending', class: 'badge bg-secondary' },
                'verified': { label: 'Terverifikasi', class: 'badge bg-primary' },
                'rejected': { label: 'Perlu Perbaikan', class: 'badge bg-warning text-dark' },
                'diterima': { label: 'Lulus', class: 'badge bg-success' },
                'gugur': { label: 'Tidak Lulus', class: 'badge bg-danger' },
                'cadangan': { label: 'Cadangan', class: 'badge bg-info text-dark' }
            };
            var status = statusMapping[data.toLowerCase()];
            return status ? `<span class="${status.class}">${status.label}</span>` : data
          },
          className: 'align-middle',
        },
        {
          data: 'id',
          name: 'aksi',
          orderable: false,
          searchable: false,
          className: 'text-center align-middle',
          render: function(data, type, row, meta) {
            return `<a href="/admin/pendaftar/${data}" class="btn btn-sm btn-info">
                      <i class="bi bi-eye"></i>
                    </a>`;
          }
        }
      ]
    });

    $('#filter').click(function() {
      table.draw();
    });

    $('#cetak-pdf').click(function(e) {
        e.preventDefault();
        var periode = $('#periode').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var jurusan = $('#jurusan').val();
        var status_pendaftaran = $('#status_pendaftaran').val();

        var url = "{{ route('laporan.pdf') }}?periode=" + periode + 
                  "&start_date=" + start_date + 
                  "&end_date=" + end_date + 
                  "&jurusan=" + jurusan + 
                  "&status_pendaftaran=" + status_pendaftaran;

        window.location.href = url;
    });

    $('#cetak-excel').click(function(e) {
        e.preventDefault();
        var periode = $('#periode').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var jurusan = $('#jurusan').val();
        var status_pendaftaran = $('#status_pendaftaran').val();

        var url = "{{ route('laporan.excel') }}?periode=" + periode + 
                  "&start_date=" + start_date + 
                  "&end_date=" + end_date + 
                  "&jurusan=" + jurusan + 
                  "&status_pendaftaran=" + status_pendaftaran;

        window.location.href = url;
    }); 
  });
</script>
@endsection
