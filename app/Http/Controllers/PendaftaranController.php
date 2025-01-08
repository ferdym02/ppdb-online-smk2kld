<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Periode;
use App\Models\PeriodeJurusan;
use App\Models\AptitudeTest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use PDF;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        // Simpan URL saat ini ke session sebelum render halaman
        session(['index_url' => $request->fullUrl()]);
        $title = 'Data Pendaftar';
        $name = Auth::user()->name;

        // Ambil semua periode untuk dropdown
        $periodes = Periode::all();

        // Periksa apakah ada periode aktif
        $activePeriod = Periode::where('status', 1)->first();

        // Cek jika ada request untuk memilih periode
        $selectedPeriodId = $request->input('periode_id', $activePeriod ? $activePeriod->id : null);

        // Jika tidak ada periode aktif dan tidak ada yang dipilih
        if (!$selectedPeriodId) {
            $totalPending = 0;
            $totalVerified = 0;
            $totalRejected = 0;
            $totalDiterima = 0;
            $totalGugur = 0;
            $totalCadangan = 0;
        } else {
            // Hitung jumlah pendaftar berdasarkan status dan periode terpilih/aktif
            $totalPending = Pendaftar::where('status_pendaftaran', 'pending')
                                    ->where('periode_id', $selectedPeriodId)
                                    ->count();
            $totalVerified = Pendaftar::where('status_pendaftaran', 'verified')
                                    ->where('periode_id', $selectedPeriodId)
                                    ->count();
            $totalRejected = Pendaftar::where('status_pendaftaran', 'rejected')
                                    ->where('periode_id', $selectedPeriodId)
                                    ->count();
            $totalDiterima = Pendaftar::where('status_pendaftaran', 'diterima')
                                    ->where('periode_id', $selectedPeriodId)
                                    ->count();
            $totalGugur = Pendaftar::where('status_pendaftaran', 'gugur')
                                    ->where('periode_id', $selectedPeriodId)
                                    ->count();
            $totalCadangan = Pendaftar::where('status_pendaftaran', 'cadangan')
                                    ->where('periode_id', $selectedPeriodId)
                                    ->count();
        }

        
        return view('admin.pendaftar.index', compact(
            'totalPending', 'totalVerified', 'totalRejected', 'totalDiterima', 'totalGugur', 'totalCadangan', 'title', 'name', 'periodes', 'selectedPeriodId'
        ));
    }

    public function indexByStatus(Request $request, $status)
    {
        session(['index_by_status_url' => $request->fullUrl()]);
        $title = 'Data Pendaftar';
        $name = Auth::user()->name;
        $pendaftar = Pendaftar::where('status_pendaftaran', $status)->get();
        
        $jurusans = Jurusan::all()->keyBy('id');

        // Membuat mapping ID jurusan ke nama jurusan
        $jurusanMap = $jurusans->mapWithKeys(function ($item) {
            return [$item->id => $item->nama];
        });

        return view('admin.pendaftar.index_by_status', compact('pendaftar', 'jurusanMap', 'title', 'name', 'status'));
    }

    public function show($id, Request $request)
    {
        $name = Auth::user()->name;
        $pendaftar = Pendaftar::with(['jurusans', 'user'])->findOrFail($id);
        $title = "Detail Pendaftar";
        
        // Simpan URL halaman sebelumnya di sesi
        $request->session()->put('previous_url', url()->previous());

        // Mengambil pilihan jurusan
        $jurusanPilihan1 = $pendaftar->jurusans->where('pivot.urutan_pilihan', 1)->first();
        $jurusanPilihan2 = $pendaftar->jurusans->where('pivot.urutan_pilihan', 2)->first();
        $jurusanPilihan3 = $pendaftar->jurusans->where('pivot.urutan_pilihan', 3)->first();

        // Menggabungkan pilihan jurusan dalam satu koleksi
        $jurusans = collect([$jurusanPilihan1, $jurusanPilihan2, $jurusanPilihan3])->filter();

        // Menambahkan informasi kuota dari tabel `periode_jurusan`
        $currentDate = now();
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $jurusans = $jurusans->map(function ($jurusan) use ($activePeriod) {
            if ($activePeriod) {
                $periodeJurusan = PeriodeJurusan::where('jurusan_id', $jurusan->id)
                    ->where('periode_id', $activePeriod->id)
                    ->first();
                $jurusan->periode_jurusan_id = $periodeJurusan->id ?? null; // Tambahkan ID periode_jurusan
                $jurusan->kuota = $periodeJurusan->kuota ?? 'Tidak tersedia'; // Tambahkan kuota
            } else {
                $jurusan->periode_jurusan_id = null;
                $jurusan->kuota = 'Periode tidak aktif';
            }
            return $jurusan;
        });       

        return view('admin.pendaftar.show', compact('pendaftar', 'title', 'name', 'jurusans'));
    }

    public function create()
    {
        $title = 'Pendaftaran';
        // Asumsikan Anda memiliki autentikasi dan dapatkan user_id dari pengguna yang sedang login
        $userId = Auth::id();
        
        // Cek apakah pendaftar sudah ada
        $pendaftar = Pendaftar::where('user_id', $userId)->first();

        $currentDate = now(); // Mengambil tanggal saat ini

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;

        // Ambil jurusan yang terkait dengan periode aktif
        $jurusans = PeriodeJurusan::with('jurusan')
        ->where('periode_id', $activePeriod->id)
        ->get()
        ->map(function ($periodeJurusan) {
            return $periodeJurusan->jurusan;
        });
        
        return view('user.pendaftaran', compact('jurusans', 'pendaftar', 'isRegistrationOpen', 'title'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        // Cek apakah pendaftar sudah ada
        $existingPendaftar = Pendaftar::where('user_id', $userId)->first();

        if ($existingPendaftar) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar.');
        }

        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:pendaftars,nisn',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'prestasi_akademik' => 'required|boolean',
            'prestasi_non_akademik' => 'required|boolean',
            'pilihan_jurusan_1' => 'required|exists:jurusans,id',
            'pilihan_jurusan_2' => 'required|exists:jurusans,id',
            'pilihan_jurusan_3' => 'required|exists:jurusans,id',
            'kartu_keluarga' => 'required|file|mimes:jpg,jpeg,pdf|max:2048',
            'ktp_orang_tua' => 'required|file|mimes:jpg,jpeg,pdf|max:2048',
            'akte_kelahiran' => 'required|file|mimes:jpg,jpeg,pdf|max:2048',
            'ijazah' => 'required|file|mimes:jpg,jpeg,pdf|max:2048',
            'foto_calon_siswa' => 'required|file|mimes:jpg,jpeg|max:2048',
            'raport' => 'required|file|mimes:pdf|max:2048',
            'piagam' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'surat_keterangan' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'nilai_rapor.*.mtk' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.ipa' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.bahasa_inggris' => 'required|numeric|min:0|max:100',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar, silakan periksa kembali.',
        ]);
        
        // Validasi tambahan untuk memastikan pilihan jurusan berbeda
        $pilihanJurusan1 = $request->input('pilihan_jurusan_1');
        $pilihanJurusan2 = $request->input('pilihan_jurusan_2');
        $pilihanJurusan3 = $request->input('pilihan_jurusan_3');

        if ($pilihanJurusan1 == $pilihanJurusan2 || $pilihanJurusan1 == $pilihanJurusan3 || $pilihanJurusan2 == $pilihanJurusan3) {
            return redirect()->back()->withErrors(['pilihan_jurusan' => 'Pilihan jurusan tidak boleh sama.'])->withInput();
        }

        // Mendapatkan tanggal saat ini
        $currentDate = now();

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        // Jika tidak ada periode yang aktif, kembalikan pesan error atau tangani sesuai kebutuhan
        if (!$activePeriod) {
            return redirect()->back()->withErrors(['periode' => 'Tidak ada periode yang aktif saat ini.'])->withInput();
        }

        DB::beginTransaction();

        try {
            // Handle file upload
            $files = [];
            foreach (['kartu_keluarga', 'ktp_orang_tua', 'akte_kelahiran', 'ijazah', 'foto_calon_siswa', 'raport', 'piagam', 'surat_keterangan'] as $fileField) {
                if ($request->hasFile($fileField)) {
                    $originalName = $request->file($fileField)->getClientOriginalName();
                    $fileExtension = $request->file($fileField)->getClientOriginalExtension();
                    $fileName = $request->nisn . '_' . $fileField . '_' . time() . '.' . $fileExtension;
                    $files[$fileField] = $request->file($fileField)->storeAs('file_pendaftaran', $fileName, 'public');
                }
            }

            // Set default status verifikasi
            $validatedData = $request->all();
            $validatedData['status_pendaftaran'] = 'pending';
            $validatedData['daftar_ulang'] = null;
            $validatedData['catatan_penolakan'] = null;
            // Simpan data pendaftar baru
            $pendaftar = Pendaftar::create([
                'user_id' => $userId,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'asal_sekolah' => $request->asal_sekolah,
                'nisn' => $request->nisn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'nomor_wa' => $request->nomor_wa,
                'prestasi_akademik' => $request->prestasi_akademik,
                'prestasi_non_akademik' => $request->prestasi_non_akademik,
                'kartu_keluarga' => $files['kartu_keluarga'] ?? null,
                'ktp_orang_tua' => $files['ktp_orang_tua'] ?? null,
                'akte_kelahiran' => $files['akte_kelahiran'] ?? null,
                'ijazah' => $files['ijazah'] ?? null,
                'foto_calon_siswa' => $files['foto_calon_siswa'] ?? null,
                'raport' => $files['raport'] ?? null,
                'piagam' => $files['piagam'] ?? null,
                'surat_keterangan' => $files['surat_keterangan'] ?? null,
                'periode_id' => $activePeriod->id, // Menyimpan periode_id yang aktif
                // Nilai rapor
                'nilai_mtk_semester_1' => $request->input('nilai_rapor.1.mtk'),
                'nilai_mtk_semester_2' => $request->input('nilai_rapor.2.mtk'),
                'nilai_mtk_semester_3' => $request->input('nilai_rapor.3.mtk'),
                'nilai_mtk_semester_4' => $request->input('nilai_rapor.4.mtk'),
                'nilai_mtk_semester_5' => $request->input('nilai_rapor.5.mtk'),
                'nilai_ipa_semester_1' => $request->input('nilai_rapor.1.ipa'),
                'nilai_ipa_semester_2' => $request->input('nilai_rapor.2.ipa'),
                'nilai_ipa_semester_3' => $request->input('nilai_rapor.3.ipa'),
                'nilai_ipa_semester_4' => $request->input('nilai_rapor.4.ipa'),
                'nilai_ipa_semester_5' => $request->input('nilai_rapor.5.ipa'),
                'nilai_bahasa_indonesia_semester_1' => $request->input('nilai_rapor.1.bahasa_indonesia'),
                'nilai_bahasa_indonesia_semester_2' => $request->input('nilai_rapor.2.bahasa_indonesia'),
                'nilai_bahasa_indonesia_semester_3' => $request->input('nilai_rapor.3.bahasa_indonesia'),
                'nilai_bahasa_indonesia_semester_4' => $request->input('nilai_rapor.4.bahasa_indonesia'),
                'nilai_bahasa_indonesia_semester_5' => $request->input('nilai_rapor.5.bahasa_indonesia'),
                'nilai_bahasa_inggris_semester_1' => $request->input('nilai_rapor.1.bahasa_inggris'),
                'nilai_bahasa_inggris_semester_2' => $request->input('nilai_rapor.2.bahasa_inggris'),
                'nilai_bahasa_inggris_semester_3' => $request->input('nilai_rapor.3.bahasa_inggris'),
                'nilai_bahasa_inggris_semester_4' => $request->input('nilai_rapor.4.bahasa_inggris'),
                'nilai_bahasa_inggris_semester_5' => $request->input('nilai_rapor.5.bahasa_inggris'),
            ]);
        
            // Simpan data pilihan jurusan di tabel pivot
            $pendaftar->jurusans()->attach($pilihanJurusan1, ['urutan_pilihan' => 1]);
            $pendaftar->jurusans()->attach($pilihanJurusan2, ['urutan_pilihan' => 2]);
            $pendaftar->jurusans()->attach($pilihanJurusan3, ['urutan_pilihan' => 3]);

            // Ambil kode jurusan untuk pilihan jurusan 1
            $jurusan1 = Jurusan::find($pilihanJurusan1);
            $pendaftar->update(['nomor_pendaftaran' => Pendaftar::generateNomorPendaftaran($jurusan1->kode, $pendaftar->id)]);

            DB::commit();

            // Redirect atau respon setelah berhasil menyimpan data
            return redirect()->route('user.pendaftaran')->with('success', 'Pendaftaran berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pendaftaran.')->withInput();
        }
    }

    public function edit($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $title = "Edit Pendaftar";
        $name = Auth::user()->name;
        $jurusans = Jurusan::all();
        return view('admin.pendaftar.edit', compact('pendaftar', 'title', 'name'));
    }

    public function update(Request $request, $id)
    {
        // Cari data pendaftar berdasarkan $id
        $pendaftar = Pendaftar::findOrFail($id);
        
        // Validasi input data utama
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:15',
            'prestasi_akademik' => 'required|boolean',
            'prestasi_non_akademik' => 'required|boolean',
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'ktp_orang_tua' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'akte_kelahiran' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'foto_calon_siswa' => 'nullable|file|mimes:jpg,jpeg|max:2048',
            'raport' => 'nullable|file|mimes:pdf|max:2048',
            'piagam' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'surat_keterangan' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'nilai_rapor.*.mtk' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.ipa' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.bahasa_inggris' => 'required|numeric|min:0|max:100',
        ]);
        
        // Handle file uploads and deletions
        foreach (['kartu_keluarga', 'ktp_orang_tua', 'akte_kelahiran', 'ijazah', 'foto_calon_siswa', 'raport', 'piagam', 'surat_keterangan'] as $fileField) {
            if ($request->hasFile($fileField)) {
                // Hapus file lama jika ada
                $oldFilePath = $pendaftar->$fileField;
                if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }

                // Buat nama file baru dengan format khusus
                $fileExtension = $request->file($fileField)->getClientOriginalExtension();
                $fileName = $request->nisn . '_' . $fileField . '_' . time() . '.' . $fileExtension;

                // Simpan file baru dengan nama khusus
                $validatedData[$fileField] = $request->file($fileField)->storeAs('file_pendaftaran', $fileName, 'public');
            } else {
                // Jika tidak ada file baru, gunakan file lama
                $validatedData[$fileField] = $pendaftar->$fileField;
            }
        }

        // Update nilai rapor
        $nilaiRapor = [];
        foreach (['mtk', 'ipa', 'bahasa_indonesia', 'bahasa_inggris'] as $subject) {
            for ($semester = 1; $semester <= 5; $semester++) {
                $nilaiRapor["nilai_{$subject}_semester_{$semester}"] = $request->input("nilai_rapor.{$semester}.{$subject}");
            }
        }
        $pendaftar->update($nilaiRapor);
        
        // Update data pendaftar
        $pendaftar->update($validatedData);

        // Redirect atau respon setelah berhasil memperbarui data
        return redirect()->route('admin.pendaftar.show', $id)->with('success', 'Data pendaftar berhasil diperbarui.');
    }

    public function editPendaftaran()
    {
        $title = "Edit Data Pendaftaran";
        // Asumsikan Anda memiliki autentikasi dan dapatkan user_id dari pengguna yang sedang login
        $userId = Auth::id();

        $currentDate = now(); // Mengambil tanggal saat ini

        // Mencari periode yang aktif dan berada di antara tanggal buka dan tanggal tutup
        $activePeriod = Periode::where('status', 1)
            ->where('tanggal_buka', '<=', $currentDate)
            ->where('tanggal_tutup', '>=', $currentDate)
            ->first();

        $isRegistrationOpen = $activePeriod ? true : false;
        
        // Cek apakah pendaftar sudah ada
        $pendaftar = Pendaftar::where('user_id', $userId)->first();
        $jurusans = Jurusan::all();
        return view('user.pendaftaran_edit', compact('jurusans', 'pendaftar', 'isRegistrationOpen', 'title'));
    }

    public function updatePendaftaran(Request $request, $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);

        // Validasi input data utama
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pendaftars', 'nisn')->ignore($pendaftar->id), // Abaikan validasi unik untuk NISN milik pendaftar ini
            ],
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:20',
            'prestasi_akademik' => 'required|boolean',
            'prestasi_non_akademik' => 'required|boolean',
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'ktp_orang_tua' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'akte_kelahiran' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'foto_calon_siswa' => 'nullable|file|mimes:jpg,jpeg|max:2048',
            'raport' => 'nullable|file|mimes:pdf|max:2048',
            'piagam' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'surat_keterangan' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048',
            'nilai_rapor.*.mtk' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.ipa' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_rapor.*.bahasa_inggris' => 'required|numeric|min:0|max:100',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar, silakan periksa kembali.',
        ]);

        // Update status verifikasi and catatan penolakan
        $validatedData['status_pendaftaran'] = 'pending';
        $validatedData['catatan_penolakan'] = null;
        $validatedData['daftar_ulang'] = null;
        
        // Handle file uploads and deletions
        foreach (['kartu_keluarga', 'ktp_orang_tua', 'akte_kelahiran', 'ijazah', 'foto_calon_siswa', 'raport', 'piagam', 'surat_keterangan'] as $fileField) {
            if ($request->hasFile($fileField)) {
                // Hapus file lama jika ada
                $oldFilePath = $pendaftar->$fileField;
                if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }

                // Buat nama file baru dengan format khusus
                $fileExtension = $request->file($fileField)->getClientOriginalExtension();
                $fileName = $request->nisn . '_' . $fileField . '_' . time() . '.' . $fileExtension;

                // Simpan file baru dengan nama khusus
                $validatedData[$fileField] = $request->file($fileField)->storeAs('file_pendaftaran', $fileName, 'public');
            } else {
                // Jika tidak ada file baru, gunakan file lama
                $validatedData[$fileField] = $pendaftar->$fileField;
            }
        }

        // Update nilai rapor
        $nilaiRapor = [];
        foreach (['mtk', 'ipa', 'bahasa_indonesia', 'bahasa_inggris'] as $subject) {
            for ($semester = 1; $semester <= 5; $semester++) {
                $nilaiRapor["nilai_{$subject}_semester_{$semester}"] = $request->input("nilai_rapor.{$semester}.{$subject}");
            }
        }
        $pendaftar->update($nilaiRapor);

        // Update data pendaftar dengan data yang sudah tervalidasi
        $pendaftar->update($validatedData);

        // Redirect atau respon setelah berhasil memperbarui data
        return redirect()->route('user.pendaftaran')->with('success', 'Pendaftaran berhasil diperbarui!');
    }

    public function destroy($id, Request $request)
    {
        // Temukan data pendaftar berdasarkan ID
        $pendaftar = Pendaftar::find($id);

        if ($pendaftar) {
            // Update kuota pada tabel periode_jurusan jika pendaftar memiliki jurusan_diterima
            if ($pendaftar->jurusan_diterima && $pendaftar->status_pendaftaran !== 'cadangan') {
                $periodeJurusan = PeriodeJurusan::where('jurusan_id', $pendaftar->jurusan_diterima)
                    ->where('periode_id', $pendaftar->periode_id)
                    ->first();

                if ($periodeJurusan) {
                    $periodeJurusan->kuota += 1;
                    $periodeJurusan->save();
                }
            }

            // Daftar atribut file yang perlu dihapus
            $fileAttributes = [
                'kartu_keluarga',
                'ktp_orang_tua',
                'akte_kelahiran',
                'ijazah',
                'foto_calon_siswa',
                'raport',
                'piagam',
                'surat_keterangan',
            ];

            // Hapus setiap file jika ada
            foreach ($fileAttributes as $attribute) {
                if ($pendaftar->$attribute) {
                    Storage::disk('public')->delete('file_pendaftaran/' . basename($pendaftar->$attribute));
                }
            }

            // Hapus data pendaftar
            $pendaftar->delete();

            // Redirect ke halaman index_by_status yang tersimpan di session
            $redirectUrl = session('index_by_status_url', route('admin.pendaftar.index')); // Fallback ke daftar utama jika URL tidak ditemukan
            return redirect($redirectUrl)->with('success', 'Pendaftar berhasil dihapus.');
        }

        // Redirect ke halaman index_by_status dengan pesan error jika data tidak ditemukan
        $redirectUrl = session('index_by_status_url', route('admin.pendaftar.index')); // Fallback ke daftar utama jika URL tidak ditemukan
        return redirect($redirectUrl)->with('error', 'Pendaftar tidak ditemukan.');
    }

    public function verifikasi(Request $request, $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);

        if ($request->status == 'verifikasi') {
            $pendaftar->status_pendaftaran = 'verified';
            $pendaftar->catatan_penolakan = null;

            // Ambil tes aktif yang belum selesai
            $tesAktif = AptitudeTest::where('status', true)
                ->where('tanggal_tutup_tes', '>=', now()->toDateString())
                ->orderBy('tanggal_buka_tes')
                ->first();

            if (!$tesAktif) {
                return redirect()->back()->with('error', 'Tidak ada tes minat bakat tersedia saat ini.');
            }

            try {
                DB::beginTransaction(); // Mulai transaksi hanya untuk penjadwalan tanggal tes
                
                $startDate = Carbon::parse($tesAktif->tanggal_buka_tes)->greaterThan(now())
                            ? Carbon::parse($tesAktif->tanggal_buka_tes)
                            : now()->addDay();
                $endDate = Carbon::parse($tesAktif->tanggal_tutup_tes);

                while ($startDate <= $endDate) {
                    // Periksa apakah tanggal saat ini adalah hari Minggu
                    if ($startDate->isSunday()) {
                        $startDate->addDay(); // Lewati hari Minggu
                        continue;
                    }

                    // Cek kuota pada tanggal ini dengan locking untuk menghindari race condition
                    $count = Pendaftar::where('tanggal_tes', $startDate->toDateString())
                        ->lockForUpdate() // Lock hanya saat memeriksa kuota
                        ->count();

                    if ($count < $tesAktif->kuota_per_hari) {
                        $pendaftar->tanggal_tes = $startDate->toDateString();
                        break;
                    }

                    $startDate->addDay(); // Lanjut ke hari berikutnya
                }

                if (!$pendaftar->tanggal_tes) {
                    DB::rollBack(); // Batalkan transaksi jika tidak menemukan kuota
                    return redirect()->back()->with('error', 'Semua kuota tes minat bakat pada periode ini sudah penuh.');
                }

                $pendaftar->save(); // Simpan perubahan pendaftar
                DB::commit(); // Selesaikan transaksi
            } catch (\Exception $e) {
                DB::rollBack(); // Batalkan transaksi jika terjadi error
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menentukan tanggal tes.');
            }
        } elseif ($request->status == 'tolak') {
            $pendaftar->status_pendaftaran = 'rejected';
            $pendaftar->catatan_penolakan = $request->catatan_penolakan;
            $pendaftar->save();
        }

        return redirect()->back()->with('success', 'Status verifikasi telah diperbarui.');
    }

    public function updateNilaiTes(Request $request, $id)
    {
        try {
            $request->validate([
                'nilai_tes_minat_bakat' => 'required|in:A,B,C,K',
                'jurusan_diterima' => 'nullable|exists:periode_jurusan,id',
            ]);
            
            $pendaftar = Pendaftar::findOrFail($id);
            $pendaftar->nilai_tes_minat_bakat = $request->nilai_tes_minat_bakat;
            
            if ($request->nilai_tes_minat_bakat === 'K') {
                $pendaftar->status_pendaftaran = 'gugur';
            } else {
               // Hitung nilai akhir
                $nilaiMtkTotal = (
                    $pendaftar->nilai_mtk_semester_1 +
                    $pendaftar->nilai_mtk_semester_2 +
                    $pendaftar->nilai_mtk_semester_3 +
                    $pendaftar->nilai_mtk_semester_4 +
                    $pendaftar->nilai_mtk_semester_5
                ) * 2;

                $nilaiBahasaInggrisTotal = (
                    $pendaftar->nilai_bahasa_inggris_semester_1 +
                    $pendaftar->nilai_bahasa_inggris_semester_2 +
                    $pendaftar->nilai_bahasa_inggris_semester_3 +
                    $pendaftar->nilai_bahasa_inggris_semester_4 +
                    $pendaftar->nilai_bahasa_inggris_semester_5
                ) * 2;

                $nilaiRapor = (
                    $nilaiMtkTotal +
                    $nilaiBahasaInggrisTotal +
                    $pendaftar->nilai_ipa_semester_1 +
                    $pendaftar->nilai_bahasa_indonesia_semester_1 +
                    $pendaftar->nilai_ipa_semester_2 +
                    $pendaftar->nilai_bahasa_indonesia_semester_2 +
                    $pendaftar->nilai_ipa_semester_3 +
                    $pendaftar->nilai_bahasa_indonesia_semester_3 +
                    $pendaftar->nilai_ipa_semester_4 +
                    $pendaftar->nilai_bahasa_indonesia_semester_4 +
                    $pendaftar->nilai_ipa_semester_5 +
                    $pendaftar->nilai_bahasa_indonesia_semester_5
                ) / 30;
    
                $nilaiPrestasi = 0;
                if ($pendaftar->prestasi_akademik) {
                    $nilaiPrestasi += 50;
                }
                if ($pendaftar->prestasi_non_akademik) {
                    $nilaiPrestasi += 50;
                }
                $nilaiPrestasi = $nilaiPrestasi / 2;
    
                $pendaftar->nilai_akhir = ($nilaiRapor * 0.8) + ($nilaiPrestasi * 0.2);
    
                // Cek kuota melalui tabel periode_jurusan
                $periodeJurusan = PeriodeJurusan::find($request->jurusan_diterima);
                
                if ($periodeJurusan) {
                    $pendaftar->jurusan_diterima = $periodeJurusan->jurusan_id; // Simpan ID jurusan
                    if ($periodeJurusan->kuota > 0) {
                        $pendaftar->status_pendaftaran = 'diterima';
    
                        // Kurangi kuota jurusan
                        $periodeJurusan->kuota -= 1;
                        $periodeJurusan->save();
                    } else {
                        $pendaftar->status_pendaftaran = 'cadangan';
                    }
                } else {
                    return redirect()->back()->with('error', 'Jurusan tidak valid untuk periode ini.');
                }
            }
    
            $pendaftar->status_tes = 'sudah';
            $pendaftar->save();
    
            return redirect()->back()->with('success', 'Nilai tes minat bakat dan status pendaftaran berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors()); // Debug pesan error validasi
        }
    }

    public function cetakBukti($id)
    {
        $pendaftar = Pendaftar::with('jurusans')->findOrFail($id);

        // Periksa otorisasi
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin' || auth()->id() === $pendaftar->user_id) {
            // Path ke gambar logo kiri
            $pathLeft = storage_path('app/public/lampung.png');
            $typeLeft = pathinfo($pathLeft, PATHINFO_EXTENSION);
            $dataLeft = file_get_contents($pathLeft);
            $base64Left = 'data:image/' . $typeLeft . ';base64,' . base64_encode($dataLeft);

            // Path ke gambar logo kanan (gambar baru)
            $pathRight = storage_path('app/public/logo.png');
            $typeRight = pathinfo($pathRight, PATHINFO_EXTENSION);
            $dataRight = file_get_contents($pathRight);
            $base64Right = 'data:image/' . $typeRight . ';base64,' . base64_encode($dataRight);

            $periode = Periode::where('status', true)->first();  // Ambil periode yang aktif

            // Ambil foto calon siswa dan konversi ke base64
            $pathFotoCalonSiswa = storage_path('app/public/' . $pendaftar->foto_calon_siswa);
            $pathFotoCalonSiswa = str_replace('\\', '/', $pathFotoCalonSiswa);

            if (file_exists($pathFotoCalonSiswa)) {
                $typeFoto = pathinfo($pathFotoCalonSiswa, PATHINFO_EXTENSION);
                $dataFoto = file_get_contents($pathFotoCalonSiswa);
                $base64FotoCalonSiswa = 'data:image/' . $typeFoto . ';base64,' . base64_encode($dataFoto);
            } else {
                $base64FotoCalonSiswa = null; // Foto tidak ada
            }

            $pilihanJurusan1 = $pendaftar->jurusans->where('pivot.urutan_pilihan', 1)->first();
            $pilihanJurusan2 = $pendaftar->jurusans->where('pivot.urutan_pilihan', 2)->first();
            $pilihanJurusan3 = $pendaftar->jurusans->where('pivot.urutan_pilihan', 3)->first();

            $data = [
                'nomor_pendaftaran' => $pendaftar->nomor_pendaftaran,
                'waktu_pendaftaran' => $pendaftar->created_at,
                'jenis_pendaftaran' => 'Reguler',
                'nisn' => $pendaftar->nisn,
                'nama_lengkap' => $pendaftar->nama_lengkap,
                'tempat_tanggal_lahir' => $pendaftar->tempat_lahir . ', ' . $pendaftar->tanggal_lahir,
                'alamat' => $pendaftar->alamat,
                'asal_sekolah' => $pendaftar->asal_sekolah,
                'jenis_kelamin' => $pendaftar->jenis_kelamin,
                'nomor_wa' => $pendaftar->nomor_wa,
                'nama_ayah' => $pendaftar->nama_ayah,
                'nama_ibu' => $pendaftar->nama_ibu,
                'tanggal_tes' => $pendaftar->tanggal_tes,
                'pilihan_jurusan_1' => $pilihanJurusan1 ? $pilihanJurusan1->nama : '-',
                'pilihan_jurusan_2' => $pilihanJurusan2 ? $pilihanJurusan2->nama : '-',
                'pilihan_jurusan_3' => $pilihanJurusan3 ? $pilihanJurusan3->nama : '-',
                'base64FotoCalonSiswa' => $base64FotoCalonSiswa,
            ];

            $pdf = PDF::loadView('pdf.bukti_pendaftaran', $data, compact('base64Left', 'base64Right', 'periode'));
            return $pdf->download('Bukti_Pendaftaran.pdf');
        }

        // Jika tidak berhak, tampilkan error
        abort(403, 'Unauthorized action.');
    }

    public function updateDaftarUlang(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $pendaftar = Pendaftar::findOrFail($id);

                $request->validate([
                    'daftar_ulang' => 'required|in:ya,tidak',
                ]);

                $pendaftar->daftar_ulang = $request->daftar_ulang;

                if ($request->daftar_ulang === 'tidak') {
                    $pendaftar->status_pendaftaran = 'gugur';

                    if ($pendaftar->jurusan_diterima) {
                        $periodeJurusan = PeriodeJurusan::where('jurusan_id', $pendaftar->jurusan_diterima)
                            ->where('periode_id', $pendaftar->periode_id)
                            ->lockForUpdate() // Lock untuk mencegah race condition
                            ->first();

                        if ($periodeJurusan) {
                            $periodeJurusan->kuota += 1;
                            $periodeJurusan->save();
                        }
                    }

                    $pendaftar->jurusan_diterima = null;
                }

                $pendaftar->save();
            });

            return redirect()->back()->with('success', 'Status daftar ulang berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $pendaftar = Pendaftar::findOrFail($id);

                if ($pendaftar->status_pendaftaran !== 'cadangan') {
                    throw new \Exception('Hanya pendaftar dengan status "cadangan" yang dapat diubah.');
                }

                $periodeJurusan = PeriodeJurusan::where('jurusan_id', $pendaftar->jurusan_diterima)
                    ->lockForUpdate()
                    ->first();

                if (!$periodeJurusan) {
                    throw new \Exception('Jurusan tidak valid atau tidak tersedia dalam periode ini.');
                }

                if ($periodeJurusan->kuota <= 0) {
                    throw new \Exception('Kuota untuk jurusan yang dipilih sudah penuh.');
                }

                $periodeJurusan->kuota -= 1;
                $periodeJurusan->save();

                $pendaftar->status_pendaftaran = 'diterima';
                $pendaftar->save();
            });

            return redirect()->back()->with('success', 'Status pendaftaran berhasil diubah menjadi diterima.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}