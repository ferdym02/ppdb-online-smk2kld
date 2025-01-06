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
          <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#jurusanModal" onclick="openCreateModal()">Tambah Data</button>
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Kode</th>
                    <th>Jurusan</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($jurusans as $key => $jurusan)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td class="text-center">{{ $jurusan->kode }}</td>
                      <td>{{ $jurusan->nama }}</td>
                      <td class="text-center">
                        <button class="btn btn-warning btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#jurusanModal" 
                                onclick="openEditModal({{ $jurusan->id }}, '{{ $jurusan->kode }}', '{{ $jurusan->nama }}')">
                          Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" 
                                data-id="{{ $jurusan->id }}">
                          Hapus
                        </button>
                        <form id="deleteForm{{ $jurusan->id }}" action="{{ route('jurusan.destroy', $jurusan->id) }}" method="POST" style="display:none;">
                          @csrf
                          @method('DELETE')
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade @if($errors->any()) show @endif" id="jurusanModal" tabindex="-1" aria-labelledby="jurusanModalLabel" aria-hidden="true" @if($errors->any()) style="display: block;" @endif>
    <div class="modal-dialog">
      <form id="jurusanForm" method="POST" action="{{ route('jurusan.store') }}">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="{{ old('_method', 'POST') }}">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="jurusanModalLabel">{{ old('id') ? 'Edit Jurusan' : 'Tambah Jurusan' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="kode" class="form-label">Kode</label>
              <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode') }}" placeholder="Masukkan kode jurusan" required>
              @error('kode')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama Jurusan</label>
              <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama jurusan" required>
              @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Kirim</button>
          </div>
        </div>
      </form>
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
<script>
    function openCreateModal() {
        // Set form action to create route
        const form = document.getElementById('jurusanForm');
        form.action = "{{ route('jurusan.store') }}";
        document.getElementById('formMethod').value = "POST";

        // Reset modal fields
        document.getElementById('kode').value = "";
        document.getElementById('nama').value = "";
        document.getElementById('jurusanModalLabel').innerText = "Tambah Jurusan";
    }

    function openEditModal(id, kode, nama) {
        // Set form action to edit route
        const form = document.getElementById('jurusanForm');
        form.action = `/admin/jurusan/${id}`;
        document.getElementById('formMethod').value = "PUT";

        // Populate modal fields
        document.getElementById('kode').value = kode;
        document.getElementById('nama').value = nama;
        document.getElementById('jurusanModalLabel').innerText = "Edit Jurusan";
    }

    // SweetAlert for delete confirmation
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
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
                    document.getElementById('deleteForm' + id).submit();
                }
            });
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

    // Reopen modal if there were validation errors
    @if($errors->any())
        var myModal = new bootstrap.Modal(document.getElementById('jurusanModal'), {
            keyboard: false
        });
        myModal.show();
    @endif
</script>
@endsection
