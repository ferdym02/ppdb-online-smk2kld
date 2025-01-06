@extends('user.layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header Selamat Datang -->
    <div class="jumbotron text-center py-4 mb-4">
        <h1 class="display-5">Selamat Datang Calon Peserta Didik Baru</h1>
        <p class="lead">di PPDB Online SMK Negeri 2 Kalianda Jalur Reguler</p>
    </div>
    <div class="row">
        <!-- Sidebar Navigasi -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Daftar Isi</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="#info" class="text-decoration-none">Info Penting</a></li>
                        <li class="list-group-item"><a href="#persyaratan" class="text-decoration-none">Persyaratan PPDB</a></li>
                        <li class="list-group-item"><a href="#panduan" class="text-decoration-none">Panduan Pendaftaran</a></li>
                        <li class="list-group-item"><a href="#jadwal" class="text-decoration-none">Jadwal PPDB</a></li>
                        <li class="list-group-item"><a href="#test" class="text-decoration-none">Tes Minat dan Bakat</a></li>
                        <li class="list-group-item"><a href="#kontak" class="text-decoration-none">Kontak Panitia</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Status Pendaftaran -->
            <div class="card mb-4 shadow-sm" id="info">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Info Penting</h5>
                </div>
                <div class="card-body">
                    @if($isRegistrationOpen)
                        <div class="alert alert-info" role="alert">
                            Pendaftaran sedang dibuka. Silakan lakukan pendaftaran.
                        </div>
                        <div class="alert alert-warning" role="alert">
                            Harap <strong>membaca seluruh informasi</strong> yang ada di halaman dashboard calon peserta didik baru ini dengan seksama <strong>sebelum melakukan pendaftaran</strong>!
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Saat ini tidak ada periode pendaftaran yang aktif.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Persyaratan PPDB -->
            <div class="card mb-4 shadow-sm" id="persyaratan">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Persyaratan PPDB</h5>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Telah dinyatakan lulus dari SMP/MTS/Sederajat dan memiliki Ijazah/Surat Keterangan Lulus</li>
                        <li>Berusia paling tinggi 21 tahun</li>
                        <li>Mengisi formulir pendaftaran dan mengunggah scan dokumen berupa:</li>
                        <ul>
                            <li>Kartu Keluarga dan KTP orang tua / wali</li>
                            <li>Akte Kelahiran</li>
                            <li>Ijazah/Surat Keterangan Lulus</li>
                            <li>Pas foto berwarna 3 x 4</li>
                            <li>Raport semester 1-5</li>
                            <li>Piagam/Sertifikat (jika ada)</li>
                            <li>Surat Keterangan Peringkat Kelas/Sekolah (jika ada)</li>
                        </ul>
                    </ol>
                </div>
            </div>

            <!-- Panduan Pendaftaran -->
            <div class="card mb-4 shadow-sm" id="panduan">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Panduan Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fas fa-file-alt mr-2 text-primary me-2"></i>
                            <span>Calon peserta didik baru menyiapkan berkas persyaratan.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fas fa-globe mr-2 text-primary me-2"></i>
                            <span>Calon peserta didik baru akses laman situs PPDB Online SMK Negeri 2 Kalianda.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fas fa-edit mr-2 text-primary me-2"></i>
                            <span>Calon peserta didik baru melakukan pengajuan <a href="/user/pendaftaran">pendaftaran</a> mandiri dengan mengisi formulir dan mengunggah dokumen persyaratan secara online.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fas fa-clock mr-2 text-primary me-2"></i>
                            <span>Calon peserta didik baru menunggu verifikasi pendaftaran oleh admin yang dapat dilihat pada laman <a href="/user/pendaftaran">pendaftaran</a>.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-circle-xmark mr-2 text-primary me-2"></i>
                            <span>Jika pendaftaran belum terverifikasi, calon peserta didik baru dapat melakukan edit data pendaftaran sesuai catatan dari admin.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fas fa-check-circle mr-2 text-primary me-2"></i>
                            <span>Jika pendaftaran calon peserta didik baru sudah terverifikasi, calon peserta didik baru dapat mencetak bukti pendaftaran.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fas fa-calendar-alt mr-2 text-primary me-2"></i>
                            <span>Calon peserta didik baru mendapat jadwal Tes Minat dan Bakat yang dapat dilihat <a href="#test">disini</a>.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fas fa-clipboard-check mr-2 text-primary me-2"></i>
                            <span>Calon peserta didik baru melakukan Tes Minat dan Bakat di SMK Negeri 2 Kalianda sesuai jadwal dan dengan tata cara yang dapat dilihat <a href="#test">disini</a>.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-eye mr-2 text-primary me-2"></i>
                            <span>Calon peserta didik baru melihat hasil seleksi dan pengumuman secara online di laman <a href="/user/pendaftaran">pendaftaran</a> pada bagian informasi pendaftaran.</span>
                        </li>
                        <li class="mb-3 d-flex justify-content-start align-items-center">
                            <i class="fas fa-bullhorn mr-2 text-primary me-2"></i>
                            <span>Untuk informasi terkait daftar ulang dan info tambahan harap cek halaman <a href="/user/pengumuman">pengumuman</a> secara berkala.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Jadwal Pelaksanaan Umum -->
            <div class="card mb-4 shadow-sm" id="jadwal">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Jadwal Pelaksanaan PPDB SMK Negeri 2 Kalianda</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>KEGIATAN</th>
                            <th>LOKASI</th>
                            <th>TANGGAL</th>
                            <th>WAKTU</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            // Array warna yang bisa dipilih secara acak
                            $colors = ['red', 'blue', 'green', 'orange', 'purple', 'brown',];
                            $usedColors = [];
                            @endphp
                            @foreach($jadwals as $jadwal)
                            @php
                            // Filter warna yang belum digunakan
                            $availableColors = array_diff($colors, $usedColors);
                            
                            // Pilih warna dari warna yang belum digunakan
                            if (count($availableColors) > 0) {
                                $colorToUse = array_shift($availableColors); // Ambil warna pertama dari yang tersedia
                            } else {
                                $colorToUse = 'black'; // Jika semua warna sudah digunakan, gunakan warna default
                            }
                            
                            // Simpan warna yang sudah digunakan
                            $usedColors[] = $colorToUse;
                            @endphp
                            <tr>
                                <td style="color: {{ $colorToUse }}">{{ $jadwal->kegiatan }}</td>
                                <td>{{ $jadwal->lokasi }}</td>
                                <td>
                                {{ $jadwal->tanggal_mulai->format('d M Y') }}
                                @if ($jadwal->tanggal_selesai)
                                    - {{ $jadwal->tanggal_selesai->format('d M Y') }}
                                @endif
                                </td>
                                <td>{{ $jadwal->waktu }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Informasi Tes Minat dan Bakat -->
            <div class="card mb-4 shadow-sm" id="test">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Informasi Tes Minat dan Bakat</h5>
                </div>
                <div class="card-body">
                    @php
                        use Carbon\Carbon;
                    @endphp

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Tanggal Tes Minat dan Bakat</th>
                                <td>
                                    @if ($pendaftar && $pendaftar->tanggal_tes)
                                        {{ Carbon::parse($pendaftar->tanggal_tes)->locale('id')->translatedFormat('d F Y') }}
                                    @else
                                        Belum ditentukan
                                    @endif
                                </td>
                            </tr>
                            @if($pendaftar && $pendaftar->status_tes == "sudah")
                                <tr>
                                    <th scope="row">Nilai Tes Minat dan Bakat</th>
                                    <td>{{ $pendaftar->nilai_tes_minat_bakat }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Persyaratan jika sudah ada tanggal tes -->
                    <div class="mt-4">
                        <h6>Tata Cara Pelaksanaan Tes Minat dan Bakat:</h6>
                        <ol>
                            <li>Datang ke sekolah dengan menggunakan baju putih biru (SMP) sesuai dengan tanggal yang didapatkan saat pendaftaran sudah terverifikasi.</li>
                            <li>Membawa dokumen berikut yang dimasukkan ke dalam map di antaranya:
                                <ul>
                                    <li>Rapor asli semester 1-5</li>
                                    <li>Foto copy Kartu Keluarga dan KTP orang tua / wali</li>
                                    <li>Foto copy Akte Kelahiran</li>
                                    <li>Foto copy Ijazah / Surat Keterangan Lulus</li>
                                    <li>Pas foto berwarna 3 x 4 sebanyak 2 lembar</li>
                                    <li>Piagam/Sertifikat asli (jika ada)</li>
                                    <li>Surat Keterangan Peringkat Kelas/Sekolah asli (jika ada)</li>
                                    <li>Bukti pendaftaran yang dapat di unduh di halaman <a href="/user/pendaftaran">Pendaftaran</a></li>
                                    <li>
                                        Surat Pernyataan Tanggung Jawab Mutlak (SPTJM) yang sudah diisi dan ttd materai 10.000.
                                        @if($sptjm && $sptjm->file_lampiran)
                                            <a href="{{ Storage::url($sptjm->file_lampiran) }}" target="_blank">Unduh SPTJM</a>
                                        @else
                                            <span>File belum tersedia.</span>
                                        @endif
                                    </li>                                                       
                                </ul>
                            </li>
                            <li>Tes minat dan bakat dilaksanakan dari jam 08.00-12.00 WIB.</li>
                            <li>Apabila calon peserta didik tidak mengikuti tes minat dan bakat di hari yang sudah ditentukan tanpa alasan yang jelas maka akan dianyatakan gugur.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Kontak Panitia -->
            <div class="card mb-4 shadow-sm" id="kontak">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Kontak Panitia</h5>
                </div>
                <div class="card-body">
                    <p>Jika memiliki pertanyaan atau kendala dapat menghubungi panitia PPDB SMK Negeri 2 Kalianda melalui:</p>
                    
                    @if(!empty($profile->call_center))
                        @php
                            $callCenters = json_decode($profile->call_center, true);
                        @endphp
                        @foreach($callCenters as $number)
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-whatsapp me-2" style="font-size: 1.5rem; color: #25D366;"></i>
                                <a href="https://wa.me/{{ str_replace([' ', '-', '(', ')'], '', $number) }}" target="_blank" style="font-size: 1.1rem; color: #000;">
                                    {{ $number }}
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p>Belum ada nomor call center yang tersedia.</p>
                    @endif
                </div>        
                
            </div>
        </div>
    </div>
    

    
</div>
@endsection
