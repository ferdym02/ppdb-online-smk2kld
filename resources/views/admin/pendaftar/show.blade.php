@extends('admin.main')
@section('css')
    <style>
        table td {
            word-wrap: break-word;
            max-width: 300px; /* Tentukan batas lebar */
        }
    </style>
@endsection

@section('content')
<main class="app-main">
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center">
                    <!-- Tombol ikon kembali -->
                    <a href="{{ session('index_by_status_url') }}" class="me-3">
                      <i class="fas fa-arrow-left"></i>
                    </a>
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
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->

    <!-- Main content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-body">
                            <div class="row">
                                <!-- Column 1 -->
                                <h5 class="text-center">Data Pribadi</h5>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Periode Pendaftaran</th>
                                            <td>: {{ $pendaftar->periode->tahun_pelajaran ?? 'Tidak tersedia' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Pendaftaran</th>
                                            <td>: {{ $pendaftar->nomor_pendaftaran }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <td>: {{ $pendaftar->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tempat Lahir</th>
                                            <td>: {{ $pendaftar->tempat_lahir }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>: {{ \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>: {{ $pendaftar->jenis_kelamin }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: {{ $pendaftar->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>NISN</th>
                                            <td>: {{ $pendaftar->nisn }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Asal Sekolah</th>
                                            <td>: {{ $pendaftar->asal_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Ayah</th>
                                            <td>: {{ $pendaftar->nama_ayah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Ibu</th>
                                            <td>: {{ $pendaftar->nama_ibu }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor WA</th>
                                            <td>: {{ $pendaftar->nomor_wa }}</td>
                                        </tr>
                                        <tr>
                                            <th>Prestasi Akademik</th>
                                            <td>: {{ $pendaftar->prestasi_akademik ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Prestasi Non Akademik</th>
                                            <td>: {{ $pendaftar->prestasi_non_akademik ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>: {{ $pendaftar->user->email ?? 'Tidak tersedia' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <hr class="border border-info border-1 opacity-75">
                            
                            <div class="row">
                                <h5 class="text-center">Pilihan Jurusan</h5>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Pilihan Jurusan 1</th>
                                            <td>: {{ $pendaftar->jurusans->where('pivot.urutan_pilihan', 1)->first()->nama ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pilihan Jurusan 2</th>
                                            <td>: {{ $pendaftar->jurusans->where('pivot.urutan_pilihan', 2)->first()->nama ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Pilihan Jurusan 3</th>
                                            <td>: {{ $pendaftar->jurusans->where('pivot.urutan_pilihan', 3)->first()->nama ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <hr class="border border-info border-1 opacity-75">
                            
                            <div class="row">
                                <h5 class="text-center">Dokumen Pendukung</h5>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Kartu Keluarga</th>
                                            <td>: <a href="{{ asset('storage/' . $pendaftar->kartu_keluarga) }}" target="_blank">Lihat File</a></td>
                                        </tr>
                                        <tr>
                                            <th>KTP Orang Tua</th>
                                            <td>: <a href="{{ asset('storage/' . $pendaftar->ktp_orang_tua) }}" target="_blank">Lihat File</a></td>
                                        </tr>
                                        <tr>
                                            <th>Akte Kelahiran</th>
                                            <td>: <a href="{{ asset('storage/' . $pendaftar->akte_kelahiran) }}" target="_blank">Lihat File</a></td>
                                        </tr>
                                        <tr>
                                            <th>Ijazah</th>
                                            <td>: <a href="{{ asset('storage/' . $pendaftar->ijazah) }}" target="_blank">Lihat File</a></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Foto Calon Siswa</th>
                                            <td>: <a href="{{ asset('storage/' . $pendaftar->foto_calon_siswa) }}" target="_blank">Lihat File</a></td>
                                        </tr>
                                        <tr>
                                            <th>Raport</th>
                                            <td>: <a href="{{ asset('storage/' . $pendaftar->raport) }}" target="_blank">Lihat File</a></td>
                                        </tr>
                                        <tr>
                                            <th>Piagam/Sertifikat</th>
                                            <td>: 
                                                @if ($pendaftar->piagam)
                                                    <a href="{{ asset('storage/' . $pendaftar->piagam) }}" target="_blank">Lihat File</a>
                                                @else
                                                    Tidak ada
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Surat Keterangan Peringkat Kelas/Sekolah</th>
                                            <td>:
                                            @if ($pendaftar->surat_keterangan) 
                                                <a href="{{ asset('storage/' . $pendaftar->surat_keterangan) }}" target="_blank">Lihat File</a>
                                            @else
                                                Tidak ada
                                            @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <hr class="border border-info border-1 opacity-75">
                            
                            <div class="row">
                                <h5 class="text-center">Nilai Rapor</h5>
                                <div class="col-md-6">
                                    <table class="table">
                                        @for ($semester = 1; $semester <= 3; $semester++)
                                        <tr>
                                            <th>Nilai MTK Semester {{ $semester }}</th>
                                            <td>: {{ $pendaftar->{'nilai_mtk_semester_'.$semester} }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai IPA Semester {{ $semester }}</th>
                                            <td>: {{ $pendaftar->{'nilai_ipa_semester_'.$semester} }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Bahasa Indonesia Semester {{ $semester }}</th>
                                            <td>: {{ $pendaftar->{'nilai_bahasa_indonesia_semester_'.$semester} }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Bahasa Inggris Semester {{ $semester }}</th>
                                            <td>: {{ $pendaftar->{'nilai_bahasa_inggris_semester_'.$semester} }}</td>
                                        </tr>
                                        @endfor
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        @for ($semester = 4; $semester <= 5; $semester++)
                                        <tr>
                                            <th>Nilai MTK Semester {{ $semester }}</th>
                                            <td>: {{ $pendaftar->{'nilai_mtk_semester_'.$semester} }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai IPA Semester {{ $semester }}</th>
                                            <td>: {{ $pendaftar->{'nilai_ipa_semester_'.$semester} }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Bahasa Indonesia Semester {{ $semester }}</th>
                                            <td>: {{ $pendaftar->{'nilai_bahasa_indonesia_semester_'.$semester} }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Bahasa Inggris Semester {{ $semester }}</th>
                                            <td>: {{ $pendaftar->{'nilai_bahasa_inggris_semester_'.$semester} }}</td>
                                        </tr>
                                        @endfor
                                    </table>
                                </div>
                            </div>
                            
                            <hr class="border border-info border-1 opacity-75">
                            
                            <div class="row">
                                <h5 class="text-center">Informasi Pendaftaran</h5>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Tanggal Pendaftaran</th>
                                            <td>: {{ \Carbon\Carbon::parse($pendaftar->created_at)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pendaftaran</th>
                                            <td>:
                                                <span class="badge 
                                                    {{ strtolower($pendaftar->status_pendaftaran) == 'pending' ? 'text-bg-secondary' : '' }}
                                                    {{ strtolower($pendaftar->status_pendaftaran) == 'verified' ? 'text-bg-primary' : '' }}
                                                    {{ strtolower($pendaftar->status_pendaftaran) == 'rejected' ? 'text-bg-warning' : '' }}
                                                    {{ strtolower($pendaftar->status_pendaftaran) == 'diterima' ? 'text-bg-success' : '' }}
                                                    {{ strtolower($pendaftar->status_pendaftaran) == 'gugur' ? 'text-bg-danger' : '' }}
                                                    {{ strtolower($pendaftar->status_pendaftaran) == 'cadangan' ? 'text-bg-info' : '' }}">
                                                    {{ ucfirst($pendaftar->status_pendaftaran) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @if ($pendaftar->catatan_penolakan)
                                        <tr>
                                            <th>Catatan Penolakan</th>
                                            <td>: {{ $pendaftar->catatan_penolakan }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Tanggal Tes</th>
                                            <td>: 
                                                @if ($pendaftar->tanggal_tes)
                                                    {{ \Carbon\Carbon::parse($pendaftar->tanggal_tes)->format('d-m-Y') }}
                                                @else
                                                    Belum ditentukan
                                                @endif
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <th>Status Tes</th>
                                            <td>: {{ $pendaftar->status_tes == 'sudah' ? 'Sudah tes' : 'Belum tes' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th>Nilai Tes Minat Bakat</th>
                                            <td>: {{ $pendaftar->nilai_tes_minat_bakat ?? 'Belum ditentukan' }}</td>
                                        </tr>
                                        @if ($pendaftar->jurusan_diterima)
                                        <tr>
                                            <th>Jurusan Diterima</th>
                                            <td>: {{ $pendaftar->jurusanDiterima->nama }}</td>
                                        </tr>
                                        @endif
                                        @if ($pendaftar->nilai_akhir)
                                        <tr>
                                            <th>Nilai Akhir</th>
                                            <td>: {{ $pendaftar->nilai_akhir }}</td>
                                        </tr>
                                        @endif
                                        @if ($pendaftar->status_pendaftaran === "diterima")
                                        <tr>
                                            <th>Daftar Ulang</th>
                                            <td>: {{ $pendaftar->daftar_ulang ? ucfirst($pendaftar->daftar_ulang) : 'Belum' }}</td>
                                        </tr>  
                                        @endif
                                    </table>
                                </div>
                            </div>   
                            
                            <hr class="border border-info border-1 opacity-75">

                            @if ($pendaftar->status_pendaftaran === 'cadangan')
                                <!-- Tombol untuk memunculkan/menyembunyikan form ubah status -->
                                <button class="btn btn-info mb-4 d-block" type="button" data-bs-toggle="collapse" data-bs-target="#ubahStatusForm" aria-expanded="false" aria-controls="ubahStatusForm">
                                    Ubah Status
                                </button>
                            @endif
                            <!-- Form Ubah Status (disembunyikan pada awalnya) -->
                            <div class="collapse" id="ubahStatusForm">
                                <div class="card card-body mb-4">
                                    <form class="form-ubah-status" action="{{ route('pendaftar.updateStatus', $pendaftar->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="status_pendaftaran">Status Pendaftaran:</label>
                                            <select name="status_pendaftaran" id="status_pendaftaran" class="form-control">
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option value="diterima" {{ $pendaftar->status_pendaftaran == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary mt-3 btn-submit">Simpan</button>
                                    </form>
                                </div>
                            </div>

                            @if ($pendaftar->status_pendaftaran === 'diterima' && $pendaftar->daftar_ulang === null)
                                <!-- Tombol untuk memunculkan/menyembunyikan form daftar ulang -->
                                <button class="btn btn-info mb-4 d-block" type="button" data-bs-toggle="collapse" data-bs-target="#daftarUlangForm" aria-expanded="false" aria-controls="daftarUlangForm">
                                    Daftar Ulang
                                </button>
                            @endif
                            <!-- Form Daftar Ulang (disembunyikan pada awalnya) -->
                            <div class="collapse" id="daftarUlangForm">
                                <div class="card card-body mb-4">
                                    <form class="form-daftar-ulang" action="{{ route('pendaftar.updateDaftarUlang', $pendaftar->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="daftar_ulang">Status Daftar Ulang:</label>
                                            <select name="daftar_ulang" id="daftar_ulang" class="form-control">
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option value="ya" {{ $pendaftar->daftar_ulang == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak" {{ $pendaftar->daftar_ulang == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </form>
                                </div>
                            </div>

                            @if ($pendaftar->status_pendaftaran == 'pending')
                                <!-- Tombol untuk memunculkan/menyembunyikan form verifikasi -->
                                <button class="btn btn-info mb-4 d-block" type="button" data-bs-toggle="collapse" data-bs-target="#verifikasiForm" aria-expanded="false" aria-controls="verifikasiForm">
                                    Verifikasi Pendaftar
                                </button>
                            @endif

                            <!-- Form Verifikasi (disembunyikan pada awalnya) -->
                            <div class="collapse" id="verifikasiForm">
                                <div class="card card-body mb-4">
                                    <form action="{{ route('pendaftar.verifikasi', $pendaftar->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="status">Status Verifikasi:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="" disabled selected>Pilih Status Verifikasi</option>
                                                <option value="verifikasi">Verifikasi</option>
                                                <option value="tolak">Tolak</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3" id="catatan_penolakan_div" style="display: none;">
                                            <label for="catatan_penolakan">Catatan Penolakan:</label>
                                            <textarea name="catatan_penolakan" id="catatan_penolakan" class="form-control"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </form>
                                </div>
                            </div>

                            @if ($pendaftar->status_pendaftaran == 'verified')
                                <!-- Tombol untuk memunculkan/menyembunyikan form nilai tes -->
                                <button class="btn btn-info mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#nilaiTesForm" aria-expanded="false" aria-controls="nilaiTesForm">
                                    Input Nilai Tes dan Jurusan Diterima
                                </button>
                            @endif

                            <!-- Form Nilai Tes (disembunyikan pada awalnya) -->
                            <div class="collapse" id="nilaiTesForm">
                                <div class="card card-body mb-4">
                                    <form id="nilaiJurusanForm" action="{{ route('pendaftar.updateNilaiTes', $pendaftar->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nilai_tes_minat_bakat">Nilai Tes Minat Bakat:</label>
                                            <select name="nilai_tes_minat_bakat" id="nilai_tes_minat_bakat" class="form-control">
                                                <option value="" disabled selected>Pilih Nilai Tes Minat Bakat</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="K">K</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3" id="jurusan_diterima_div" style="display: none;">
                                            <label for="jurusan_diterima">Jurusan Diterima:</label>
                                            <select name="jurusan_diterima" id="jurusan_diterima" class="form-control">
                                                <option value="" disabled selected>Pilih Jurusan Diterima</option>
                                                @foreach($jurusans as $jurusan)
                                                    @if($jurusan->periode_jurusan_id)
                                                        <option value="{{ $jurusan->periode_jurusan_id }}" data-kuota="{{ $jurusan->kuota }}">
                                                            {{ $jurusan->nama }} (Kuota: {{ $jurusan->kuota }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>                                        
                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                @if (!in_array($pendaftar->status_pendaftaran, ['pending', 'rejected']))
                                    <a href="{{ route('admin.cetakBukti', $pendaftar->id) }}" class="btn btn-success me-1">
                                        <i class="fas fa-print"></i> | Cetak Bukti Pendaftaran
                                    </a>
                                @endif
                                <a href="/admin/pendaftar/{{ $pendaftar->id }}/edit" class="btn btn-warning">Edit</a>
                                <form action="{{ route('pendaftar.destroy', $pendaftar->id) }}" method="POST" style="display:inline;" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mx-1">Delete</button>
                                </form>                                
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
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
    // SweetAlert untuk tombol delete
    document.querySelectorAll('.form-delete').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting immediately

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form after confirmation
                }
            });
        });
    });

    // SweetAlert untuk semua tombol submit, kecuali tombol delete
    document.querySelectorAll('form:not(.form-delete)').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            // Cek apakah form yang disubmit adalah nilaiJurusanForm
            if (form.id === 'nilaiJurusanForm') {
                // Get selected jurusan and its kuota
                let selectedJurusan = document.querySelector('#jurusan_diterima');
                let selectedOption = selectedJurusan.options[selectedJurusan.selectedIndex];
                let kuota = selectedOption.getAttribute('data-kuota');

                if (kuota <= 0) {
                    // Show SweetAlert for kuota confirmation
                    Swal.fire({
                        title: 'Kuota Jurusan Habis',
                        text: "Kuota jurusan yang dipilih sudah habis. Pendaftar akan menjadi cadangan. Apakah Anda ingin melanjutkan?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, lanjutkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form after confirmation
                        }
                    });
                } else {
                    // Show SweetAlert for general confirmation
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Pastikan data yang Anda masukkan sudah benar!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, submit!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form after confirmation
                        }
                    });
                }
            } else {
                // Show SweetAlert for general confirmation for other forms
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pastikan data yang Anda masukkan sudah benar!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, submit!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form after confirmation
                    }
                });
            }
        });
    });

    document.querySelector('.form-daftar-ulang').addEventListener('submit', function (e) {
        e.preventDefault();

        const daftarUlang = document.getElementById('daftar_ulang').value;

        if (!daftarUlang) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Harap pilih status daftar ulang terlebih dahulu!',
                icon: 'warning',
                confirmButtonText: 'OK',
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin mengubah status daftar ulang menjadi "${daftarUlang === 'ya' ? 'Ya' : 'Tidak'}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit(); // Submit form jika pengguna mengonfirmasi
            }
        });
    });

    document.querySelector('.btn-submit').addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Status pendaftaran akan diubah menjadi 'diterima'.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit(); // Submit form jika dikonfirmasi
            }
        });
    });

    // Show/Hide 'Catatan Penolakan' field based on status selection
    document.getElementById('status').addEventListener('change', function() {
        var catatanPenolakanDiv = document.getElementById('catatan_penolakan_div');
        if (this.value == 'tolak') {
            catatanPenolakanDiv.style.display = 'block';
        } else {
            catatanPenolakanDiv.style.display = 'none';
        }
    });

    // Show/Hide 'Jurusan Diterima' field based on test score selection
    document.getElementById('nilai_tes_minat_bakat').addEventListener('change', function() {
        var jurusanDiterimaDiv = document.getElementById('jurusan_diterima_div');
        if (this.value == 'K') {
            jurusanDiterimaDiv.style.display = 'none';
        } else {
            jurusanDiterimaDiv.style.display = 'block';
        }
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
