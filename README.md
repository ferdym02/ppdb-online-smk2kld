# Sistem PPDB Online SMKN 2 Kalianda

## Prasyarat

-   **XAMPP/Laragon/Software Sejenis:** (Berisi Apache, MySQL, PHP) Pastikan PHP versi >= 8.1 dan _extension_ yang dibutuhkan Laravel sudah aktif.
-   **Composer:** (Manajer paket untuk PHP)
-   **Node.js dan npm (atau Yarn):** Jika Anda menggunakan _frontend tooling_ seperti Vite atau Webpack.
-   **Git (Opsional):** Untuk mengkloning repositori.

**Penting:** Selama proses instalasi, disarankan untuk **mematikan sementara Windows Defender atau antivirus lainnya** untuk mencegah potensi masalah, terutama saat `composer install` dan `npm install`. Setelah instalasi selesai, Anda dapat mengaktifkannya kembali.

## Instalasi

1.  **Kloning repositori (atau salin folder proyek):**

2.  **Jalankan XAMPP/Laragon/Software Sejenis:** Pastikan Apache dan MySQL sudah berjalan.

3.  **Instal dependensi PHP (Composer):**

    Buka _Command Prompt_ atau _Terminal_ dan arahkan ke direktori proyek. Kemudian jalankan perintah berikut:

    ```bash
    composer install
    ```

    **Perhatian:** Jika terjadi _error_ pada tahap ini, pastikan Windows Defender atau antivirus Anda sudah dimatikan.

4.  **Salin berkas `.env.example` dan buat berkas `.env`:**

    ```bash
    cp .env.example .env
    # atau jika di windows
    copy .env.example .env
    ```

5.  **Konfigurasi berkas `.env`:**

    Buka berkas `.env` dan sesuaikan pengaturan berikut:

    -   `APP_NAME`: `PPDB Online SMK Negeri 2 Kalianda`.
    -   `APP_URL`: URL aplikasi Anda (misalnya, `http://localhost`).
    -   `DB_CONNECTION`: Koneksi database Anda (misalnya, `mysql`).
    -   `DB_HOST`: Host database Anda (biasanya `127.0.0.1` atau `localhost`).
    -   `DB_PORT`: Port database Anda (biasanya `3306` untuk MySQL).
    -   `DB_DATABASE`: `ppdb`
    -   `DB_USERNAME`: `root`
    -   `DB_PASSWORD`:

6.  **Generate key aplikasi:**

    ```bash
    php artisan key:generate
    ```

7.  **Migrasi dan _Seed_ Database:**

    ```bash
    php artisan migrate --seed
    ```

    Perintah `--seed` akan mengisi database dengan data awal, termasuk data _user default_.

8.  **Buat _Symbolic Link_ untuk Storage:**

    ```bash
    php artisan storage:link
    ```

    Perintah ini akan membuat _link_ dari `public/storage` ke `storage/app/public`, sehingga _file_ yang diunggah dapat diakses melalui web.

9.  **Instal dependensi _frontend_:**

    ```bash
    npm install
    ```

    **Perhatian:** Jika terjadi _error_ pada tahap ini, pastikan Windows Defender atau antivirus Anda sudah dimatikan.

10. **Jalankan server pengembangan:**

    ```bash
    php artisan serve
    ```

    Buka aplikasi Anda di _browser_ pada URL yang ditampilkan (biasanya `http://127.0.0.1:8000`).

## Akun Default

Berikut adalah akun _default_ yang akan dibuat setelah menjalankan `php artisan migrate --seed`:

| Nama       | Email              | Password | Role       |
| ---------- | ------------------ | -------- | ---------- |
| Admin      | admin2@example.com | password | admin      |
| Awaludin   | awaludin@gmail.com | password | user       |
| Superadmin | admin1@example.com | password | superadmin |

## Troubleshooting

-   **Error saat `composer install` atau `npm install`:** Pastikan Windows Defender atau antivirus Anda sudah dimatikan sementara.
-   **Error koneksi database:** Periksa kembali konfigurasi database di berkas `.env`.
-   **File tidak tampil di storage:** Pastikan Anda sudah menjalankan `php artisan storage:link`.
