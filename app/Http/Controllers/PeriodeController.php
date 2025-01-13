<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeriodeController extends Controller
{
    public function index(Request $request)
    {
        session(['periodes_url' => $request->fullUrl()]);
        $name = Auth::user()->name;
        $title = 'Periode Pendaftaran';
        $periodes = Periode::all();
        return view('admin.periode.index', compact('title', 'name', 'periodes'));
    }

    public function show($id, Request $request)
    {
        // Simpan URL halaman sebelumnya di sesi
        $request->session()->put('previous_url', url()->previous());
        $name = Auth::user()->name;
        $title = 'Detail Periode Pendaftaran';
        // Ambil data periode beserta data relasi
        $periodes = Periode::with(['aptitudeTests', 'periodeJurusans.jurusan', 'pendaftars'])->findOrFail($id);

        return view('admin.periode.show', compact('title','name', 'periodes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_pelajaran' => 'required|string|max:255',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after_or_equal:tanggal_buka',
            'kuota_penerimaan' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ], [
            'tanggal_tutup.after_or_equal' => 'Tanggal tutup harus sama atau setelah tanggal buka.',
            'kuota_penerimaan.min' => 'Kuota penerimaan minimal adalah 0.',
        ]);
        
        // Cek apakah ada periode aktif
        if ($request->status == 1 && Periode::where('status', 1)->exists()) {
            return redirect()->back()->with('error', 'Periode aktif sudah ada. Nonaktifkan periode pendaftaran yang sedang aktif sebelum menambahkan yang baru.');
        }

        // Simpan data periode baru
        Periode::create($validated);

        return redirect()->route('periodes.index')->with('success', 'Data periode pendaftaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'tahun_pelajaran' => 'required|string|max:255',
                'tanggal_buka' => 'required|date',
                'tanggal_tutup' => 'required|date|after_or_equal:tanggal_buka',
                'kuota_penerimaan' => 'required|integer|min:0',
                'status' => 'required|boolean',
            ], [
                'tanggal_tutup.after_or_equal' => 'Tanggal tutup harus sama atau setelah tanggal buka.',
                'kuota_penerimaan.min' => 'Kuota penerimaan minimal adalah 0.',
            ]);

            // Cek apakah ada periode aktif selain yang sedang diedit
            $periode = Periode::findOrFail($id);
            if ($request->status == 1 && Periode::where('id', '!=', $id)->where('status', 1)->exists()) {
                return redirect()->back()
                    ->with('error', 'Periode aktif sudah ada. Nonaktifkan periode pendaftaran yang sedang aktif sebelum mengaktifkan yang baru.');
            }

            // Update data periode
            $periode->update($validated);

            return redirect()->route('periodes.index')->with('success', 'Data periode berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, simpan action URL ke `old()`
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput($request->all() + ['action_url' => route('periodes.update', $id)]);
        }
    }

    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);
        if ($periode->status == 1) {
            return redirect()->back()->with('error', 'Periode yang sedang aktif tidak dapat dihapus.');
        }

        $periode->delete();

        return redirect()->route('periodes.index')->with('success', 'Data periode pendaftaran berhasil dihapus');
    }

    public function getPeriodeData()
    {
        $periodes = Periode::select(['id', 'tahun_pelajaran', 'tanggal_buka', 'tanggal_tutup', 'kuota_penerimaan', 'kuota_penerimaan_used', 'status'])
            ->get();

        return datatables()->of($periodes)
            ->editColumn('tanggal_buka', function ($row) {
                return Carbon::parse($row->tanggal_buka)->format('d/m/Y');
            })
            ->editColumn('tanggal_tutup', function ($row) {
                return Carbon::parse($row->tanggal_tutup)->format('d/m/Y');
            })
            ->addColumn('action', function ($row) {
                $btn = '<button data-url="' . route('periodes.update', $row->id) . '" data-periode=\'' . json_encode($row) . '\' class="edit-btn btn btn-warning btn-sm">Edit</button>';
                $btn .= ' <form action="'.route('periodes.destroy', $row->id).'" method="POST" style="display:inline;">';
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
