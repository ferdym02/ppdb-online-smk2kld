<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\SchoolProfile;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $title = "Dashboard Admin";
        $user = Auth::user();
        $totalPendaftar = Pendaftar::count();
        $totalDiterima = Pendaftar::where('status_pendaftaran', 'diterima')->count();
        $totalGugur = Pendaftar::where('status_pendaftaran', 'gugur')->count();
        $totalJurusan = Jurusan::count();
        $schoolProfile = SchoolProfile::first();
        return view('admin.dashboard', compact('title', 'user', 'totalPendaftar', 'totalDiterima', 'totalGugur', 'totalJurusan', 'schoolProfile'));
    }

    public function adminProfile()
    {
        $title = "Profil Admin";
        $user = Auth::user();
        $admin = Auth::user(); // Mendapatkan admin yang sedang login
        return view('admin.profile', compact('title', 'user', 'admin'));
    }

    public function adminUpdate(Request $request)
    {
        $admin = Auth::user();

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed', // password_confirmation harus sesuai
        ]);

        // Update name dan email
        $admin->name = $request->input('name');

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }

        $admin->save(); // Simpan perubahan

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
