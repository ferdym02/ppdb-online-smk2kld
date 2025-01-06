<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pendaftaran</title>
    <style>
        body {
            font-family: Times New Roman, Times, serif; /* Menggunakan Times New Roman untuk seluruh body */
        }

        header, .header-text h1, .header-text h3, .header-text p {
            font-family: Arial, sans-serif; /* Menggunakan Arial untuk bagian header */
        }

        h2 {
            text-align: center;
        }

        /* Menghilangkan border pada tabel header-table */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .header-table td {
            border: none; /* Menghilangkan border pada semua td di header-table */
            vertical-align: top;
            padding: 0px !important;
        }
        #logo-left {
            width: auto;
            height: 120px;
            margin: 0px;
        }
        #logo-right {
            width: auto;
            height: 120px;
            margin: 0px;
        }
        .logo-right-container {
            text-align: right;
        }
        .header-text {
            text-align: center;
        }
        .header-text h1, .header-text h3, .header-text h5, .header-text h6 {
            margin: 0;
        }
        .keclogo {
            font-size: 26px;
        }
        .kablogo {
            font-size: 20px;
        }
        .dinaslogo {
            font-size: 22px;
        }
        .alamatlogo {
            font-size: 10px;
            margin: 0;
            padding: 0;
        }
        .garis1 {
            border-top: 3px solid black;
            height: 2px;
            border-bottom: 1px solid black;
        }
        .section-judul {
            text-align: center;
            font-size: 14px;
            margin-top: 25px;
        }

        .section-judul p {
            margin: 0;
            padding: 0;
        }
        .pendaftar-table {
            margin-top: 25px;
            font-size: 14px;
        }
        #nama-kepsek {
            margin-top: 80px;
        }
        #ttd {
            text-align: left;
            font-size: 14px;
            float: right;
            margin-top: 30px;
            position: relative;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #000;
            text-align: left;
            padding: 6px;
        }
        th {
            background-color: #c0c0c0;
            text-align: center; /* Memusatkan teks di header tabel */
        }

        /* Tabel untuk Info Pendaftaran */
        .info-pendaftaran-table {
            width: 100%;
            border: 1px solid black;
            margin-top: 20px;
            font-size: 14px;
        }
        .info-pendaftaran-table th {
            background-color: #c0c0c0;
            padding: 8px;
        }
        .info-pendaftaran-table td {
            padding: 8px;
            text-align: center;
        }

        /* Custom styling for Data Calon Peserta and Daftar Pilihan Jurusan sections */
        .data-diri-table, .jurusan-table {
            margin-top: 20px;
            width: 100%;
            font-size: 14px;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .data-diri-table th, .data-diri-table td {
            padding: 8px;
        }

        .jurusan-table td {
            padding: 6px;
            text-align: center;
        }

        .data-diri-header {
            width: 25%; /* Atur lebar sesuai kebutuhan */
            text-align: left;
        }
    </style>
</head>
<body>
    <header>
        <table class="header-table">
            <tr>
                <td>
                    <img id="logo-left" src="{{ $base64Left  }}" alt="Logo" />
                </td>
                <td class="header-text">
                    <h3 class="kablogo">PEMERINTAH PROVINSI LAMPUNG</h3>
                    <h3 class="dinaslogo">DINAS PENDIDIKAN DAN KEBUDAYAAN</h3>
                    <h1 class="keclogo"><strong>SMK NEGERI 2 KALIANDA</strong></h1>
                    <h3 class="dinaslogo">TERAKREDITASI A ( Unggul )</h3>
                    <p class="alamatlogo">Alamat : Jl. Soekarno-Hatta Km. 52 Kalianda 35511 Telp. 0727-322282/Fax : 0727-321396</p>
                    <p class="alamatlogo">email : smkn02kalianda@gmail.com/www.smkn2kalianda.sch.id</p>
                </td>
                <td class="logo-right-container">
                    <img id="logo-right" src="{{ $base64Right  }}" alt="Logo" />
                </td>
            </tr>
        </table>
    </header>
    <hr class="garis1" />
    <div class="section-judul">
        <strong>
            <p>Bukti Pendaftaran</p>
            <p>Penerimaan Peserta Didik Baru Online SMK Negeri 2 Kalianda</p>
            <p>Tahun Pelajaran {{ $periode ? $periode->tahun_pelajaran : 'Tidak Diketahui' }}</p>
        </strong>
    </div>
    <table class="info-pendaftaran-table">
        <thead>
            <tr>
                <th>Nomor Pendaftaran</th>
                <th>Waktu Pendaftaran</th>
                <th>Tanggal Tes Minat Bakat</th>
                <th>Jenis Pendaftaran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $nomor_pendaftaran }}</td>
                <td>{{ \Carbon\Carbon::parse($waktu_pendaftaran)->format('d-m-Y H:i:s') }}</td>
                <td>{{ \Carbon\Carbon::parse($tanggal_tes)->format('d-m-Y') }}</td>
                <td>{{ $jenis_pendaftaran }}</td>
            </tr>
        </tbody>
    </table>    
    <div class="container">
        {{-- Data Calon Peserta Didik Baru --}}
        <table class="data-diri-table">
            <thead>
                <tr>
                    <th colspan="2" style="background-color: transparent;">Data Calon Peserta Didik Baru</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="data-diri-header">NISN</th>
                    <td>{{ $nisn }}</td>
                </tr>
                <tr>
                    <th class="data-diri-header">Nama Lengkap</th>
                    <td>{{ $nama_lengkap }}</td>
                </tr>
                <tr>
                    <th class="data-diri-header">Tempat, Tanggal Lahir</th>
                    <td>{{ $tempat_tanggal_lahir }}</td>
                </tr>
                <tr>
                    <th class="data-diri-header">Jenis Kelamin</th>
                    <td>{{ $jenis_kelamin }}</td>
                </tr>
                <tr>
                    <th class="data-diri-header">Alamat</th>
                    <td>{{ $alamat }}</td>
                </tr>
                <tr>
                    <th class="data-diri-header">Sekolah Asal</th>
                    <td>{{ $asal_sekolah }}</td>
                </tr>
                <tr>
                    <th class="data-diri-header">Nomor Wa</th>
                    <td>{{ $nomor_wa }}</td>
                </tr>
                <tr>
                    <th class="data-diri-header">Nama Ayah</th>
                    <td>{{ $nama_ayah }}</td>
                </tr>
                <tr>
                    <th class="data-diri-header">Nama Ibu</th>
                    <td>{{ $nama_ibu }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Daftar Pilihan Jurusan --}}
        <table class="jurusan-table">
            <thead>
                <tr>
                    <th colspan="4" style="background-color: transparent;">Daftar Pilihan Jurusan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>1</th>
                    <td style="text-align: left;">{{ $pilihan_jurusan_1 }}</td>
                    <th>2</th>
                    <td style="text-align: left;">{{ $pilihan_jurusan_2 }}</td>
                </tr>
                <tr>
                    <th>3</th>
                    <td style="text-align: left;">{{ $pilihan_jurusan_3 }}</td>
                    <td colspan="2"> </td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="text-align: left; width: 33%;">
                    Mengetahui,<br />
                    Orang Tua/Wali Murid,<br /><br /><br /><br /><br /><br />
                    <div style="text-align: center;">
                        (................................................)
                    </div>
                </td>
                <td style="width: 33%; text-align: center;">
                    {{-- <div>Foto Calon Peserta Didik Baru</div> --}}
                    @if ($base64FotoCalonSiswa)
                        <p style="margin: 0; padding: 0;">Foto Calon Peserta Didik Baru</p>
                        <img src="{{ $base64FotoCalonSiswa }}" alt="Foto Calon Peserta Didik" style="width: auto; height: 120px; object-fit: cover;">
                    @else
                        <p>Foto tidak tersedia</p>
                    @endif
                </td>
                <td style="text-align: left; width: 33%;">
                    Kalianda, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br />
                    Calon Peserta Didik Baru,<br /><br /><br /><br /><br /><br />
                    <div style="text-align: center;">
                        <strong>{{ $nama_lengkap }}</strong>
                    </div>
                </td>
            </tr>
        </table>        
    </div>
</body>
</html>
