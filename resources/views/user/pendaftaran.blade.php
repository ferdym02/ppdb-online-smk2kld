@extends('user.layouts.app')
@section('css')
    <style>
        @media (max-width: 768px) {
            .responsive-btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
                line-height: 1.5;
                border-radius: 0.2rem;
            }
        } 
    </style>
@endsection

@section('content')
@if (!$isRegistrationOpen)
<div class="row mt-3">
    <div class="col-md-6 mx-auto">
        <div class="card mb-4 shadow-sm" id="info">
            <div class="card-header text-white">
                <h5 class="card-title mb-0">Info Penting</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" role="alert">
                    Saat ini belum ada periode pendaftaran yang dibuka.
                </div>
            </div>
        </div>
    </div>
</div>
@else
@if ($pendaftar)
<div class="card my-3 text-dark">
    <div class="card-header text-white">
        Informasi Pendaftaran
    </div>
    <div class="card-body">
        <p class="card-text">
            <strong>Tanggal Pendaftaran:</strong> {{ $pendaftar->created_at->format('d-m-Y') }}
        </p>
        <p class="card-text">
            <strong>Jam Pendaftaran:</strong> {{ $pendaftar->created_at->format('H:i:s') }} WIB
        </p>

        @if ($pendaftar->status_pendaftaran == 'verified')
            <p class="card-text">
                <strong>Status Pendaftaran:</strong>
                <span class="bg-primary text-white px-2 py-1 rounded">Terverifikasi</span>
            </p>
            <div class="alert alert-success">
                Pendaftaran Anda sudah terverifikasi, silakan cek jadwal Tes Minat Bakat Anda di 
                <a href="/user/dashboard">dashboard</a>.
            </div>
            <div class="alert alert-info">
                Silakan menunggu hasil tes pada halaman ini setelah Anda melakukan Tes Minat Bakat.
            </div>
            <a href="{{ route('pendaftar.cetakBukti', $pendaftar->id) }}" class="btn btn-success" target="_blank">
                <i class="fas fa-print"></i> Cetak Bukti Pendaftaran
            </a>
        @elseif ($pendaftar->status_pendaftaran == 'rejected')
            <p class="card-text">
                <strong>Status Pendaftaran:</strong>
                <span class="bg-warning px-2 py-1 rounded">Perlu Perbaikan</span>
            </p>
            <p class="card-text">
                <strong>Catatan Perbaikan:</strong> {{ $pendaftar->catatan_penolakan }}
            </p>
            <div class="alert alert-warning mt-3">
                <strong>Perhatian:</strong> Segera edit data yang perlu perbaikan sesuai dengan informasi dari catatan 
                perbaikan supaya data pendaftaran Anda dapat segera diverifikasi kembali oleh admin.
            </div>
            <a href="{{ route('pendaftaran.edit', $pendaftar->id) }}" class="btn btn-warning">Edit Data</a>
        @elseif ($pendaftar->status_pendaftaran == 'pending')
            <p class="card-text">
                <strong>Status Pendaftaran:</strong>
                <span class="bg-secondary text-white px-2 py-1 rounded">Pending</span>
            </p>
            <div class="alert alert-info mt-3">
                Silakan menunggu data pendaftaran Anda diverifikasi oleh admin dan cek secara berkala.
            </div>
            <a href="{{ route('pendaftaran.edit', $pendaftar->id) }}" class="btn btn-warning">Edit Data</a>
        @elseif ($pendaftar->status_pendaftaran == 'gugur')
            <p class="card-text">
                <strong>Status Pendaftaran:</strong>
                <span class="bg-danger text-white px-2 py-1 rounded">Tidak Lulus</span>
            </p>
            <div class="alert alert-info mt-3">
                Kami menyesal untuk memberitahukan bahwa Anda <strong>tidak lulus</strong> dalam seleksi penerimaan. Kami mengapresiasi usaha dan waktu yang telah Anda berikan. Jangan menyerah, teruslah berusaha dan semoga sukses di kesempatan berikutnya!
            </div>
        @elseif ($pendaftar->status_pendaftaran == 'cadangan')
            <p class="card-text">
                <strong>Status Pendaftaran:</strong>
                <span class="bg-info text-white px-2 py-1 rounded">Cadangan</span>
            </p>
            <p class="card-text">
                <strong>Cadangan di jurusan:</strong> {{ $pendaftar->jurusanDiterima->nama }}
            </p>
            <div class="alert alert-info mt-3">
                Saat ini status Anda sebagai cadangan di jurusan tersebut. Anda dapat menunggu pihak panitia mengontak Anda jika ada calon peserta didik baru yang mengundurkan diri dan Anda akan otomatis 
                <strong>lulus</strong>.
            </div>
            <a href="{{ route('pendaftar.cetakBukti', $pendaftar->id) }}" class="btn btn-success">
                <i class="fas fa-print"></i> Cetak Bukti Pendaftaran
            </a>
        @elseif ($pendaftar->status_pendaftaran == 'diterima')
            <p class="card-text">
                <strong>Status Pendaftaran:</strong>
                <span class="bg-success text-white px-2 py-1 rounded">Lulus</span>
            </p>
            <p class="card-text">
                <strong>Diterima di jurusan:</strong> {{ $pendaftar->jurusanDiterima->nama }}
            </p>
            <p class="card-text">
                <strong>Status Daftar Ulang:</strong>
                @if (is_null($pendaftar->daftar_ulang))
                    <span>Belum</span>
                @elseif ($pendaftar->daftar_ulang === 'tidak')
                    <span>Tidak</span>
                @elseif ($pendaftar->daftar_ulang === 'ya')
                    <span>Sudah</span>
                @endif
            </p>
            <div class="alert alert-info mt-3">
                Selamat! Anda telah lulus dalam proses PPDB. Silakan segera melakukan <strong>daftar ulang</strong> sesuai dengan tanggal yang ada di jadwal. Terkait tata cara daftar ulang dapat dilihat pada menu 
                <a href="/user/pengumuman">Pengumuman</a>.
            </div>
            <a href="{{ route('pendaftar.cetakBukti', $pendaftar->id) }}" class="btn btn-success">
                <i class="fas fa-print"></i> Cetak Bukti Pendaftaran
            </a>
        @endif
    </div>
