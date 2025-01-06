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
          <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createJadwalModal">Tambah Data</button>
          <div class="card">
            <div class="card-body">
              <table id="jadwalTable" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>Kegiatan</th>
                    <th>Lokasi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Waktu</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($jadwals as $jadwal)
                  <tr>
                    <td>{{ $jadwal->kegiatan }}</td>
                    <td>{{ $jadwal->lokasi }}</td>
                    <td>{{ $jadwal->tanggal_mulai->format('d M Y') }}</td>
                    <td>{{ $jadwal->tanggal_selesai ? $jadwal->tanggal_selesai->format('d M Y') : '-' }}</td>
                    <td hidden data-tanggal-mulai="{{ $jadwal->tanggal_mulai->toDateString() }}"></td>
                    <td hidden data-tanggal-selesai="{{ $jadwal->tanggal_selesai ? $jadwal->tanggal_selesai->toDateString() : '' }}"></td>                    
                    <td>{{ $jadwal->waktu }}</td>
                    <td class="text-center">
                      <button class="btn btn-warning btn-edit btn-sm" 
                              data-id="{{ $jadwal->id }}" 
                              data-kegiatan="{{ $jadwal->kegiatan }}" 
                              data-lokasi="{{ $jadwal->lokasi }}" 
                              data-tanggal-mulai="{{ $jadwal->tanggal_mulai }}" 
                              data-tanggal-selesai="{{ $jadwal->tanggal_selesai }}" 
                              data-waktu="{{ $jadwal->waktu }}" 
                              data-bs-toggle="modal" 
                              data-bs-target="#editJadwalModal">
                          Edit
                      </button>
                        
                        <form action="{{ route('jadwals.destroy', $jadwal->id) }}" method="POST" style="display:inline-block;">
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
</main>

<!-- Modal Create -->
<div class="modal fade" id="createJadwalModal" tabindex="-1" aria-labelledby="createJadwalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createJadwalModalLabel">Tambah Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('jadwals.store') }}" method="POST">
        @csrf
        <input type="hidden" name="form_action" value="create">
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="kegiatan">Kegiatan</label>
            <input type="text" name="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror" value="{{ old('kegiatan') }}" required placeholder="Cont: MPLS">
            @error('kegiatan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="lokasi">Lokasi</label>
            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" required placeholder="Cont: Online/Di Sekolah">
            @error('lokasi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}" required>
            @error('tanggal_mulai')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}">
            @error('tanggal_selesai')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="waktu">Waktu</label>
            <input type="text" name="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu') }}" required placeholder="Cont: 07.00-08.00 WIB">
            @error('waktu')
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
<div class="modal fade" id="editJadwalModal" tabindex="-1" aria-labelledby="editJadwalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editJadwalModalLabel">Edit Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editJadwalForm" method="POST" action="{{ old('action_url', '') }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="form_action" value="edit">
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="kegiatan">Kegiatan</label>
            <input type="text" id="editKegiatan" name="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror" value="{{ old('kegiatan') }}" required>
            @error('kegiatan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="lokasi">Lokasi</label>
            <input type="text" id="editLokasi" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" required>
            @error('lokasi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" id="editTanggalMulai" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}" required>
            @error('tanggal_mulai')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" id="editTanggalSelesai" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}">
            @error('tanggal_selesai')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group mb-3">
            <label for="waktu">Waktu</label>
            <input type="text" id="editWaktu" name="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu') }}" required>
            @error('waktu')
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
@endsection


@section('scripts')
<script>
  $(document).ready(function() {
      $('#jadwalTable').on('click', '.btn-edit', function() {
          var id = $(this).data('id');
          var kegiatan = $(this).data('kegiatan');
          var lokasi = $(this).data('lokasi');
          var tanggalMulai = $(this).closest('tr').find('[data-tanggal-mulai]').data('tanggal-mulai');
          var tanggalSelesai = $(this).closest('tr').find('[data-tanggal-selesai]').data('tanggal-selesai');
          var waktu = $(this).data('waktu');

          $('#editJadwalForm').attr('action', '/admin/jadwals/' + id);
          $('#editKegiatan').val(kegiatan);
          $('#editLokasi').val(lokasi);
          $('#editTanggalMulai').val(tanggalMulai);
          $('#editTanggalSelesai').val(tanggalSelesai);
          $('#editWaktu').val(waktu);
      });
  });


  @if ($errors->any())
      document.addEventListener('DOMContentLoaded', function() {
          @if (old('form_action') === 'create')
              // Tampilkan modal create
              var createModal = new bootstrap.Modal(document.getElementById('createJadwalModal'));
              createModal.show();
          @elseif (old('form_action') === 'edit')
              // Tampilkan modal edit
              var editModal = new bootstrap.Modal(document.getElementById('editJadwalModal'));
              editModal.show();

              // Tambahkan action URL jika tidak ada
              var actionUrl = "{{ old('action_url', '') }}";
              if (actionUrl) {
                  document.getElementById('editJadwalForm').setAttribute('action', actionUrl);
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

  // Handle delete confirmation with SweetAlert
  $('#jadwalTable').on('click', '.btn-danger', function(e) {
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
</script>
@endsection
