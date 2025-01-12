@extends('user.layouts.app')

@section('content')
@if ($pendaftar)
    <div class="card mt-3 text-dark">
        <div class="card-header text-white" style="background-color: #0a369d">
            Informasi Pendaftaran
        </div>
        <div class="card-body">
            <p class="card-text">
                <strong>Tanggal Pendaftaran:</strong> 
                {{ $pendaftar->created_at->format('d-m-Y') }}
            </p>
            <p class="card-text">
                <strong>Jam Pendaftaran:</strong> 
                {{ $pendaftar->created_at->format('H:i:s') }} WIB
            </p>
            <p class="card-text">
                @if($pendaftar->status_pendaftaran == 'verified')
                    <p>
                        <strong>Status Pendaftaran:</strong> 
                        <span class="bg-primary" style="color: white; padding: 5px 10px; border-radius: 5px;">Terverifikasi</span>
                    </p>
                    <p class="alert alert-success">
                        Pendaftaran Anda sudah terverifikasi, silahkan cek tanggal Tes Minat dan Bakat Anda di <a href="/user/dashboard">dashboard</a>.
                    </p>
                    <p class="alert alert-info">
                        Silakan menunggu hasil tes pada halaman ini setelah Anda melakukan Tes Minat dan Bakat.
                    </p>
                    <a href="{{ route('pendaftar.cetakBukti', $pendaftar->id) }}" class="btn btn-success">Cetak Bukti Pendaftaran</a>
                @elseif ($pendaftar->status_pendaftaran == 'rejected')
                    <p>
                        <strong>Status Pendaftaran:</strong> 
                        <span class="bg-warning" style="padding: 5px 10px; border-radius: 5px;">Ditolak</span>
                    </p>
                    <p class="card-text"><strong>Catatan Penolakan:</strong> {{ $pendaftar->catatan_penolakan }}</p>
                    <div class="alert alert-warning mt-3">
                        <strong>Perhatian:</strong> Segera edit data yang salah sesuai dengan informasi dari catatan penolakan supaya data pendaftaran Anda dapat segera diverifikasi kembali oleh admin.
                    </div>
                    <a href="{{ route('pendaftaran.edit', $pendaftar->id) }}" class="btn btn-info">Edit Data</a>
                @elseif ($pendaftar->status_pendaftaran == 'pending')
                    <p>
                        <strong>Status Pendaftaran:</strong> 
                        <span class="bg-secondary" style="color: white; padding: 5px 10px; border-radius: 5px;">Pending</span>
                        <div class="alert alert-info mt-3">
                            Silakan menunggu data pendaftaran Anda diverifikasi oleh admin dan cek secara berkala.
                        </div>
                    </p>
                    <a href="{{ route('pendaftaran.edit', $pendaftar->id) }}" class="btn btn-warning">Edit Data</a>
                @elseif ($pendaftar->status_pendaftaran == 'gugur')
                    <p>
                        <strong>Status Pendaftaran:</strong> 
                        <span class="bg-danger" style="color: white; padding: 5px 10px; border-radius: 5px;">Gugur</span>
                        <div class="alert alert-info mt-3">
                            Kami menyesal untuk memberitahukan bahwa Anda <strong>tidak lolos</strong> dalam seleksi penerimaan. Kami mengapresiasi usaha dan waktu yang telah Anda berikan. Jangan menyerah, teruslah berusaha dan semoga sukses di kesempatan berikutnya!
                        </div>
                    </p>
                @elseif ($pendaftar->status_pendaftaran == 'cadangan')
                    <p>
                        <strong>Status Pendaftaran:</strong> 
                        <span class="bg-info" style="padding: 5px 10px; border-radius: 5px;">Cadangan</span>
                        <p><strong>Cadangan di jurusan:</strong> {{ $pendaftar->jurusanDiterima->nama }}</p>
                        <div class="alert alert-info mt-3">
                            Saat ini status Anda sebagai cadangan di jurusan tersebut. Anda dapat menunggu pihak panitia mengontak Anda jika ada calon peserta didik baru yang mengundurkan diri dan Anda akan otomatis <strong>diterima</strong>.
                        </div>
                    </p>
                    <a href="{{ route('pendaftar.cetakBukti', $pendaftar->id) }}" class="btn btn-success">Cetak Bukti Pendaftaran</a>
                @elseif ($pendaftar->status_pendaftaran == 'diterima')
                    <p>
                        <strong>Status Pendaftaran:</strong> 
                        <span class="bg-success" style="color: white; padding: 5px 10px; border-radius: 5px;">Diterima</span>
                        <p><strong>Diterima di jurusan:</strong> {{ $pendaftar->jurusanDiterima->nama }}</p>
                        <strong>Status Daftar Ulang:</strong>
                        @if (is_null($pendaftar->daftar_ulang))
                            <span>Belum</span>
                        @elseif ($pendaftar->daftar_ulang === 'tidak')
                            <span>Tidak</span>
                        @elseif ($pendaftar->daftar_ulang === 'ya')
                            <span>Sudah</span>
                        @endif
                        <div class="alert alert-info mt-3">
                            Selamat! Anda telah diterima dalam proses PPDB. Silakan segera melakukan <strong>daftar ulang</strong> sesuai dengan tanggal yang ada di jadwal. Terkait tata cara daftar ulang dapat dilihat pada menu <a href="/user/pengumuman">Pengumuman</a>.
                        </div>
                    <a href="{{ route('pendaftar.cetakBukti', $pendaftar->id) }}" class="btn btn-success">Cetak Bukti Pendaftaran</a>
                @endif
            </p>            
        </div>
    </div>
