<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>PPDB Online {{ $profile->nama_sekolah }}</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-32x32.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <style>
      .registration-step {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        background-color: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .registration-step i {
        font-size: 24px;
        color: #007bff;
        margin-right: 15px;
      }

      .registration-step p {
        margin: 0;
        font-size: 16px;
        line-height: 1.5;
        color: #5f687b;
      }

      .registration-step:last-child {
        margin-bottom: 0;
      }
      .text-container {
        display: flex;
        flex-direction: column; /* Atur teks secara vertikal */
      }

      .text-container h5 {
        margin: 0; /* Hapus margin default */
        font-size: 1.25rem; /* Atur ukuran font untuk "PPDB Online" */
      }

      .text-container span {
        font-size: 1rem; /* Atur ukuran font untuk "{{ $profile->nama_sekolah }}" */
      }
    </style>
  </head>

  <body class="index-page">
    <header id="header" class="header d-flex align-items-center sticky-top">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="/" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="{{ asset('storage/' . ($profile->logo_sekolah ?? 'default-logo.png')) }}" alt="" />
          <div class="text-container">
            <h5>PPDB Online</h5>
            <span>{{ $profile->nama_sekolah }}</span>
          </div>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="active">Home</a></li>
            <li><a href="#profil">Profil</a></li>
            <li><a href="#jurusan">Jurusan</a></li>
            <li><a href="#alur">Alur & Syarat</a></li>
            <li><a href="#jadwal">Jadwal</a></li>
            <li><a href="#contact">Kontak</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="/login">Login</a>
      </div>
    </header>

    <main class="main">
      <!-- Hero Section -->
      <section id="hero" class="hero section">
        <div class="container">
          <div class="row gy-4">
            @php
              $currentYear = date('Y');
              $nextYear = $currentYear + 1;
            @endphp
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
              <h1>PPDB Online {{ $profile->nama_sekolah }} {{ $currentYear }}/{{ $nextYear }}</h1>
              <p>Melalui halaman ini, Anda dapat mendaftar sebagai calon peserta didik baru secara online dengan mudah dan cepat.</p>
              <div class="d-flex">
                <a href="/register" class="btn-get-started">Daftar</a>
              </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img d-flex justify-content-center" data-aos="zoom-out" data-aos-delay="100">
              <img src="{{ asset('storage/' . ($profile->logo_sekolah ?? 'default-logo.png')) }}" class="img-fluid animated" alt="" />
            </div>
          </div>
        </div>
      </section>
      <!-- /Hero Section -->

      <!-- Featured Services Section -->
      <section id="featured-services" class="featured-services section">
        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="100">
              <div class="service-item position-relative">
                <div class="icon"><i class="bi bi-building-check"></i></div>
                <h4>Fasilitas Lengkap</h4>
                <p>{{ $profile->nama_sekolah }} menyediakan fasilitas yang lengkap untuk menunjang kegiatan belajar mengajar, termasuk laboratorium komputer, bengkel praktik, perpustakaan, serta sarana olahraga dan kesenian. Dengan fasilitas ini, siswa dapat mengembangkan keterampilan praktis dan akademis secara optimal.</p>
              </div>
            </div>
            <!-- End Service Item -->
      
            <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="200">
              <div class="service-item position-relative">
                <div class="icon"><i class="bi bi-list-check"></i></div>
                <h4>Jurusan yang Beragam</h4>
                <p>{{ $profile->nama_sekolah }} menawarkan berbagai jurusan yang dirancang untuk memenuhi kebutuhan dunia industri dan teknologi masa kini. Saat ini terdapat 10 macam jurusan, siswa dapat memilih jurusan yang sesuai dengan minat dan bakat mereka.</p>
              </div>
            </div>
            <!-- End Service Item -->
      
            <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="300">
              <div class="service-item position-relative">
                <div class="icon"><i class="bi bi-clipboard-check"></i></div>
                <h4>Terakreditasi A</h4>
                <p>Dengan status akreditasi A, {{ $profile->nama_sekolah }} telah diakui secara nasional sebagai sekolah yang unggul dalam kualitas pendidikan. Akreditasi ini mencerminkan komitmen kami untuk terus memberikan pendidikan yang terbaik, yang ditunjang oleh kurikulum terkini dan tenaga pengajar yang berpengalaman.</p>
              </div>
            </div>
            <!-- End Service Item -->
          </div>
        </div>
      </section>      
      <!-- /Featured Services Section -->

      <!-- About Section -->
      <section id="profil" class="about section">
        <!-- Section Title -->
        <div class="container section-title mb-0" data-aos="fade-up">
          <span>Profil Sekolah<br /></span>
          <h2>Profil Sekolah</h2>
          <p class="col-lg-8 mx-auto">Sekolah Menengah Kejuruan Negeri 2 Kalianda, Lampung Selatan adalah sekolah Teknik yang tergolong Paling tua di Kalianda, Lampung Selatan, SMK Negeri 2 Kalanda ini pertama kali berdiri pada tahun 2000.</p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="row gy-4 d-flex justify-content-center align-items-center">
            <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
              <img src="{{ asset('assets/img/about-2.png') }}" class="img-fluid" alt="" />
              <a href="https://youtu.be/BKnnKlXq4-c" class="glightbox pulsating-play-btn"></a>
            </div>
            <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
              <h3>Visi {{ $profile->nama_sekolah }}</h3>
              <p class="fst-italic">
                Menghasilkan lulusan yang terdepan dalam bertaqwa, berakhlak mulia dan beriman kepada Tuhan Yang Maha Esa, yang memiliki karakter kuat Pelajar Pancasila dan berkompetensi tinggi di bidangnya sehingga siap bersaing untuk
                bekerja, melanjutkan pendidikan tinggi dan berwirausaha untuk masa depannya.
              </p>
              <h3>Misi {{ $profile->nama_sekolah }}</h3>
              <ul>
                <li><i class="bi bi-check2-all"></i> <span>Menanamkan keimanan, ketakwaan, akhlak mulia, dan karakter Pelajar Pancasila dalam semua aspek pendidikan dan latihan yang diselenggarakan di sekolah.</span></li>
                <li><i class="bi bi-check2-all"></i> <span>Menanamkan budaya kerja yang tinggi dalam semua aspek pendidikan dan latihan di sekolah.</span></li>
                <li>
                  <i class="bi bi-check2-all"></i>
                  <span>Menghasilkan lulusan yang kompeten dan tersertifikasi di bidang keahlian masing-masing sehingga mampu berkompetisi untuk bekerja di dunia kerja dan industri bertaraf nasional dan internasional.</span>
                </li>
                <li><i class="bi bi-check2-all"></i> <span>Membekali peserta didik dengan keilmuan yang bermanfaat untuk bersaing dalam melanjutkan pendidikan di perguruan tinggi.</span></li>
                <li><i class="bi bi-check2-all"></i> <span>Menumbuhkan jiwa technopreneur melalui pendidikan, latihan dengan sarana dan prasarana yang berorientasi pada projek nyata dan kewirausahaan.</span></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <!-- /About Section -->

      <!-- Services Section -->
      <section id="jurusan" class="services section light-background">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <span>Jurusan</span>
          <h2>Jurusan</h2>
          <p>Kompetensi Keahlian yang Tersedia</p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-wifi"></i>
                </div>
                <h3>Teknik Komputer dan Jaringan</h3>
                <p>Jurusan ini mengajarkan tentang perancangan, pemasangan, dan pengelolaan jaringan komputer serta pemeliharaan perangkat keras dan lunak komputer.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-car-front"></i>
                </div>
                <h3>Teknik Kendaraan Ringan</h3>
                <p>Jurusan ini fokus pada perawatan dan perbaikan kendaraan bermotor, termasuk sistem mesin, kelistrikan, dan suspensi kendaraan ringan.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-house"></i>
                </div>
                <h3>Teknik Konstruksi dan Perumahan</h3>
                <p>Jurusan ini mengajarkan tentang teknik bangunan, termasuk perencanaan, konstruksi, dan pemeliharaan infrastruktur perumahan.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-building"></i>
                </div>
                <h3>Desain Pemodelan dan Informasi Bangunan</h3>
                <p>Jurusan ini berfokus pada penggunaan perangkat lunak untuk merancang dan memodelkan bangunan serta mengelola informasi konstruksi.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-motherboard"></i>
                </div>
                <h3>Teknik Audio Video</h3>
                <p>Jurusan ini mengajarkan tentang teknologi audio dan video, mulai dari instalasi, pengoperasian, hingga perbaikan perangkat audio dan video.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-lightning"></i>
                </div>
                <h3>Teknik Instalasi Tenaga Listrik</h3>
                <p>Jurusan ini berfokus pada instalasi dan pemeliharaan sistem tenaga listrik, termasuk distribusi daya dan pengelolaan sistem kelistrikan.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-gear"></i>
                </div>
                <h3>Teknik Pemesinan</h3>
                <p>Jurusan ini mengajarkan tentang proses produksi menggunakan mesin, termasuk pemrograman mesin CNC dan teknik pemesinan lainnya.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="800">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-tools"></i>
                </div>
                <h3>Teknik Sepeda Motor</h3>
                <p>Jurusan ini berfokus pada perawatan dan perbaikan sepeda motor, mencakup mesin, kelistrikan, dan sistem lainnya yang ada pada sepeda motor.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="900">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-water"></i>
                </div>
                <h3>Agribisnis Perikanan Payau dan Laut</h3>
                <p>Jurusan ini mengajarkan tentang budidaya dan pengelolaan sumber daya perikanan di lingkungan payau dan laut, termasuk teknik pengolahan hasil laut.</p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="1000">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-droplet"></i>
                </div>
                <h3>Agribisnis Perikanan Tawar</h3>
                <p>Jurusan ini berfokus pada budidaya dan pengelolaan perikanan air tawar, termasuk teknik pembenihan dan pengelolaan kolam ikan.</p>
              </div>
            </div>
            <!-- End Service Item -->
          </div>
        </div>
      </section>
      <!-- /Services Section -->

      <!-- Call To Action Section -->
      <section id="alur" class="requirements-and-flow section accent-background">
        <div class="container">
          <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
            <!-- Syarat Pendaftaran -->
            <div class="col-lg-6">
              <h3 class="text-center">Syarat Pendaftaran</h3>
              <div class="card">
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span>1.</span> Telah dinyatakan lulus dari SMP/MTS/Sederajat dan memiliki Ijazah/Surat Keterangan Lulus</li>
                    <li class="list-group-item"><span>2.</span> Mengisi formulir pendaftaran dan mengunggah scan dokumen berupa:
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">a. Kartu Keluarga dan KTP orang tua / wali</li>
                        <li class="list-group-item">b. Akte Kelahiran</li>
                        <li class="list-group-item">c. Ijazah/Surat Keterangan Lulus</li>
                        <li class="list-group-item">d. Pas foto berwarna 3 x 4</li>
                        <li class="list-group-item">e. Raport semester 1-5</li>
                        <li class="list-group-item">f. Piagam/Sertifikat (jika ada)</li>
                        <li class="list-group-item">g. Surat Keterangan Peringkat Kelas/Sekolah (jika ada)</li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
      
            <!-- Alur Pendaftaran -->
            <div class="col-lg-6 mt-5 mt-lg-0">
              <div class="registration-flow">
                <h3 class="text-center">Alur Pendaftaran</h3>
                <div class="registration-step">
                  <i class="bi bi-r-circle"></i>
                  <p>Buat akun PPDB dengan cara klik login yang ada bagian atas kemudian pilih "Daftar".</p>
                </div>
                <div class="registration-step">
                  <i class="bi bi-pencil-square"></i>
                  <p>Isi formulir pendaftaran dengan data diri yang benar.</p>
                </div>
                <div class="registration-step">
                  <i class="bi bi-cloud-upload"></i>
                  <p>Upload dokumen yang diperlukan sesuai dengan ketentuan.</p>
                </div>
                <div class="registration-step">
                  <i class="bi bi-check-circle"></i>
                  <p>Verifikasi data dan dokumen oleh panitia PPDB.</p>
                </div>
                <div class="registration-step">
                  <i class="bi bi-book"></i>
                  <p>Melakukan Tes Minat dan Bakat</p>
                </div>
                <div class="registration-step">
                  <i class="bi bi-megaphone"></i>
                  <p>Pengumuman hasil seleksi melalui website PPDB.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /Call To Action Section -->

      <!-- Jadwal Pelaksanaan PPDB Section -->
      <section id="jadwal" class="jadwal-pelaksanaan section light-background">
        <div class="container section-title" data-aos="fade-up">
          <span>Jadwal Pelaksanaan PPDB</span>
          <h2>Jadwal Pelaksanaan PPDB</h2>
        </div>
        <div class="container">
          <!-- Jadwal Pelaksanaan Umum -->
          <div class="card">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>KEGIATAN</th>
                    <th>LOKASI</th>
                    <th>TANGGAL</th>
                    <th>WAKTU</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    // Array warna yang bisa dipilih secara acak
                    $colors = ['red', 'blue', 'green', 'orange', 'purple', 'brown',];
                    $usedColors = [];
                  @endphp
                  @foreach($jadwals as $jadwal)
                  @php
                    // Filter warna yang belum digunakan
                    $availableColors = array_diff($colors, $usedColors);
                    
                    // Pilih warna dari warna yang belum digunakan
                    if (count($availableColors) > 0) {
                      $colorToUse = array_shift($availableColors); // Ambil warna pertama dari yang tersedia
                    } else {
                      $colorToUse = 'black'; // Jika semua warna sudah digunakan, gunakan warna default
                    }
                    
                    // Simpan warna yang sudah digunakan
                    $usedColors[] = $colorToUse;
                  @endphp
                    <tr>
                      <td style="color: {{ $colorToUse }}">{{ $jadwal->kegiatan }}</td>
                      <td>{{ $jadwal->lokasi }}</td>
                      <td>
                        {{ $jadwal->tanggal_mulai->format('d M Y') }}
                        @if ($jadwal->tanggal_selesai)
                          - {{ $jadwal->tanggal_selesai->format('d M Y') }}
                        @endif
                      </td>
                      <td>{{ $jadwal->waktu }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
      <!-- /Jadwal Pelaksanaan PPDB Section -->

      <!-- Contact Section -->
      <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <span>Informasi Kontak</span>
          <h2>Informasi Kontak</h2>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row gy-4">
            <div class="col-lg-6">
              <div class="info-wrap">
                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                  <i class="bi bi-geo-alt flex-shrink-0"></i>
                  <div>
                    <h3>Alamat</h3>
                    <p>{{ $profile->alamat_sekolah ?? 'Alamat Sekolah' }}</p>
                  </div>
                </div>
                <!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-telephone flex-shrink-0"></i>
                  <div>
                    <h3>Telpon</h3>
                    <p>{{ $profile->telepon_sekolah ?? '(021) 12345678' }}</p>
                  </div>
                </div>
                <!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-whatsapp flex-shrink-0"></i>
                  <div>
                      <h3>Call Center</h3>
                      <ul class="m-0">
                          @if(!empty($profile->call_center))
                              @foreach($profile->call_center as $number)
                                  <li>
                                      <a href="https://wa.me/{{ preg_replace('/\D/', '', $number) }}" target="_blank">{{ $number }}</a>
                                  </li>
                              @endforeach
                          @else
                              <li>Belum ada nomor call center.</li>
                          @endif
                      </ul>
                  </div>
                </div>              
                <!-- End Info Item -->

                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-envelope flex-shrink-0"></i>
                  <div>
                    <h3>Email</h3>
                    <a href="mailto:{{ $profile->email_sekolah ?? 'email@sekolah.sch.id' }}">
                      {{ $profile->email_sekolah ?? 'email@sekolah.sch.id' }}
                    </a>
                  </div>
                </div>
                <!-- End Info Item -->
              </div>
            </div>

            <div class="col-lg-6">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15880.147698001629!2d105.5896283!3d-5.7078051!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e411019ba58ca2f%3A0xc66ae879b32810a2!2sSMK%20Negeri%202%20Kalianda!5e0!3m2!1sen!2sid!4v1722916631933!5m2!1sen!2sid"
                frameborder="0"
                style="border: 0; width: 100%; height: 100%"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
        </div>
      </section>
      <!-- /Contact Section -->
    </main>

    <footer id="footer" class="footer">
      <div class="container footer-top">
        <div class="row gy-4 d-flex justify-content-lg-between">
          <div class="col-lg-4 footer-about">
            <a href="https://smkn2kalianda.sch.id/" target="blank" class="d-flex align-items-center">
              <span class="sitename">{{ $profile->nama_sekolah }}</span>
            </a>
            <div class="footer-contact pt-3">
              <p>{{ $profile->alamat_sekolah ?? 'Alamat Sekolah' }}</p>
              <p class="mt-3"><strong>Telpon:</strong> <span>{{ $profile->telepon_sekolah ?? '(021) 12345678' }}</span></p>
              <p><strong>Email:</strong> <span>{{ $profile->email_sekolah ?? 'email@sekolah.sch.id' }}</span></p>
            </div>
          </div>

          <div class="col-lg-4">
            <h4>Follow Kami</h4>
            <p>Follow media sosial {{ $profile->nama_sekolah }} untuk mendapatkan informasi terbaru</p>
            <div class="social-links d-flex">
              <a href="{{ $profile->x ?? '#' }}" target="blank"><i class="bi bi-twitter-x"></i></a>
              <a href="{{ $profile->facebook ?? '#' }}" target="blank"><i class="bi bi-facebook"></i></a>
              <a href="{{ $profile->instagram ?? '#' }}" target="blank"><i class="bi bi-instagram"></i></a>
              <a href="{{ $profile->tiktok ?? '#' }}" target="blank"><i class="bi bi-tiktok"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">PPDB SMK Negeri 2 Kalianada</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you've purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
          <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
        </div>
      </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
  </body>
</html>
