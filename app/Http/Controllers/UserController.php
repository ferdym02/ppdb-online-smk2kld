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
        $pendaftar = Pendaftar::where('user_id', auth()->id())->first();
        $profile = SchoolProfile::first();
        $profile->call_center = array_filter([
            $profile->call_center_1,
            $profile->call_center_2
        ]);
        $jadwals = Jadwal::all();

        return view('user.dashboard', compact('isRegistrationOpen', 'pendaftar', 'profile', 'jadwals', 'title'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            
            'new_password.min' => 'Password harus minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = auth()->user();
        // Update nama jika ada
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Data akun berhasil diperbarui');
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
