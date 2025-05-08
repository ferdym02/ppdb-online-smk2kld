@extends('admin.main')

@section('css')
<link href="https://cdn.datatables.net/v/bs5/dt-2.1.5/datatables.min.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            Tambah Data
          </button>
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table id="pengumumanTable" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th>Judul</th>
                      <th>Ringkasan Isi</th> <!-- Tambahkan kolom Ringkasan -->
                      <th class="text-center">File Lampiran</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pengumumans as $index => $pengumuman)
                    <tr>
                      <td class="text-center align-middle">{{ $index + 1 }}</td>
                      <td class="align-middle">{{ \Illuminate\Support\Str::limit(strip_tags($pengumuman->judul), 25, '...') }}</td>
                      <td class="align-middle">{{ \Illuminate\Support\Str::limit(strip_tags($pengumuman->isi), 50, '...') }}</td> <!-- Tambahkan ini -->
                      <td class="text-center align-middle">
                        @if($pengumuman->file_lampiran)
                        <a href="{{ asset('storage/' . $pengumuman->file_lampiran) }}" target="_blank">Download</a>
                        @else
                        Tidak Ada File
                        @endif
                      </td>
                      <td class="text-center align-middle">
                        <a href="{{ route('pengumuman.show', $pengumuman->id) }}" class="btn btn-sm btn-info">
                          Detail
                        </a>
                        <button class="btn btn-sm btn-warning btn-edit"
                          data-id="{{ $pengumuman->id }}"
                          data-judul="{{ $pengumuman->judul }}"
                          data-file="{{ $pengumuman->file_lampiran }}"
                          data-isi="{{ $pengumuman->isi }}"
                          data-bs-toggle="modal"
                          data-bs-target="#editModal">
                          Edit
                        </button>
                        <form action="{{ route('pengumuman.destroy', $pengumuman->id) }}" method="POST" style="display:inline-block;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-delete btn-sm btn-danger">Hapus</button>
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
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('pengumuman.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="form_action" value="create">
          <div class="modal-header">
            <h5 class="modal-title" id="createModalLabel">Tambah Pengumuman</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group mb-3">
              <label for="judul">Judul</label>
              <input 
                type="text" 
                class="form-control @error('judul') is-invalid @enderror" 
                id="judul" 
                name="judul" 
                value="{{ old('judul') }}" 
                placeholder="Masukkan judul pengumuman"
                required>
              @error('judul')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group mb-3">
              <label for="isi">Isi Pengumuman</label>
              <div id="editor-container" style="height: 200px;"></div>
              <input type="hidden" name="isi" id="isi">
            </div>
            <div class="form-group mb-3">
              <label for="file_lampiran">File Lampiran</label>
              <input 
                type="file" 
                class="form-control @error('file_lampiran') is-invalid @enderror" 
                id="file_lampiran" 
                name="file_lampiran" 
              >
              <small class="text-muted">Format: PDF, DOCX | Maksimal: 2MB</small>
              @error('file_lampiran')
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

  <!-- Modal Edit -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="editForm" method="POST" enctype="multipart/form-data" action="{{ old('action_url', '') }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="form_action" value="edit">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Pengumuman</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group mb-3">
              <label for="editJudul">Judul</label>
              <input 
                type="text" 
                class="form-control @error('judul') is-invalid @enderror" 
                id="editJudul" 
                name="judul" 
                value="{{ old('judul') }}" 
                required>
              @error('judul')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group mb-3">
              <label for="editIsi">Isi Pengumuman</label>
              <div id="edit-editor-container" style="height: 200px;"></div>
              <input type="hidden" name="isi" id="editIsi">
            </div>
            <div class="form-group mb-3">
              <label for="editFileLampiran">File Lampiran</label>
              <input 
                type="file" 
                class="form-control @error('file_lampiran') is-invalid @enderror" 
                id="editFileLampiran" 
                name="file_lampiran"
              >
              <small class="text-muted d-block">Format: PDF, DOCX | Maksimal: 2MB</small>
              @error('file_lampiran')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
              @if (!empty($pengumuman->file_lampiran))
                  <a href="{{ asset('storage/' . $pengumuman->file_lampiran) }}" id="editFileLink" target="_blank">Download File Lama</a>
              @endif
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Update</button>
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
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
  var quill = new Quill('#editor-container', {
      theme: 'snow',
      placeholder: 'Tulis isi pengumuman di sini...',
      modules: {
          toolbar: {
              container: [
                [{ header: [1, 2, 3, 4, 5, false] }],
                ['bold', 'italic', 'underline'],
                [{ color: [] }, { background: [] }],
                ['link', 'blockquote', 'image', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }]
              ],
              handlers: {
                  image: function () {
                      let input = document.createElement('input');
                      input.setAttribute('type', 'file');
                      input.setAttribute('accept', 'image/*');
                      input.click();

                      input.onchange = async () => {
                          let file = input.files[0];

                          if (file) {
                              if (file.size > 2097152) {
                                alert("Ukuran gambar maksimal 2 MB.");
                                return;
                              }
                              let reader = new FileReader();
                              reader.onload = (e) => {
                                  let range = quill.getSelection();
                                  quill.insertEmbed(range.index, 'image', e.target.result);
                              };
                              reader.readAsDataURL(file);
                          }
                      };
                  }
              }
          }
      }
  });

  // Set nilai Quill ke dalam input hidden sebelum submit form
  document.querySelector("form[action='{{ route('pengumuman.store') }}']").addEventListener("submit", function() {
    document.getElementById('isi').value = quill.root.innerHTML;
  });
