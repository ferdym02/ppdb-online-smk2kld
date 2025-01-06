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
              <option value="" selected disabled>Periode Pendaftaran</option>
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
              <option value="" selected disabled>Jurusan</option>
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
              <option value="" selected disabled>Status</option>
              @foreach($status_pendaftaran as $status)
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
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
  
      <!-- Tombol Cetak PDF dan Tabel -->
      <div class="row mb-3">
        <div class="col-12">
          <a href="{{ route('laporan.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Laporan PDF
          </a>
          <a href="{{ route('laporan.word') }}" class="btn btn-primary mx-1">
            <i class="bi bi-file-earmark-word"></i> Laporan Word
          </a>
          <a href="{{ route('laporan.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Laporan Excel
          </a>
        </div>
      </div>
  
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="pendaftar-table" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Nomor Pendaftaran</th>
                    <th class="text-center">NISN</th>
                    <th>Nama Lengkap</th>
                    <th class="text-center">L/P</th>
                    <th>Asal Sekolah</th>
                    <th>Status Pendaftaran</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="card-footer">
              <a href="{{ route('laporan.pdfDiterima') }}" class="btn btn-danger mb-3">
                <i class="bi bi-file-earmark-pdf"></i> Cetak PDF Pendaftar Diterima
              </a>
              <a href="{{ route('laporan.wordDiterima') }}" class="btn btn-primary mb-3 mx-1">
                <i class="bi bi-file-earmark-word"></i> Cetak Word Pendaftar Diterima
              </a>            
              <a href="{{ route('laporan.excelDiterima') }}" class="btn btn-success mb-3">
                <i class="bi bi-file-earmark-excel"></i> Cetak Excel Pendaftar Diterima
              </a>        
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
      format: 'yyyy-mm-dd',
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
        className: 'text-center'
      },
      { data: 'nomor_pendaftaran', name: 'nomor_pendaftaran', className: 'text-center', },
      { data: 'nisn', name: 'nisn', className: 'text-center', },
      { data: 'nama_lengkap', name: 'nama_lengkap' },
      { 
          data: 'jenis_kelamin', 
          name: 'jenis_kelamin',
          render: function(data, type, row) {
              return data === 'Laki-Laki' ? 'L' : 'P';
          },
          className: 'text-center'
      },
      { data: 'asal_sekolah', name: 'asal_sekolah' },
      { 
        data: 'status_pendaftaran', 
        name: 'status_pendaftaran',
        render: function(data, type, row) {
          if (data) {
            return data.charAt(0).toUpperCase() + data.slice(1).toLowerCase();
          }
          return data;
        } 
      }
    ]
  });


    $('#filter').click(function() {
      table.draw();
    });
  });
</script>
@endsection
