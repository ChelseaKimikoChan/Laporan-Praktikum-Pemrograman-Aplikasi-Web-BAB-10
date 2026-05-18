# Portal Berita Mahasiswa - CRUD & Authentication (Laravel 11 + Vite)

Aplikasi Web Portal Berita sederhana yang dibangun menggunakan **Framework Laravel 11** sebagai REST API Backend, terintegrasi dengan **Vite** dan **Vanilla JavaScript (Fetch API)** di sisi Frontend. Proyek ini dibuat untuk memenuhi tugas praktikum Pemrograman Web (BAB 10 - Web Framework).

## 🚀 Fitur Utama

Sesuai dengan ketentuan spesifikasi tugas, aplikasi ini menerapkan sistem hak akses sebagai berikut:
1. **Operasi Read Terbuka (Public)**: Siapa saja (termasuk pengunjung yang belum login) dapat melihat daftar berita terkini lengkap dengan nama penulisnya.
2. **Operasi Create Terproteksi**: Hanya pengguna yang telah melakukan registrasi dan login (memiliki token valid) yang dapat menulis berita baru.
3. **Operasi Update & Delete Khusus Pemilik (Owner-Based Authorization)**: Pengguna yang sudah login hanya berhak mengubah (*Edit*) atau menghapus (*Hapus*) berita yang mereka tulis sendiri. Tombol aksi akan otomatis disembunyikan jika berita tersebut milik akun lain.

## 🛠️ Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Autentikasi**: Laravel Sanctum (Token-Based Authentication)
- **Database**: MySQL / Peranti bawaan phpMyAdmin
- **Frontend**: Vanilla JavaScript (Fetch API) & Bootstrap 5
- **Asset Manager**: Vite (ES Modules Integration)

## 📁 Struktur Komponen Kunci

Proyek ini menerapkan konsep pemisahan kode (*Separation of Concerns*) yang bersih menggunakan struktur bawaan Laravel:
- **Database Relational (One-to-Many)**: Ditangani oleh `create_news_table.php` menggunakan kunci tamu `user_id` yang terhubung secara `cascade` dengan tabel `users`.
- **Logika Backend**: Terpisah secara rapi di dalam `AuthController.php` (Register & Login) dan `NewsController.php` (CRUD & Eager Loading `with('user')`).
- **Logika Frontend**: Kode JavaScript dipisahkan dari file Blade dan dikelola langsung oleh Vite di dalam direktori `resources/js/` (`index.js`, `login.js`, `register.js`).

---

## 💻 Cara Menjalankan Proyek di Lokal

Ikuti langkah-langkah di bawah ini untuk memasang dan menjalankan proyek ini di komputer Anda:

### 1. Persiapan Awal
Pastikan komputer Anda sudah terpasang Git, PHP (v8.2+), Composer, Node.js (NPM), dan web server seperti XAMPP atau Laragon.

### 2. Kloning Repositori
```bash
git clone [https://github.com/username-kamu/nama-repo-kamu.git](https://github.com/username-kamu/nama-repo-kamu.git)
cd nama-repo-kamu
```

### 3. Instalasi Dependensi Backend & Frontend
```bash
# Mengunduh paket core PHP/Laravel
composer install

# Mengunduh paket node_modules untuk Vite & Front-end
npm install
```

### 4. Konfigurasi Environment (.env)
```bash
cp .env.example .env
```

Ubah file  `.env` mu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_news        # Buat database bernama 'db_news' terlebih dahulu di phpMyAdmin
DB_USERNAME=root
DB_PASSWORD=
```

Buat Application Key:

```bash
php artisan key:generate
```

### 5. Migrasi Database
```bash
php artisan migrate:fresh
```

---

## ▶️ Menjalankan Server Aplikasi

Menjalankan Server Laravel Backend:

```bash
php artisan serve
```

Menjalankan Kompiler Vite Frontend:

```bash
npm run dev
```

Aplikasi dapat diakses di URL: `http://127.0.0.1:8000`.

---

## 📡 Daftar Endpoints API

| Metode | Endpoint | Keterangan | Hak Akses |
|---|---|---|---|
| POST | `/api/register` | Mendaftarkan akun pengguna baru | Publik |
| POST | `/api/login`	| Login untuk mendapatkan Bearer Token	| Publik |
| GET | `/api/news` | Mengambil seluruh daftar berita (+ Data Penulis) | Publik |
| GET | `/api/news/{id}` | Mengambil detail satu berita berdasarkan ID | Publik |
| POST | `/api/news` | Membuat berita baru (Otomatis mencatat `user_id`) | User Login |
| PUT | `/api/news/{id}` | Memperbarui berita (Wajib pemilik asli berita) | User Login |
| DELETE | `/api/news/{id}` | Menghapus berita (Wajib pemilik asli berita) | User Login |
| GET | `/api/user` | Mengambil data profil user yang sedang login | User Login |

---

## 📁 Struktur Projek

```text
Laporan-Praktikum-Pemrograman-Aplikasi-Web-BAB-10/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php      # Menangani logika API Register & Login (Sanctum Token)
│   │       └── NewsController.php      # Menangani logika API CRUD Berita & Validasi Hak Akses
│   └── Models/
│       ├── News.php                    # Model Berita (Relasi: BelongsTo User)
│       └── User.php                    # Model Pengguna (Relasi: HasMany News + Trait HasApiTokens)
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php  # Tabel bawaan User, Resets, & Sessions
│       └── 2026_05_18_074258_create_news_table.php   # Tabel Berita + Foreign Key 'user_id'
├── resources/
│   ├── js/                             # Logika Frontend (Dikelola oleh Vite)
│   │   ├── app.js
│   │   ├── index.js                    # Fetch API untuk CRUD Berita, manajemen token, & global scope
│   │   ├── login.js                    # Fetch API untuk Autentikasi Login & simpan token ke localStorage
│   │   └── register.js                 # Fetch API untuk pendaftaran akun pengguna baru
│   └── views/                          # Interface Tampilan (Blade Template)
│       ├── index.blade.php             # Halaman utama Portal Berita & Form CRUD
│       ├── login.blade.php             # Halaman Form Login Pengguna
│       └── register.blade.php          # Halaman Form Registrasi Akun
├── routes/
│   ├── api.php                         # Endpoint REST API (Terproteksi Middleware auth:sanctum)
│   └── web.php                         # Router Web untuk memuat halaman View Blade
└── vite.config.js                      # Konfigurasi jalur bunder aset JavaScript untuk compiler Vite
```