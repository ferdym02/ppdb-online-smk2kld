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
                    <div class="row">
                        <!-- Filter Periode -->
                        <div class="col-md-3">
                            <form action="{{ route('periode-jurusan.index') }}" method="GET" class="mb-3">
                                <div class="form-group">
                                    <label for="periode_id">Periode Pendaftaran:</label>
                                    <select name="periode_id" id="periode_id" class="form-control" onchange="updateTambahButton(); this.form.submit()">
                                        <option value="" selected disabled>-- Pilih Periode Pendaftaran --</option>
                                        @foreach($periodes as $periode)
                                            <option value="{{ $periode->id }}" {{ $periode_id == $periode->id ? 'selected' : '' }}>
                                                {{ $periode->tahun_pelajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Tombol Tambah Data -->
                    <!-- Tombol Tambah Data dengan Wrapper untuk Tooltip -->
                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-title="Pilih periode terlebih dahulu untuk menambah data.">
                        <button 
                            class="btn btn-primary mb-3" 
                            id="btnTambah" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalTambah" 
                            disabled
                        >
                            Tambah Data
                        </button>
                    </span>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Jurusan</th>
                                        <th class="text-center">Kuota</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($periodeJurusans as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $item->jurusan->nama }}</td>
                                            <td class="text-center">{{ $item->kuota }}</td>
                                            <td class="text-center">
                                                <button 
                                                    class="btn btn-warning btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEdit"
                                                    data-id="{{ $item->id }}" 
                                                    data-kuota="{{ $item->kuota }}"
                                                >
                                                    Edit
                                                </button>
                                                <form action="{{ route('periode-jurusan.destroy', $item->id) }}" method="POST" id="deleteForm{{ $item->id }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}">Hapus</button>
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('periode-jurusan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Data Periode Jurusan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="periode_id" id="hiddenPeriodeId">
                        <div class="form-group mb-3">
                            <label for="jurusan_id">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="form-control @error('jurusan_id') is-invalid @enderror" required>
                                <option value="" selected disabled>Pilih Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    @if(!$periodeJurusans->contains('jurusan_id', $jurusan->id))
                                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                            {{ $jurusan->nama }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="kuota">Kuota</label>
                            <input type="number" name="kuota" id="kuota" class="form-control @error('kuota') is-invalid @enderror" value="{{ old('kuota') }}" required>
                            @error('kuota')
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

    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ old('action_url', '') }}" method="POST" id="formEdit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_action" value="edit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Kuota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="kuotaEdit">Kuota</label>
                            <input 
                                type="number" 
                                name="kuota" 
                                id="kuotaEdit" 
                                class="form-control @error('kuota') is-invalid @enderror" 
                                value="{{ old('kuota') }}" 
                                required
                            >
                            @error('kuota')
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
                <i class="bi bi-circle me-2"></i>
                <strong class="me-auto">Success</strong>
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
                <i class="bi bi-circle me-2"></i>
                <strong class="me-auto">Error</strong>
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
<script>
    $(document).ready(function() {
        // Handle edit modal show event
        $('#modalEdit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var kuota = button.data('kuota');

        var modal = $(this);
        modal.find('#kuotaEdit').val(kuota);
        modal.find('#formEdit').attr('action', '/admin/periode-jurusan/' + id);
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
            })
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
                    document.getElementById('formEdit').setAttribute('action', actionUrl);
                }
            @endif
        });
    @endif
    
    // Fungsi untuk memperbarui status tombol dan tooltip
    function updateTambahButton() {
        const periodeId = document.getElementById('periode_id').value;
        const btnTambah = document.getElementById('btnTambah');
        const tooltipWrapper = btnTambah.parentElement;

        if (periodeId) {
            btnTambah.disabled = false;
            tooltipWrapper.removeAttribute('data-bs-title'); // Hapus tooltip
        } else {
            btnTambah.disabled = true;
            tooltipWrapper.setAttribute('data-bs-title', 'Pilih periode terlebih dahulu untuk menambah data.');
        }

        // Refresh tooltip agar perubahan langsung terlihat
        const tooltip = bootstrap.Tooltip.getInstance(tooltipWrapper);
        if (tooltip) tooltip.dispose(); // Hapus tooltip lama
        new bootstrap.Tooltip(tooltipWrapper); // Buat tooltip baru
    }

    document.addEventListener('DOMContentLoaded', function () {
    const btnTambah = document.getElementById('btnTambah');
    const periodeIdSelect = document.getElementById('periode_id');
    const hiddenPeriodeId = document.getElementById('hiddenPeriodeId');

    // Ketika tombol "Tambah Data" diklik
    btnTambah.addEventListener('click', function () {
        hiddenPeriodeId.value = periodeIdSelect.value;
    });

    // Inisialisasi tombol dan tooltip
    updateTambahButton();
});


</script>
@endsection