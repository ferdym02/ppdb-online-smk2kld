<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Jurusan;
use App\Models\Pendaftar;
use App\Models\Periode;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use App\Exports\PendaftarExport;
use App\Exports\PendaftarDiterimaExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $title = 'Laporan Pendaftar';
        $name = Auth::user()->name;
        // Mendapatkan semua periode dan periode terbaru (aktif)
        $periodes = Periode::orderBy('id', 'desc')->get();
        $jurusans = Jurusan::all();
        $status_pendaftaran = ['pending', 'verified', 'rejected', 'diterima', 'gugur', 'cadangan'];

        return view('admin.laporan.index', compact('title', 'name', 'periodes', 'jurusans', 'status_pendaftaran'));
    }

    public function getData(Request $request)
    {
        $query = Pendaftar::query();

        if ($request->periode) {
            $query->where('periode_id', $request->periode);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan jurusan pilihan dari tabel pivot
        if ($request->filled('jurusan')) {
            $query->whereHas('jurusans', function($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan);
            });
        }
        
        if ($request->filled('status_pendaftaran')) {
            $query->where('status_pendaftaran', $request->status_pendaftaran);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function generatePDF(Request $request)
    {
        // Path ke gambar logo kiri
        $pathLeft = storage_path('app/public/lampung.png');
        $typeLeft = pathinfo($pathLeft, PATHINFO_EXTENSION);
        $dataLeft = file_get_contents($pathLeft);
        $base64Left = 'data:image/' . $typeLeft . ';base64,' . base64_encode($dataLeft);

        // Path ke gambar logo kanan (gambar baru)
        $pathRight = storage_path('app/public/logo.png');
        $typeRight = pathinfo($pathRight, PATHINFO_EXTENSION);
        $dataRight = file_get_contents($pathRight);
        $base64Right = 'data:image/' . $typeRight . ';base64,' . base64_encode($dataRight);

        // Mengambil data tahun pelajaran dari tabel periodes (misalnya, periode aktif)
        $periode = Periode::where('status', true)->first();  // Ambil periode yang aktif

        $query = Pendaftar::query();

        if ($request->has('periode') && $request->periode != '') {
            $query->where('periode_id', $request->periode);
        }

        if ($request->has('start_date') && $request->start_date != '' && $request->has('end_date') && $request->end_date != '') {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->whereHas('jurusans', function($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan);
            });
        }

        if ($request->has('status_pendaftaran') && $request->status_pendaftaran != '') {
            $query->where('status_pendaftaran', $request->status_pendaftaran);
        }

        $pendaftar = $query->get();
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pendaftar', 'base64Left', 'base64Right', 'periode'));
        return $pdf->download('laporan_pendaftar.pdf');
    }

    public function generateWord()
    {
        // Menginisialisasi PhpWord
        $phpWord = new PhpWord();
        $periode = Periode::where('status', true)->first();  // Ambil periode yang aktif

        // Menyiapkan gaya default
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);

        // Membuat section
        $section = $phpWord->addSection([
            'marginTop' => 600,    // Margin atas
            'marginBottom' => 600, // Margin bawah
            'marginLeft' => 600,   // Margin kiri
            'marginRight' => 600,  // Margin kanan
        ]);

        // Menambahkan Header
        $headerTable = $section->addTable();
        $headerTable->addRow();
        $headerTable->addCell(1000)->addImage(storage_path('app/public/lampung.png'), ['height' => 90, 'spaceAfter' => 0]); // Logo kiri
        $headerCell = $headerTable->addCell(8000);

        // Menambahkan teks header
        $headerCell->addText('PEMERINTAH PROVINSI LAMPUNG', ['bold' => true, 'name' => 'Arial', 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('DINAS PENDIDIKAN DAN KEBUDAYAAN', ['bold' => true, 'name' => 'Arial', 'size' => 16], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('SMK NEGERI 2 KALIANDA', ['bold' => true, 'size' => 20, 'name' => 'Arial'], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('TERAKREDITASI A ( Unggul )', ['bold' => true, 'name' => 'Arial', 'size' => 16], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('Alamat: Jl. Soekarno-Hatta Km. 52 Kalianda 35511 Telp. 0727-322282/Fax : 0727-321396', ['name' => 'Arial', 'size' => 8], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('email : smkn02kalianda@gmail.com/www.smkn2kalianda.sch.id', ['name' => 'Arial', 'size' => 8], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerTable->addCell(1000, ['valign' => 'top'])->addImage(storage_path('app/public/logo.png'), ['height' => 90, 'wrappingStyle' => 'square', 'alignment' => Jc::RIGHT, 'spaceAfter' => 0]); // Logo kanan

        // Menambahkan garis di bawah header
        $section->addText('', [], ['borderBottomSize' => 12, 'borderBottomColor' => '000000', 'spaceAfter' => 0]);

        // Menambahkan Judul
        $section->addTextBreak(1);
        $section->addText('LAPORAN JUMLAH PENDAFTAR/CALON PESERTA DIDIK BARU (CPDB)', ['bold' => true], ['alignment' => Jc::CENTER]);
        $section->addText('JALUR REGULER', ['bold' => true], ['alignment' => Jc::CENTER]);
        $section->addText('SMK NEGERI 2 TAHUN PELAJARAN ' . ($periode ? $periode->tahun_pelajaran : 'Tidak Diketahui'), ['bold' => true], ['alignment' => Jc::CENTER]);

        // Mengambil data pendaftar
        $pendaftar = Pendaftar::orderBy('nama_lengkap')->get();

        // Membuat Tabel Pendaftar
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'allowBreakAcrossPages' => true]);

        // Header Tabel
        $table->addRow();
        $table->addCell(700, ['bgColor' => 'cccccc'])->addText('No.', ['bold' => true], ['align' => Jc::CENTER]);
        $table->addCell(2000, ['bgColor' => 'cccccc'])->addText('Nomor Pendaftaran', ['bold' => true], ['align' => Jc::CENTER]);
        $table->addCell(2000, ['bgColor' => 'cccccc'])->addText('NISN', ['bold' => true], ['align' => Jc::CENTER]);
        $table->addCell(4000, ['bgColor' => 'cccccc'])->addText('Nama Lengkap', ['bold' => true], ['align' => Jc::CENTER]);
        $table->addCell(700, ['bgColor' => 'cccccc'])->addText('L/P', ['bold' => true], ['align' => Jc::CENTER]);
        $table->addCell(3000, ['bgColor' => 'cccccc'])->addText('Asal Sekolah', ['bold' => true], ['align' => Jc::CENTER]);
        $table->addCell(2000, ['bgColor' => 'cccccc'])->addText('Status Pendaftaran', ['bold' => true], ['align' => Jc::CENTER]);

        // Isi Tabel
        foreach ($pendaftar as $index => $p) {
            $table->addRow();
            $table->addCell(700)->addText($index + 1, null, ['alignment' => Jc::CENTER]);
            $table->addCell(2000)->addText($p->nomor_pendaftaran);
            $table->addCell(2000)->addText($p->nisn);
            $table->addCell(4000)->addText($p->nama_lengkap);
            $table->addCell(700)->addText($p->jenis_kelamin == 'Laki-laki' ? 'L' : 'P', null, ['alignment' => Jc::CENTER]);
            $table->addCell(3000)->addText($p->asal_sekolah);
            $table->addCell(2000)->addText(ucfirst($p->status_pendaftaran));
        }

       // Tanda Tangan Kepala Sekolah
       $section->addTextBreak(1);

       // Membuat table untuk bagian tanda tangan
       $tandatanganTable = $section->addTable();

       // Menambahkan baris tanda tangan
       $tandatanganTable->addRow();

       // Menambahkan cell kosong di sebelah kiri
       $tandatanganTable->addCell(10000); // Cell kiri kosong

       // Menambahkan cell di sebelah kanan untuk tanda tangan
       $tandatanganCell = $tandatanganTable->addCell(5000); // Cell kanan untuk tanda tangan

       // Menambahkan teks di cell kanan dengan rata kiri, tanpa jarak antar tulisan
       $tandatanganCell->addText(
           'Kalianda, ' . \Carbon\Carbon::now()->translatedFormat('d F Y'), 
           null, 
           ['spaceAfter' => 0]
       );
       $tandatanganCell->addText('Kepala Sekolah,', null, ['spaceAfter' => 0]);

       $tandatanganCell->addTextBreak(3);
       $tandatanganCell->addText('NYOMAN MISTER, M.Pd', ['underline' => 'single', 'bold' => true], ['spaceAfter' => 0]);
       $tandatanganCell->addText('Pembina Tk I', null, ['spaceAfter' => 0]);
       $tandatanganCell->addText('NIP. 19720706 200604 1 012', null, ['spaceAfter' => 0]);


        // Menyimpan file sebagai Word
        $fileName = 'laporan_pendaftar.docx';
        $filePath = storage_path($fileName);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function generateExcel(Request $request)
    {
        $filters = $request->all(); // Ambil filter dari request

        // Format nama file
        $fileName = 'laporan_pendaftar.xlsx';

        // Ekspor file Excel menggunakan PendaftarExport
        return Excel::download(new PendaftarExport($filters), $fileName);
    }

    public function generatePdfDiterima()
    {
        // Path ke gambar logo kiri
        $pathLeft = storage_path('app/public/lampung.png');
        $typeLeft = pathinfo($pathLeft, PATHINFO_EXTENSION);
        $dataLeft = file_get_contents($pathLeft);
        $base64Left = 'data:image/' . $typeLeft . ';base64,' . base64_encode($dataLeft);

        // Path ke gambar logo kanan (gambar baru)
        $pathRight = storage_path('app/public/logo.png');
        $typeRight = pathinfo($pathRight, PATHINFO_EXTENSION);
        $dataRight = file_get_contents($pathRight);
        $base64Right = 'data:image/' . $typeRight . ';base64,' . base64_encode($dataRight);

        // Mengambil data pendaftar yang diterima atau cadangan dan mengelompokkannya berdasarkan jurusan_diterima
        $pendaftarDiterima = Pendaftar::whereIn('status_pendaftaran', ['diterima', 'cadangan'])
            ->orderBy('nilai_akhir', 'desc')
            ->get()
            ->groupBy('jurusan_diterima');

        // Mengambil data tahun pelajaran dari tabel periodes (misalnya, periode aktif)
        $periode = Periode::where('status', true)->first();  // Ambil periode yang aktif

        // Meload view untuk PDF dengan data yang sudah diambil
        $pdf = PDF::loadView('admin.laporan.pendaftar-diterima-pdf', compact('pendaftarDiterima', 'base64Left', 'base64Right', 'periode'));

        // Mengembalikan file PDF untuk didownload atau ditampilkan
        return $pdf->download('laporan_pendaftar_diterima.pdf');
    }

    public function generateWordDiterima()
    {
        // Menginisialisasi PhpWord
        $phpWord = new PhpWord();
        $periode = Periode::where('status', true)->first();  // Ambil periode yang aktif
    
        // Menyiapkan gaya default
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);
    
        // Membuat section
        $section = $phpWord->addSection([
            'marginTop' => 600,    // Margin atas
            'marginBottom' => 600, // Margin bawah
            'marginLeft' => 600,   // Margin kiri
            'marginRight' => 600,  // Margin kanan
        ]);
    
        // Menambahkan Header
        $headerTable = $section->addTable();
        $headerTable->addRow();
        $headerTable->addCell(1000)->addImage(storage_path('app/public/lampung.png'), ['height' => 90, 'spaceAfter' => 0]);  // Hanya atur height untuk menjaga proporsi
        $headerCell = $headerTable->addCell(8000);

        // Menambahkan teks tanpa jarak antar tulisan
        $headerCell->addText('PEMERINTAH PROVINSI LAMPUNG', ['bold' => true, 'name' => 'Arial', 'size' => 14], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('DINAS PENDIDIKAN DAN KEBUDAYAAN', ['bold' => true, 'name' => 'Arial', 'size' => 16], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('SMK NEGERI 2 KALIANDA', ['bold' => true, 'size' => 20, 'name' => 'Arial'], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('TERAKREDITASI A ( Unggul )', ['bold' => true, 'name' => 'Arial', 'size' => 16], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('Alamat: Jl. Soekarno-Hatta Km. 52 Kalianda 35511 Telp. 0727-322282/Fax : 0727-321396', ['name' => 'Arial', 'size' => 8], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerCell->addText('email : smkn02kalianda@gmail.com/www.smkn2kalianda.sch.id', ['name' => 'Arial', 'size' => 8], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        $headerTable->addCell(1000, ['valign' => 'top', 'cellMarginRight' => 0])->addImage(storage_path('app/public/logo.png'), ['height' => 90, 'wrappingStyle' => 'square', 'alignment' => Jc::RIGHT, 'spaceAfter' => 0]);

        // Menambahkan garis di bawah header
        $section->addText('', [], ['borderBottomSize' => 12, 'borderBottomColor' => '000000', 'spaceAfter' => 0]);

        // Menambahkan Judul
        $section->addTextBreak(1);
        $section->addText('DAFTAR NAMA-NAMA CALON PESERTA DIDIK BARU (CPDB)', ['bold' => true], ['alignment' => Jc::CENTER]);
        $section->addText('JALUR REGULER', ['bold' => true], ['alignment' => Jc::CENTER]);
        $section->addText('SMK NEGERI 2 TAHUN PELAJARAN ' . ($periode ? $periode->tahun_pelajaran : 'Tidak Diketahui'), ['bold' => true], ['alignment' => Jc::CENTER]);
    
        // Mengambil data pendaftar yang diterima
        $pendaftarDiterima = Pendaftar::whereIn('status_pendaftaran', ['diterima', 'cadangan'])
            ->orderBy('nilai_akhir', 'desc')
            ->get()
            ->groupBy('jurusan_diterima');
    
        foreach ($pendaftarDiterima as $jurusanId => $pendaftar) {
            $jurusan = \App\Models\Jurusan::find($jurusanId);
    
            $section->addTextBreak(1);
            // Menampilkan nama jurusan
            $section->addText('Konsentrasi Keahlian:', ['bold' => true], ['align' => Jc::CENTER]);
            $section->addText(($jurusan ? $jurusan->nama : 'Tidak Diketahui'), ['bold' => true], ['align' => Jc::CENTER]);

            // Membuat Tabel Pendaftar
            $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'allowBreakAcrossPages' => true]);
    
            // Header Tabel
            $table->addRow();
            $table->addCell(700, ['bgColor' => 'cccccc'])->addText('No.', ['bold' => true], ['align' => Jc::CENTER]);
            $table->addCell(2000, ['bgColor' => 'cccccc'])->addText('Nomor Pendaftaran', ['bold' => true], ['align' => Jc::CENTER]);
            $table->addCell(2000, ['bgColor' => 'cccccc'])->addText('NISN', ['bold' => true], ['align' => Jc::CENTER]);
            $table->addCell(4000, ['bgColor' => 'cccccc'])->addText('Nama Lengkap', ['bold' => true], ['align' => Jc::CENTER]);
            $table->addCell(700, ['bgColor' => 'cccccc'])->addText('L/P', ['bold' => true], ['align' => Jc::CENTER]);
            $table->addCell(3000, ['bgColor' => 'cccccc'])->addText('Asal Sekolah', ['bold' => true], ['align' => Jc::CENTER]);
    
            foreach ($pendaftar->sortByDesc('nilai_akhir') as $index => $p) {
                // Isi Tabel
                $table->addRow();
                $table->addCell(700)->addText($index + 1, null, ['alignment' => Jc::CENTER]);
                $table->addCell(2000)->addText($p->nomor_pendaftaran);
                $table->addCell(2000)->addText($p->nisn);
                $table->addCell(4000)->addText($p->nama_lengkap);
                $table->addCell(700)->addText($p->jenis_kelamin == 'Laki-laki' ? 'L' : 'P', null, ['alignment' => Jc::CENTER]);
                $table->addCell(3000)->addText($p->asal_sekolah);
            }

            // Tanda Tangan Kepala Sekolah
            $section->addTextBreak(1);

            // Membuat table untuk bagian tanda tangan
            $tandatanganTable = $section->addTable();

            // Menambahkan baris tanda tangan
            $tandatanganTable->addRow();

            // Menambahkan cell kosong di sebelah kiri
            $tandatanganTable->addCell(10000); // Cell kiri kosong

            // Menambahkan cell di sebelah kanan untuk tanda tangan
            $tandatanganCell = $tandatanganTable->addCell(5000); // Cell kanan untuk tanda tangan

            // Menambahkan teks di cell kanan dengan rata kiri, tanpa jarak antar tulisan
            $tandatanganCell->addText(
                'Kalianda, ' . \Carbon\Carbon::now()->translatedFormat('d F Y'), 
                null, 
                ['spaceAfter' => 0]
            );
            $tandatanganCell->addText('Kepala Sekolah,', null, ['spaceAfter' => 0]);

            $tandatanganCell->addTextBreak(3);
            $tandatanganCell->addText('NYOMAN MISTER, M.Pd', ['underline' => 'single', 'bold' => true], ['spaceAfter' => 0]);
            $tandatanganCell->addText('Pembina Tk I', null, ['spaceAfter' => 0]);
            $tandatanganCell->addText('NIP. 19720706 200604 1 012', null, ['spaceAfter' => 0]);

            // Menambahkan page break setelah tanda tangan
            $section->addPageBreak();
        }
    
        // Menyimpan file sebagai Word
        $fileName = 'laporan_pendaftar_diterima.docx';
        $filePath = storage_path($fileName);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);
    
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function generateExcelDiterima()
    {
        // Format nama file
        $fileName = 'laporan_pendaftar_diterima.xlsx';

        // Ekspor file Excel menggunakan PendaftarDiterimaExport
        return Excel::download(new PendaftarDiterimaExport(), $fileName);
    }

}
