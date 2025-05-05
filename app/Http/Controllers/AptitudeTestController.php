<?php

namespace App\Http\Controllers;

use App\Models\AptitudeTest;
use App\Models\Periode;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AptitudeTestController extends Controller
{
    public function index(Request $request)
    {
        session(['aptitude_tests_url' => $request->fullUrl()]);
        $name = Auth::user()->name;
        $title = 'Tes Minat Bakat';
        $periodes = Periode::all();
        $aptitudes = AptitudeTest::with('periode')
            ->orderByDesc('status') // Status aktif (true) di atas
            ->orderBy('created_at', 'desc') // Baru berdasarkan waktu dibuat
            ->get();
        return view('admin.aptitude.index', compact('title', 'name', 'periodes', 'aptitudes'));
    }

    public function getPendaftarData(Request $request, $id)
    {
        $query = Pendaftar::where('aptitude_tests_id', $id);

        if ($request->tanggal_tes) {
            $query->whereDate('tanggal_tes', $request->tanggal_tes);
        }

        if ($request->status_tes) {
            if ($request->status_tes == 'belum') {
                $query->where('status_tes', 'belum');
            } elseif ($request->status_tes == 'sudah') {
                $query->where('status_tes', 'sudah');
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('jenis_kelamin', function ($row) {
                return $row->jenis_kelamin == 'Laki-laki' ? 'L' : 'P';
            })
            ->editColumn('tanggal_tes', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal_tes)->format('d-m-Y');
            })
            ->editColumn('status_tes', function ($row) {
                return ucfirst($row->status_tes);
            })
            ->addColumn('aksi', function($row) {
                $url = url('/admin/pendaftar/' . $row->id);
                return '<a href="'.$url.'" class="btn btn-sm btn-info">Detail</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id, Request $request)
    {
        // Simpan URL halaman sebelumnya di sesi
        $request->session()->put('previous_url', url()->previous());
        // Cari data Tes Minat dan Bakat berdasarkan ID
        $aptitudes = AptitudeTest::with('periode')->findOrFail($id);

        // Ambil filter dari request
        $tanggalTes = $request->get('tanggal_tes');
        $statusTes = $request->get('status_tes'); // Tambahkan status_tes

        // Judul halaman
        $title = "Detail Tes Minat Bakat";

        // Tampilkan view dengan data
        return view('admin.aptitude.show', compact('aptitudes', 'title', 'tanggalTes', 'statusTes'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'tanggal_buka_tes' => 'required|date',
            'tanggal_tutup_tes' => 'required|date|after_or_equal:tanggal_buka_tes',
            'kuota_per_hari' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ], [
            'tanggal_tutup_tes.after_or_equal' => 'Tanggal tutup tes harus sama atau setelah tanggal buka tes.',
            'kuota_per_hari.min' => 'Kuota per hari minimal adalah 1.',
        ]);

        // Ambil data periode berdasarkan periode_id
        $periode = Periode::findOrFail($request->periode_id);

        // Validasi tambahan untuk memastikan tanggal tes berada dalam rentang periode pendaftaran
        if ($request->tanggal_buka_tes < $periode->tanggal_buka) {
            $tanggalBukaPendaftaran = Carbon::parse($periode->tanggal_buka)->format('d-m-Y');
            return redirect()->route('aptitudes.index')->with('error', 'Tanggal buka tes tidak boleh kurang dari tanggal buka pendaftaran (' . $tanggalBukaPendaftaran . ').');
        }

        // Hitung maksimal tanggal_tutup_tes (1 hari setelah tanggal tutup pendaftaran)
        $maxTanggalTes = Carbon::parse($periode->tanggal_tutup)->addDay(); // Tambah 1 hari

        if (Carbon::parse($request->tanggal_tutup_tes)->gt($maxTanggalTes)) {
            $tanggalMaxTes = $maxTanggalTes->format('d-m-Y');
            return redirect()->route('aptitudes.index')->with('error', 'Tanggal tutup tes maksimal sampai ' . $tanggalMaxTes . '.');
        }

        // Jika status yang diinginkan adalah aktif (1)
        if ($request->status) {
            // Cek apakah ada tes yang sudah aktif
            $activeTestExists = AptitudeTest::where('status', 1)->exists();

            // Jika sudah ada tes yang aktif, tolak permintaan
            if ($activeTestExists) {
                return redirect()->back()->with('error', 'Tidak boleh ada lebih dari satu tes yang aktif');
            }
        }

        // Simpan data tes minat dan bakat
        AptitudeTest::create($request->all());

        return redirect()->route('aptitudes.index')->with('success', 'Tes Minat Bakat berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'periode_id' => 'required|exists:periodes,id',
                'tanggal_buka_tes' => 'required|date',
                'tanggal_tutup_tes' => 'required|date|after_or_equal:tanggal_buka_tes',
                'kuota_per_hari' => 'required|integer|min:1',
                'status' => 'required|boolean',
            ], [
                'tanggal_tutup_tes.after_or_equal' => 'Tanggal tutup tes harus sama atau setelah tanggal buka tes.',
                'kuota_per_hari.min' => 'Kuota per hari minimal adalah 1.',
            ]);
    
            $aptitudeTest = AptitudeTest::findOrFail($id);
    
            // Ambil data periode berdasarkan periode_id
            $periode = Periode::findOrFail($request->periode_id);
    
            if ($request->tanggal_buka_tes < $periode->tanggal_buka) {
                $tanggalBukaPendaftaran = Carbon::parse($periode->tanggal_buka)->format('d-m-Y');
                return redirect()->route('aptitudes.index')->with('error', 'Tanggal buka tes tidak boleh kurang dari tanggal buka pendaftaran (' . $tanggalBukaPendaftaran . ').');
            }
    
            // Hitung maksimal tanggal_tutup_tes (1 hari setelah tanggal tutup pendaftaran)
            $maxTanggalTes = Carbon::parse($periode->tanggal_tutup)->addDay(); // Tambah 1 hari

            if (Carbon::parse($request->tanggal_tutup_tes)->gt($maxTanggalTes)) {
                $tanggalMaxTes = $maxTanggalTes->format('d-m-Y');
                return redirect()->route('aptitudes.index')->with('error', 'Tanggal tutup tes maksimal sampai ' . $tanggalMaxTes . '.');
            }
    
            // Jika status yang diinginkan adalah aktif (1) dan status yang sekarang belum aktif
            if ($request->status && $aptitudeTest->status != 1) {
                // Cek apakah ada tes lain yang sudah aktif
                $activeTestExists = AptitudeTest::where('status', 1)->where('id', '!=', $id)->exists();
    
                // Jika sudah ada tes yang aktif, tolak permintaan
                if ($activeTestExists) {
                    return redirect()->back()->with('error', 'Tidak boleh ada lebih dari satu tes yang aktif');
                }
            }
    
            // Update data tes minat dan bakat
            $aptitudeTest->update($request->all());
    
            return redirect()->route('aptitudes.index')->with('success', 'Data Tes Minat Bakat berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('aptitudes.update', $id)]);
        }
        
    }

    public function destroy($id)
    {
        $aptitudeTest = AptitudeTest::findOrFail($id);
        if ($aptitudeTest->status == 1) {
            return redirect()->back()->with('error', 'Tes minat bakat yang sedang aktif tidak dapat dihapus.');
        }

        if ($aptitudeTest->pendaftars()->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus tes minat bakat karena sudah digunakan oleh data pendaftar.');
        }
        
        $aptitudeTest->delete();

        return redirect()->route('aptitudes.index')->with('success', 'Data Tes Minat Bakat berhasil dihapus');
    }
}