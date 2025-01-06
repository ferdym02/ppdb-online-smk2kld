<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PeriodeJurusan;
use App\Models\Jurusan;
use App\Models\Periode;

class PeriodeJurusanController extends Controller
{
    // Menampilkan daftar jurusan berdasarkan periode
    public function index(Request $request)
    {
        $title = 'Kuota Jurusan';
        $name = Auth::user()->name;
        $periode_id = $request->query('periode_id');
        $periodes = Periode::all(); // Untuk dropdown filter
        $jurusans = Jurusan::all(); // Untuk dropdown tambah/edit
        $periodeJurusans = PeriodeJurusan::where('periode_id', $periode_id)
            ->with('jurusan', 'periode')
            ->get();

        return view('admin.periode-jurusan.index', compact('periodes', 'jurusans', 'periodeJurusans', 'periode_id', 'name', 'title'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'kuota' => 'required|integer|min:0',
        ]);
    
        // Ambil periode terkait
        $currentPeriod = Periode::find($request->periode_id);
    
        // Cek apakah kuota jurusan yang diminta akan melampaui kuota penerimaan yang tersedia
        $totalKuotaUsed = $currentPeriod->kuota_penerimaan_used + $request->kuota;
    
        if ($totalKuotaUsed > $currentPeriod->kuota_penerimaan) {
            // Jika melebihi kuota, beri pesan error
            return redirect()->back()->with('error', 'Kuota yang diminta melebihi kuota penerimaan yang tersedia untuk periode pendaftaran ini.');
        }
    
        // Simpan data ke tabel periode_jurusan
        PeriodeJurusan::create($request->only(['periode_id', 'jurusan_id', 'kuota']));
    
        // Update kuota_penerimaan_used di periode terkait
        $currentPeriod->kuota_penerimaan_used = $totalKuotaUsed;
        $currentPeriod->save();

        return redirect()->back()->with('success', 'Kuota jurusan berhasil ditambahkan.');
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kuota' => 'required|integer|min:0',
            ]);
        
            $periodeJurusan = PeriodeJurusan::findOrFail($id);
        
            // Ambil periode terkait
            $currentPeriod = Periode::find($periodeJurusan->periode_id);
        
            // Cek perubahan kuota
            $kuotaDifference = $request->kuota - $periodeJurusan->kuota;
            $totalKuotaUsed = $currentPeriod->kuota_penerimaan_used + $kuotaDifference;
        
            // Validasi apakah kuota melebihi kuota penerimaan
            if ($totalKuotaUsed > $currentPeriod->kuota_penerimaan) {
                return redirect()->back()->with('error', 'Kuota yang diminta melebihi kuota penerimaan yang tersedia untuk periode pendaftaran ini.');
            }
        
            // Update data periode_jurusan
            $periodeJurusan->update($request->only(['kuota']));
        
            // Update kuota penerimaan yang sudah digunakan
            $currentPeriod->kuota_penerimaan_used = $totalKuotaUsed;
            $currentPeriod->save();
    
            return redirect()->back()->with('success', 'Kuota Jurusan berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('periode-jurusan.update', $id)]);
        }
    }

    // Menghapus data
    public function destroy($id)
    {
        $periodeJurusan = PeriodeJurusan::findOrFail($id);

        // Ambil periode terkait
        $currentPeriod = Periode::find($periodeJurusan->periode_id);

        if ($currentPeriod) {
            // Kurangi kuota yang digunakan
            $currentPeriod->kuota_penerimaan_used -= $periodeJurusan->kuota;
            $currentPeriod->save();
        }

         // Hapus data periode_jurusan
        $periodeJurusan->delete();

        return redirect()->back()->with('success', 'Kuota jurusan berhasil dihapus.');
    }
}
