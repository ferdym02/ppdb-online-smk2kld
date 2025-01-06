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
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Ganti href menjadi data-bs-toggle dan data-bs-target untuk memanggil modal -->
          <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
          <div class="card">
            <div class="card-body">
              <table id="users-table" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th>Name</th>
                    <th>Email</th>
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

  <!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <input type="hidden" name="form_action" value="create">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Data Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="role" value="user">
          <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
            @error('password_confirmation')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
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

<!-- Modal Edit Data -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm" method="POST" action="{{ old('action_url', '') }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="form_action" value="edit">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditLabel">Edit Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="role" value="user">
          <div class="form-group mb-3">
            <label for="editName">Nama</label>
            <input type="text" name="name" id="editName" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="editEmail">Email</label>
            <input type="email" name="email" id="editEmail" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="editPassword">Password (Biarkan kosong jika tidak ingin mengubah)</label>
            <input type="password" name="password" id="editPassword" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="edit_password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
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
      <div class="toast-header">
        <i class="bi bi-circle me-2"></i> <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ session('success') }}
      </div>
    </div>
  </div>

  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toastDanger" class="toast toast-danger" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <i class="bi bi-circle me-2"></i> <strong class="me-auto">Error</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ session('error') }}
      </div>
    </div>
  </div>
</main>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
  $(document).ready(function() {
    var table = $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('users.data') }}",
      columns: [
        { 
          data: 'no', 
          name: 'no', 
          orderable: true, 
          searchable: false,
          className: 'text-center'
        },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }
      ]
    });

    // Script untuk membuka modal edit dan mengisi data
    $('#users-table').on('click', '.btn-edit', function() {
      var id = $(this).data('id');
      var name = $(this).data('name');
      var email = $(this).data('email');

      $('#editForm').attr('action', `/admin/users/${id}`);
      $('#editName').val(name);
      $('#editEmail').val(email);
      $('#editPassword').val('');
      $('#edit_password_confirmation').val('');
      $('#modalEdit').modal('show');
    });

    // Handle delete confirmation with SweetAlert
    $('#users-table').on('click', '.btn-danger', function(e) {
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
                var createModal = new bootstrap.Modal(document.getElementById('modalTambah'));
                createModal.show();
            @elseif (old('form_action') === 'edit')
                // Tampilkan modal edit
                var editModal = new bootstrap.Modal(document.getElementById('modalEdit'));
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
      var toastError = new bootstrap.Toast(document.getElementById('toastError'));
      toastError.show();
    @endif
</script>
@endsection

