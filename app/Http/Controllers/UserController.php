<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Periode;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\AptitudeTest;
use App\Models\SchoolProfile;
use App\Models\Jadwal;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function userDashboard()
    {
        $title = "Dashboard";
        $currentDate = now();

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;

        // Mengambil data pendaftar untuk user yang saat ini login
        $pendaftar = Pendaftar::where('user_id', auth()->id())->first();

        $profile = SchoolProfile::first();
        $jadwals = Jadwal::all();

        // Mengambil file SPTJM dari tabel pengumumans berdasarkan judul
        $sptjm = Pengumuman::where('judul', 'SPTJM')->first();

        return view('user.dashboard', compact('isRegistrationOpen', 'pendaftar', 'profile', 'jadwals', 'title', 'sptjm'));
    }

    public function showProfile()
    {
        $title = "Profile";
        $currentDate = now(); // Mengambil tanggal saat ini
        
        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;

        $user = auth()->user();

        $pendaftar = Pendaftar::where('user_id', auth()->id())->first();
        return view('user.profile', compact('pendaftar', 'user', 'isRegistrationOpen', 'title'));
    }

    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Update password user
        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui');
    }

    public function index() {
        $title = "Data Pengguna";
        $name = Auth::user()->name;
        return view('admin.users.index', compact('title', 'name'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required'
        ]);

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role' => $request->get('role')
        ]);

        $user->save();
    
        return redirect('/admin/users')->with('success', 'Data Pengguna berhasil diperbarui');
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
                $user->password = Hash::make($request->get('password'));
            }
            $user->save();
    
            return redirect('/admin/users')->with('success', 'Data Pengguna berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('users.update', $id)]);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/users')->with('success', 'Data Pengguna berhasil dihapus');
    }

}
