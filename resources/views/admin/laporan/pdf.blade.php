<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendaftar</title>
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
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
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
        }
        .filter-bg {
            background-color: #f2f2f2
        }
    </style>
</head>
<body>
    @php
        $statusMapping = [
            'pending' => 'Pending',
            'verified' => 'Terverifikasi',
            'rejected' => 'Perlu Perbaikan',
            'diterima' => 'Lulus',
            'gugur' => 'Tidak Lulus',
            'cadangan' => 'Cadangan'
        ];
    @endphp
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
    <div style="margin-top: 15px;">
        <h4 style="margin-bottom: 5px;">Filter Laporan:</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="filter-bg" style="width: 30%;"><strong>Periode</strong></td>
                <td>{{ request()->periode ? $pendaftarGrouped->first()->first()->periode->tahun_pelajaran ?? 'Semua' : 'Semua' }}</td>
            </tr>
            <tr>
                <td class="filter-bg"><strong>Dari Tanggal</strong></td>
                <td>{{ request()->start_date ? date('d-m-Y', strtotime(request()->start_date)) : '-' }}</td>
            </tr>
            <tr>
                <td class="filter-bg"><strong>Sampai Tanggal</strong></td>
                <td>{{ request()->end_date ? date('d-m-Y', strtotime(request()->end_date)) : '-' }}</td>
            </tr>            
            <tr>
                <td class="filter-bg"><strong>Jurusan</strong></td>
                <td>{{ request()->jurusan ? \App\Models\Jurusan::find(request()->jurusan)->nama ?? 'Semua' : 'Semua' }}</td>
            </tr>
            <tr>
                <td class="filter-bg"><strong>Status Pendaftaran</strong></td>
                <td>{{ request()->status_pendaftaran ? ($statusMapping[request()->status_pendaftaran] ?? request()->status_pendaftaran) : 'Semua' }}</td>
            </tr>
        </table>
    </div>    
    @foreach ($pendaftarGrouped as $periodeId => $pendaftar)
        <div class="section-judul">
            <strong>
                <p>Laporan Calon Peserta Didik Baru PPDB Online</p>
                <p>Jalur Reguler</p>
                <p>SMK Negeri 2 Kalianda Tahun Pelajaran {{ $pendaftar->first()->periode->tahun_pelajaran ?? 'Tidak Diketahui' }}</p>
            </strong>
        </div>

        <div class="pendaftar-table">
            <table>
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No.</th>
                        <th class="text-center" style="width: 10%">Nomor Pendaftaran</th>
                        <th class="text-center" style="width: 15%">NISN</th>
                        <th class="text-left">Nama Lengkap</th>
                        <th class="text-center" style="width: 5%">L/P</th>
                        <th class="text-left" style="width: 20%">Asal Sekolah</th>
                        <th class="text-left" style="width: 10%">Status Pendaftaran</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($pendaftar->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center"><strong>Tidak ada data</strong></td>
                        </tr>
                    @else
                        @foreach ($pendaftar as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item->nomor_pendaftaran }}</td>
                                <td class="text-center">{{ $item->nisn }}</td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td class="text-center">{{ $item->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                                <td>{{ $item->asal_sekolah }}</td>
                                <td>{{ $statusMapping[strtolower($item->status_pendaftaran)] ?? $item->status_pendaftaran }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div id="ttd" style="float: right; margin-top: 30px;">
            <p>Kalianda, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p> 
            <p id="kepsek">Kepala Sekolah,</p>
            <div id="nama-kepsek">
                <strong><u>NYOMAN MISTER, M.Pd</u></strong><br />
                Pembina Tk I<br />
                NIP. 19720706 200604 1 012
            </div>
        </div>

        @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
</body>
</html>
