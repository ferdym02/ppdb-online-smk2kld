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
        $title = 'Kelola Pengumuman';
        $pengumumans = Pengumuman::all();
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
            'file_lampiran' => 'required|file|mimes:pdf|max:2048'
        ]);

        // Ambil nama asli file
        $originalFileName = $request->file('file_lampiran')->getClientOriginalName();

        // Simpan file dengan nama asli
        $path = $request->file('file_lampiran')->storeAs('pengumuman', $originalFileName, 'public');

        Pengumuman::create([
            'judul' => $request->judul,
            'file_lampiran' => $path,
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'file_lampiran' => 'nullable|file|mimes:pdf|max:2048'
            ]);
    
            $pengumuman = Pengumuman::findOrFail($id);
            $pengumuman->judul = $request->judul;
    
            if ($request->hasFile('file_lampiran')) {
                // Hapus file lama jika ada
                if ($pengumuman->file_lampiran && Storage::disk('public')->exists($pengumuman->file_lampiran)) {
                    Storage::disk('public')->delete($pengumuman->file_lampiran);
                }
    
                // Simpan file baru dengan nama asli
                $originalFileName = $request->file('file_lampiran')->getClientOriginalName();
                $path = $request->file('file_lampiran')->storeAs('pengumuman', $originalFileName, 'public');
    
                $pengumuman->file_lampiran = $path;
            }
    
            $pengumuman->save();
    
            return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('pengumuman.update', $id)]);
        }
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->file_lampiran && Storage::disk('public')->exists($pengumuman->file_lampiran)) {
            Storage::disk('public')->delete($pengumuman->file_lampiran);
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
        $pengumumans = Pengumuman::all();
        return view('user.pengumuman', compact('pengumumans', 'isRegistrationOpen', 'title'));
    }
}
