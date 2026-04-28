<div align="center">

<img src="assets/logo.png" alt="Museum Kota Samarinda Logo" width="120" />

# ✦ Museum Kota Samarinda
### *Website Informasi & Digitalisasi Museum Berbasis Web*

<p>
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white"/>
  <img src="https://img.shields.io/badge/Three.js-Landing-000000?style=for-the-badge&logo=three.js&logoColor=white"/>
  <img src="https://img.shields.io/badge/Chart.js-Dashboard-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white"/>
  <img src="https://img.shields.io/badge/Anime.js-Animation-FF6B6B?style=for-the-badge"/>
</p>

<p>
  <a href="http://museum-smr.ct.ws/">
    <img src="https://img.shields.io/badge/🌐 Live Demo-museum--smr.ct.ws-2D6A4F?style=for-the-badge"/>
  </a>
</p>

> *Menyajikan warisan budaya Kota Samarinda dalam satu layar — modern, informatif, dan mudah diakses.*

---

</div>

## 📖 Deskripsi Aplikasi

**Museum Kota Samarinda** adalah sebuah sistem berbasis web yang dikembangkan sebagai media penyampaian informasi digital kepada masyarakat. Website ini hadir sebagai solusi atas keterbatasan sistem lama yang masih tergabung dengan platform UPTD — menjadikannya lebih mandiri, terstruktur, dan kaya fitur.

Sistem ini memiliki dua jenis pengguna: **Admin** yang mengelola seluruh data museum, dan **Pengunjung (User)** yang dapat mengakses informasi, memberikan ulasan, serta mengajukan peminjaman ruangan secara online.

> 🏛️ Objek Nyata: **Museum Kota Samarinda**, Kalimantan Timur, Indonesia

---

## 🌐 Live Hosting

