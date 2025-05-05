<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\SchoolProfile;
use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $title = "Dashboard Admin";
        $user = Auth::user();
        $totalJurusan = Jurusan::count();
        $schoolProfile = SchoolProfile::first();
        $tahunSekarang = date('Y');

        // Ambil periode aktif
        $periodeAktif = Periode::where('status', 1)->first();

        $totalPendaftar = 0;
        $totalDiterima = 0;
        $totalGugur = 0;

        if ($periodeAktif) {
            $totalPendaftar = Pendaftar::where('periode_id', $periodeAktif->id)->count();
            $totalDiterima = Pendaftar::where('periode_id', $periodeAktif->id)
                ->where('status_pendaftaran', 'diterima')->count();
            $totalGugur = Pendaftar::where('periode_id', $periodeAktif->id)
                ->where('status_pendaftaran', 'gugur')->count();

            $tanggalTutup = $periodeAktif->tanggal_tutup ? Carbon::parse($periodeAktif->tanggal_tutup) : null;
            
            if ($tanggalTutup && now()->greaterThan($tanggalTutup)) {
                $pendaftarYangDiperbarui = Pendaftar::where('status_pendaftaran', 'rejected')->get();

                if ($pendaftarYangDiperbarui->count() > 0) {
                    Pendaftar::where('status_pendaftaran', 'rejected')
                    ->update(['status_pendaftaran' => 'gugur']);

                    Log::info('Status pendaftar otomatis diperbarui ke "gugur" karena periode telah berakhir', [
                        'jumlah_pendaftar' => $pendaftarYangDiperbarui->count()
                    ]);
                }
            }
        }

        // Ambil data jumlah pendaftar per tahun
        $dataPendaftar = Pendaftar::selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->get()
            ->pluck('total', 'tahun')
            ->toArray();

        $dataDiterima = Pendaftar::where('status_pendaftaran', 'diterima')
            ->selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->get()
            ->pluck('total', 'tahun')
            ->toArray();

        $dataGugur = Pendaftar::where('status_pendaftaran', 'gugur')
            ->selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->get()
            ->pluck('total', 'tahun')
            ->toArray();

        // Cek apakah array data tidak kosong sebelum mengambil min/max
        $tahunPertama = !empty($dataPendaftar) ? min(array_keys($dataPendaftar)) : $tahunSekarang;
        $tahunBatas = $tahunSekarang + 5;
        $tahunTerakhir = !empty($dataPendaftar) ? max($tahunBatas, max(array_keys($dataPendaftar))) : $tahunBatas;

        $pendaftarPerTahun = [];
        $diterimaPerTahun = [];
        $gugurPerTahun = [];

        for ($tahun = $tahunPertama; $tahun <= $tahunTerakhir; $tahun++) {
            $pendaftarPerTahun[$tahun] = $dataPendaftar[$tahun] ?? 0;
            $diterimaPerTahun[$tahun] = $dataDiterima[$tahun] ?? 0;
            $gugurPerTahun[$tahun] = $dataGugur[$tahun] ?? 0;
        }

        $totalLakiLaki = Pendaftar::whereYear('created_at', $tahunSekarang)
            ->where('jenis_kelamin', 'Laki-laki')
            ->count();

        $totalPerempuan = Pendaftar::whereYear('created_at', $tahunSekarang)
            ->where('jenis_kelamin', 'Perempuan')
            ->count();

        return view('admin.dashboard', compact(
            'title', 'user', 'totalPendaftar', 'totalDiterima', 'totalGugur', 'totalJurusan',
            'schoolProfile', 'pendaftarPerTahun', 'diterimaPerTahun', 'gugurPerTahun', 'tahunSekarang', 'totalLakiLaki', 'totalPerempuan',
        ));
    }

    public function adminProfile()
    {
        $title = "Profil Admin";
        $admin = Auth::user();
        return view('admin.profile', compact('title', 'admin'));
    }

    public function adminUpdate(Request $request)
    {
        $admin = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:8|confirmed',
        ]);
        $admin->name = $request->input('name');
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function index() {
        $title = "Data Admin";
        $user = Auth::user();
        return view('admin.admins.index', compact('title', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required'
        ]);

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role' => $request->get('role')
        ]);

        $user->save();
    
        return redirect('/admin/admins')->with('success', 'Data Admin berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'nullable|min:6|confirmed',
            ]);
    
            $user = User::findOrFail($id);
            $user->name = $request->get('name');
            $user->email = $request->get('email');
    
            if ($request->get('password')) {
                $user->password = bcrypt($request->get('password'));
            }
    
            $user->save();
    
            return redirect('/admin/admins')->with('success', 'Data Admin berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('admins.update', $id)]);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/admins')->with('success', 'Data Admin berhasil dihapus');
    }
}
