<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class PendaftarExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Pendaftar::with('periode') // Load relasi periode
            ->select('pendaftars.*'); // Ambil semua kolom dari tabel pendaftar

        // Filter berdasarkan permintaan
        if (!empty($this->filters['periode'])) {
            $query->where('periode_id', $this->filters['periode']);
        }
        if (!empty($this->filters['jurusan'])) {
            $query->where('jurusan_id', $this->filters['jurusan']);
        }
        if (!empty($this->filters['status_pendaftaran'])) {
            $query->where('status_pendaftaran', $this->filters['status_pendaftaran']);
        }
        // Filter berdasarkan tanggal pendaftaran
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('created_at', [$this->filters['start_date'], $this->filters['end_date']]);
        } elseif (!empty($this->filters['start_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['start_date']);
        } elseif (!empty($this->filters['end_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['end_date']);
        }

        // Ambil data dan urutkan berdasarkan periode dan nama lengkap
        $data = $query->orderBy('periode_id')->orderBy('nama_lengkap')->get();

        // Mapping status pendaftaran
        $statusMapping = [
            'pending' => 'Pending',
            'verified' => 'Terverifikasi',
            'rejected' => 'Perlu Perbaikan',
            'diterima' => 'Lulus',
            'gugur' => 'Tidak Lulus',
            'cadangan' => 'Cadangan'
        ];

        // Kelompokkan berdasarkan periode
        $groupedData = $data->groupBy('periode_id');

        $finalData = new Collection();
        foreach ($groupedData as $periodeId => $pendaftarList) {
            $periodeNama = optional($pendaftarList->first()->periode)->tahun_pelajaran ?? 'Periode Tidak Diketahui';

            // Tambahkan header periode
            $finalData->push(['Periode: ' . $periodeNama, '', '', '', '', '', '']);

            // Tambahkan header tabel setelah setiap periode
            $finalData->push([
                'No', 'Nomor Pendaftaran', 'NISN', 'Nama Lengkap', 'Jenis Kelamin', 'Asal Sekolah', 'Status Pendaftaran'
            ]);

            // Tambahkan data pendaftar
            foreach ($pendaftarList as $index => $item) {
                $status = $statusMapping[$item->status_pendaftaran] ?? $item->status_pendaftaran;

                $finalData->push([
                    $index + 1,
                    $item->nomor_pendaftaran,
                    $item->nisn,
                    $item->nama_lengkap,
                    $item->jenis_kelamin,
                    $item->asal_sekolah,
                    $status, // Status sudah dikonversi sesuai mapping
                ]);
            }
        }

        return $finalData;
    }

    public function headings(): array
    {
        return []; // Header sudah ditangani dalam collection()
    }
}
