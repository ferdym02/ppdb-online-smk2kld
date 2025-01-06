@extends('user.layouts.app')

@section('content')
<div class="card bg-light mt-3 text-dark">
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
            {{ $pendaftar->created_at->format('H:i:s') }}
        </p>
        <p class="card-text">
            
            @if ($pendaftar->status_pendaftaran == 'rejected')
                <p>
                    <strong>Status Pendaftaran:</strong> 
                    <span class="bg-warning" style="padding: 5px 10px; border-radius: 5px;">Ditolak</span>
                </p>
                <p class="card-text"><strong>Catatan Penolakan:</strong> {{ $pendaftar->catatan_penolakan }}</p>
            @elseif ($pendaftar->status_pendaftaran == 'pending')
                <p>
                    <strong>Status Pendaftaran:</strong> 
                    <span class="bg-secondary" style="color: white; padding: 5px 10px; border-radius: 5px;">Pending</span>
            @endif
        </p>            
    </div>
</div>
<div class="card mt-4">
    <div class="card-header text-white" style="background-color: #0a369d">
        Edit Data Pendaftaran
    </div>
    <div class="card-body">
        <div class="alert alert-warning mt-3">
            <strong>Perhatian:</strong> Khusus untuk pendaftarannya yang <strong>ditolak</strong>, perhatikan catatan penolakan dari admin dan pastikan Anda memperbaiki data yang keliru supaya pendaftaran Anda dapat terverifikasi.
        </div>
        <form id="pendaftaranForm" method="POST" action="{{ route('pendaftaran.update', $pendaftar->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hidden Field for Resubmission -->
            {{-- <input type="hidden" name="resubmission" value="true"> --}}
            <!-- Tahap 1: Data Diri -->
            <div id="formTahap1" class="form-tahap">
                <h3 class="mb-4 mt-1">Tahap 1: Data Diri</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $pendaftar->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $pendaftar->tempat_lahir) }}" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span>:</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pendaftar->tanggal_lahir) }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="asal_sekolah">Asal Sekolah <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah', $pendaftar->asal_sekolah) }}" required>
                            @error('asal_sekolah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nisn">NISN <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn', $pendaftar->nisn) }}" required>
                            @error('nisn')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span>:</label>
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" disabled {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_ayah">Nama Ayah <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $pendaftar->nama_ayah) }}" required>
                            @error('nama_ayah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_ibu">Nama Ibu <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $pendaftar->nama_ibu) }}" required>
                            @error('nama_ibu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nomor_wa">Nomor WA <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control @error('nomor_wa') is-invalid @enderror" id="nomor_wa" name="nomor_wa" value="{{ old('nomor_wa', $pendaftar->nomor_wa) }}" required>
                            @error('nomor_wa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat">Alamat <span class="text-danger">*</span>:</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pendaftar->alamat) }}</textarea>
                            @error('alamat')
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
                                <option value="1" {{ old('prestasi_akademik', $pendaftar->prestasi_akademik) == '1' ? 'selected' : '' }}>Ya</option>
                                <option value="0" {{ old('prestasi_akademik', $pendaftar->prestasi_akademik) == '0' ? 'selected' : '' }}>Tidak</option>
                            </select>
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
                                <option value="1" {{ old('prestasi_non_akademik', $pendaftar->prestasi_non_akademik) == '1' ? 'selected' : '' }}>Ya</option>
                                <option value="0" {{ old('prestasi_non_akademik', $pendaftar->prestasi_non_akademik) == '0' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('prestasi_non_akademik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="nextTahap2">Selanjutnya: Tahap 2</button>
            </div>
            
            <!-- Tahap 2: Upload Dokumen Pendukung -->
            <div id="formTahap2" class="form-tahap d-none">
                <h3 class="mt-1">Tahap 2: Upload Dokumen Pendukung</h3>
                <div class="alert alert-warning mt-3">
                    <strong>Perhatian:</strong> Hanya unggah ulang dokumen yang salah. Jika tidak ada kesalahan bisa dilewati.
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="kartu_keluarga">Kartu Keluarga <span class="text-danger">*</span>:</label>
                            <input type="file" class="form-control @error('kartu_keluarga') is-invalid @enderror" id="kartu_keluarga" name="kartu_keluarga">
                            @error('kartu_keluarga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($pendaftar->kartu_keluarga)
                                <a href="{{ asset('storage/'.$pendaftar->kartu_keluarga) }}" target="_blank">Lihat file lama</a>
                            @endif
                            <small class="d-block form-text text-muted">Tipe file: jpg/jpeg</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ktp_orang_tua">KTP Orang Tua/Wali <span class="text-danger">*</span>:</label>
                            <input type="file" class="form-control @error('ktp_orang_tua') is-invalid @enderror" id="ktp_orang_tua" name="ktp_orang_tua">
                            @error('ktp_orang_tua')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($pendaftar->ktp_orang_tua)
                                <a href="{{ asset('storage/'.$pendaftar->ktp_orang_tua) }}" target="_blank">Lihat file lama</a>
                            @endif
                            <small class="d-block form-text text-muted">Tipe file: jpg/jpeg</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="akte_kelahiran">Akte Kelahiran <span class="text-danger">*</span>:</label>
                            <input type="file" class="form-control @error('akte_kelahiran') is-invalid @enderror" id="akte_kelahiran" name="akte_kelahiran">
                            @error('akte_kelahiran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($pendaftar->akte_kelahiran)
                                <a href="{{ asset('storage/'.$pendaftar->akte_kelahiran) }}" target="_blank">Lihat file lama</a>
                            @endif
                            <small class="d-block form-text text-muted">Tipe file: jpg/jpeg</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ijazah">Ijazah/Surat Keterangan Lulus <span class="text-danger">*</span>:</label>
                            <input type="file" class="form-control @error('ijazah') is-invalid @enderror" id="ijazah" name="ijazah">
                            @error('ijazah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($pendaftar->ijazah)
                                <a href="{{ asset('storage/'.$pendaftar->ijazah) }}" target="_blank">Lihat file lama</a>
                            @endif
                            <small class="d-block form-text text-muted">Tipe file: jpg/jpeg</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="foto_calon_siswa">Foto Calon Siswa Ukuran 3x4 <span class="text-danger">*</span>:</label>
                            <input type="file" class="form-control @error('foto_calon_siswa') is-invalid @enderror" id="foto_calon_siswa" name="foto_calon_siswa">
                            @error('foto_calon_siswa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($pendaftar->foto_calon_siswa)
                                <a href="{{ asset('storage/'.$pendaftar->foto_calon_siswa) }}" target="_blank">Lihat file lama</a>
                            @endif
                            <small class="d-block form-text text-muted">Tipe file: jpg/jpeg</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="raport">Rapor Semester 1-5 <span class="text-danger">*</span>:</label>
                            <input type="file" class="form-control @error('raport') is-invalid @enderror" id="raport" name="raport">
                            @error('raport')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($pendaftar->raport)
                                <a href="{{ asset('storage/'.$pendaftar->raport) }}" target="_blank">Lihat file lama</a>
                            @endif
                            <small class="d-block form-text text-muted">Tipe file: pdf</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="piagam">Piagam/Sertifikat (Jika Ada):</label>
                            <input type="file" class="form-control @error('piagam') is-invalid @enderror" id="piagam" name="piagam">
                            @error('piagam')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($pendaftar->piagam)
                                <a href="{{ asset('storage/'.$pendaftar->piagam) }}" target="_blank">Lihat file lama</a>
                            @endif
                            <small class="d-block form-text text-muted">Tipe file: jpg/jpeg</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="surat_keterangan">Surat Keterangan Peringkat Kelas/Sekolah (Jika Ada):</label>
                            <input type="file" class="form-control @error('surat_keterangan') is-invalid @enderror" id="surat_keterangan" name="surat_keterangan">
                            @error('surat_keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($pendaftar->surat_keterangan)
                                <a href="{{ asset('storage/'.$pendaftar->surat_keterangan) }}" target="_blank">Lihat file lama</a>
                            @endif
                            <small class="d-block form-text text-muted">Tipe file: jpg/jpeg</small>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" id="prevTahap1">Kembali: Tahap 1</button>
                <button type="button" class="btn btn-primary" id="nextTahap3">Selanjutnya: Tahap 3</button>
            </div>

            <!-- Tahap 3: Nilai Rapor -->
            <div id="formTahap3" class="form-tahap d-none">
                <h3 class="mt-4">Tahap 3: Nilai Rapor Semester 1-5</h3>
                @for ($semester = 1; $semester <= 5; $semester++)
                    <h4 class="mt-3">Semester {{ $semester }}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mtk_semester_{{ $semester }}">Nilai MTK:</label>
                                <input type="number" class="form-control" id="mtk_semester_{{ $semester }}" name="nilai_rapor[{{ $semester }}][mtk]" value="{{ old('nilai_rapor.' . $semester . '.mtk', $pendaftar->{'nilai_mtk_semester_' . $semester}) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="bahasa_indonesia_semester_{{ $semester }}">Nilai Bahasa Indonesia:</label>
                                <input type="number" class="form-control" id="bahasa_indonesia_semester_{{ $semester }}" name="nilai_rapor[{{ $semester }}][bahasa_indonesia]" value="{{ old('nilai_rapor.' . $semester . '.bahasa_indonesia', $pendaftar->{'nilai_bahasa_indonesia_semester_' . $semester}) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ipa_semester_{{ $semester }}">Nilai IPA:</label>
                                <input type="number" class="form-control" id="ipa_semester_{{ $semester }}" name="nilai_rapor[{{ $semester }}][ipa]" value="{{ old('nilai_rapor.' . $semester . '.ipa', $pendaftar->{'nilai_ipa_semester_' . $semester}) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="bahasa_inggris_semester_{{ $semester }}">Nilai Bahasa Inggris:</label>
                                <input type="number" class="form-control" id="bahasa_inggris_semester_{{ $semester }}" name="nilai_rapor[{{ $semester }}][bahasa_inggris]" value="{{ old('nilai_rapor.' . $semester . '.bahasa_inggris', $pendaftar->{'nilai_bahasa_inggris_semester_' . $semester}) }}" required>
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="mt-3">
                    <button type="button" class="btn btn-secondary" id="prevTahap2">Kembali: Tahap 2</button>
                    <button type="submit" class="btn btn-success">Simpan Pembaruan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
{{-- SA --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    // Event listener untuk tombol "Lanjut ke Tahap 2"
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
        document.getElementById('formTahap2').classList.add('d-none');
        document.getElementById('formTahap3').classList.remove('d-none');
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
        console.log('Event submit berjalan'); // Debug log
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
            } else if (input.value < 0) {
                errorText.innerText = 'Minimal nilai 0';
                isValid = false;
                input.classList.add('is-invalid');
                input.after(errorText);
            } else if (input.value > 100) {
                errorText.innerText = 'Maksimal nilai 100';
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
                text: "Pastikan semua data sudah benar sebelum disimpan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
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