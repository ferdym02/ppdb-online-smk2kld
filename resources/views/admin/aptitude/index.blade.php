@extends('admin.main')

@section('css')
<link href="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.css" rel="stylesheet">
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
      <div class="row">
        <div class="col-12">
          <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Data</button>
          <div class="card">
            <div class="card-body">
              <table id="aptitude-tests-table" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Periode Pendaftaran</th>
                    <th class="text-center">Tanggal Buka Tes</th>
                    <th class="text-center">Tanggal Tutup Tes</th>
                    <th class="text-center">Kuota Per Hari</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($aptitudes as $index => $aptitude)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="text-center">{{ $aptitude->periode->tahun_pelajaran }}</td>
                      <td class="text-center">{{ \Carbon\Carbon::parse($aptitude->tanggal_buka_tes)->format('d/m/Y') }}</td>
                      <td class="text-center">{{ \Carbon\Carbon::parse($aptitude->tanggal_tutup_tes)->format('d/m/Y') }}</td>                      
                      <td class="text-center">{{ $aptitude->kuota_per_hari }}</td>
                      <td class="text-center">{{ $aptitude->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                      <td class="text-center">
                        <button class="btn btn-warning btn-edit btn-sm" data-id="{{ $aptitude->id }}" 
                          data-periode="{{ $aptitude->periode_id }}" 
                          data-tanggal-buka="{{ $aptitude->tanggal_buka_tes }}" 
                          data-tanggal-tutup="{{ $aptitude->tanggal_tutup_tes }}" 
                          data-kuota="{{ $aptitude->kuota_per_hari }}" 
                          data-status="{{ $aptitude->status }}" 
                          data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                        <form action="{{ route('aptitudes.destroy', $aptitude->id) }}" method="POST" style="display:inline-block;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="createForm" method="POST" action="{{ route('aptitudes.store') }}">
          @csrf
          <input type="hidden" name="form_action" value="create">
          <div class="modal-header">
            <h5 class="modal-title" id="createModalLabel">Tambah Data Tes Minat Bakat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="periode_id" class="form-label">Periode Pendaftaran</label>
              <select class="form-control @error('periode_id') is-invalid @enderror" id="periode_id" name="periode_id" required>
                <option value="" disabled selected>Pilih Periode</option>
                @foreach($periodes as $periode)
                  <option value="{{ $periode->id }}" {{ old('periode_id') == $periode->id ? 'selected' : '' }}>
                    {{ $periode->tahun_pelajaran }}
                  </option>
                @endforeach
              </select>
              @error('periode_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="tanggal_buka_tes" class="form-label">Tanggal Buka Tes</label>
              <input type="date" name="tanggal_buka_tes" id="tanggal_buka_tes" 
                     class="form-control @error('tanggal_buka_tes') is-invalid @enderror" 
                     value="{{ old('tanggal_buka_tes') }}" required>
              @error('tanggal_buka_tes')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="tanggal_tutup_tes" class="form-label">Tanggal Tutup Tes</label>
              <input type="date" name="tanggal_tutup_tes" id="tanggal_tutup_tes" 
                     class="form-control @error('tanggal_tutup_tes') is-invalid @enderror" 
                     value="{{ old('tanggal_tutup_tes') }}" required>
              @error('tanggal_tutup_tes')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="kuota_per_hari" class="form-label">Kuota Per Hari</label>
              <input type="number" name="kuota_per_hari" id="kuota_per_hari" 
                     class="form-control @error('kuota_per_hari') is-invalid @enderror" 
                     value="{{ old('kuota_per_hari') }}" required>
              @error('kuota_per_hari')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih status</option>
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Kirim</button>
          </div>
        </form>        
      </div>
    </div>
  </div>

  <!-- Modal Edit -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editForm" method="POST" action="{{ old('action_url', '') }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="form_action" value="edit">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Data Tes Minat Bakat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_periode_id" class="form-label">Periode Pendaftaran</label>
              <select class="form-control @error('periode_id') is-invalid @enderror" id="edit_periode_id" name="periode_id" required>
                <option value="" disabled {{ old('periode_id') ? '' : 'selected' }}>Pilih Periode</option>
                @foreach($periodes as $periode)
                  <option value="{{ $periode->id }}" {{ old('periode_id') == $periode->id ? 'selected' : '' }}>
                    {{ $periode->tahun_pelajaran }}
                  </option>
                @endforeach
              </select>
              @error('periode_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="edit_tanggal_buka_tes" class="form-label">Tanggal Buka Tes</label>
              <input type="date" name="tanggal_buka_tes" id="edit_tanggal_buka_tes" 
                    class="form-control @error('tanggal_buka_tes') is-invalid @enderror"
                    value="{{ old('tanggal_buka_tes') }}" required>
              @error('tanggal_buka_tes')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="edit_tanggal_tutup_tes" class="form-label">Tanggal Tutup Tes</label>
              <input type="date" name="tanggal_tutup_tes" id="edit_tanggal_tutup_tes" 
                    class="form-control @error('tanggal_tutup_tes') is-invalid @enderror"
                    value="{{ old('tanggal_tutup_tes') }}" required>
              @error('tanggal_tutup_tes')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="edit_kuota_per_hari" class="form-label">Kuota Per Hari</label>
              <input type="number" name="kuota_per_hari" id="edit_kuota_per_hari" 
                    class="form-control @error('kuota_per_hari') is-invalid @enderror"
                    value="{{ old('kuota_per_hari') }}" required>
              @error('kuota_per_hari')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="edit_status" class="form-label">Status</label>
              <select name="status" id="edit_status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih status</option>
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Perbarui</button>
          </div>
        </form>
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
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#aptitude-tests-table').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      lengthChange: true,
      autoWidth: false,
    });

    $('#aptitude-tests-table').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var periode = $(this).data('periode');
        var tanggalBuka = $(this).data('tanggal-buka');
        var tanggalTutup = $(this).data('tanggal-tutup');
        var kuota = $(this).data('kuota');
        var status = $(this).data('status');

        $('#editForm').attr('action', '/admin/aptitudes/' + id);
        $('#edit_periode_id').val(periode);
        $('#edit_tanggal_buka_tes').val(tanggalBuka);
        $('#edit_tanggal_tutup_tes').val(tanggalTutup);
        $('#edit_kuota_per_hari').val(kuota);
        $('#edit_status').val(status);
    });

    // Handle delete confirmation with SweetAlert
    $('#aptitude-tests-table').on('click', '.btn-danger', function(e) {
      e.preventDefault();

      var form = $(this).closest('form');

      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        customClass: {
        confirmButton: 'btn btn-danger me-1', // Tombol konfirmasi menjadi merah
        cancelButton: 'btn btn-secondary' // Tombol batal menjadi abu-abu
        },
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  @if ($errors->any())
      document.addEventListener('DOMContentLoaded', function() {
          @if (old('form_action') === 'create')
              // Tampilkan modal create
              var createModal = new bootstrap.Modal(document.getElementById('createModal'));
              createModal.show();
          @elseif (old('form_action') === 'edit')
              // Tampilkan modal edit
              var editModal = new bootstrap.Modal(document.getElementById('editModal'));
              editModal.show();

              // Tambahkan action URL jika tidak ada
              var actionUrl = "{{ old('action_url', '') }}";
              if (actionUrl) {
                  document.getElementById('editForm').setAttribute('action', actionUrl);
              }
          @endif
      });
  @endif

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
