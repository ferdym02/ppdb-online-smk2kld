<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Pendaftar;
use Yajra\DataTables\Facades\DataTables;

class DataTableController extends Controller
{
    public function getUsersData(Request $request) {
        if ($request->ajax()) {
            $data = User::where('role', 'user')
            ->select(['id', 'name', 'email']) // Pilih hanya kolom yang diperlukan
                ->get()
                ->map(function($item, $index) {
                    $item->no = $index + 1; // Tambahkan kolom 'no' untuk nomor urut
                    return $item;
                });
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button type="button" class="btn btn-warning btn-sm btn-edit" data-id="'.$row->id.'" data-name="'.$row->name.'" data-email="'.$row->email.'">Edit</button>';
                    $btn .= ' <form action="/admin/users/' . $row->id . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }    

    public function getAdminsData(Request $request) {
        if ($request->ajax()) {
            $data = User::where('role', 'admin')
                ->select(['id', 'name', 'email']) // Pilih hanya kolom yang diperlukan
                ->get()
                ->map(function($item, $index) {
                    $item->no = $index + 1; // Tambahkan kolom 'no' untuk nomor urut
                    return $item;
                });
    
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" class="btn btn-warning btn-sm btn-edit" data-id="'.$row->id.'" data-name="'.$row->name.'" data-email="'.$row->email.'">Edit</button>';
                    $btn .= ' <form action="/admin/admins/' . $row->id . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }       
    
    public function getJurusanData()
    {
        // Mengambil semua data jurusan beserta relasi periode
        $jurusans = Jurusan::with('periode')->get();

        // Menambahkan nomor urut pada setiap data
        $jurusans->each(function($item, $key) {
            $item->nomor = $key + 1;
        });

        return datatables()->of($jurusans)
            ->addColumn('periode', function($row) {
                return $row->periode ? $row->periode->tahun_pelajaran : '-'; // Tampilkan periode atau '-' jika tidak ada
            })
            ->addColumn('action', function($row){
                $btn = ' <a href="/admin/jurusan/' . $row->id . '/edit" class="edit btn btn-warning btn-sm">Edit</a>';
                $btn .= ' <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">Delete</button>';
                return $btn;
            })
            ->make(true);
    }

    public function getPendaftarByStatus($status, Request $request)
{
    // Filter hanya untuk status 'diterima'
    $pendaftars = Pendaftar::where('status_pendaftaran', $status);

    // Tambahkan filter daftar ulang
    if ($request->has('daftar_ulang') && $request->daftar_ulang !== '') {
        if ($request->daftar_ulang === 'null') {
            $pendaftars->whereNull('daftar_ulang');
        } elseif ($request->daftar_ulang === 'ya') {
            $pendaftars->where('daftar_ulang', 'ya');
        }
        // Abaikan 'tidak', tidak perlu disertakan karena status otomatis 'gugur'
    }

    return DataTables::eloquent($pendaftars)
        ->addIndexColumn()
        ->addColumn('jenis_kelamin', function ($row) {
            return $row->jenis_kelamin === 'Laki-Laki' ? 'L' : 'P';
        })
        ->addColumn('tanggal_pendaftaran', function ($pendaftar) {
            return $pendaftar->created_at->format('d-m-Y');
        })
        ->make(true);
}



}
