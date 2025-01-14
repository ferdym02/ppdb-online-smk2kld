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
              <table id="periode-table" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Tahun Pelajaran</th>
                    <th class="text-center">Tanggal Buka</th>
                    <th class="text-center">Tanggal Tutup</th>
                    <th class="text-center">Kuota Penerimaan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($periodes as $index => $periode)
                  <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $periode->tahun_pelajaran }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($periode->tanggal_buka)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($periode->tanggal_tutup)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $periode->kuota_penerimaan }}</td>
                    <td class="text-center">{{ $periode->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td class="text-center">
                      <a href="{{ route('periodes.show', $periode->id) }}" class="btn btn-info btn-sm">Detail</a>
                      <!-- Tambahkan tombol aksi (edit/delete) sesuai kebutuhan -->
                      <button class="btn btn-warning btn-sm edit-btn" data-periode="{{ $periode }}">Edit</button>
                      <form method="POST" action="{{ route('periodes.destroy', $periode->id) }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
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

  <!-- Create Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createForm" method="POST" action="{{ route('periodes.store') }}">
                @csrf
                <input type="hidden" name="form_action" value="create">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Data Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                        <input 
                            type="text" 
                            class="form-control @error('tahun_pelajaran') is-invalid @enderror" 
                            id="tahun_pelajaran" 
                            name="tahun_pelajaran" 
                            value="{{ old('tahun_pelajaran') }}" 
                            required>
                        @error('tahun_pelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_buka" class="form-label">Tanggal Buka</label>
                        <input 
                            type="date" 
                            class="form-control @error('tanggal_buka') is-invalid @enderror" 
                            id="tanggal_buka" 
                            name="tanggal_buka" 
                            value="{{ old('tanggal_buka') }}" 
                            required>
                        @error('tanggal_buka')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_tutup" class="form-label">Tanggal Tutup</label>
                        <input 
                            type="date" 
                            class="form-control @error('tanggal_tutup') is-invalid @enderror" 
                            id="tanggal_tutup" 
                            name="tanggal_tutup" 
                            value="{{ old('tanggal_tutup') }}" 
                            required>
                        @error('tanggal_tutup')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kuota_penerimaan" class="form-label">Kuota Penerimaan</label>
                        <input 
                            type="number" 
                            class="form-control @error('kuota_penerimaan') is-invalid @enderror" 
                            id="kuota_penerimaan" 
                            name="kuota_penerimaan" 
                            value="{{ old('kuota_penerimaan') }}" 
                            required>
                        @error('kuota_penerimaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select 
                            class="form-control @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status" 
                            required>
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

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST" action="{{ isset($periode) ? route('periodes.update', $periode->id) : '#' }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_action" value="edit">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                        <input 
                            type="text" 
                            class="form-control @error('tahun_pelajaran') is-invalid @enderror" 
                            id="edit_tahun_pelajaran" 
                            name="tahun_pelajaran" 
                            value="{{ old('tahun_pelajaran') }}" 
                            required>
                        @error('tahun_pelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_buka" class="form-label">Tanggal Buka</label>
                        <input 
                            type="date" 
                            class="form-control @error('tanggal_buka') is-invalid @enderror" 
                            id="edit_tanggal_buka" 
                            name="tanggal_buka" 
                            value="{{ old('tanggal_buka') }}" 
                            required>
                        @error('tanggal_buka')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_tutup" class="form-label">Tanggal Tutup</label>
                        <input 
                            type="date" 
                            class="form-control @error('tanggal_tutup') is-invalid @enderror" 
                            id="edit_tanggal_tutup" 
                            name="tanggal_tutup" 
                            value="{{ old('tanggal_tutup') }}" 
                            required>
                        @error('tanggal_tutup')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_kuota_penerimaan" class="form-label">Kuota Penerimaan</label>
                        <input 
                            type="number" 
                            class="form-control @error('kuota_penerimaan') is-invalid @enderror" 
                            id="edit_kuota_penerimaan" 
                            name="kuota_penerimaan" 
                            value="{{ old('kuota_penerimaan') }}" 
                            required>
                        @error('kuota_penerimaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select 
                            class="form-control @error('status') is-invalid @enderror" 
                            id="edit_status" 
                            name="status" 
                            required>
                            <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih status</option>
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
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#periode-table').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      lengthChange: true,
      autoWidth: true,
    });

    // Handle edit button click
    $('#periode-table').on('click', '.edit-btn', function() {
      var url = $(this).data('url');
      var data = $(this).data('periode');
      
      $('#editForm').attr('action', url);
      $('#edit_tahun_pelajaran').val(data.tahun_pelajaran);
      $('#edit_tanggal_buka').val(data.tanggal_buka);
      $('#edit_tanggal_tutup').val(data.tanggal_tutup);
      $('#edit_kuota_penerimaan').val(data.kuota_penerimaan);
      $('#edit_status').val(data.status);
      
      $('#editModal').modal('show');
    });

    // Handle delete confirmation with SweetAlert
    $('#periode-table').on('click', '.btn-danger', function(e) {
        e.preventDefault();

        var form = $(this).closest('form');
        var actionUrl = form.attr('action');

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
            buttonsStyling: false // Agar SweetAlert tidak menggunakan gaya default tombol
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