| Platform | URL |
|----------|-----|
| 🌍 Website | [http://museum-smr.ct.ws/](http://museum-smr.ct.ws/) |

---

## ✨ Fitur Website

### 👤 Fitur Pengunjung (User)

| Fitur | Deskripsi |
|-------|-----------|
| 🏠 **Beranda** | Hero section interaktif, koleksi unggulan, event terbaru, berita, dan ulasan pengunjung |
| 🏺 **Katalog Koleksi** | Tampilan grid card koleksi museum dengan filter kategori, live search, dan slide panel detail tanpa pindah halaman |
| 📅 **Kalender Kegiatan** | Daftar event museum terstruktur berdasarkan tanggal, lengkap dengan detail dan sidebar kategori |
| 📰 **Berita & Artikel** | Filter kategori, sort terbaru, tampilan grid responsif berbasis Vue.js |
| 🗺️ **Peta Lokasi** | Integrasi Google Maps interaktif + informasi jam operasional & fasilitas |
| 🏛️ **Tentang Museum** | Profil lengkap: sejarah, visi-misi, linimasa slider interaktif, statistik museum |
| 💬 **Ulasan & Kesan** | Form komentar untuk pengunjung terdaftar, tampilan daftar ulasan dinamis |
| 📋 **Peminjaman Ruangan** | Form pengajuan lengkap dengan kalender ketersediaan, pratinjau data, dan integrasi WhatsApp otomatis |
| 🔍 **Pencarian** | Cari koleksi & informasi secara langsung (live search) |
| 🔐 **Login & Registrasi** | Autentikasi berbasis session dengan validasi penuh |

### 🛠️ Fitur Admin

| Fitur | Deskripsi |
|-------|-----------|
| 📊 **Dashboard** | Ringkasan data sistem, statistik jumlah koleksi/event/berita, grafik visualisasi (Chart.js) |
| 🏺 **Kelola Koleksi** | CRUD koleksi museum + upload multi-gambar, filter kategori, modal popup |
| 📅 **Kelola Kegiatan** | CRUD event museum, status kegiatan (aktif/selesai), filter kategori |
| 📰 **Kelola Berita** | CRUD artikel/berita, thumbnail upload, status tayang, kategori |
| 📋 **Kelola Peminjaman** | Lihat, setujui, tolak, atau reset status permohonan peminjaman ruangan |

---

## 🛠️ Tech Stack

### Backend
```
PHP (Native)        → Pengolahan data & logika server
MySQL               → Database utama (via PDO)
PDO                 → Koneksi database yang aman dan fleksibel
Session PHP         → Autentikasi & manajemen sesi pengguna
JSON API            → Komunikasi data antara frontend & backend
```

### Frontend
```
HTML5 / CSS3        → Struktur & styling halaman
Vue.js 3            → Komponen dinamis (berita, koleksi, filter)
Three.js            → Animasi 3D tubes cursor pada Landing Page
Chart.js            → Grafik statistik dashboard admin
Anime.js            → Animasi UI smooth & transisi halaman
Fetch API           → Komunikasi AJAX ke backend (tanpa jQuery)
CSS Flexbox & Grid  → Layout responsif
CSS Variable        → Konsistensi desain (design tokens)
CSS Transition      → Interaktivitas hover & animasi scroll
```

### Tools & Libraries
```
Animejs 3.2.1       → Animasi kompleks frontend
Chart.js (CDN)      → Visualisasi data grafik
Vue 3 (CDN)         → Reactive UI tanpa build step
Three.js Components → Efek 3D landing page
Google Maps Embed   → Integrasi peta lokasi
```

---

## 📁 Struktur Folder

```
museum-kota-samarinda/
│
├── 📂 admin/               → Halaman admin (dashboard, CRUD)
│   ├── index.php           → Dashboard admin
│   ├── koleksi.php         → Kelola koleksi museum
│   ├── event.php           → Kelola kegiatan/event
│   ├── berita.php          → Kelola berita & artikel
│   └── peminjaman.php      → Kelola permohonan peminjaman
│
├── 📂 api/                 → Backend API (mengembalikan JSON)
│   ├── koleksi.php         → API CRUD koleksi
│   ├── kegiatan.php        → API CRUD kegiatan
│   ├── berita.php          → API CRUD berita
│   ├── peminjaman.php      → API CRUD peminjaman
│   ├── ulasan.php          → API ulasan pengunjung
│   ├── dashboard.php       → API ringkasan dashboard
│   └── stats.php           → API statistik grafik
│
├── 📂 config/              → Konfigurasi sistem
│   ├── db.php              → Koneksi database (PDO)
│   └── auth.php            → Autentikasi & otorisasi session
│
├── 📂 assets/
│   ├── css/                → Stylesheet per halaman + global
│   └── js/                 → JavaScript per halaman + admin
│
├── 📂 images/              → Gambar koleksi museum (per kategori)
│   ├── etnografika/        → Alat musik, pakaian adat, mandau, dll
│   └── keramologi/         → Guci, mangkok, keramik
│
├── 📂 uploads/             → File yang diunggah admin
│   ├── berita/             → Gambar berita
│   └── koleksi/            → Gambar koleksi baru
│
├── 📂 proses/              → Handler form (non-API)
│   ├── login_proses.php    → Proses autentikasi login
│   ├── signup_proses.php   → Proses pendaftaran akun
│   └── logout.php          → Akhiri sesi pengguna
│
├── 📂 templates/           → Komponen reusable
│   ├── header.php          → Header HTML + asset loader
│   ├── sidebar.php         → Navigasi samping admin
│   ├── topbar.php          → Topbar admin
│   ├── modal-koleksi.php   → Modal popup form koleksi
│   ├── modal-kegiatan.php  → Modal popup form kegiatan
│   ├── modal-berita.php    → Modal popup form berita
│   └── toast.php           → Notifikasi toast
│
├── index.html              → Landing Page (Three.js + animasi 3D)
├── home.php                → Beranda utama pengguna
├── koleksi.php             → Katalog koleksi (Vue.js)
├── event.php               → Halaman kegiatan/event
├── berita.php              → Halaman berita (Vue.js)
├── peminjaman.php          → Form peminjaman ruangan
├── ulasan.php              → Halaman ulasan pengunjung
├── tentang.php             → Profil museum
├── peta.php                → Peta lokasi museum
├── login.php               → Halaman login
└── signup.php              → Halaman registrasi
```

---

## 🗃️ Rancangan Database

```sql
-- Tabel pengguna & hak akses
CREATE TABLE akun (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  usia INT,
  pekerjaan VARCHAR(100),
  peran ENUM('admin', 'user')
);

-- Tabel koleksi museum
CREATE TABLE koleksi (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nomor VARCHAR(50),
  nama_koleksi VARCHAR(200),
  kategori_id INT,
  deskripsi TEXT,
  era VARCHAR(100),
  kondisi VARCHAR(100),
  asal VARCHAR(100),
  lokasi VARCHAR(100)
);

-- Tabel gambar koleksi (relasi one-to-many)
CREATE TABLE koleksi_images (
  id INT PRIMARY KEY AUTO_INCREMENT,
  koleksi_id INT,
  image_path VARCHAR(255)
);

-- Tabel berita
CREATE TABLE berita (
  id INT PRIMARY KEY AUTO_INCREMENT,
  judul VARCHAR(255),
  ringkasan TEXT,
  isi LONGTEXT,
  thumbnail VARCHAR(255),
  kategori VARCHAR(100),
  tanggal_publish DATE
);

-- Tabel event/kegiatan
CREATE TABLE event (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama_event VARCHAR(200),
  deskripsi TEXT,
  tanggal_mulai DATE,
  tanggal_selesai DATE,
  jam TIME,
  kategori VARCHAR(100),
  tempat VARCHAR(200),
  status VARCHAR(50)
);

-- Tabel peminjaman ruangan
CREATE TABLE peminjaman_ruang (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  nama_peminjam VARCHAR(100),
  instansi VARCHAR(200),
  email VARCHAR(100),
  no_hp VARCHAR(20),
  nama_kegiatan VARCHAR(200),
  tanggal_mulai DATE,
  tanggal_selesai DATE,
  jumlah_peserta INT,
  deskripsi_kegiatan TEXT,
  status ENUM('pending', 'disetujui', 'ditolak')
);

-- Tabel ulasan pengunjung
CREATE TABLE komentar (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  isi_komentar TEXT,
  tanggal DATETIME
);
```

---

## 🖼️ Tampilan Website

### Landing Page
> 📌 *Insert screenshot Landing Page (index.html) — Three.js 3D tubes animation, opening card, countdown*

---

### Beranda (Home)
> 📌 *Insert screenshot Beranda — hero section, slider koleksi unggulan*

> 📌 *Insert screenshot Beranda — section event, berita, ulasan pengunjung*

---

### Katalog Koleksi
> 📌 *Insert screenshot halaman katalog koleksi — grid card + filter*

> 📌 *Insert screenshot slide panel detail koleksi*

---

### Kegiatan & Event
> 📌 *Insert screenshot halaman event — daftar event + sidebar kategori*

---

### Berita
> 📌 *Insert screenshot halaman berita — grid artikel + filter Vue.js*

---

### Peminjaman Ruangan
> 📌 *Insert screenshot form peminjaman + kalender ketersediaan*

> 📌 *Insert screenshot pratinjau & kirim ke WhatsApp*

---

### Peta Lokasi
> 📌 *Insert screenshot halaman peta — Google Maps embed*

---

### Tentang Museum
> 📌 *Insert screenshot halaman tentang — sejarah, visi misi, linimasa*

---

### Ulasan & Kesan
> 📌 *Insert screenshot halaman ulasan + form komentar*

---

### Admin Dashboard
> 📌 *Insert screenshot dashboard admin — ringkasan data + grafik Chart.js*

---

### Admin — Kelola Koleksi
> 📌 *Insert screenshot tabel koleksi + modal tambah/edit*

---

### Admin — Kelola Kegiatan
> 📌 *Insert screenshot tabel kegiatan + modal*

---

### Admin — Kelola Berita
> 📌 *Insert screenshot tabel berita + modal*

---

### Admin — Kelola Peminjaman
> 📌 *Insert screenshot daftar permohonan + filter status*

---

## 🔄 Alur Sistem

### Alur Login & Registrasi
> 📌 *Insert Flowchart Login & Registrasi*

---

### Alur Pengguna (User)
> 📌 *Insert Flowchart Alur Pengguna*

---

### Alur Admin
> 📌 *Insert Flowchart Alur Admin (CRUD Koleksi, Kegiatan, Berita)*

---

## 👥 Tim Pengembang

| No | Nama | NIM | Kontribusi |
|----|------|-----|------------|
| 1 | **Hendri Zaidan Safitra** | 2409116013 | Backend, Frontend |
| 2 | **Putri Syafana Afrillia** | 2409116015 | Fullstack, Database, Hosting |
| 3 | **Indah Putri Lestari** | 2409116004 | Flowchart, Database, Laporan |
| 4 | **Narendra Augusta Srianandha** | 2409116010 | Design Figma, Frontend |

---

## 📚 Mata Kuliah

> **Pemrograman Berbasis Web**  
> Dosen Pengampu: **Ir. M. Ibadurrahman Arrasyid, S.Kom., M.Kom**  
> Program Studi Sistem Informasi — Fakultas Teknik  
> **Universitas Mulawarman** · 2026/2027

---

<div align="center">

*© 2026 Museum Kota Samarinda Website — Sistem Informasi, Universitas Mulawarman*

</div>