</script>

<script>
  var quillEdit = new Quill('#edit-editor-container', {
    theme: 'snow',
    placeholder: 'Edit isi pengumuman di sini...',
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, 4, 5, false] }],
        ['bold', 'italic', 'underline'],
        [{ color: [] }, { background: [] }],
        ['link', 'blockquote', 'image', 'code-block'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        [{ align: [] }]
      ]
    }
  });

  // Saat tombol edit diklik, isi Quill dengan teks yang ada
  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function () {
      let id = this.getAttribute('data-id');
      let judul = this.getAttribute('data-judul');
      let isi = this.getAttribute('data-isi');
      let file = this.getAttribute('data-file');

      document.getElementById('editForm').setAttribute('action', `/admin/pengumuman/${id}`);
      document.getElementById('editJudul').value = judul;
      quillEdit.root.innerHTML = isi; // Masukkan teks ke dalam Quill
      document.getElementById('editFileLink').setAttribute('href', `/storage/${file}`);
      document.getElementById('editFileLink').textContent = 'Download File Lama';
    });
  });

  // Set nilai Quill ke dalam input hidden sebelum submit form edit
  document.getElementById('editForm').addEventListener('submit', function () {
    document.getElementById('editIsi').value = quillEdit.root.innerHTML;
  });
</script>
<script>
  $(document).ready(function() {
    // Datatable setup
    $('#pengumumanTable').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      lengthChange: true,
      autoWidth: false,
    });

    // Handle edit modal show event
    $('#editModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var judul = button.data('judul');
      var fileLampiran = button.data('file');

      var modal = $(this);
      modal.find('#editJudul').val(judul);
      modal.find('#editForm').attr('action', '/admin/pengumuman/' + id);
      modal.find('#editFileLink').attr('href', '/storage/' + fileLampiran);
    });
  });

  // SweetAlert for delete confirmation
    $('.btn-delete').on('click', function(e) {
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

  // Show toast notification if session has 'success' or 'error'
  @if(session('success'))
    var toastSuccess = new bootstrap.Toast(document.getElementById('toastSuccess'));
    toastSuccess.show();
  @endif

  @if(session('error'))
    var toastError = new bootstrap.Toast(document.getElementById('toastError'));
    toastError.show();
  @endif

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
</script>
@endsection