@extends('user.layouts.app')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Header Selamat Datang -->
<div class="text-center my-4">
    <h1>Selamat Datang Calon Peserta Didik Baru</h1>
    <p>di PPDB Online SMK Negeri 2 Kalianda Jalur Reguler</p>
</div>
<div class="row">
    <!-- Sidebar Navigasi -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm sticky-top" style="top: 80px;">
            <div class="card-header text-white" style="background-color: #9D0A36">
                <h5 class="card-title mb-0">Daftar Isi</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="#info" class="text-decoration-none">Info Penting</a></li>
                    <li class="list-group-item"><a href="#persyaratan" class="text-decoration-none">Persyaratan PPDB</a></li>
                    <li class="list-group-item"><a href="#panduan" class="text-decoration-none">Panduan Pendaftaran</a></li>
                    <li class="list-group-item"><a href="#jadwal" class="text-decoration-none">Jadwal PPDB</a></li>
                    <li class="list-group-item"><a href="#test" class="text-decoration-none">Tes Minat Bakat</a></li>
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
                        Saat ini belum ada periode pendaftaran yang dibuka.
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
                        <span>Calon peserta didik baru melakukan <a href="/user/pendaftaran">pendaftaran</a> mandiri dengan mengisi formulir dan mengunggah dokumen persyaratan secara online.</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-start align-items-center">
                        <i class="fas fa-clock mr-2 text-primary me-2"></i>
                        <span>Calon peserta didik baru menunggu verifikasi pendaftaran oleh admin yang dapat dilihat pada halaman <a href="/user/pendaftaran">Pendaftaran</a>.</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-start align-items-center">
                        <i class="fa-solid fa-circle-xmark mr-2 text-primary me-2"></i>
                        <span>Jika status pendaftaran perlu perbaikan, calon peserta didik baru dapat melakukan edit data pendaftaran sesuai dengan catatan perbaikan dari admin.</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-start align-items-center">
                        <i class="fas fa-check-circle mr-2 text-primary me-2"></i>
                        <span>Jika pendaftaran calon peserta didik baru sudah terverifikasi, calon peserta didik baru dapat mencetak bukti pendaftaran.</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-start align-items-center">
                        <i class="fas fa-calendar-alt mr-2 text-primary me-2"></i>
                        <span>Calon peserta didik baru mendapat jadwal Tes Minat Bakat yang dapat dilihat <a href="#test">disini</a>.</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-start align-items-center">
                        <i class="fas fa-clipboard-check mr-2 text-primary me-2"></i>
                        <span>Calon peserta didik baru melakukan Tes Minat Bakat di SMK Negeri 2 Kalianda sesuai jadwal dan dengan tata cara yang dapat dilihat <a href="#test">disini</a>.</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-start align-items-center">
                        <i class="fa-solid fa-eye mr-2 text-primary me-2"></i>
                        <span>Calon peserta didik baru melihat hasil seleksi dan pengumuman secara online di halaman <a href="/user/pendaftaran">Pendaftaran</a> pada bagian informasi pendaftaran.</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-start align-items-center">
                        <i class="fas fa-bullhorn mr-2 text-primary me-2"></i>
                        <span>Calon peserta didik baru yang dinyatakan "Lulus" seleksi harap melakukan daftar ulang yang dilaksanakan di sekolah. Informasi terkait daftar ulang dan info lainnya dapat dicek di halaman <a href="/user/pengumuman">Pengumuman</a>.</span>
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

        <!-- Informasi Tes Minat Bakat -->
        <div class="card mb-4 shadow-sm" id="test">
            <div class="card-header text-white">
                <h5 class="card-title mb-0">Informasi Tes Minat Bakat</h5>
            </div>
            <div class="card-body">
                @php
                    use Carbon\Carbon;
                @endphp

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row">Tanggal Tes Minat Bakat</th>
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
                                <th scope="row">Nilai Tes Minat Bakat</th>
                                <td>:
                                    @php
                                        $nilai = $pendaftar->nilai_tes_minat_bakat;
                                        $keterangan = match ($nilai) {
                                            'A' => 'Sangat Baik',
                                            'B' => 'Baik',
                                            'C' => 'Cukup',
                                            'K' => 'Kurang',
                                            default => null,
                                        };
                                    @endphp

                                    @if ($nilai && $keterangan)
                                        {{ $nilai }} ({{ $keterangan }})
                                    @else
                                        Belum ditentukan
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Persyaratan jika sudah ada tanggal tes -->
                <div class="mt-4">
                    <h6>Tata Cara Pelaksanaan Tes Minat Bakat:</h6>
                    <ol>
                        <li>Tes minat bakat dilaksanakan di sekolah.</li>
                        <li>Datang ke sekolah dengan menggunakan baju putih biru (SMP) sesuai dengan tanggal yang didapatkan saat pendaftaran sudah terverifikasi.</li>
                        <li>Setelah sampai di sekolah, panitia akan memberikan arahan selanjutnya untuk melakukan tes.</li>
                        <li>Membawa dokumen berikut yang dimasukkan ke dalam map di antaranya:
                            <ul>
                                <li>Foto Copy Rapor semester 1-5</li>
                                <li>Foto copy Kartu Keluarga dan KTP orang tua / wali</li>
                                <li>Foto copy Akte Kelahiran</li>
                                <li>Foto copy Ijazah / Surat Keterangan Lulus</li>
                                <li>Pas foto berwarna 3 x 4 sebanyak 2 lembar</li>
                                <li>Foto copy Piagam/Sertifikat (jika ada)</li>
                                <li>Foto copy Surat Keterangan Peringkat Kelas/Sekolah (jika ada)</li>
                                <li>Bukti pendaftaran yang dapat di unduh di halaman <a href="/user/pendaftaran">Pendaftaran</a> jika data pendaftaran sudah terverifikasi</li>
                                <li>
                                    Surat Pernyataan Tanggung Jawab Mutlak (SPTJM) yang sudah diisi dan ttd materai 10.000
                                </li>
                                <li>
                                    (SPTJM) dapat diunduh di halaman <a href="{{ route('pengumumanUser') }}">Pengumuman</a>
                                </li>
                            </ul>
                        </li>
                        <li>Tes minat bakat dilaksanakan dari jam 08.00-15.00 WIB.</li>
                        <li>Apabila calon peserta didik tidak mengikuti tes minat bakat di hari yang sudah ditentukan tanpa alasan yang jelas maka akan dianyatakan gugur.</li>
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
                    @foreach($profile->call_center as $number)
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-whatsapp me-2" style="font-size: 1.5rem; color: #25D366;"></i>
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $number) }}" target="_blank">{{ $number }}</a></li>
                    </div>
                    @endforeach
                @else
                    Belum ada nomor call center.
                @endif
            </div>
        </div>
    </div>
</div>
<div id="backToTop" class="back-to-top d-none">
    <i class="fas fa-arrow-up"></i>
</div>
@endsection