</div>
@else
    <h5 class="mt-3">Silakan isi formulir untuk melakukan pendaftaran</h5>
    <div class="alert alert-warning mt-3">
        <strong>Perhatian:</strong> Pengisian formulir pendaftaran ini terdiri dari 3 tahap. <strong>Tahap 1: Data Diri, Tahap 2: Upload Dokumen Pendukung, dan Tahap 3: Nilai Rapor.</strong> Silakan isi semua data dengan benar dan lengkap sebelum ke tahap selanjutnya. Jangan refresh halaman ketika sedang melakukan pengisian untuk menghindari data harus diisi kembali.
    </div>
    <div class="alert alert-success mt-3">
        <strong>Tips:</strong> Scan terlebih dahulu dokumen pendukung kemudian kumpulkan dalam satu folder sebelum di upload untuk kemudahan proses upload.
    </div>
    <div class="alert alert-info mt-3">
        <strong>Catatan:</strong> Field yang ditandai dengan <span class="text-danger">*</span> wajib diisi.
    </div>
@endif
<div class="card card-info card-outline mt-3 mb-3">
    <div class="card-header text-white">
        @if ($pendaftar)
            Data Pendaftar
        @else
            Formulir Pendaftaran
        @endif
    </div>
    <div class="card-body">
        @if ($pendaftar)
            <!-- Bagian Data Diri -->
            <h3>Data Diri</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th style="width: 40%;">Nomor Pendaftaran</th>
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
                            <th>Alamat</th>
                            <td>: {{ $pendaftar->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Asal Sekolah</th>
                            <td>: {{ $pendaftar->asal_sekolah }}</td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td>: {{ $pendaftar->nisn }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: {{ $pendaftar->jenis_kelamin }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
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
                            <th>Memiliki Prestasi Akademik</th>
                            <td>: {{ $pendaftar->prestasi_akademik ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <th>Memiliki Prestasi Non Akademik</th>
                            <td>: {{ $pendaftar->prestasi_non_akademik ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <th>Pilihan Jurusan 1</th>
                            <td>: {{ $pendaftar->jurusans->where('pivot.urutan_pilihan', 1)->first()->nama }}</td>
                        </tr>
                        <tr>
                            <th>Pilihan Jurusan 2</th>
                            <td>: {{ $pendaftar->jurusans->where('pivot.urutan_pilihan', 2)->first()->nama }}</td>
                        </tr>
                        <tr>
                            <th>Pilihan Jurusan 3</th>
                            <td>: {{ $pendaftar->jurusans->where('pivot.urutan_pilihan', 3)->first()->nama }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr class="border border-warning border-1 opacity-75">

            <!-- Bagian Dokumen Pendukung -->
            <h3>Unggahan Dokumen</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Kartu Keluarga</th>
                            <td>
                                :
                                @if ($pendaftar->kartu_keluarga)
                                    <a href="{{ route('dokumen.lihat', basename($pendaftar->kartu_keluarga)) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>KTP Orang Tua/Wali</th>
                            <td>
                                :
                                @if ($pendaftar->ktp_orang_tua)
                                    <a href="{{ route('dokumen.lihat', basename($pendaftar->ktp_orang_tua)) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Akte Kelahiran</th>
                            <td>
                                :
                                @if ($pendaftar->akte_kelahiran)
                                    <a href="{{ route('dokumen.lihat', basename($pendaftar->akte_kelahiran)) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Ijazah/Surat Keterangan Lulus</th>
                            <td>
                                :
                                @if ($pendaftar->ijazah)
                                    <a href="{{ route('dokumen.lihat', basename($pendaftar->ijazah)) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th style="width: 50%">Foto Calon Siswa</th>
                            <td>
                                :
                                @if ($pendaftar->foto_calon_siswa)
                                    <a href="{{ route('dokumen.lihat', basename($pendaftar->foto_calon_siswa)) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Raport Semester 1 - 5</th>
                            <td>
                                :
                                @if ($pendaftar->raport)
                                    <a href="{{ route('dokumen.lihat', basename($pendaftar->raport)) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Surat Keterangan Peringkat Kelas/Sekolah (Akademik)</th>
                            <td>
                                :
                                @if ($pendaftar->surat_keterangan)
                                    <a href="{{ route('dokumen.lihat', basename($pendaftar->surat_keterangan)) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Piagam/Sertifikat (Non Akademik)</th>
                            <td>
                                :
                                @if ($pendaftar->piagam)
                                    <a href="{{ route('dokumen.lihat', basename($pendaftar->piagam)) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr class="border border-warning border-1 opacity-75">

            <!-- Bagian Nilai Rapor -->
            <h3>Nilai Rapor</h3>
            <div class="row">
                <div class="col-md-4">
                    @for ($semester = 1; $semester <= 2; $semester++)
                        <table class="table mb-3">
                            <tr>
                                <th colspan="2">Nilai Rapor Semester {{ $semester }}</th>
                            </tr>
                            <tr>
                                <th>MTK</th>
                                <td>: {{ $pendaftar->{"nilai_mtk_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>IPA</th>
                                <td>: {{ $pendaftar->{"nilai_ipa_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>Bahasa Indonesia</th>
                                <td>: {{ $pendaftar->{"nilai_bahasa_indonesia_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>Bahasa Inggris</th>
                                <td>: {{ $pendaftar->{"nilai_bahasa_inggris_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                        </table>
                    @endfor
                </div>
                <div class="col-md-4">
                    @for ($semester = 3; $semester <= 4; $semester++)
                        <table class="table mb-3">
                            <tr>
                                <th colspan="2">Nilai Rapor Semester {{ $semester }}</th>
                            </tr>
                            <tr>
                                <th>MTK</th>
                                <td>: {{ $pendaftar->{"nilai_mtk_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>IPA</th>
                                <td>: {{ $pendaftar->{"nilai_ipa_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>Bahasa Indonesia</th>
                                <td>: {{ $pendaftar->{"nilai_bahasa_indonesia_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>Bahasa Inggris</th>
                                <td>: {{ $pendaftar->{"nilai_bahasa_inggris_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                        </table>
                    @endfor
                </div>
                <div class="col-md-4">
                    @for ($semester = 5; $semester <= 5; $semester++)
                        <table class="table mb-3">
                            <tr>
                                <th colspan="2">Nilai Rapor Semester {{ $semester }}</th>
                            </tr>
                            <tr>
                                <th>MTK</th>
                                <td>: {{ $pendaftar->{"nilai_mtk_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>IPA</th>
                                <td>: {{ $pendaftar->{"nilai_ipa_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>Bahasa Indonesia</th>
                                <td>: {{ $pendaftar->{"nilai_bahasa_indonesia_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                            <tr>
                                <th>Bahasa Inggris</th>
                                <td>: {{ $pendaftar->{"nilai_bahasa_inggris_semester_$semester"} ?? 'Tidak Ada' }}</td>
                            </tr>
                        </table>
                    @endfor
                </div>
            </div>
        @else
            <form method="POST" action="/user/pendaftaran" enctype="multipart/form-data" id="pendaftaranForm">
                @csrf
                <!-- Tahap 1: Data Diri -->
                <div id="formTahap1" class="form-tahap">
                    <p class="mb-4 mt-1"><strong>Tahap 1: Data Diri</strong></p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Masukkan tempat lahir" required>
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span>:</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span>:</label>
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="alamat">Alamat <span class="text-danger">*</span>:</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nisn">NISN <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan NISN" required>
                                @error('nisn')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="asal_sekolah">Asal Sekolah <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Masukkan asal sekolah" required>
                                @error('asal_sekolah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_ayah">Nama Ayah <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" placeholder="Masukkan nama ayah" required>
                                @error('nama_ayah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_ibu">Nama Ibu <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" placeholder="Masukkan nama ibu" required>
                                @error('nama_ibu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nomor_wa">Nomor WA <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('nomor_wa') is-invalid @enderror" id="nomor_wa" name="nomor_wa" value="{{ old('nomor_wa') }}" placeholder="Masukkan nomor WhatsApp" required>
                                @error('nomor_wa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="prestasi_akademik">Prestasi Akademik <span class="text-danger">*</span>:</label>
                                <select class="form-control @error('prestasi_akademik') is-invalid @enderror" id="prestasi_akademik" name="prestasi_akademik" required>
                                    <option value="" disabled selected>Memiliki Prestasi Akademik?</option>
                                    <option value="1" {{ old('prestasi_akademik') == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ old('prestasi_akademik') == '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                <small class="form-text text-muted">
                                    (Pernah Rank 1- 10 dikelas 1,2,3)
                                </small>
                                @error('prestasi_akademik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="prestasi_non_akademik">Prestasi Non Akademik <span class="text-danger">*</span>:</label>
                                <select class="form-control @error('prestasi_non_akademik') is-invalid @enderror" id="prestasi_non_akademik" name="prestasi_non_akademik" required>
                                    <option value="" disabled selected>Memiliki Prestasi Non Akademik?</option>
                                    <option value="1" {{ old('prestasi_non_akademik') == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ old('prestasi_non_akademik') == '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                <small class="form-text text-muted">
                                    (Lomba Minimal Tingkat Kecamatan)
                                </small>
                                @error('prestasi_non_akademik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <strong>Catatan:</strong>
                        <ul>
                            <li>
                                Jurusan <strong>Teknik Komputer dan Jaringan</strong>, <strong>Teknik Kendaraan Ringan</strong>, dan <strong>Teknik Sepeda Motor</strong> hanya bisa dipilih di Pilihan Jurusan 1.
                            </li>
                            <li>
                                Pilihan Jurusan 1, 2, dan 3 tidak boleh sama.
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="pilihan_jurusan_1">Pilihan Jurusan 1 <span class="text-danger">*</span>:</label>
                                <select class="form-control @error('pilihan_jurusan_1') is-invalid @enderror" id="pilihan_jurusan_1" name="pilihan_jurusan_1" required>
                                    <option value="" disabled selected>Pilih Jurusan 1</option>
                                    @foreach($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" data-code="{{ $jurusan->kode }}" {{ old('pilihan_jurusan_1') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                    @endforeach
                                </select>
                                @error('pilihan_jurusan_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="pilihan_jurusan_2">Pilihan Jurusan 2 <span class="text-danger">*</span>:</label>
                                <select class="form-control @error('pilihan_jurusan_2') is-invalid @enderror" id="pilihan_jurusan_2" name="pilihan_jurusan_2" required>
                                    <option value="" disabled selected>Pilih Jurusan 2</option>
                                    @foreach($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" data-code="{{ $jurusan->kode }}" {{ old('pilihan_jurusan_2') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                    @endforeach
                                </select>
                                @error('pilihan_jurusan_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="pilihan_jurusan_3">Pilihan Jurusan 3 <span class="text-danger">*</span>:</label>
                                <select class="form-control @error('pilihan_jurusan_3') is-invalid @enderror" id="pilihan_jurusan_3" name="pilihan_jurusan_3" required>
                                    <option value="" disabled selected>Pilih Jurusan 3</option>
                                    @foreach($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" data-code="{{ $jurusan->kode }}" {{ old('pilihan_jurusan_3') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                    @endforeach
                                </select>
                                @error('pilihan_jurusan_3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        
                        <button type="button" class="btn btn-primary responsive-btn" id="nextTahap2">Selanjutnya: Tahap 2</button>
                    </div>
                </div>
            
                <!-- Tahap 2: Upload Dokumen Pendukung -->
                <div id="formTahap2" class="form-tahap d-none">
                    <p class="mb-4 mt-1"><strong>Tahap 2: Upload Dokumen Pendukung</strong></p>
                    <div class="alert alert-warning mt-3">
                        <strong>Perhatian:</strong> Scan kemudian unggah dokumen yang dibutuhkan. Untuk dokumen lebih dari satu halaman, <strong>scan dan gabungkan dokumen</strong> menjadi satu file sebelum diunggah. Perhatikan tipe file yang diunggah seperti <strong>jpg/jpeg/pdf</strong>.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kartu_keluarga">Kartu Keluarga <span class="text-danger">*</span>:</label>
                                <input type="file" accept=".jpg, .jpeg, .pdf" class="form-control @error('kartu_keluarga') is-invalid @enderror" id="kartu_keluarga" name="kartu_keluarga" required>
                                @error('kartu_keluarga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf | Maksimal 2MB</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ktp_orang_tua">KTP Orang Tua/Wali <span class="text-danger">*</span>:</label>
                                <input type="file" accept=".jpg, .jpeg, .pdf" class="form-control @error('ktp_orang_tua') is-invalid @enderror" id="ktp_orang_tua" name="ktp_orang_tua" required>
                                @error('kartu_keluarga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf | Maksimal 2MB</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="akte_kelahiran">Akte Kelahiran <span class="text-danger">*</span>:</label>
                                <input type="file" accept=".jpg, .jpeg, .pdf" class="form-control @error('akte_kelahiran') is-invalid @enderror" id="akte_kelahiran" name="akte_kelahiran" required>
                                @error('akte_kelahiran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf | Maksimal 2MB</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ijazah">Ijazah/Surat Keterangan Lulus <span class="text-danger">*</span>:</label>
                                <input type="file" accept=".jpg, .jpeg, .pdf" class="form-control @error('ijazah') is-invalid @enderror" id="ijazah" name="ijazah" required>
                                @error('ijazah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf | Maksimal 2MB</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="foto">Foto Calon Siswa Ukuran 3x4 <span class="text-danger">*</span>:</label>
                                <input type="file" accept=".jpg, .jpeg" class="form-control @error('foto_calon_siswa') is-invalid @enderror" id="foto" name="foto_calon_siswa" required>
                                @error('foto_calon_siswa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg | Maksimal 2MB</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="raport">Rapor Semester 1-5 <span class="text-danger">*</span>:</label>
                                <input type="file" accept=".pdf" class="form-control @error('raport') is-invalid @enderror" id="raport" name="raport" required>
                                @error('raport')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">
                                    Tipe file: pdf | Maksimal 4MB
                                </small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="surat_keterangan">Surat Keterangan Peringkat Kelas/Sekolah (Akademik) Jika Ada:</label>
                                <input type="file" accept=".jpg, .jpeg, .pdf" class="form-control @error('surat_keterangan') is-invalid @enderror" id="surat_keterangan" name="surat_keterangan">
                                @error('surat_keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">
                                    Tipe file: jpg/jpeg/pdf | Maksimal 4MB
                                </small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="piagam">Piagam/Sertifikat (Non Akademik) Jika Ada:</label>
                                <input type="file" accept=".jpg, .jpeg, .pdf" class="form-control @error('piagam') is-invalid @enderror" id="piagam" name="piagam">
                                @error('piagam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">
                                    Tipe file: jpg/jpeg/pdf | Maksimal 4MB
                                </small>
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <button type="button" class="btn btn-secondary responsive-btn" id="prevTahap1">Kembali: Tahap 1</button>
                        <button type="button" class="btn btn-primary responsive-btn" id="nextTahap3">Selanjutnya: Tahap 3</button>
                    </div>
                </div>

                <!-- Tahap 3: Nilai Rapor -->
                <div id="formTahap3" class="form-tahap d-none">
                    <p class="mb-4 mt-1"><strong>Tahap 3: Nilai Rapor Semester 1-5</strong></p>
                    <div class="alert alert-warning mt-3">
                        <strong>Perhatian:</strong> Gunakan tanda "." (titik) jika nilainya desimal. <strong>Contoh: "80.25"</strong> (Maksimal 2 angka di belakang koma).
                    </div>
                    @for ($semester = 1; $semester <= 5; $semester++)
                        <h4 class="mt-3">Semester {{ $semester }}</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="mtk_semester_{{ $semester }}">Nilai MTK <span class="text-danger">*</span>:</label>
                                    <input 
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        max="100"
                                        class="form-control" 
                                        id="mtk_semester_{{ $semester }}" 
                                        name="nilai_rapor[{{ $semester }}][mtk]" 
                                        value="{{ old('nilai_rapor.' . $semester . '.mtk') }}" 
                                        placeholder="Masukkan nilai MTK semester {{ $semester }}"
                                        required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bahasa_indonesia_semester_{{ $semester }}">Nilai Bahasa Indonesia <span class="text-danger">*</span>:</label>
                                    <input 
                                        type="number"
                                        step="0.01" 
                                        min="0"
                                        max="100"
                                        class="form-control" 
                                        id="bahasa_indonesia_semester_{{ $semester }}" 
                                        name="nilai_rapor[{{ $semester }}][bahasa_indonesia]" 
                                        value="{{ old('nilai_rapor.' . $semester . '.bahasa_indonesia') }}" 
                                        placeholder="Masukkan nilai B. Indonesia semester {{ $semester }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="ipa_semester_{{ $semester }}">Nilai IPA <span class="text-danger">*</span>:</label>
                                    <input 
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        max="100"
                                        class="form-control" 
                                        id="ipa_semester_{{ $semester }}" 
                                        name="nilai_rapor[{{ $semester }}][ipa]" 
                                        value="{{ old('nilai_rapor.' . $semester . '.ipa') }}" 
                                        placeholder="Masukkan nilai IPA semester {{ $semester }}"
                                        required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bahasa_inggris_semester_{{ $semester }}">Nilai Bahasa Inggris <span class="text-danger">*</span>:</label>
                                    <input 
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        max="100"
                                        class="form-control" 
                                        id="bahasa_inggris_semester_{{ $semester }}" 
                                        name="nilai_rapor[{{ $semester }}][bahasa_inggris]" 
                                        value="{{ old('nilai_rapor.' . $semester . '.bahasa_inggris') }}" 
                                        placeholder="Masukkan nilai B. Inggris semester {{ $semester }}"
                                        required>
                                </div>
                            </div>
                        </div>
                    @endfor
                    <div class="mt-3">
                        <div style="text-align: right;">
                            <button type="button" class="btn btn-secondary responsive-btn" id="prevTahap2">Kembali: Tahap 2</button>
                            <button type="submit" class="btn btn-success responsive-btn">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
    <div id="backToTop" class="back-to-top d-none">
        <i class="fas fa-arrow-up"></i>
    </div>
</div>    {{-- Tampilkan form pendaftaran --}}
@endif
@endsection

@section('scripts')
{{-- SA --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- SweetAlert Session Notification --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4CAF50',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jurusan1 = document.getElementById('pilihan_jurusan_1');
        const jurusan2 = document.getElementById('pilihan_jurusan_2');
        const jurusan3 = document.getElementById('pilihan_jurusan_3');
        
        // Daftar kode jurusan yang hanya bisa dipilih pada pilihan 1
        const restrictedCodes = ['TKR', 'TSM', 'TKJ'];

        function updateOptions() {
            const selectedJurusan1 = jurusan1.options[jurusan1.selectedIndex];
            const selectedJurusan2 = jurusan2.options[jurusan2.selectedIndex];
            const selectedJurusan3 = jurusan3.options[jurusan3.selectedIndex];

            const selectedCode1 = selectedJurusan1 ? selectedJurusan1.getAttribute('data-code') : null;
            const selectedCode2 = selectedJurusan2 ? selectedJurusan2.getAttribute('data-code') : null;
            const selectedCode3 = selectedJurusan3 ? selectedJurusan3.getAttribute('data-code') : null;

            // Menonaktifkan opsi pada pilihan jurusan kedua yang sama dengan pilihan pertama atau termasuk jurusan khusus
            for (let option of jurusan2.options) {
                const code = option.getAttribute('data-code');
                option.disabled = restrictedCodes.includes(code) || code === selectedCode1;
            }

            // Menonaktifkan opsi pada pilihan jurusan ketiga yang sama dengan pilihan pertama/kedua atau termasuk jurusan khusus
            for (let option of jurusan3.options) {
                const code = option.getAttribute('data-code');
                option.disabled = restrictedCodes.includes(code) || code === selectedCode1 || code === selectedCode2;
            }
        }

        jurusan1.addEventListener('change', updateOptions);
        jurusan2.addEventListener('change', updateOptions);
        jurusan3.addEventListener('change', updateOptions);
        
        // Initial call to set the right options on page load
        updateOptions();
    });

    /// Event listener untuk tombol "Lanjut ke Tahap 2"
    document.getElementById('nextTahap2').addEventListener('click', function() {
        var inputs = document.querySelectorAll('#formTahap1 .form-control');
        var isValid = true;

        inputs.forEach(function(input) {
            var errorText = document.createElement('div');
            errorText.classList.add('invalid-feedback');
            errorText.innerText = 'Wajib diisi';

            if (!input.checkValidity()) {
                isValid = false;
                input.classList.add('is-invalid');
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.after(errorText);
                }
            } else {
                input.classList.remove('is-invalid');
                if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.nextElementSibling.remove();
                }
            }
        });

        if (isValid) {
            document.getElementById('formTahap1').classList.add('d-none');
            document.getElementById('formTahap2').classList.remove('d-none');
        }

        document.getElementById('formTahap1').classList.add('d-none');
        document.getElementById('formTahap2').classList.remove('d-none');
    });

    // Event listener untuk tombol "Lanjut ke Tahap 3"
    document.getElementById('nextTahap3').addEventListener('click', function() {
        var inputs = document.querySelectorAll('#formTahap2 .form-control');
        var isValid = true;

        inputs.forEach(function(input) {
            var errorText = document.createElement('div');
            errorText.classList.add('invalid-feedback');
            errorText.innerText = 'Wajib diisi';

            if (!input.checkValidity()) {
                isValid = false;
                input.classList.add('is-invalid');
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.after(errorText);
                }
            } else {
                input.classList.remove('is-invalid');
                if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.nextElementSibling.remove();
                }
            }
        });

        if (isValid) {
            document.getElementById('formTahap2').classList.add('d-none');
            document.getElementById('formTahap3').classList.remove('d-none');
        }

        document.getElementById('formTahap2').classList.add('d-none');
        document.getElementById('formTahap3').classList.remove('d-none');
    });

    document.getElementById('pendaftaranForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Cegah submit langsung

        // Validasi Tahap 3
        var inputs = document.querySelectorAll('#formTahap3 .form-control');
        var isValid = true;

        inputs.forEach(function(input) {
            var errorText = document.createElement('div');
            errorText.classList.add('invalid-feedback');

            if (!input.checkValidity()) {
                errorText.innerText = 'Wajib diisi';
                isValid = false;
                input.classList.add('is-invalid');
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.after(errorText);
                }
            } else {
                input.classList.remove('is-invalid');
                if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.nextElementSibling.remove();
                }
            }
        });

        // Tampilkan dialog konfirmasi sebelum mengirim form
        if (isValid) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan semua data sudah benar sebelum submit!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, submit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form setelah konfirmasi
                    document.getElementById('pendaftaranForm').submit(); // Lakukan submit form
                }
            });
        }
    });

    // Event listener untuk tombol "Kembali ke Tahap 1"
    document.getElementById('prevTahap1').addEventListener('click', function() {
        document.getElementById('formTahap2').classList.add('d-none');
        document.getElementById('formTahap1').classList.remove('d-none');
    });

    // Event listener untuk tombol "Kembali ke Tahap 2"
    document.getElementById('prevTahap2').addEventListener('click', function() {
        document.getElementById('formTahap3').classList.add('d-none');
        document.getElementById('formTahap2').classList.remove('d-none');
    });

    // Setup validasi langsung untuk setiap input agar pesan error muncul/hilang saat mengetik
    function setupLiveValidation(formId) {
        var inputs = document.querySelectorAll(formId + ' .form-control');

        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                var errorText = document.createElement('div');
                errorText.classList.add('invalid-feedback');
                errorText.innerText = 'Harap isi dengan benar';

                if (!input.checkValidity()) {
                    input.classList.add('is-invalid');
                    if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
                        input.after(errorText);
                    }
                } else {
                    input.classList.remove('is-invalid');
                    if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                        input.nextElementSibling.remove();
                    }
                }
            });
        });
    }

    // Menyiapkan validasi langsung untuk setiap tahap
    setupLiveValidation('#formTahap1');
    setupLiveValidation('#formTahap2');
    setupLiveValidation('#formTahap3');
</script>
@endsection