@else
    <h5>Silahkan isi formulir untuk melakukan pendaftaran</h5>
    <div class="alert alert-warning mt-3">
        <strong>Perhatian:</strong> Pastikan Anda mengisi semua data dengan benar dan hati-hati. Data yang Anda masukkan akan digunakan dalam proses seleksi, jadi periksa kembali setiap informasi sebelum menyimpan. Kesalahan dalam pengisian data dapat mempengaruhi hasil pendaftaran Anda. Terima kasih.
    </div>
    <div class="alert alert-info mt-3">
        <strong>Catatan:</strong> Field yang ditandai dengan <span class="text-danger">*</span> wajib diisi.
    </div>
@endif
<div class="card card-info card-outline mt-3 mb-3">
    <div class="card-header text-white" style="background-color: #0a369d">
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
                            <th>Prestasi Akademik</th>
                            <td>: {{ $pendaftar->prestasi_akademik ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <th>Prestasi Non Akademik</th>
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
                                    <img src="{{ asset('storage/' . $pendaftar->kartu_keluarga) }}" alt="Kartu Keluarga" style="max-width: 150px;">
                                    
                                    <a href="{{ asset('storage/' . $pendaftar->kartu_keluarga) }}" target="_blank">Lihat</a>
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
                                    <img src="{{ asset('storage/' . $pendaftar->ktp_orang_tua) }}" alt="KTP Orang Tua/Wali" style="max-width: 150px;">
                                    
                                    <a href="{{ asset('storage/' . $pendaftar->ktp_orang_tua) }}" target="_blank">Lihat</a>
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
                                    <img src="{{ asset('storage/' . $pendaftar->akte_kelahiran) }}" alt="Akte Kelahiran" style="max-width: 150px;">
                                    
                                    <a href="{{ asset('storage/' . $pendaftar->akte_kelahiran) }}" target="_blank">Lihat</a>
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
                                    <img src="{{ asset('storage/' . $pendaftar->ijazah) }}" alt="Ijazah" style="max-width: 150px;">
                                    
                                    <a href="{{ asset('storage/' . $pendaftar->ijazah) }}" target="_blank">Lihat</a>
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
                            <th style="width: 50%">Foto Calon Siswa Ukuran 3x4</th>
                            <td>
                                :
                                @if ($pendaftar->foto_calon_siswa)
                                    <img src="{{ asset('storage/' . $pendaftar->foto_calon_siswa) }}" alt="Foto Calon Siswa" style="max-width: 150px;">
                                    
                                    <a href="{{ asset('storage/' . $pendaftar->foto_calon_siswa) }}" target="_blank">Lihat</a>
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
                                    <a href="{{ asset('storage/' . $pendaftar->raport) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Piagam/Sertifikat</th>
                            <td>
                                :
                                @if ($pendaftar->piagam)
                                    <img src="{{ asset('storage/' . $pendaftar->piagam) }}" alt="Piagam/Sertifikat" style="max-width: 150px;">
                                    
                                    <a href="{{ asset('storage/' . $pendaftar->piagam) }}" target="_blank">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 50%">Surat Keterangan Peringkat Kelas/Sekolah</th>
                            <td>
                                :
                                @if ($pendaftar->surat_keterangan)
                                    <img src="{{ asset('storage/' . $pendaftar->surat_keterangan) }}" alt="Surat Keterangan" style="max-width: 150px;">
                                    
                                    <a href="{{ asset('storage/' . $pendaftar->surat_keterangan) }}" target="_blank">Lihat</a>
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
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
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
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
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
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn') }}" required>
                                @error('nisn')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="asal_sekolah">Asal Sekolah <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}" required>
                                @error('asal_sekolah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_ayah">Nama Ayah <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" required>
                                @error('nama_ayah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_ibu">Nama Ibu <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" required>
                                @error('nama_ibu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="prestasi_akademik">Prestasi Akademik <span class="text-danger">*</span>:</label>
                                <select class="form-control @error('prestasi_akademik') is-invalid @enderror" id="prestasi_akademik" name="prestasi_akademik" required>
                                    <option value="" disabled selected>Memiliki Prestasi Akademik?</option>
                                    <option value="1" {{ old('prestasi_akademik') == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ old('prestasi_akademik') == '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                @error('prestasi_akademik')
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
                                <label for="nomor_wa">Nomor WA <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('nomor_wa') is-invalid @enderror" id="nomor_wa" name="nomor_wa" value="{{ old('nomor_wa') }}" required>
                                @error('nomor_wa')
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
                                @error('prestasi_non_akademik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <strong>Catatan:</strong> Jurusan <strong>Teknik Komputer dan Jaringan</strong>, <strong>Teknik Kendaraan Ringan</strong>, dan <strong>Teknik Sepeda Motor</strong> hanya bisa dipilih di Pilihan Jurusan 1.
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="pilihan_jurusan_1">Pilihan Jurusan 1 <span class="text-danger">*</span>:</label>
                                <select class="form-control" id="pilihan_jurusan_1" name="pilihan_jurusan_1" required>
                                    <option value="" disabled selected>Pilih Jurusan 1</option>
                                    @foreach($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" data-code="{{ $jurusan->kode }}" {{ old('pilihan_jurusan_1') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="pilihan_jurusan_2">Pilihan Jurusan 2 <span class="text-danger">*</span>:</label>
                                <select class="form-control" id="pilihan_jurusan_2" name="pilihan_jurusan_2" required>
                                    <option value="" disabled selected>Pilih Jurusan 2</option>
                                    @foreach($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" data-code="{{ $jurusan->kode }}" {{ old('pilihan_jurusan_2') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="pilihan_jurusan_3">Pilihan Jurusan 3 <span class="text-danger">*</span>:</label>
                                <select class="form-control" id="pilihan_jurusan_3" name="pilihan_jurusan_3" required>
                                    <option value="" disabled selected>Pilih Jurusan 3</option>
                                    @foreach($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" data-code="{{ $jurusan->kode }}" {{ old('pilihan_jurusan_3') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="nextTahap2">Selanjutnya: Tahap 2</button>
                </div>
            
                <!-- Tahap 2: Upload Dokumen Pendukung -->
                <div id="formTahap2" class="form-tahap d-none">
                    <p class="mb-4 mt-1"><strong>Tahap 2: Upload Dokumen Pendukung</strong></p>
                    <div class="alert alert-warning mt-3">
                        <strong>Perhatian:</strong> Scan dokumen kemudian unggah dokumen yang dibutuhkan. Perhatikan tipe file yang diunggah seperti <strong>jpg/jpeg/pdf</strong>, maksimal ukuran file <strong>2MB</strong>.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kartu_keluarga">Kartu Keluarga <span class="text-danger">*</span>:</label>
                                <input type="file"  class="form-control @error('kartu_keluarga') is-invalid @enderror" id="kartu_keluarga" name="kartu_keluarga" required>
                                @error('kartu_keluarga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ktp_orang_tua">KTP Orang Tua/Wali <span class="text-danger">*</span>:</label>
                                <input type="file" class="form-control @error('ktp_orang_tua') is-invalid @enderror" id="ktp_orang_tua" name="ktp_orang_tua" required>
                                @error('kartu_keluarga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="akte_kelahiran">Akte Kelahiran <span class="text-danger">*</span>:</label>
                                <input type="file" class="form-control @error('akte_kelahiran') is-invalid @enderror" id="akte_kelahiran" name="akte_kelahiran" required>
                                @error('akte_kelahiran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ijazah">Ijazah/Surat Keterangan Lulus <span class="text-danger">*</span>:</label>
                                <input type="file" class="form-control @error('ijazah') is-invalid @enderror" id="ijazah" name="ijazah" required>
                                @error('ijazah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="foto">Foto Calon Siswa Ukuran 3x4 <span class="text-danger">*</span>:</label>
                                <input type="file" class="form-control @error('foto_calon_siswa') is-invalid @enderror" id="foto" name="foto_calon_siswa" required>
                                @error('foto_calon_siswa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="raport">Rapor Semester 1-5 <span class="text-danger">*</span>:</label>
                                <input type="file" class="form-control @error('raport') is-invalid @enderror" id="raport" name="raport" required>
                                @error('raport')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: pdf</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="paiagam">Piagam/Sertifikat (Jika Ada):</label>
                                <input type="file" class="form-control @error('piagam') is-invalid @enderror" id="paiagam" name="piagam">
                                @error('piagam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="surat_keterangan">Surat Keterangan Peringkat Kelas/Sekolah (Jika Ada):</label>
                                <input type="file" class="form-control @error('surat_keterangan') is-invalid @enderror" id="surat_keterangan" name="surat_keterangan">
                                @error('surat_keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Tipe file: jpg/jpeg/pdf</small>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="prevTahap1">Kembali: Tahap 1</button>
                    <button type="button" class="btn btn-primary" id="nextTahap3">Selanjutnya: Tahap 3</button>
                </div>

                <!-- Tahap 3: Nilai Rapor -->
                <div id="formTahap3" class="form-tahap d-none">
                    <p class="mb-4 mt-1"><strong>Tahap 3: Nilai Rapor Semester 1-5</strong></p>
                    @for ($semester = 1; $semester <= 5; $semester++)
                        <h4 class="mt-3">Semester {{ $semester }}</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mtk_semester_{{ $semester }}">Nilai MTK:</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="mtk_semester_{{ $semester }}" 
                                        name="nilai_rapor[{{ $semester }}][mtk]" 
                                        value="{{ old('nilai_rapor.' . $semester . '.mtk') }}" 
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="bahasa_indonesia_semester_{{ $semester }}">Nilai Bahasa Indonesia:</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="bahasa_indonesia_semester_{{ $semester }}" 
                                        name="nilai_rapor[{{ $semester }}][bahasa_indonesia]" 
                                        value="{{ old('nilai_rapor.' . $semester . '.bahasa_indonesia') }}" 
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ipa_semester_{{ $semester }}">Nilai IPA:</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="ipa_semester_{{ $semester }}" 
                                        name="nilai_rapor[{{ $semester }}][ipa]" 
                                        value="{{ old('nilai_rapor.' . $semester . '.ipa') }}" 
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="bahasa_inggris_semester_{{ $semester }}">Nilai Bahasa Inggris:</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="bahasa_inggris_semester_{{ $semester }}" 
                                        name="nilai_rapor[{{ $semester }}][bahasa_inggris]" 
                                        value="{{ old('nilai_rapor.' . $semester . '.bahasa_inggris') }}" 
                                        required>
                                </div>
                            </div>
                        </div>
                    @endfor
                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary" id="prevTahap2">Kembali: Tahap 2</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

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

            // Update jurusan2 options
            for (let option of jurusan2.options) {
                const code = option.getAttribute('data-code');
                option.disabled = restrictedCodes.includes(code) || code === selectedCode1;
            }
            
            // Update jurusan3 options
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

    // Menambahkan event listener untuk setiap input di Tahap 1 dan Tahap 2 agar pesan invalid hilang saat input diisi
    function setupLiveValidation(formId) {
        var inputs = document.querySelectorAll(formId + ' .form-control');

        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                var errorText = document.createElement('div');
                errorText.classList.add('invalid-feedback');
                errorText.innerText = 'Wajib diisi';

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

    document.getElementById('pendaftaranForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Cegah submit langsung

        // Validasi Tahap 3
        var inputs = document.querySelectorAll('#formTahap3 .form-control');
        var isValid = true;

        inputs.forEach(function(input) {
            var errorText = document.createElement('div');
            errorText.classList.add('invalid-feedback');

            // Hapus pesan kesalahan sebelumnya jika ada
            if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                input.nextElementSibling.remove();
            }

            if (input.value.trim() === '') {
                errorText.innerText = 'Wajib diisi';
                isValid = false;
                input.classList.add('is-invalid');
                input.after(errorText);
            } else if (input.value > 100) {
                errorText.innerText = 'Maksimal nilai 100';
                isValid = false;
                input.classList.add('is-invalid');
                input.after(errorText);
            } else if (input.value < 0) {
                errorText.innerText = 'Minimal nilai 0';
                isValid = false;
                input.classList.add('is-invalid');
                input.after(errorText);
            } else {
                input.classList.remove('is-invalid');
                if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.nextElementSibling.remove();
                }
            }
        });

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

    // Menyiapkan validasi langsung untuk setiap tahap
    setupLiveValidation('#formTahap1');
    setupLiveValidation('#formTahap2');
    setupLiveValidation('#formTahap3');

    
</script>
@endsection
