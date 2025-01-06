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
        $callCenters = json_decode($schoolProfile->call_center, true);
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
            'call_center' => 'nullable|array',
            'call_center.*' => 'nullable|string|max:15', // validasi untuk setiap nomor di call center
            'x' => 'nullable|url',
            'tiktok' => 'nullable|url',
        ]);

        $data = $request->only([
            'nama_sekolah', 
            'alamat_sekolah', 
            'email_sekolah', 
            'telepon_sekolah', 
            'facebook', 
            'instagram',
            'x',
            'tiktok',
        ]);

        // Mengubah array call_center menjadi JSON
        if ($request->has('call_center')) {
            $data['call_center'] = json_encode(array_filter($request->call_center));
        }

        // Ambil data profil sekolah yang ada untuk mendapatkan logo lama
        $schoolProfile = SchoolProfile::find(1);

        // Menyimpan logo sekolah jika ada file yang diunggah
        if ($request->hasFile('logo_sekolah')) {
            // Jika ada logo lama, hapus file lama terlebih dahulu
            if ($schoolProfile && $schoolProfile->logo_sekolah) {
                Storage::disk('public')->delete($schoolProfile->logo_sekolah);
            }

            $logo = $request->file('logo_sekolah');
            
            // Tentukan nama file baru dengan format 'school-logo'
            $fileName = 'school-logo.' . $logo->getClientOriginalExtension();

            // Simpan file dengan nama yang ditentukan
            $filePath = $logo->storeAs('logos', $fileName, 'public');

            // Simpan path file dalam database
            $data['logo_sekolah'] = $filePath;
        }

        // Menggunakan updateOrCreate untuk memperbarui atau membuat data
        SchoolProfile::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'Profil sekolah berhasil disimpan');
    }

}
