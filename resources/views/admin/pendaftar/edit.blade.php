@extends('admin.main')

@section('content')
<main class="app-main">
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
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
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->

    <div class="app-content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Ada kesalahan dalam input:</strong>
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <form id="updateForm" method="POST" action="{{ route('pendaftar.update', $pendaftar->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="text-center">Data Pribadi</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="nama_lengkap">Nama Lengkap:</label>
                                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ $pendaftar->nama_lengkap }}" required>
                                            @error('nama_lengkap')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="tempat_lahir">Tempat Lahir:</label>
                                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ $pendaftar->tempat_lahir }}" required>
                                            @error('tempat_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="tanggal_lahir">Tanggal Lahir:</label>
                                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ $pendaftar->tanggal_lahir }}" required>
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="jenis_kelamin">Jenis Kelamin:</label>
                                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="Laki-laki" {{ $pendaftar->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ $pendaftar->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="alamat">Alamat:</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required>{{ $pendaftar->alamat }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="nisn">NISN:</label>
                                            <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ $pendaftar->nisn }}" required>
                                            @error('nisn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="asal_sekolah">Asal Sekolah:</label>
                                            <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" id="asal_sekolah" name="asal_sekolah" value="{{ $pendaftar->asal_sekolah }}" required>
                                            @error('asal_sekolah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="nama_ayah">Nama Ayah:</label>
                                            <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah" name="nama_ayah" value="{{ $pendaftar->nama_ayah }}" required>
                                            @error('nama_ayah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="nama_ibu">Nama Ibu:</label>
                                            <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ $pendaftar->nama_ibu }}" required>
                                            @error('nama_ibu')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="nomor_wa">Nomor WA:</label>
                                            <input type="text" class="form-control @error('nomor_wa') is-invalid @enderror" id="nomor_wa" name="nomor_wa" value="{{ $pendaftar->nomor_wa }}" required>
                                            @error('nomor_wa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="prestasi_akademik">Prestasi Akademik:</label>
                                            <select class="form-control @error('prestasi_akademik') is-invalid @enderror" id="prestasi_akademik" name="prestasi_akademik" required>
                                                <option value="1" {{ $pendaftar->prestasi_akademik == 1 ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $pendaftar->prestasi_akademik == 0 ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                            @error('prestasi_akademik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="prestasi_non_akademik">Prestasi Non Akademik:</label>
                                            <select class="form-control @error('prestasi_akademik') is-invalid @enderror" id="prestasi_non_akademik" name="prestasi_non_akademik" required>
                                                <option value="1" {{ $pendaftar->prestasi_non_akademik == 1 ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $pendaftar->prestasi_non_akademik == 0 ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                            @error('prestasi_non_akademik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr class="border border-info border-1 opacity-75">
                                <div class="row">
                                    <h5 class="text-center">Dokumen Pendukung</h5>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="kartu_keluarga">Kartu Keluarga:</label>
                                            <input type="file" class="form-control @error('kartu_keluarga') is-invalid @enderror" id="kartu_keluarga" name="kartu_keluarga">
                                            @if ($pendaftar->kartu_keluarga)
                                                <p><a href="{{ asset('storage/' . $pendaftar->kartu_keluarga) }}" target="_blank">Lihat</a></p>
                                            @endif
                                            @error('kartu_keluarga')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="ktp_orang_tua">KTP Orang Tua/Wali:</label>
                                            <input type="file" class="form-control @error('ktp_orang_tua') is-invalid @enderror" id="ktp_orang_tua" name="ktp_orang_tua">
                                            @if ($pendaftar->ktp_orang_tua)
                                                <p><a href="{{ asset('storage/' . $pendaftar->ktp_orang_tua) }}" target="_blank">Lihat</a></p>
                                            @endif
                                            @error('ktp_orang_tua')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="akte_kelahiran">Akte Kelahiran:</label>
                                            <input type="file" class="form-control @error('akte_kelahiran') is-invalid @enderror" id="akte_kelahiran" name="akte_kelahiran">
                                            @if ($pendaftar->akte_kelahiran)
                                                <p><a href="{{ asset('storage/' . $pendaftar->akte_kelahiran) }}" target="_blank">Lihat</a></p>
                                            @endif
                                            @error('akte_kelahiran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="piagam">Piagam/Sertifikat (jika ada):</label>
                                            <input type="file" class="form-control @error('piagam') is-invalid @enderror" id="piagam" name="piagam">
                                            @if ($pendaftar->piagam)
                                                <p><a href="{{ asset('storage/' . $pendaftar->piagam) }}" target="_blank">Lihat</a></p>
                                            @endif
                                            @error('piagam')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="foto_calon_siswa">Foto Calon Siswa (3x4):</label>
                                            <input type="file" class="form-control @error('foto_calon_siswa') is-invalid @enderror" id="foto_calon_siswa" name="foto_calon_siswa">
                                            @if ($pendaftar->foto_calon_siswa)
                                                <p><a href="{{ asset('storage/' . $pendaftar->foto_calon_siswa) }}" target="_blank">Lihat</a></p>
                                            @endif
                                            @error('foto_calon_siswa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="raport">Raport Semester 1 - 5:</label>
                                            <input type="file" class="form-control @error('raport') is-invalid @enderror" id="raport" name="raport">
                                            @if ($pendaftar->raport)
                                                <p><a href="{{ asset('storage/' . $pendaftar->raport) }}" target="_blank">Lihat</a></p>
                                            @endif
                                            @error('raport')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="ijazah">Ijazah/Surat Keterangan Lulus:</label>
                                            <input type="file" class="form-control @error('ijazah') is-invalid @enderror" id="ijazah" name="ijazah">
                                            @if ($pendaftar->ijazah)
                                                <p><a href="{{ asset('storage/' . $pendaftar->ijazah) }}" target="_blank">Lihat</a></p>
                                            @endif
                                            @error('ijazah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="surat_keterangan">Surat Keterangan Peringkat Kelas/Sekolah (jika ada):</label>
                                            <input type="file" class="form-control @error('surat_keterangan') is-invalid @enderror" id="surat_keterangan" name="surat_keterangan">
                                            @if ($pendaftar->surat_keterangan)
                                                <p><a href="{{ asset('storage/' . $pendaftar->surat_keterangan) }}" target="_blank">Lihat</a></p>
                                            @endif
                                            @error('surat_keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr class="border border-info border-1 opacity-75">
                                <div class="row">
                                    <h5 class="text-center">Nilai Rapor</h5>
                                    <div class="col-md-4">
                                        @for ($semester = 1; $semester <= 2; $semester++)
                                            <h6><strong>Semester {{ $semester }}</strong></h6>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_mtk">Nilai MTK:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_mtk" name="nilai_rapor[{{ $semester }}][mtk]" value="{{ old('nilai_rapor.'.$semester.'.mtk', $pendaftar->{'nilai_mtk_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_ipa">Nilai IPA:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_ipa" name="nilai_rapor[{{ $semester }}][ipa]" value="{{ old('nilai_rapor.'.$semester.'.ipa', $pendaftar->{'nilai_ipa_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_bahasa_indonesia">Nilai Bahasa Indonesia:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_bahasa_indonesia" name="nilai_rapor[{{ $semester }}][bahasa_indonesia]" value="{{ old('nilai_rapor.'.$semester.'.bahasa_indonesia', $pendaftar->{'nilai_bahasa_indonesia_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_bahasa_inggris">Nilai Bahasa Inggris:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_bahasa_inggris" name="nilai_rapor[{{ $semester }}][bahasa_inggris]" value="{{ old('nilai_rapor.'.$semester.'.bahasa_inggris', $pendaftar->{'nilai_bahasa_inggris_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="col-md-4">
                                        @for ($semester = 3; $semester <= 4; $semester++)
                                            <h6><strong>Semester {{ $semester }}</strong></h6>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_mtk">Nilai MTK:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_mtk" name="nilai_rapor[{{ $semester }}][mtk]" value="{{ old('nilai_rapor.'.$semester.'.mtk', $pendaftar->{'nilai_mtk_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_ipa">Nilai IPA:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_ipa" name="nilai_rapor[{{ $semester }}][ipa]" value="{{ old('nilai_rapor.'.$semester.'.ipa', $pendaftar->{'nilai_ipa_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_bahasa_indonesia">Nilai Bahasa Indonesia:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_bahasa_indonesia" name="nilai_rapor[{{ $semester }}][bahasa_indonesia]" value="{{ old('nilai_rapor.'.$semester.'.bahasa_indonesia', $pendaftar->{'nilai_bahasa_indonesia_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_bahasa_inggris">Nilai Bahasa Inggris:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_bahasa_inggris" name="nilai_rapor[{{ $semester }}][bahasa_inggris]" value="{{ old('nilai_rapor.'.$semester.'.bahasa_inggris', $pendaftar->{'nilai_bahasa_inggris_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="col-md-4">
                                        @for ($semester = 5; $semester <= 5; $semester++)
                                            <h6><strong>Semester {{ $semester }}</strong></h6>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_mtk">Nilai MTK:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_mtk" name="nilai_rapor[{{ $semester }}][mtk]" value="{{ old('nilai_rapor.'.$semester.'.mtk', $pendaftar->{'nilai_mtk_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_ipa">Nilai IPA:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_ipa" name="nilai_rapor[{{ $semester }}][ipa]" value="{{ old('nilai_rapor.'.$semester.'.ipa', $pendaftar->{'nilai_ipa_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_bahasa_indonesia">Nilai Bahasa Indonesia:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_bahasa_indonesia" name="nilai_rapor[{{ $semester }}][bahasa_indonesia]" value="{{ old('nilai_rapor.'.$semester.'.bahasa_indonesia', $pendaftar->{'nilai_bahasa_indonesia_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="nilai_rapor_{{ $semester }}_bahasa_inggris">Nilai Bahasa Inggris:</label>
                                                <input type="number" class="form-control" id="nilai_rapor_{{ $semester }}_bahasa_inggris" name="nilai_rapor[{{ $semester }}][bahasa_inggris]" value="{{ old('nilai_rapor.'.$semester.'.bahasa_inggris', $pendaftar->{'nilai_bahasa_inggris_semester_'.$semester} ) }}" min="0" max="100" required>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="button" id="confirmUpdate" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.getElementById('confirmUpdate').addEventListener('click', function (e) {
        Swal.fire({
            title: 'Konfirmasi Pembaruan',
            text: "Apakah Anda yakin ingin memperbarui data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, perbarui!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('updateForm').submit();
            }
        });
    });
</script>
@endsection