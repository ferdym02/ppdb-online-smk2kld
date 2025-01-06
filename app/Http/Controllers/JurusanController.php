<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;

class JurusanController extends Controller
{
    public function index()
    {
        $title = 'Master Jurusan';
        $name = Auth::user()->name;
        $jurusans = Jurusan::all();
        return view('admin.jurusan.index', compact('title', 'name', 'jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|max:4|unique:jurusans,kode',
            'nama' => 'required|unique:jurusans,nama',
        ]);

        // Simpan data jurusan
        Jurusan::create($request->only(['kode', 'nama']));

        return redirect()->route('jurusan.index')->with('success', 'Data jurusan berhasil ditambahkan');
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'kode' => 'required|max:4|unique:jurusans,kode,' . $jurusan->id,
            'nama' => 'required|unique:jurusans,nama,' . $jurusan->id,
        ]);

        // Update data jurusan
        $jurusan->update($request->only(['kode', 'nama']));

        return redirect()->route('jurusan.index')->with('success', 'Data jurusan berhasil diperbarui');
    }

    public function destroy(Jurusan $jurusan)
    {
        // Hapus jurusan
        $jurusan->delete();

        return redirect()->route('jurusan.index')->with('success', 'Data jurusan berhasil dihapus');
    }

}
