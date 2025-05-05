<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    public function index()
    {
        $title = 'Pengumuman';
        $pengumumans = Pengumuman::orderBy('created_at', 'desc')->get();
        $name = Auth::user()->name;
        return view('admin.pengumuman.index', compact('title', 'name', 'pengumumans'));
    }

    public function getPengumumanData(Request $request)
    {
        if ($request->ajax()) {
            $data = Pengumuman::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$row->id.'" data-judul="'.$row->judul.'" data-file="'.$row->file_lampiran.'">Edit</button>';
                    $btn .= ' <form action="'.route('pengumuman.destroy', $row->id).'" method="POST" style="display:inline;">';
                    $btn .= csrf_field();
                    $btn .= method_field('DELETE');
                    $btn .= '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
                    $btn .= '</form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,docx|max:2048'
        ]);

        // Proses file lampiran jika ada
        $path = null;
        if ($request->hasFile('file_lampiran')) {
            $originalFileName = $request->file('file_lampiran')->getClientOriginalName();
            $path = $request->file('file_lampiran')->storeAs('pengumuman', $originalFileName, 'public');
        }

        // Proses gambar dari Base64 ke file yang tersimpan
        $isi = $request->isi;
        preg_match_all('/<img[^>]+src="data:image\/([^";]+);base64,([^">]+)"/', $isi, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $imageType = $match[1]; // Contoh: png, jpeg
            $imageData = base64_decode($match[2]);
            $imageName = time() . '_' . uniqid() . '.' . $imageType;
            $imagePath = 'storage/pengumuman_images/' . $imageName;

            // Simpan gambar ke folder
            file_put_contents(public_path($imagePath), $imageData);

            // Ganti base64 di dalam editor dengan URL gambar sebenarnya
            $isi = preg_replace('/<img[^>]+src="data:image\/[^";]+;base64,[^">]+">?/', '<img src="' . asset($imagePath) . '">', $isi);
        }

        // Simpan pengumuman ke database
        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $isi,
            'file_lampiran' => $path,
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'file_lampiran' => 'nullable|file|mimes:pdf,docx|max:2048'
            ]);

            $pengumuman = Pengumuman::findOrFail($id);

            // Ambil gambar lama dari isi sebelum diperbarui
            preg_match_all('/<img[^>]+src="([^"]+)"/', $pengumuman->isi, $oldImages);
            $oldImagePaths = $oldImages[1] ?? [];

            // Proses file lampiran jika ada
            $path = $pengumuman->file_lampiran;
            if ($request->hasFile('file_lampiran')) {
                // Hapus lampiran lama jika ada
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }

                $originalFileName = $request->file('file_lampiran')->getClientOriginalName();
                $path = $request->file('file_lampiran')->storeAs('pengumuman', $originalFileName, 'public');
            }

            // Proses gambar dari Base64 ke file
            $isi = $request->isi;
            preg_match_all('/<img[^>]+src="data:image\/([^";]+);base64,([^">]+)"/', $isi, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $imageType = $match[1]; // Contoh: png, jpeg
                $imageData = base64_decode($match[2]);
                $imageName = time() . '_' . uniqid() . '.' . $imageType;
                $imagePath = 'storage/pengumuman_images/' . $imageName;

                // Simpan gambar ke folder
                file_put_contents(public_path($imagePath), $imageData);

                // Ganti base64 di dalam editor dengan URL gambar sebenarnya
                $isi = preg_replace('/<img[^>]+src="data:image\/[^";]+;base64,[^">]+">?/', '<img src="' . asset($imagePath) . '">', $isi);
            }

            // Ambil gambar baru dari isi setelah diperbarui
            preg_match_all('/<img[^>]+src="([^"]+)"/', $isi, $newImages);
            $newImagePaths = $newImages[1] ?? [];

            // Hapus gambar lama yang tidak lagi digunakan
            foreach ($oldImagePaths as $oldImage) {
                if (!in_array($oldImage, $newImagePaths)) {
                    $filePath = str_replace(asset('storage/'), '', $oldImage);
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }

            // Simpan perubahan
            $pengumuman->update([
                'judul' => $request->judul,
                'isi' => $isi,
                'file_lampiran' => $path,
            ]);

            return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('pengumuman.update', $id)]);
        }
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.show', [
            'title' => 'Detail Pengumuman',
            'pengumuman' => $pengumuman
        ]);
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->file_lampiran && Storage::disk('public')->exists($pengumuman->file_lampiran)) {
            Storage::disk('public')->delete($pengumuman->file_lampiran);
        }

        // Cari semua gambar dalam isi pengumuman
        preg_match_all('/<img[^>]+src="([^"]+)"/', $pengumuman->isi, $matches);
        $imagePaths = $matches[1] ?? [];

        foreach ($imagePaths as $imagePath) {
            // Pastikan gambar berada di dalam direktori penyimpanan yang benar
            if (strpos($imagePath, asset('storage/pengumuman_images/')) !== false) {
                $filePath = str_replace(asset('storage/'), '', $imagePath);

                // Hapus gambar dari penyimpanan jika ada
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }

    public function pengumumanUser()
    {
        $title = 'Pengumuman';
        $currentDate = now(); // Mengambil tanggal saat ini

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;
        $pengumumans = Pengumuman::orderBy('created_at', 'desc')->get();
        return view('user.pengumuman', compact('pengumumans', 'isRegistrationOpen', 'title'));
    }

    public function pengumumanUserShow($id)
    {
        $title = 'Detail Pengumuman';
        $currentDate = now(); // Mengambil tanggal saat ini

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;
        $pengumuman = Pengumuman::findOrFail($id);
        return view('user.pengumumanShow', compact('pengumuman', 'isRegistrationOpen', 'title'));
    }
}
