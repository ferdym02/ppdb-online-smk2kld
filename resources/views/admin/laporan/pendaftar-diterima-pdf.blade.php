<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendaftar Diterima</title>
    <style>
        body {
            font-family: Times New Roman, Times, serif; /* Menggunakan Times New Roman untuk seluruh body */
        }

        header, .header-text h1, .header-text h3, .header-text p {
            font-family: Arial, sans-serif; /* Menggunakan Arial untuk bagian header */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            text-align: left;
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center; /* Memusatkan teks di header tabel */
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
        .clear-float {
            clear: both;
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
            <p>DAFTAR NAMA-NAMA CALON PESERTA DIDIK BARU (CPDB)</p>
            <p>JALUR REGULER</p>
            <p>SMK NEGERI 2 TAHUN PELAJARAN {{ $periode ? $periode->tahun_pelajaran : 'Tidak Diketahui' }}</p>
        </strong>
    </div>
    @foreach($pendaftarDiterima as $jurusanId => $pendaftar)
        @php
            $jurusan = \App\Models\Jurusan::find($jurusanId);
        @endphp
        <div class="section-judul ">
            <p><strong>Konsentrasi Keahlian:</strong></p>
            <p><strong>{{ $jurusan ? $jurusan->nama : 'Tidak Diketahui' }}</strong></p>
        </div>
        <div class="pendaftar-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">No.</th> <!-- Menambahkan kolom No. -->
                        <th style="width: 10%">Nomor Pendaftaran</th>
                        <th style="width: 15%">NISN</th>
                        <th>Nama Lengkap</th>
                        <th style="width: 5%">L/P</th>
                        <th style="width: 20%">Asal Sekolah</th>
                        <th style="width: 10%">Status Pendaftaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftar->sortByDesc('nilai_akhir') as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Menampilkan nomor urut -->
                            <td>{{ $p->nomor_pendaftaran }}</td>
                            <td>{{ $p->nisn }}</td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                            <td>{{ $p->asal_sekolah }}</td>
                            <td>{{ ucfirst($p->status_pendaftaran) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="ttd">
            <p>Kalianda, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p> 
            <p id="kepsek">Kepala Sekolah,</p>
            <div id="nama-kepsek">
                <strong><u>NYOMAN MISTER, M.Pd</u></strong><br />
                Pembina Tk I<br />
                NIP. 19720706 200604 1 012
            </div>
        </div>
        <div class="clear-float"></div>
    @endforeach
</body>
</html>
