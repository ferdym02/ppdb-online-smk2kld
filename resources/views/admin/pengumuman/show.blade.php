@extends('admin.main')
@section('css')
<style>
  .pengumuman-content img {
      max-width: 100%;
      height: auto;
      display: block;
      margin: 10px auto;
  }

  /* Batasi lebar gambar hanya pada layar besar */
  @media (min-width: 768px) {
      .pengumuman-content img {
          max-width: 500px;
      }
  }
</style>
@endsection

@section('content')
<main class="app-main">
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center">
                  <!-- Tombol ikon kembali -->
                    <a href="{{ route('pengumuman.index') }}" class="me-3">
                      <i class="fas fa-arrow-left"></i>
                    </a>
                    <h3 class="mb-0">{{ $title }}</h3>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
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
                    <h4>{{ $pengumuman->judul }}</h4>
                    <p class="text-muted">{{ $pengumuman->created_at->format('d M Y H:i') }}</p>
                    
                    <div class="pengumuman-content">
                        {!! $pengumuman->isi !!}
                    </div>
                  
                    @if($pengumuman->file_lampiran)
                      <div class="mt-3">
                        <a href="{{ asset('storage/' . $pengumuman->file_lampiran) }}" class="btn btn-primary" target="_blank">
                          <i class="fas fa-download"></i> Download Lampiran
                        </a>
                      </div>
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
