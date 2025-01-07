<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SchoolProfileController extends Controller
{
    public function create()
    {
        $title = 'Profil Sekolah';
        $name = Auth::user()->name;
        $schoolProfile = SchoolProfile::first();
        // Decode JSON call_center menjadi array
        $callCenters = $schoolProfile->call_center;
        return view('admin.school-profile.create', compact('schoolProfile', 'name', 'title', 'callCenters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string',
            'email_sekolah' => 'required|email|max:255',
            'telepon_sekolah' => 'required|string|max:15',
            'logo_sekolah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'call_center_1' => 'nullable|string|max:15',
            'call_center_2' => 'nullable|string|max:15',
            'x' => 'nullable|url',
            'tiktok' => 'nullable|url',
        ]);

        // Ambil semua input yang diperlukan
        $data = $request->only([
            'nama_sekolah', 'alamat_sekolah', 'email_sekolah', 'telepon_sekolah',
            'facebook', 'instagram', 'call_center_1', 'call_center_2', 'x', 'tiktok'
        ]);

        // Proses logo sekolah jika ada
        if ($request->hasFile('logo_sekolah')) {
            $logo = $request->file('logo_sekolah');
            $fileName = 'school-logo.' . $logo->getClientOriginalExtension();
            $filePath = $logo->storeAs('logos', $fileName, 'public');

            // Hapus logo lama jika ada
            $schoolProfile = SchoolProfile::find(1);
            if ($schoolProfile && $schoolProfile->logo_sekolah) {
                Storage::disk('public')->delete($schoolProfile->logo_sekolah);
            }

            $data['logo_sekolah'] = $filePath;
        }

        // Simpan atau perbarui profil sekolah
        SchoolProfile::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'Profil sekolah berhasil disimpan');
    }

}
