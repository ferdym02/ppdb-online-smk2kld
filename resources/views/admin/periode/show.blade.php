@extends('admin.main')

@section('content')
<main class="app-main">
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center">
                  <!-- Tombol ikon kembali -->
                    <a href="{{ session('periodes_url') }}" class="me-3">
                      <i class="fas fa-arrow-left"></i>
                    </a>
                    <h3 class="mb-0">{{ $title }}</h3>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('periodes.index') }}">Periode Pendaftaran</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                  </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                <div class="card card-primary card-outline">
                  <div class="card-body">
                    <div class="row">
                      <!-- Column 1 -->
                      <h5 class="text-center">Data Periode Pendaftaran</h5>
                      <div class="col-md-6">
                        <table class="table">
                          <tr>
                              <th>Tahun Pelajaran</th>
                              <td>: {{ $periodes->tahun_pelajaran }}</td>
                          </tr>
                          <tr>
                            <th>Tanggal Buka Pendaftaran</th>
                            <td>: {{ \Carbon\Carbon::parse($periodes->tanggal_buka)->format('d-m-Y') }}</td>
                          </tr>
                          <tr>
                              <th>Tanggal Tutup Pendaftaran</th>
                              <td>: {{ \Carbon\Carbon::parse($periodes->tanggal_tutup)->format('d-m-Y') }}</td>
                          </tr>
                          <tr>
                            <th>Status</th>
                            <td>: {{ $periodes->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table">
                          <tr>
                            <th>Kuota Penerimaan</th>
                            <td>: {{ $periodes->kuota_penerimaan }}</td>
                          </tr>
                          <tr>
                            <th>Kuota Terpakai</th>
                            <td>: {{ $periodes->kuota_penerimaan_used }}</td>
                          </tr>
                          <tr>
                            <th>Kuota Tersedia</th>
                            <td>: {{ $periodes->kuota_penerimaan - $periodes->kuota_penerimaan_used}}</td>
                          </tr>
                          <tr>
                            <th>Total Pendaftar</th>
                            <td>: {{ $periodes->pendaftars->count() }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end::Row-->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Data Tes Minat dan Bakat</h3>
                        </div>
                        <div class="card-body">
                            @if($periodes->aptitudeTests->isEmpty())
                                <p class="text-center">Tidak ada data tes minat dan bakat untuk periode ini.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Periode Pendaftaran</th>
                                            <th class="text-center">Tanggal Tes Dibuka</th>
                                            <th class="text-center">Tanggal Tes Ditutup</th>
                                            <th class="text-center">Kuota Per Hari</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($periodes->aptitudeTests as $index => $test)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $periodes->tahun_pelajaran }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($test->tanggal_buka_tes)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($test->tanggal_tutup_tes)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $test->kuota_per_hari }}</td>
                                                <td class="text-center">{{ $test->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                                                <td class="text-center">
                                                  <a href="{{ route('aptitudes.show', $test->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!--end::Row-->

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-secondary">
                      <div class="card-header">
                          <h3 class="card-title">Data Jurusan dan Alokasi Kuota</h3>
                      </div>
                        <div class="card-body">
                            @if($periodes->periodeJurusans->isEmpty())
                                <p class="text-center">Tidak ada data jurusan untuk periode ini.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Jurusan</th>
                                            <th class="text-center">Kuota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($periodes->periodeJurusans as $index => $periodeJurusan)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $periodeJurusan->jurusan->nama }}</td>
                                                <td class="text-center">{{ $periodeJurusan->kuota }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-start">Total Kuota</th>
                                            <td class="text-center"><strong>{{ $periodes->periodeJurusans->sum('kuota') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>          
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
@endsection
